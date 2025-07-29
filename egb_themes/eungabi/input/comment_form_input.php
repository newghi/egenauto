<?php

// 입력 데이터 정리 및 유효성 검사
$table_name = egb('comment_table_name', 71);  // 예: 'egb_comment_news'
$comment_board_uniq_id = egb('comment_board_uniq_id', 72); 
$comment_user_uniq_id = egb('comment_user_uniq_id', 73);
$comment_contents = egb('comment_contents', 74);

$comment_user_ip = egb('comment_user_ip');
$comment_user_agent = egb('comment_user_agent');
$comment_user_password = egb('comment_user_password');
$comment_parent_uniq_id = egb('comment_parent_uniq_id');

// comment_parent_uniq_id가 빈 값이거나 없는 경우 null로 설정
$comment_parent_uniq_id = (!empty($comment_parent_uniq_id) && $comment_parent_uniq_id !== '') ? $comment_parent_uniq_id : null;

// 댓글 테이블과 게시글 테이블의 이름을 구하기 위해 접두사만 바꿔서 사용
$board_table_name = str_replace('egb_comment_', 'egb_board_', $table_name);
$comment_table_name = $table_name;

// 유효성 검사
if (! $table_name || ! $comment_board_uniq_id || ! $comment_user_uniq_id || ! $comment_contents) {
    echo json_encode(['success' => false, 'failureCode' => 71]);
    exit;
}

// 댓글 삽입 쿼리
$uniq_id = uniqid();
$query = "
    INSERT INTO {$comment_table_name} (
        uniq_id,
        is_status,
        display_order,
        comment_board_uniq_id,
        comment_user_uniq_id,
        comment_user_ip,
        comment_user_agent,
        comment_user_password,
        comment_contents,
        comment_data,
        comment_is_notice,
        comment_is_secret,
        comment_recommended,
        comment_not_recommended,
        comment_report,
        comment_parent_uniq_id,
        created_by,
        updated_by,
        deleted_by,
        created_at,
        deleted_at,
        updated_at
    ) VALUES (
        :uniq_id,
        1,
        0,
        :comment_board_uniq_id,
        :comment_user_uniq_id,
        :comment_user_ip,
        :comment_user_agent,
        :comment_user_password,
        :comment_contents,
        NULL,
        0,
        0,
        0,
        0,
        0,
        :comment_parent_uniq_id,
        :created_by,
        NULL,
        NULL,
        CURRENT_TIMESTAMP,
        NULL,
        CURRENT_TIMESTAMP
    )
";
$params = [
    ':uniq_id'                => $uniq_id,
    ':comment_board_uniq_id'  => $comment_board_uniq_id,
    ':comment_user_uniq_id'   => $comment_user_uniq_id,
    ':comment_user_ip'        => $comment_user_ip,
    ':comment_user_agent'     => $comment_user_agent,
    ':comment_user_password'  => $comment_user_password,
    ':comment_contents'       => $comment_contents,
    ':comment_parent_uniq_id' => $comment_parent_uniq_id,
    ':created_by'             => $comment_user_uniq_id
];

$binding = binding_sql(2, $query, $params);
$result  = egb_sql($binding);

if (! isset($result[0])) {
    echo json_encode(['success' => false, 'failureCode' => 75]);
    exit;
}

// 댓글 로그 추가
egb_comment_log($comment_table_name, $uniq_id, $comment_user_uniq_id);

// 게시글의 댓글 수 증가
$update_comment_count = "
    UPDATE {$board_table_name} 
    SET board_comment_count = board_comment_count + 1
    WHERE uniq_id = :board_uniq_id
";
$update_params = [':board_uniq_id' => $comment_board_uniq_id];
$binding = binding_sql(2, $update_comment_count, $update_params);
egb_sql($binding);

// 부모 댓글이 있는 경우 reply_count 증가
if ($comment_parent_uniq_id) {
    $update_reply_count = "
        UPDATE {$comment_table_name}
        SET comment_reply_count = comment_reply_count + 1
        WHERE uniq_id = :parent_id
    ";
    $reply_params = [':parent_id' => $comment_parent_uniq_id];
    $binding = binding_sql(2, $update_reply_count, $reply_params);
    egb_sql($binding);
}

// 댓글 작성자 닉네임 조회
$user_query = "
    SELECT user_nick_name, user_name 
    FROM egb_user 
    WHERE uniq_id = :comment_user_uniq_id
    AND is_status = 1
";

$user_params = [
    ':comment_user_uniq_id' => $comment_user_uniq_id
];

$user_binding = binding_sql(1, $user_query, $user_params);
$user_result = egb_sql($user_binding);

$user_nick_name = '탈퇴한 회원';
if (!empty($user_result[0])) {
    if (!empty($user_result[0]['user_nick_name'])) {
        $user_nick_name = $user_result[0]['user_nick_name'];
    } else if (!empty($user_result[0]['user_name'])) {
        $user_nick_name = $user_result[0]['user_name'];
    }
}

// 알림 처리
$board_type = str_replace('egb_comment_', '', $table_name);

// 최상위 댓글 ID 찾기
$top_level_comment_id = $uniq_id; // 첫 댓글인 경우 자신이 최상위
if ($comment_parent_uniq_id) {
    $parent_query = "
        WITH RECURSIVE comment_hierarchy AS (
            SELECT uniq_id, comment_parent_uniq_id
            FROM {$comment_table_name}
            WHERE uniq_id = :start_id
            UNION ALL
            SELECT c.uniq_id, c.comment_parent_uniq_id
            FROM {$comment_table_name} c
            INNER JOIN comment_hierarchy ch ON c.uniq_id = ch.comment_parent_uniq_id
        )
        SELECT uniq_id
        FROM comment_hierarchy
        WHERE comment_parent_uniq_id IS NULL
        LIMIT 1
    ";
    $parent_params = [':start_id' => $comment_parent_uniq_id];
    $parent_binding = binding_sql(1, $parent_query, $parent_params);
    $parent_result = egb_sql($parent_binding);
    
    if (!empty($parent_result[0])) {
        $top_level_comment_id = $parent_result[0]['uniq_id'];
    }
}

// 최상위 댓글이 있는 경우에만 앵커 추가
if ($board_type == 'mentoring_private') {
    $view_base = "/page/mentoring_private_view";
} else if ($board_type == 'mentoring_release') {
    $view_base = "/page/mentoring_release_view";
} else {
    $view_base = "/page/{$board_type}_board_view";
}

if ($top_level_comment_id) {
    $view_path = $view_base . "/?uniq_id={$comment_board_uniq_id}#comment_{$top_level_comment_id}";
} else {
    $view_path = $view_base . "/?uniq_id={$comment_board_uniq_id}";
}

// 게시글 작성자 정보 조회
$board_query = "
    SELECT board_user_uniq_id
    FROM {$board_table_name}
    WHERE uniq_id = :board_id
    AND is_status = 1
";
$board_params = [':board_id' => $comment_board_uniq_id];
$board_binding = binding_sql(1, $board_query, $board_params);
$board_result = egb_sql($board_binding);

$board_user_id = $board_result[0]['board_user_uniq_id'] ?? null;

// 기본 comment_data 정의
$comment_data = [
    'uniq_id' => $uniq_id,
    'comment_contents' => $comment_contents,
    'created_at' => date('Y-m-d H:i:s'),
    'comment_user_uniq_id' => $comment_user_uniq_id,
    'user_nick_name' => $user_nick_name,
    'comment_reply_count' => 0,
    'comment_id' => $comment_parent_uniq_id,
    'comment_parent_uniq_id' => $comment_parent_uniq_id,
    'board_type' => $board_type,
    'board_uniq_id' => $comment_board_uniq_id,
    'board_user_uniq_id' => $board_user_id
];

// 부모 댓글이 있는 경우 알림 처리
if ($comment_parent_uniq_id) {
    // 부모 댓글 조회
    $parent_comment_query = "
        SELECT comment_user_uniq_id
        FROM {$comment_table_name}
        WHERE uniq_id = :parent_id
        AND is_status = 1
    ";
    $parent_comment_params = [':parent_id' => $comment_parent_uniq_id];
    $parent_comment_binding = binding_sql(1, $parent_comment_query, $parent_comment_params);
    $parent_comment_result = egb_sql($parent_comment_binding);

    if (!empty($parent_comment_result[0])) {
        $parent_user_id = $parent_comment_result[0]['comment_user_uniq_id'];
        
        // 부모 댓글 작성자 정보 조회
        $parent_user_query = "
            SELECT user_nick_name, user_name
            FROM egb_user
            WHERE uniq_id = :parent_user_id
            AND is_status = 1
        ";
        $parent_user_params = [':parent_user_id' => $parent_user_id];
        $parent_user_binding = binding_sql(1, $parent_user_query, $parent_user_params);
        $parent_user_result = egb_sql($parent_user_binding);

        // comment_data에 parent_user_id 추가
        $comment_data['parent_user_id'] = $parent_user_id;

        // 부모 댓글 작성자가 존재하고 본인이 아닌 경우에만 알림 발송
        if (!empty($parent_user_result[0]) && $parent_user_id != $comment_user_uniq_id) {
            $parent_nickname = '알 수 없음';
            if (!empty($parent_user_result[0]['user_nick_name'])) {
                $parent_nickname = $parent_user_result[0]['user_nick_name'];
            } else if (!empty($parent_user_result[0]['user_name'])) {
                $parent_nickname = $parent_user_result[0]['user_name'];
            }
            
            $reply_message = "{$user_nick_name}님이 회원님의 댓글에 댓글을 남겼습니다: " . mb_substr($comment_contents, 0, 30) . "...";
            
            // 부모 댓글 작성자가 게시글 작성자가 아닌 경우에만 알림 발송
            if ($parent_user_id != $board_user_id) {
                egb_alarm_insert(
                    $parent_user_id,
                    '새 댓글 알림',
                    $reply_message,
                    $view_path,
                    'comment'
                );

                egb_send_push_event(
                    "public-user-{$parent_user_id}",  // 부모 댓글 작성자 채널
                    'new-reply',                       // 이벤트 이름
                    [
                        'uniq_id' => $uniq_id,
                        'user_nick_name' => $user_nick_name,
                        'board_type' => $board_type,
                        'board_uniq_id' => $comment_board_uniq_id,
                        'comment_contents' => $comment_contents,
                        'comment_parent_uniq_id' => $comment_parent_uniq_id,
                        'parent_user_id' => $parent_user_id,
                        'comment_user_uniq_id' => $comment_user_uniq_id,
                        'message' => $reply_message,
                        'view_path' => $view_path,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );
            }
        }
    }
}

// 게시글 작성자에게 알림 (본인이 아닌 경우에만)
if ($board_user_id && $board_user_id != $comment_user_uniq_id) {
    $message = "게시글에 새 댓글이 달렸습니다: " . mb_substr($comment_contents, 0, 30) . "...";

    egb_alarm_insert(
        $board_user_id,
        '새 댓글 알림',
        $message,
        $view_path,
        'comment'
    );

    egb_send_push_event(
        "public-user-{$board_user_id}",  // 게시글 작성자 채널
        'new-comment',                    // 이벤트 이름
        [
            'uniq_id' => $uniq_id,
            'user_nick_name' => $user_nick_name,
            'board_type' => $board_type,
            'board_uniq_id' => $comment_board_uniq_id,
            'comment_contents' => $comment_contents,
            'comment_parent_uniq_id' => $comment_parent_uniq_id,
            'comment_user_uniq_id' => $comment_user_uniq_id,
            'message' => $message,
            'view_path' => $view_path,
            'created_at' => date('Y-m-d H:i:s')
        ]
    );
}

echo json_encode([
    'success' => true,
    'successCode' => 8,
    'data' => $comment_data
]);
?>
