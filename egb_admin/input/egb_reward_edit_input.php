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

// 리워드 정보 가져오기
$uniq_id = egb('uniq_id', 142);
$reward_title = egb('reward_title', 143);
$reward_name = egb('reward_name', 144);
$reward_type = egb('reward_type', 145);
$reward_limit_count = egb('reward_limit_count', 146);
$reward_grant = egb('reward_grant', 147);
$reward_expired_days = egb('reward_expired_days', 148);
$reward_memo = egb('reward_memo');
$target_grades = egb('target_grades[]', 149);

// reward_data JSON 생성
$reward_data = json_encode($target_grades);

// 쿼리 생성
$query = "UPDATE egb_reward SET
    reward_title = :reward_title,
    reward_name = :reward_name,
    reward_type = :reward_type,
    reward_limit_count = :reward_limit_count,
    reward_grant = :reward_grant,
    reward_expired_days = :reward_expired_days,
    reward_memo = :reward_memo,
    reward_data = :reward_data,
    updated_by = :updated_by,
    updated_at = NOW()
WHERE uniq_id = :uniq_id";

// 파라미터 설정
$params = [
    ':uniq_id' => $uniq_id,
    ':reward_title' => $reward_title,
    ':reward_name' => $reward_name,
    ':reward_type' => $reward_type,
    ':reward_limit_count' => $reward_limit_count,
    ':reward_grant' => $reward_grant,
    ':reward_expired_days' => $reward_expired_days,
    ':reward_memo' => $reward_memo,
    ':reward_data' => $reward_data,
    ':updated_by' => $filter_user_id
];

// 쿼리 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// 결과 반환
if ($sql[0]) {
    echo json_encode([
        'success' => true,
        'successCode' => 23,
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
    echo json_encode(['success' => false, 'failureCode' => 150]);
}
?>
