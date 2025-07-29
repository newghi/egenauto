<?php
$comment_table_name     = egb('comment_table_name',      175);
$comment_board_uniq_id  = egb('comment_board_uniq_id',   176);
$last_comment_uniq_id   = egb('last_comment_uniq_id',    177);

// 댓글 10개 조회
$query = "
    SELECT 
        c.*,
        (SELECT COUNT(*) 
           FROM {$comment_table_name} 
          WHERE comment_parent_uniq_id = c.uniq_id 
            AND is_status = 1
        ) AS reply_count
      FROM {$comment_table_name} c
     WHERE c.is_status = 1
       AND c.deleted_at IS NULL
       AND c.comment_board_uniq_id = :comment_board_uniq_id
       AND c.comment_parent_uniq_id IS NULL
       AND c.uniq_id < :last_comment_uniq_id
     ORDER BY c.display_order ASC, c.created_at DESC
     LIMIT 10
";

$params = [
    ':comment_board_uniq_id'   => $comment_board_uniq_id,
    ':last_comment_uniq_id'    => $last_comment_uniq_id
];

$binding = binding_sql(0, $query, $params);
$result  = egb_sql($binding);

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
            'reply_count'      => $comment['comment_reply_count'] ?? 0,
            'table_name'       => $comment_table_name,
        ];
    }

    echo json_encode([
        'success'     => true,
        'successCode' => 29,
        'data'        => $comments,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'success'     => false,
    'failureCode'=> 178,
], JSON_UNESCAPED_UNICODE);
exit;
