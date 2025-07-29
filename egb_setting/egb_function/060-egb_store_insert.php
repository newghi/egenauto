
<?php
function egb_store_insert($store_name) {
    // 1) 기본값 할당
    $uniq_id = uniqid();   
    
    $store_registrant_uniq_id = 'system';           
    $created_by = 'system';

    // 2) 요일별 예약 슬롯 JSON 생성
    $weekdays = ['월','화','수','목','금','토','일'];
    $schedule = [];
    foreach ($weekdays as $day) {
        $slots = [];
        for ($h = 0; $h < 24; $h++) {
            $slots[] = [
                'time'      => sprintf('%02d:00', $h),
                'count' => 0,
                'status'    => 1,
            ];
        }
        $schedule[$day] = [
            'status' => 1,
            'slots'  => $slots,
        ];
    }

    // 3) 휴일 리스트 - 현재 날짜로 더미 데이터 생성
    $holidays = [
        ['date' => date('Y-m-d'), 'holiday_name' => '휴일 테스트'],
    ];
    $schedule['holidays'] = $holidays;

    $jsonSchedule = json_encode($schedule, JSON_UNESCAPED_UNICODE);

    // 4) INSERT 쿼리 바인딩
    $sqlInsert = "
        INSERT INTO egb_store
            (uniq_id, store_registrant_uniq_id, store_name, store_schedule, created_by)
        VALUES
            (:uniq_id, :store_registrant_uniq_id, :store_name, :store_schedule, :created_by)
    ";
    $paramsInsert = [
        ':uniq_id'                  => $uniq_id,
        ':store_registrant_uniq_id' => $store_registrant_uniq_id,
        ':store_name'               => $store_name,
        ':store_schedule'           => $jsonSchedule,
        ':created_by'               => $created_by,
    ];
    $bindingInsert = binding_sql(2, $sqlInsert, $paramsInsert);

    // 5) 실행 및 결과 반환
    $result = egb_sql($bindingInsert);
    return isset($result[0]);
}
?>
