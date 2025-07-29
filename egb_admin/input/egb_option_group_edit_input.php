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

// 수정할 옵션 그룹 ID
$uniq_id = egb('uniq_id');

// 옵션 그룹 정보 가져오기
$group_title = egb('group_title', 78); // 필수 입력
$group_required = egb('group_required', 79); // 필수(2), 선택(1), 미사용(0)
$group_description = egb('group_description'); // 옵션 그룹 설명
$group_access_level = egb('group_access_level'); // 0-99 사이 접근 레벨
$display_order = egb('display_order'); // 출력 순서

// 데이터베이스 옵션 그룹 수정
$query = "UPDATE egb_option_group SET
    group_title = :group_title,
    group_required = :group_required,
    group_description = :group_description,
    group_access_level = :group_access_level,
    display_order = :display_order,
    updated_by = :updated_by,
    updated_at = NOW()
WHERE uniq_id = :uniq_id";

// 바인딩할 파라미터 설정
$params = [
    ':uniq_id' => $uniq_id,
    ':group_title' => $group_title,
    ':group_required' => $group_required,
    ':group_description' => $group_description,
    ':group_access_level' => $group_access_level,
    ':display_order' => $display_order,
    ':updated_by' => $filter_user_id
];

// SQL 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// 실행 결과에 따른 응답 반환
if ($sql[0]) {
    // 성공 응답
    echo json_encode([
        'success' => true,
        'successCode' => 10,
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
    // 실패 응답
    echo json_encode(['success' => false, 'failureCode' => 80]);
}
?>
