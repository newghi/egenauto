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

// 이벤트 정보 가져오기
$uniq_id = egb('uniq_id', 101);
$event_title = egb('event_title', 102);
$event_category = egb('event_category', 103);
$event_type = egb('event_type', 104);
$event_description = egb('event_description', 105);
$event_start_date = egb('event_start_date', 106);
$event_end_date = egb('event_end_date', 107);
$target_grades = egb('target_grades[]', 108);

// event_data JSON 생성
$event_data = json_encode($target_grades);

// 쿼리 생성
$query = "UPDATE egb_event SET
    event_title = :event_title,
    event_category = :event_category,
    event_type = :event_type,
    event_description = :event_description,
    event_data = :event_data,
    event_start_date = :event_start_date,
    event_end_date = :event_end_date,
    updated_by = :updated_by,
    updated_at = NOW()
WHERE uniq_id = :uniq_id";

// 파라미터 설정
$params = [
    ':uniq_id' => $uniq_id,
    ':event_title' => $event_title,
    ':event_category' => $event_category,
    ':event_type' => $event_type,
    ':event_description' => $event_description,
    ':event_data' => $event_data,
    ':event_start_date' => $event_start_date,
    ':event_end_date' => $event_end_date,
    ':updated_by' => $filter_user_id
];

// 쿼리 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// 결과 반환
if ($sql[0]) {
    echo json_encode([
        'success' => true,
        'successCode' => 16,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_per_page,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input,
        'filter_user_id' => $filter_user_id,
        'filter_table_name' => $filter_table_name
    ]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 109]);
}
?>
