<?php

$reservation_group_uniq_id = egb('reservation_group_uniq_id', 157);

$query = "
    SELECT r.*, 
           GROUP_CONCAT(r.reservation_time ORDER BY r.reservation_time ASC) as reservation_times,
           MIN(r.reservation_date) as start_date,
           MAX(r.reservation_date) as end_date
    FROM egb_reservation r
    WHERE r.reservation_group_uniq_id = :reservation_group_uniq_id 
    AND r.deleted_at IS NULL
    GROUP BY r.reservation_group_uniq_id
";

$params = [':reservation_group_uniq_id' => $reservation_group_uniq_id];
$binding = binding_sql(1, $query, $params);
$reservation = egb_sql($binding);

if (empty($reservation[0])) {
    echo json_encode(['success' => false, 'failureCode' => 158]);
    exit;
}

$store_query = "
    SELECT uniq_id, store_name 
    FROM egb_store
    WHERE uniq_id = :store_uniq_id
";
$store_params = [':store_uniq_id' => $reservation[0]['reservation_store_uniq_id']];
$store_binding = binding_sql(1, $store_query, $store_params);
$store = egb_sql($store_binding);

$user_query = "
    SELECT uniq_id, user_name, user_phone1, user_phone2, user_email
    FROM egb_user
    WHERE uniq_id = :user_uniq_id
";
$user_params = [':user_uniq_id' => $reservation[0]['reservation_user_uniq_id']];
$user_binding = binding_sql(1, $user_query, $user_params);
$user = egb_sql($user_binding);

// 처리자 정보 조회
$admin_uniq_ids = array_filter([
    $reservation[0]['reservation_confirmed_by'],
    $reservation[0]['reservation_canceled_by'], 
    $reservation[0]['reservation_no_show_by'],
    $reservation[0]['reservation_completed_by']
]);

$admin_names = [];
if (!empty($admin_uniq_ids)) {
    $admin_query = "
        SELECT uniq_id, user_name
        FROM egb_user 
        WHERE uniq_id IN ('" . implode("','", $admin_uniq_ids) . "')
    ";
    $admin_binding = binding_sql(0, $admin_query);
    $admin_result = egb_sql($admin_binding);
    
    foreach ($admin_result[0] as $admin) {
        $admin_names[$admin['uniq_id']] = $admin['user_name'];
    }
}

$reservation_data = json_decode($reservation[0]['reservation_data'], true);

// 시작 시간과 종료 시간 계산
$times = explode(',', $reservation[0]['reservation_times']);
$start_time = substr($times[0], 0, 5);
$end_time = date('H:i', strtotime(end($times) . ' +1 hour'));

// 총 소요 시간 계산
$start = strtotime($times[0]);
$end = strtotime(end($times)) + 3600; // 마지막 시간에 1시간 추가
$duration = ($end - $start) / 3600; // 시간 단위로 변환

// 정비 항목 라벨 조회
$maintenance_items = [];
if (!empty($reservation_data['car_maintenance_items'])) {
    $items_query = "
        SELECT option_label, uniq_id
        FROM egb_option 
        WHERE uniq_id IN ('" . implode("','", $reservation_data['car_maintenance_items']) . "')
    ";
    $items_binding = binding_sql(0, $items_query);
    $items_result = egb_sql($items_binding);
    
    foreach ($items_result[0] as $item) {
        $maintenance_items[] = [
            'uniq_id' => $item['uniq_id'],
            'label' => $item['option_label']
        ];
    }
}

$result = [
    'uniq_id' => $reservation[0]['uniq_id'],
    'reservation_group_uniq_id' => $reservation_group_uniq_id,
    'reservation_store_uniq_id' => $reservation[0]['reservation_store_uniq_id'],
    'store_name' => $store[0]['store_name'] ?? '',
    'reservation_date' => $reservation[0]['start_date'],
    'reservation_time' => $start_time . ' ~ ' . $end_time . ' (' . $duration . '시간)',
    'reservation_weekday' => $reservation[0]['reservation_weekday'],
    'reservation_status' => $reservation[0]['reservation_status'],
    'user_name' => $user[0]['user_name'] ?? '',
    'user_phone_number' => $reservation_data['user_phone_number'] ?? '',
    'user_email' => $user[0]['user_email'] ?? '',
    'car_model' => $reservation_data['car_model'] ?? '',
    'car_model_year' => $reservation_data['car_model_year'] ?? '',
    'car_number' => $reservation_data['car_number'] ?? '',
    'car_mileage' => $reservation_data['car_mileage'] ?? '',
    'car_type' => $reservation_data['car_type'] ?? '',
    'car_product_check' => $reservation_data['car_product_check'] ?? '',
    'car_maintenance_items' => $maintenance_items,
    'title' => $reservation_data['title'] ?? '',
    'contents' => $reservation_data['contents'] ?? '',
    'estimated_time' => $duration,
    'request_date' => $reservation[0]['reservation_applied_at'],
    'confirm_date' => $reservation[0]['reservation_confirmed_at'],
    'complete_date' => $reservation[0]['reservation_completed_at'],
    'cancel_date' => $reservation[0]['reservation_canceled_at'],
    'noshow_date' => $reservation[0]['reservation_no_show_at'],
    'confirm_admin' => $admin_names[$reservation[0]['reservation_confirmed_by']] ?? '',
    'complete_admin' => $admin_names[$reservation[0]['reservation_completed_by']] ?? '',
    'cancel_admin' => $admin_names[$reservation[0]['reservation_canceled_by']] ?? '',
    'noshow_admin' => $admin_names[$reservation[0]['reservation_no_show_by']] ?? '',
    'manager_note' => $reservation[0]['reservation_manager_note'] ?? '',
    'canceled_note' => $reservation[0]['reservation_canceled_note'] ?? '',
    'noshow_note' => $reservation[0]['reservation_no_show_note'] ?? ''
];

error_log(json_encode($result));
echo json_encode([
    'success' => true, 'successCode' => 18,
    'data' => $result
]);

?>