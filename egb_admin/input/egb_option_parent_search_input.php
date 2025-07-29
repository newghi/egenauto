<?php
// 입력값 확인
$mode = egb('mode');
$parent_option_keyword = egb('parent_option_keyword', 83);
$option_group_uniq_id = egb('option_group_uniq_id', 84);

$query = "SELECT 
    no,
    uniq_id,
    is_status,
    display_order,
    option_group_uniq_id,
    option_parent_uniq_id, 
    option_label,
    option_depth,
    option_access_level,
    created_by,
    updated_by,
    deleted_by,
    created_at,
    deleted_at,
    updated_at
FROM egb_option 
WHERE CONCAT(option_label) LIKE :parent_option_keyword
  AND option_group_uniq_id = :option_group_uniq_id
  AND is_status = 1
  AND deleted_at IS NULL
ORDER BY option_depth ASC, display_order ASC";

$params = [
    ':parent_option_keyword' => '%' . $parent_option_keyword . '%',
    ':option_group_uniq_id' => $option_group_uniq_id
];

$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);

// 결과 확인 및 반환
if ($sql && isset($sql[0])) {
    echo json_encode(['success' => true, 'successCode' => 12, 'data' => $sql[0], 'mode' => $mode]);
    exit;
} else {
    echo json_encode(['success' => false, 'failureCode' => 85]); // 검색 결과가 없습니다
    exit;
}
?>
