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

// 데이터 준비
$uniq_id = uniqid();
$point_target_uniq_id = egb('point_target_uniq_id', 120); 
$point_type = egb('point_type', 121);
$point_reason = egb('point_reason', 122);
$point_amount = egb('point_amount', 123);
$point_memo = egb('point_memo');

// 현재 회원의 적립금 조회
$query = "SELECT user_point FROM egb_user WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $point_target_uniq_id];
$binding = binding_sql(1, $query, $params);
$result = egb_sql($binding);

if (!$result || !isset($result[0])) {
    echo json_encode(['success' => false, 'failureCode' => 124]); // 존재하지 않는 회원
    exit;
}

$point_before_balance = $result[0]['user_point'] ?? 0;

// 적립금 처리 유형에 따라 계산
if ($point_type == '1') { // 지급
    $point_after_balance = $point_before_balance + $point_amount;
} else if ($point_type == '0') { // 차감
    // 차감할 금액이 현재 적립금보다 큰 경우 에러
    if ($point_amount > $point_before_balance) {
        echo json_encode(['success' => false, 'failureCode' => 125]); // 차감할 금액이 현재 적립금보다 큼
        exit;
    }
    $point_after_balance = $point_before_balance - $point_amount;
} else {
    echo json_encode(['success' => false, 'failureCode' => 126]); // 잘못된 적립금 처리 유형
    exit;
}

// egb_point 테이블에 내역 추가
$query = "
INSERT INTO egb_point (
    uniq_id,
    point_target_uniq_id,
    point_type,
    point_reason,
    point_amount,
    point_before_balance,
    point_after_balance,
    point_memo,
    created_by
) VALUES (
    :uniq_id,
    :point_target_uniq_id,
    :point_type,
    :point_reason,
    :point_amount,
    :point_before_balance,
    :point_after_balance,
    :point_memo,
    :created_by
)";

$params = [
    ':uniq_id' => $uniq_id,
    ':point_target_uniq_id' => $point_target_uniq_id,
    ':point_type' => $point_type,
    ':point_reason' => $point_reason,
    ':point_amount' => $point_amount,
    ':point_before_balance' => $point_before_balance,
    ':point_after_balance' => $point_after_balance,
    ':point_memo' => $point_memo,
    ':created_by' => $filter_user_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if (!$sql) {
    echo json_encode(['success' => false, 'failureCode' => 127]); // 적립금 내역 추가 실패
    exit;
}

// egb_user 테이블의 적립금 업데이트
$query = "UPDATE egb_user SET user_point = :point_after_balance WHERE uniq_id = :uniq_id";
$params = [
    ':point_after_balance' => $point_after_balance,
    ':uniq_id' => $point_target_uniq_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if (!$sql) {
    echo json_encode(['success' => false, 'failureCode' => 128]); // 적립금 업데이트 실패
    exit;
}

// 레코드 카운트 증가
increase_record_total_count('egb_point');
increase_record_active_count('egb_point');

echo json_encode([
    'success' => true,
    'successCode' => 19,
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
?>
