

<?php
// 필요한 파라미터 가져오기
$uniq_id = egb('uniq_id', 'get_schedule_1');
$year = egb('year', 'get_schedule_2'); 
$month = egb('month', 'get_schedule_3');
$day = egb('day', 'get_schedule_4');

// 스토어 스케줄 정보 조회
$sql = "SELECT store_schedule FROM egb_store WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $uniq_id];
$binding = binding_sql(1, $sql, $params);
$result = egb_sql($binding);

if (!empty($result[0]['store_schedule'])) {
    // JSON 디코딩
    $schedule = json_decode($result[0]['store_schedule'], true);
    
    // 해당 날짜의 요일 구하기
    $date = new DateTime("$year-$month-$day");
    $weekday = $date->format('w'); // 0(일) ~ 6(토)
    $weekdays = ['일', '월', '화', '수', '목', '금', '토'];
    $weekday_kr = $weekdays[$weekday];
    
    // 휴일 체크
    $is_holiday = false;
    $holiday_name = '';
    if (isset($schedule['holidays'])) {
        foreach ($schedule['holidays'] as $holiday) {
            if ($holiday['date'] === "$year-$month-$day") {
                $is_holiday = true;
                $holiday_name = $holiday['holiday_name'];
                break;
            }
        }
    }

    // 시간별 예약 가능 수량 정보 추출
    $time_slots = [];
    if (isset($schedule[$weekday_kr]['slots'])) {
        foreach ($schedule[$weekday_kr]['slots'] as $slot) {
            // 해당 시간대의 예약된 차량 수를 조회
            $hour = explode(':', $slot['time'])[0];
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
                ':store_uniq_id' => $uniq_id,
                ':year' => $year,
                ':month' => $month,
                ':day' => $day,
                ':hour' => $hour
            ];

            $reservation_count_binding = binding_sql(1, $reservation_count_query, $reservation_count_params);
            $reservation_count_result = egb_sql($reservation_count_binding);
            $reserved_count = $reservation_count_result[0]['cnt'];

            // 실제 가능한 차량 수 계산 (전체 - 예약된 수)
            $available_count = max(0, $slot['count'] - $reserved_count);

            $time_slots[] = [
                'time' => $slot['time'],
                'count' => $available_count,
                'total_count' => $slot['count'], // 전체 예약 가능 수량 추가
                'status' => isset($slot['status']) ? $slot['status'] : 1
            ];
        }
    }
    
    // 응답 데이터 구성
    $response = [
        'success' => true,
        'successCode' => 'get_schedule_1',
        'schedule' => [
            'weekday' => $weekday_kr,
            'is_holiday' => $is_holiday,
            'holiday_name' => $holiday_name,
            'status' => isset($schedule[$weekday_kr]['status']) ? $schedule[$weekday_kr]['status'] : 0,
            'time_slots' => $time_slots
        ]
    ];
    
    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'failureCode' => 'get_schedule_7'
    ]);
}
?>
