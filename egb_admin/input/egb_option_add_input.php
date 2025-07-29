<?php
// 필터 값 가져오기
$filter_table_name = egb('filter_table_name');
$filter_page_name = egb('filter_page_name'); 
$filter_menu_name = egb('filter_menu_name');
$filter_page = egb('filter_page');
$filter_per_page = egb('filter_per_page');
$filter_order = egb('filter_order');
$filter_is_status = egb('filter_is_status');
$filter_search_input = egb('filter_search_input');
$filter_user_id = egb('filter_user_id');

// 옵션 정보 가져오기
$option_group_uniq_id = egb('option_group_uniq_id', 85);
$option_parent_uniq_id = egb('option_parent_uniq_id');
$option_label = egb('option_label', 86);
$option_access_level = egb('option_access_level');
$display_order = egb('display_order');

// 중복 체크 쿼리
$dup_query = "
    SELECT COUNT(*) as cnt
    FROM egb_option
    WHERE option_group_uniq_id = :group_id
      AND option_parent_uniq_id <=> :parent_id
      AND option_label = :label
      AND deleted_at IS NULL
";
$dup_params = [
    ':group_id' => $option_group_uniq_id,
    ':parent_id' => $option_parent_uniq_id,
    ':label' => $option_label
];
$dup_binding = binding_sql(1, $dup_query, $dup_params);
$dup_result = egb_sql($dup_binding);

if (isset($dup_result[0]['cnt']) && $dup_result[0]['cnt'] > 0) {
    echo json_encode(['success' => false, 'failureCode' => 87]); // 중복 에러 코드
    exit;
}


// 옵션 깊이 계산
$option_depth = 0;
if (!empty($option_parent_uniq_id)) {
    $parent_query = "SELECT option_depth FROM egb_option WHERE uniq_id = :parent_id";
    $parent_params = [':parent_id' => $option_parent_uniq_id];
    $parent_binding = binding_sql(1, $parent_query, $parent_params);
    $parent_result = egb_sql($parent_binding);
    
    if ($parent_result[0]) {
        $option_depth = $parent_result[0]['option_depth'] + 1;
    }
}

// uniq_id 생성
$uniq_id = uniqid();

// 쿼리 생성
$query = "INSERT INTO egb_option (
    uniq_id,
    is_status,
    display_order,
    option_group_uniq_id,
    option_parent_uniq_id,
    option_label,
    option_depth,
    option_access_level,
    created_by
) VALUES (
    :uniq_id,
    1,
    :display_order,
    :option_group_uniq_id,
    :option_parent_uniq_id,
    :option_label,
    :option_depth,
    :option_access_level,
    :created_by
)";

// 파라미터 설정
$params = [
    ':uniq_id' => $uniq_id,
    ':display_order' => $display_order,
    ':option_group_uniq_id' => $option_group_uniq_id,
    ':option_parent_uniq_id' => $option_parent_uniq_id,
    ':option_label' => $option_label,
    ':option_depth' => $option_depth,
    ':option_access_level' => $option_access_level,
    ':created_by' => $filter_user_id
];

// 쿼리 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// 결과 반환
if ($sql[0]) {
    // 레코드 카운트 증가
    increase_record_total_count('egb_option');
    increase_record_active_count('egb_option');

    echo json_encode([
        'success' => true,
        'successCode' => 13,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => intval($filter_per_page) + 1,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input,
        'filter_user_id' => $filter_user_id,
        'filter_table_name' => $filter_table_name
    ]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 88]);
}
?>
