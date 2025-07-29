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
$mileage_target_uniq_id = egb('mileage_target_uniq_id', 131); 
$mileage_type = egb('mileage_type', 132);
$mileage_reason = egb('mileage_reason', 133);
$mileage_amount = egb('mileage_amount', 134);
$mileage_memo = egb('mileage_memo');

// 현재 회원의 마일리지 조회
$query = "SELECT user_mileage FROM egb_user WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $mileage_target_uniq_id];
$binding = binding_sql(1, $query, $params);
$result = egb_sql($binding);

if (!$result || !isset($result[0])) {
    echo json_encode(['success' => false, 'failureCode' => 135]); // 존재하지 않는 회원
    exit;
}

$mileage_before_balance = $result[0]['user_mileage'] ?? 0;

// 마일리지 처리 유형에 따라 계산
if ($mileage_type == '1') { // 지급
    $mileage_after_balance = $mileage_before_balance + $mileage_amount;
} else if ($mileage_type == '0') { // 차감
    // 차감할 금액이 현재 마일리지보다 큰 경우 에러
    if ($mileage_amount > $mileage_before_balance) {
        echo json_encode(['success' => false, 'failureCode' => 136]); // 차감할 금액이 현재 마일리지보다 큼
        exit;
    }
    $mileage_after_balance = $mileage_before_balance - $mileage_amount;
} else {
    echo json_encode(['success' => false, 'failureCode' => 137]); // 잘못된 마일리지 처리 유형
    exit;
}

// egb_mileage 테이블에 내역 추가
$query = "
INSERT INTO egb_mileage (
    uniq_id,
    mileage_target_uniq_id,
    mileage_type,
    mileage_reason,
    mileage_amount,
    mileage_before_balance,
    mileage_after_balance,
    mileage_memo,
    created_by
) VALUES (
    :uniq_id,
    :mileage_target_uniq_id,
    :mileage_type,
    :mileage_reason,
    :mileage_amount,
    :mileage_before_balance,
    :mileage_after_balance,
    :mileage_memo,
    :created_by
)";

$params = [
    ':uniq_id' => $uniq_id,
    ':mileage_target_uniq_id' => $mileage_target_uniq_id,
    ':mileage_type' => $mileage_type,
    ':mileage_reason' => $mileage_reason,
    ':mileage_amount' => $mileage_amount,
    ':mileage_before_balance' => $mileage_before_balance,
    ':mileage_after_balance' => $mileage_after_balance,
    ':mileage_memo' => $mileage_memo,
    ':created_by' => $filter_user_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if (!$sql) {
    echo json_encode(['success' => false, 'failureCode' => 138]); // 마일리지 내역 추가 실패
    exit;
}

// egb_user 테이블의 마일리지 업데이트
$query = "UPDATE egb_user SET user_mileage = :mileage_after_balance WHERE uniq_id = :uniq_id";
$params = [
    ':mileage_after_balance' => $mileage_after_balance,
    ':uniq_id' => $mileage_target_uniq_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if (!$sql) {
    echo json_encode(['success' => false, 'failureCode' => 139]); // 마일리지
    exit;
}

// 레코드 카운트 증가
increase_record_total_count('egb_mileage');
increase_record_active_count('egb_mileage');

echo json_encode([
    'success' => true,
    'successCode' => 21,
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
