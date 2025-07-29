<?php
// 입력값 검증
$comment_id = egb('comment_id', 172);
$table_name = egb('table_name', 173);

// 댓글 조회
$query = "
    SELECT 
        c.*,
        (SELECT COUNT(*) 
           FROM {$table_name} 
          WHERE comment_parent_uniq_id = c.uniq_id 
            AND is_status = 1
        ) AS reply_count
      FROM {$table_name} c
     WHERE c.is_status = 1
       AND c.deleted_at IS NULL 
       AND c.comment_parent_uniq_id = :comment_id
     ORDER BY c.display_order ASC, c.created_at ASC
";

$params = [':comment_id' => $comment_id];
$binding = binding_sql(0, $query, $params);
$result = egb_sql($binding);

if ($result[0]) {
    $comments = [];
    foreach ($result[0] as $comment) {
        if (!isset($comment['comment_user_uniq_id'])) {
            continue;
        }

        // 닉네임 조회
        $user_binding = binding_sql(1, "
            SELECT user_nick_name, user_name 
              FROM egb_user 
             WHERE uniq_id = :uid
               AND is_status = 1
        ", [':uid' => $comment['comment_user_uniq_id']]);
        $user_row = egb_sql($user_binding)[0] ?? [];
        
        $nick = '탈퇴한 회원';
        if (!empty($user_row['user_nick_name'])) {
            $nick = $user_row['user_nick_name'];
        } elseif (!empty($user_row['user_name'])) {
            $nick = $user_row['user_name'];
        }

        $comments[] = [
            'uniq_id'          => $comment['uniq_id'] ?? '',
            'comment_contents' => $comment['comment_contents'] ?? '',
            'created_at'       => $comment['created_at'] ?? '',
            'comment_user_uniq_id' => $comment['comment_user_uniq_id'] ?? '',
            'user_nick_name'   => $nick,
            'reply_count'      => $comment['reply_count'] ?? 0,
            'table_name'       => $table_name,
            'comment_id'       => $comment_id
        ];
    }

    echo json_encode([
        'success'     => true,
        'successCode' => 28,
        'data'        => $comments,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'success'     => false,
    'failureCode'=> 174,
], JSON_UNESCAPED_UNICODE);
exit;
?>
