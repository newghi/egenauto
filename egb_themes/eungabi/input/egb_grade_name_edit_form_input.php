<?php
$grade_name = egb('grade_name', 54);
$uniq_id = egb('uniq_id', 55);

// 중복 체크 - 같은 등급 유형 내에서만 중복 체크 (수정)
$check_query = "
    SELECT COUNT(*) as cnt 
    FROM egb_option a 
    WHERE a.option_label = :grade_name 
    AND a.uniq_id != :uniq_id 
    AND a.deleted_at IS NULL
    AND a.option_group_uniq_id = (
        SELECT option_group_uniq_id 
        FROM egb_option 
        WHERE uniq_id = :uniq_id2
    )";
    
$check_params = [
    ':grade_name' => $grade_name,
    ':uniq_id' => $uniq_id,
    ':uniq_id2' => $uniq_id
];
$check_binding = binding_sql(1, $check_query, $check_params);
$check_result = egb_sql($check_binding);

if ($check_result && isset($check_result[0]['cnt']) && intval($check_result[0]['cnt']) > 0) {
    echo json_encode(['success' => false, 'failureCode' => 56]); // 이미 사용중인 등급명
    exit;
}

// 업데이트 수행
$update_query = "UPDATE egb_option SET option_label = :grade_name WHERE uniq_id = :uniq_id";
$update_params = [
    ':grade_name' => $grade_name,
    ':uniq_id' => $uniq_id
];
$update_binding = binding_sql(2, $update_query, $update_params);
$update_result = egb_sql($update_binding);

if (is_array($update_result) && isset($update_result[0]) && $update_result[0] === true) {
    echo json_encode(['success' => true, 'successCode' => 5]); // 등급명 수정 성공
    exit;
} else {
    echo json_encode(['success' => false, 'failureCode' => 57]); // 등급명 수정 실패
    exit;
}
?>