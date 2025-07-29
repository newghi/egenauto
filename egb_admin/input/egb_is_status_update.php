<?php

$filter_page_name = egb('filter_page_name', 1);
$filter_menu_name = egb('filter_menu_name', 2);
$filter_page = egb('filter_page', 3);
$filter_perPage = egb('filter_per_page', 4);
$filter_order = egb('filter_order', 5);
$filter_is_status = egb('filter_is_status', 6);
$filter_user_id = egb('filter_user_id', 7);
$filter_table_name = egb('filter_table_name', 8);

$filter_search_input = egb('filter_search_input');    
$uniq_id = egb('uniq_id');
// 현재 상태 확인
$check_query = "SELECT is_status FROM $filter_table_name WHERE uniq_id = :uniq_id";
$check_params = [':uniq_id' => $uniq_id];
$check_binding = binding_sql(1, $check_query, $check_params);
$current_status = egb_sql($check_binding)[0]['is_status'];

// 업데이트 쿼리 실행
$query = "
    UPDATE $filter_table_name 
    SET is_status = :is_status,
        updated_at = NOW(),
        updated_by = :updated_by";

// 상태가 2에서 1이나 0으로 변경되는 경우 deleted_at을 NULL로 설정
if ($current_status == 2 && ($filter_is_status == 1 || $filter_is_status == 0)) {
    $query .= ", deleted_at = NULL";
}

$query .= " WHERE uniq_id = :uniq_id";

$params = [
    ':is_status' => $filter_is_status,
    ':updated_by' => 'system',
    ':uniq_id' => $uniq_id
];

$binding = binding_sql(2, $query, $params);
$result = egb_sql($binding);

// 상태 변경에 따른 카운트 업데이트
if ($result && isset($result[0]) && $result[0]) {
    if ($current_status == 1) {
        decrease_record_active_count($filter_table_name);
    } else if ($current_status == 0) {
        decrease_record_inactive_count($filter_table_name);
    } else if ($current_status == 2) {
        decrease_record_soft_deleted_count($filter_table_name);
    }

    if ($filter_is_status == 1) {
        increase_record_active_count($filter_table_name);
    } else if ($filter_is_status == 0) {
        increase_record_inactive_count($filter_table_name);
    } else if ($filter_is_status == 2) {
        increase_record_soft_deleted_count($filter_table_name);
    }
    echo json_encode([
        'success' => true, 
        'successCode' => 2,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_perPage,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input,
        'filter_user_id' => $filter_user_id,
        'filter_table_name' => $filter_table_name
    ]);
    exit;
} else {
    echo json_encode([
        'success' => false, 
        'failureCode' => 19
    ]);
}

?>
