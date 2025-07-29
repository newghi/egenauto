<?php

$group_code = egb('group_code', 51);
$group_required = egb('group_required');    
$group_description = egb('group_description');

// group_required 또는 group_description 중 하나는 필수
if (!isset($group_required) && empty($group_description)) {
    echo json_encode(['success' => false, 'failureCode' => 52]); exit;
}

$admin_id = 'system'; // 실제 운영시에는 세션 또는 로그인 사용자 ID를 넣으세요.

// 업데이트할 필드와 값을 동적으로 구성
$update_fields = [];
$params_update = [':group_code' => $group_code, ':updated_by' => $admin_id];

if (isset($group_required)) {
    $update_fields[] = "group_required = :group_required";
    $params_update[':group_required'] = $group_required;
}

if (!empty($group_description)) {
    $update_fields[] = "group_description = :group_description";
    $params_update[':group_description'] = $group_description;
}

// 업데이트 쿼리 실행
$query_update = "UPDATE egb_option_group SET " . 
    implode(", ", $update_fields) . ", 
    updated_by = :updated_by 
WHERE group_code = :group_code 
AND deleted_at IS NULL";

$binding_update = binding_sql(2, $query_update, $params_update);
$sql_update = egb_sql($binding_update);

if ($sql_update !== false) {
    echo json_encode(['success' => true, 'successCode' => 4]); exit;
} else {
    echo json_encode(['success' => false, 'failureCode' => 53]); exit;
}
?>
