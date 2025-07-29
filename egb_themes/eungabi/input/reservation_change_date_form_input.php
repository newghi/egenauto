<?php

$store_uniq_id = egb('reservation_store_uniq_id', 157);
$date = egb('reservation_date_day', 157);
$group_uniq_id = egb('reservation_group_uniq_id', 157);

if (empty($store_uniq_id) || empty($date) || empty($group_uniq_id)) {
    echo json_encode(['success' => false, 'failureCode' => 158]);
    exit;
}

// 날짜 분리
$date_parts = explode('-', $date);
$year = $date_parts[0];
$month = $date_parts[1];
$day = $date_parts[2];

// 스토어 스케줄 조회
$sql = "SELECT store_schedule FROM egb_store WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $store_uniq_id];
$binding = binding_sql(1, $sql, $params);
$result = egb_sql($binding);

$schedule = [];
$holidays = [];
if (!empty($result[0]['store_schedule'])) {
    $schedule = json_decode($result[0]['store_schedule'], true);
    if (isset($schedule['holidays'])) {
        $holidays = $schedule['holidays'];
    }
}

// 선택한 날짜가 휴일인지 체크
$selected_date = sprintf("%04d-%02d-%02d", $year, $month, $day);
$is_holiday = false;
foreach ($holidays as $holiday) {
    if ($holiday['date'] === $selected_date) {
        $is_holiday = true;
        break;
    }
}

// 선택한 날짜의 요일 구하기
$timestamp = strtotime($selected_date);
$days = ['일', '월', '화', '수', '목', '금', '토'];
$day_name = $days[date('w', $timestamp)];

// 해당 요일의 스케줄 가져오기
$day_schedule = isset($schedule[$day_name]) ? $schedule[$day_name] : null;

// 해당 그룹의 예약 시간 조회
$group_reservation_query = "
    SELECT reservation_time 
    FROM egb_reservation 
    WHERE reservation_group_uniq_id = :group_uniq_id 
    AND deleted_at IS NULL 
    LIMIT 1
";
$group_params = [':group_uniq_id' => $group_uniq_id];
$group_binding = binding_sql(1, $group_reservation_query, $group_params);
$group_result = egb_sql($group_binding);
$group_reservation_time = !empty($group_result[0]['reservation_time']) ? $group_result[0]['reservation_time'] : null;

$time_slots = [];
if (!$is_holiday && $day_schedule && $day_schedule['status'] == 1) {
    foreach ($day_schedule['slots'] as $slot) {
        if ($slot['status'] == 1) {
            $hour = explode(':', $slot['time'])[0];
            
            // 해당 시간대의 예약된 차량 수 조회
            $reservation_count_query = "
                SELECT COUNT(*) as cnt 
                FROM egb_reservation 
                WHERE reservation_store_uniq_id = :store_uniq_id
                AND YEAR(reservation_date) = :year
                AND MONTH(reservation_date) = :month
                AND DAY(reservation_date) = :day
                AND HOUR(reservation_time) = :hour
                AND reservation_status IN (1, 2, 3)
                AND deleted_at IS NULL
            ";
            
            $reservation_count_params = [
                ':store_uniq_id' => $store_uniq_id,
                ':year' => $year,
                ':month' => $month,
                ':day' => $day,
                ':hour' => $hour
            ];

            $reservation_count_binding = binding_sql(1, $reservation_count_query, $reservation_count_params);
            $reservation_count_result = egb_sql($reservation_count_binding);
            $reserved_count = $reservation_count_result[0]['cnt'];

            // 실제 가능한 차량 수 계산
            $available_count = max(0, $slot['count'] - $reserved_count);
            
            $time_slots[] = [
                'time' => $slot['time'],
                'available_count' => $available_count,
                'is_current_time' => ($group_reservation_time && substr($group_reservation_time, 0, 5) === $slot['time'])
            ];
        }
    }
}




echo json_encode([
    'success' => true,
    'successCode' => 20,
    'data' => [
        'store_uniq_id' => $store_uniq_id,
        'date' => $selected_date,
        'is_holiday' => $is_holiday,
        'day_name' => $day_name,
        'time_slots' => $time_slots,
        'current_reservation_time' => $group_reservation_time ? substr($group_reservation_time, 0, 5) : null
    ]
]);

?>