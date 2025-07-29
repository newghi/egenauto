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
$deposit_target_uniq_id = egb('deposit_target_uniq_id', 111); 
$deposit_type = egb('deposit_type', 112);
$deposit_reason = egb('deposit_reason', 113);
$deposit_amount = egb('deposit_amount', 114);
$deposit_memo = egb('deposit_memo');

// 현재 회원의 예치금 조회
$query = "SELECT user_deposit FROM egb_user WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $deposit_target_uniq_id];
$binding = binding_sql(1, $query, $params);
$result = egb_sql($binding);

if (!$result || !isset($result[0])) {
    echo json_encode(['success' => false, 'failureCode' => 115]); // 존재하지 않는 회원
    exit;
}

$deposit_before_balance = $result[0]['user_deposit'] ?? 0;

// 예치금 처리 유형에 따라 계산
if ($deposit_type == '1') { // 지급
    $deposit_after_balance = $deposit_before_balance + $deposit_amount;
} else if ($deposit_type == '0') { // 차감
    // 차감할 금액이 현재 예치금보다 큰 경우 에러
    if ($deposit_amount > $deposit_before_balance) {
        echo json_encode(['success' => false, 'failureCode' => 116]); // 차감할 금액이 현재 예치금보다 큼
        exit;
    }
    $deposit_after_balance = $deposit_before_balance - $deposit_amount;
} else {
    echo json_encode(['success' => false, 'failureCode' => 117]); // 잘못된 예치금 처리 유형
    exit;
}

// egb_deposit 테이블에 내역 추가
$query = "
INSERT INTO egb_deposit (
    uniq_id,
    deposit_target_uniq_id,
    deposit_type,
    deposit_reason,
    deposit_amount,
    deposit_before_balance,
    deposit_after_balance,
    deposit_memo,
    created_by
) VALUES (
    :uniq_id,
    :deposit_target_uniq_id,
    :deposit_type,
    :deposit_reason,
    :deposit_amount,
    :deposit_before_balance,
    :deposit_after_balance,
    :deposit_memo,
    :created_by
)";

$params = [
    ':uniq_id' => $uniq_id,
    ':deposit_target_uniq_id' => $deposit_target_uniq_id,
    ':deposit_type' => $deposit_type,
    ':deposit_reason' => $deposit_reason,
    ':deposit_amount' => $deposit_amount,
    ':deposit_before_balance' => $deposit_before_balance,
    ':deposit_after_balance' => $deposit_after_balance,
    ':deposit_memo' => $deposit_memo,
    ':created_by' => $filter_user_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if (!$sql) {
    echo json_encode(['success' => false, 'failureCode' => 118]); // 예치금 내역 추가 실패
    exit;
}

// egb_user 테이블의 예치금 업데이트
$query = "UPDATE egb_user SET user_deposit = :deposit_after_balance WHERE uniq_id = :uniq_id";
$params = [
    ':deposit_after_balance' => $deposit_after_balance,
    ':uniq_id' => $deposit_target_uniq_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if (!$sql) {
    echo json_encode(['success' => false, 'failureCode' => 119]); // 예치금 업데이트 실패
    exit;
}

// 레코드 카운트 증가
increase_record_total_count('egb_deposit');
increase_record_active_count('egb_deposit');

echo json_encode([
    'success' => true,
    'successCode' => 18,
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
