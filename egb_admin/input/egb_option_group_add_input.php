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

// 옵션 그룹 정보 가져오기
$group_code = egb('group_code', 73); // 영문, 숫자, 언더바만 허용
$group_title = egb('group_title', 74); // 필수 입력
$group_description = egb('group_description', 75); // 옵션 그룹 설명

$group_required = egb('group_required', 76); // 필수(2), 선택(1), 미사용(0)

$group_access_level = egb('group_access_level'); // 0-99 사이 접근 레벨
$display_order = egb('display_order'); // 출력 순서

// 고유 ID 생성
$uniq_id = uniqid();

// 데이터베이스에 옵션 그룹 추가
$query = "INSERT INTO egb_option_group (
    uniq_id,
    group_code,
    group_title,
    group_required,
    group_description,
    group_access_level,
    display_order,
    created_by
) VALUES (
    :uniq_id,
    :group_code,
    :group_title,
    :group_required,
    :group_description,
    :group_access_level,
    :display_order,
    :created_by
)";

// 바인딩할 파라미터 설정
$params = [
    ':uniq_id' => $uniq_id,
    ':group_code' => $group_code,
    ':group_title' => $group_title,
    ':group_required' => $group_required,
    ':group_description' => $group_description,
    ':group_access_level' => $group_access_level,
    ':display_order' => $display_order,
    ':created_by' => $filter_user_id
];

// SQL 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// 실행 결과에 따른 응답 반환
if ($sql[0]) {
    // 레코드 카운트 업데이트
    increase_record_total_count('egb_option_group');
    increase_record_active_count('egb_option_group');

    // 성공 응답
    echo json_encode([
        'success' => true,
        'successCode' => 9,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_per_page + 1,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input,
        'filter_user_id' => $filter_user_id,
        'filter_table_name' => $filter_table_name
    ]);
} else {
    // 실패 응답
    echo json_encode(['success' => false, 'failureCode' => 77]);
}
?>
