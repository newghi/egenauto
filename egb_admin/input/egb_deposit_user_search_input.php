<?php
$user_keyword = egb('user_keyword', 109);

$query = "SELECT 
    uniq_id,
    user_id,
    user_name, 
    user_nick_name,
    user_email,
    user_phone1,
    user_phone2,
    user_zipcode,
    user_address,
    user_address_detail,
    is_status
FROM egb_user 
WHERE (user_id LIKE :user_keyword1
OR user_name LIKE :user_keyword2 
OR user_nick_name LIKE :user_keyword3)";

$params = [
    ':user_keyword1' => '%' . $user_keyword . '%',
    ':user_keyword2' => '%' . $user_keyword . '%',
    ':user_keyword3' => '%' . $user_keyword . '%'
];

$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);

// 결과 확인 및 반환
if ($sql && isset($sql[0])) {
    echo json_encode(['success' => true, 'successCode' => 17, 'data' => $sql[0]]);
    exit;
} else {
    echo json_encode(['success' => false, 'failureCode' => 110]); // 검색 결과가 없습니다
    exit;
}
?>
