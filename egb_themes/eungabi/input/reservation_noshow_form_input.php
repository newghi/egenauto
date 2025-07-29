<?php

$reservation_group_uniq_id = egb('reservation_group_uniq_id', 157);
$reservation_noshow_memo = egb('reservation_noshow_memo', 160);

// 예약 노쇼 처리를 위한 업데이트 쿼리 - 그룹 내 모든 예약 데이터 업데이트
$update_query = "
    UPDATE egb_reservation 
    SET reservation_status = 4, 
        reservation_no_show_at = NOW(),
        reservation_no_show_by = 'system',
        reservation_no_show_note = :reservation_no_show_note,
        updated_at = NOW(),
        updated_by = 'system'
    WHERE reservation_group_uniq_id = :reservation_group_uniq_id
    AND deleted_at IS NULL
";

$update_params = [
    ':reservation_group_uniq_id' => $reservation_group_uniq_id,
    ':reservation_no_show_note' => $reservation_noshow_memo
];

$update_binding = binding_sql(2, $update_query, $update_params);
$result = egb_sql($update_binding);

// 업데이트된 예약 정보 조회
$query = "
    SELECT r.*, 
           GROUP_CONCAT(r.reservation_time ORDER BY r.reservation_time ASC) as reservation_times,
           MIN(r.reservation_date) as start_date,
           MAX(r.reservation_date) as end_date,
           MAX(r.reservation_no_show_at) as reservation_no_show_at
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
    $reservation[0]['reservation_no_show_by']
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
        SELECT option_label
        FROM egb_option 
        WHERE uniq_id IN ('" . implode("','", $reservation_data['car_maintenance_items']) . "')
    ";
    $items_binding = binding_sql(0, $items_query);
    $items_result = egb_sql($items_binding);
    
    foreach ($items_result[0] as $item) {
        $maintenance_items[] = $item['option_label'];
    }
}

$result = [
    'uniq_id' => $reservation[0]['uniq_id'],
    'reservation_group_uniq_id' => $reservation_group_uniq_id,
    'store_name' => $store[0]['store_name'] ?? '',
    'reservation_date' => $reservation[0]['start_date'],
    'reservation_time' => $start_time . ' ~ ' . $end_time . ' (' . $duration . '시간)',
    'reservation_weekday' => $reservation[0]['reservation_weekday'],
    'reservation_status' => $reservation[0]['reservation_status'],
    'user_name' => $user[0]['user_name'] ?? '',
    'user_phone_number' => $user[0]['user_phone1'] ?? $user[0]['user_phone2'] ?? '',
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
    'cancel_date' => $reservation[0]['reservation_canceled_at'],
    'noshow_date' => $reservation[0]['reservation_no_show_at'],
    'confirm_admin' => $admin_names[$reservation[0]['reservation_confirmed_by']] ?? '',
    'cancel_admin' => $admin_names[$reservation[0]['reservation_canceled_by']] ?? '',
    'noshow_admin' => $admin_names[$reservation[0]['reservation_no_show_by']] ?? '',
    'manager_note' => $reservation[0]['reservation_manager_note'] ?? '',
    'canceled_note' => $reservation[0]['reservation_canceled_note'] ?? '',
    'noshow_note' => $reservation[0]['reservation_no_show_note'] ?? ''
];

// 예약 노쇼 알림 처리
$user_uniq_id = $reservation[0]['reservation_user_uniq_id'];
$store_name = $store[0]['store_name'] ?? '매장';
$reservation_date = $reservation[0]['start_date'];
$formatted_date = date('Y년 m월 d일', strtotime($reservation_date));
$formatted_time = $start_time . ' ~ ' . $end_time;

// 사용자에게 예약 노쇼 알림 전송
$message = "{$store_name}의 {$formatted_date} {$formatted_time} 예약이 노쇼 처리되었습니다.";
$view_path = "";

// 알림 데이터베이스에 저장
egb_alarm_insert(
    $user_uniq_id,
    '예약 노쇼 알림',
    $message,
    $view_path,
    'reservation_noshow'
);

// 푸시 알림 전송
egb_send_push_event(
    "public-user-{$user_uniq_id}",
    'reservation-noshow',
    [
        'uniq_id' => $user_uniq_id,
        'user_nick_name' => $user[0]['user_name'] ?? '',
        'board_type' => '',
        'board_uniq_id' => '',
        'like_target_table' => '',
        'like_user_uniq_id' => '',
        'message' => $message,
        'view_path' => $view_path,
        'created_at' => date('Y-m-d H:i:s') 
    ]
);

echo json_encode([
    'success' => true, 'successCode' => 22,
    'data' => $result
]);

?>