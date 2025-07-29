<?php
// 입력값 확인
$mode = egb('mode');
$group_option_keyword = egb('group_option_keyword', 81);

$query = "SELECT 
    uniq_id,
    group_code,
    group_title, 
    group_input_name,
    group_required,
    group_description,
    group_access_level,
    display_order,
    is_status,
    created_by,
    updated_by,
    created_at,
    updated_at
FROM egb_option_group 
WHERE CONCAT(group_code, group_title, group_description) LIKE :group_option_keyword
  AND is_status = 1
  AND deleted_at IS NULL";

$params = [':group_option_keyword' => '%' . $group_option_keyword . '%'];

$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);

// 결과 확인 및 반환
if ($sql && isset($sql[0])) {
    echo json_encode(['success' => true, 'successCode' => 11, 'data' => $sql[0], 'mode' => $mode]);
    exit;
} else {
    echo json_encode(['success' => false, 'failureCode' => 82]); // 검색 결과가 없습니다
    exit;
}
?>
