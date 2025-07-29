<?php
// 세션에서 유저 유니크 ID 확인
if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'failureCode' => 134]); // 로그인하지 않은 경우
    exit;
}

$user_uniq_id = $_SESSION['user_uniq_id'];  // 세션에서 유저 유니크 ID 가져오기

$title = egb('title', 135);
$content = egb('content', 136);

$uniq_id = uniqid();

$query = "INSERT INTO egb_board_mentoring_private (
    uniq_id,
    board_user_uniq_id,
    board_title,
    board_contents,
    created_by,
    created_at
) VALUES (
    :uniq_id,
    :user_uniq_id,
    :title,
    :content,
    :created_by,
    NOW()
)";

$params = [
    ':uniq_id' => $uniq_id,
    ':user_uniq_id' => $user_uniq_id,
    ':title' => $title,
    ':content' => $content,
    ':created_by' => $user_uniq_id
];

$binding = binding_sql(2, $query, $params);
$result = egb_sql($binding);

if ($result) {
    // 레코드 카운트 증가
    increase_record_total_count('egb_board_mentoring_private');
    increase_record_active_count('egb_board_mentoring_private');

    // 게시판 로그 추가
    egb_board_log('egb_board_mentoring_private', $uniq_id, $user_uniq_id);

    // 리워드 지급
    egb_reward_dispatch($user_uniq_id, 'reward_mentoring_private_upload', 'point', 0, 'auto_grade_check');

    // sitemap 추가
    egb_sitemap_insert('mentoring_private', DOMAIN . '/page/mentoring_private_view/?uniq_id=' . $uniq_id);

    // 작성자 정보 조회
    $user_query = "
        SELECT user_nick_name, user_name 
        FROM egb_user 
        WHERE uniq_id = :user_id
        AND is_status = 1
    ";
    $user_params = [':user_id' => $user_uniq_id];
    $user_binding = binding_sql(1, $user_query, $user_params);
    $user_result = egb_sql($user_binding);

    $user_nick_name = '알 수 없음';
    if (!empty($user_result[0])) {
        if (!empty($user_result[0]['user_nick_name'])) {
            $user_nick_name = $user_result[0]['user_nick_name'];
        } else if (!empty($user_result[0]['user_name'])) {
            $user_nick_name = $user_result[0]['user_name'];
        }
    }

    // 현재 사용자의 user_id 조회
    $current_user_query = "
        SELECT user_id 
        FROM egb_user 
        WHERE uniq_id = :user_uniq_id 
        AND is_status = 1
    ";
    $current_user_params = [':user_uniq_id' => $user_uniq_id];
    $current_user_binding = binding_sql(1, $current_user_query, $current_user_params);
    $current_user_result = egb_sql($current_user_binding);
    
    $current_user_id = '';
    if (!empty($current_user_result[0]['user_id'])) {
        $current_user_id = $current_user_result[0]['user_id'];
    }

    // 작성자의 멘토/멘티 관계 확인
    // 멘티인지 확인 (user_mentor_id가 있는 경우) - 멘토의 uniq_id 찾기
    $mentor_query = "
        SELECT user_mentor_id 
        FROM egb_user 
        WHERE uniq_id = :user_uniq_id 
        AND user_mentor_id IS NOT NULL 
        AND user_mentor_id != ''
        AND is_status = 1
    ";
    $mentor_params = [':user_uniq_id' => $user_uniq_id];
    $mentor_binding = binding_sql(1, $mentor_query, $mentor_params);
    $mentor_result = egb_sql($mentor_binding);

    // 멘토인지 확인 (다른 사용자의 user_mentor_id가 현재 사용자의 user_id인 경우)
    $mentee_query = "
        SELECT uniq_id 
        FROM egb_user 
        WHERE user_mentor_id = :user_id 
        AND is_status = 1
    ";
    $mentee_params = [':user_id' => $current_user_id];
    $mentee_binding = binding_sql(0, $mentee_query, $mentee_params);
    $mentee_result = egb_sql($mentee_binding);

    $view_path = "/page/mentoring_private_view/?uniq_id={$uniq_id}";

    // 멘티가 글을 쓴 경우 -> 멘토에게 알림
    if (!empty($mentor_result[0]['user_mentor_id'])) {
        $mentor_user_id = $mentor_result[0]['user_mentor_id'];
        
        // 멘토의 uniq_id 찾기
        $mentor_uniq_query = "
            SELECT uniq_id 
            FROM egb_user 
            WHERE user_id = :mentor_user_id 
            AND is_status = 1
        ";
        $mentor_uniq_params = [':mentor_user_id' => $mentor_user_id];
        $mentor_uniq_binding = binding_sql(1, $mentor_uniq_query, $mentor_uniq_params);
        $mentor_uniq_result = egb_sql($mentor_uniq_binding);
        
        if (!empty($mentor_uniq_result[0]['uniq_id'])) {
            $mentor_uniq_id = $mentor_uniq_result[0]['uniq_id'];
            $message = "{$user_nick_name} 멘티님이 새로운 멘토링 프라이빗 게시글을 작성했습니다.";
            
            egb_alarm_insert(
                $mentor_uniq_id,
                '멘티 게시글 알림',
                $message,
                $view_path,
                'mentoring_private_mentee_upload'
            );

            egb_send_push_event(
                "public-user-{$mentor_uniq_id}",
                'new-mentoring',
                [
                    'uniq_id' => $uniq_id,
                    'user_nick_name' => $user_nick_name,
                    'board_title' => $title,
                    'message' => $message,
                    'view_path' => $view_path,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }
    }

    // 멘토가 글을 쓴 경우 -> 멘티들에게 알림
    if (!empty($mentee_result[0])) {
        foreach ($mentee_result[0] as $mentee) {
            // uniq_id 키가 존재하는지 확인
            if (!isset($mentee['uniq_id']) || empty($mentee['uniq_id'])) {
                continue; // uniq_id가 없으면 건너뛰기
            }
            
            $mentee_uniq_id = $mentee['uniq_id'];
            $message = "{$user_nick_name} 멘토님이 새로운 멘토링 프라이빗 게시글을 작성했습니다.";
            
            egb_alarm_insert(
                $mentee_uniq_id,
                '멘토 게시글 알림',
                $message,
                $view_path,
                'mentoring_private_mentor_upload'
            );

            egb_send_push_event(
                "public-user-{$mentee_uniq_id}",
                'new-mentoring',
                [
                    'uniq_id' => $uniq_id,
                    'user_nick_name' => $user_nick_name,
                    'board_title' => $title,
                    'message' => $message,
                    'view_path' => $view_path,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }
    }

    echo json_encode(['success' => true, 'successCode' => 16, 'url' => DOMAIN . '/page/mentoring_private_view/?uniq_id=' . $uniq_id]);
} else {
    // 게시글 삽입 실패 시 처리
    echo json_encode(['success' => false, 'failureCode' => 137]);
}

?>
