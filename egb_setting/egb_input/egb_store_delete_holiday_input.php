
<?php
$uniq_id = egb('uniq_id', 'store_delete_holiday_1');
$holiday_date = egb('holiday_date', 'store_delete_holiday_2');

// 기존 스케줄 조회
$sqlSelect = "SELECT store_schedule FROM egb_store WHERE uniq_id = :uniq_id";
$paramsSelect = [':uniq_id' => $uniq_id];
$bindingSelect = binding_sql(1, $sqlSelect, $paramsSelect);
$rowResult = egb_sql($bindingSelect);

if (!$rowResult || !isset($rowResult[0]['store_schedule'])) {
    echo json_encode([
        'success' => false,
        'failureCode' => 'store_delete_holiday_3'
    ]);
    exit;
}

// JSON 파싱
$schedule = json_decode($rowResult[0]['store_schedule'], true);
if (!is_array($schedule) || !isset($schedule['holidays'])) {
    echo json_encode([
        'success' => false, 
        'failureCode' => 'store_delete_holiday_4'
    ]);
    exit;
}

// 해당 날짜의 휴일 삭제
$holidays = $schedule['holidays'];
$found = false;
foreach ($holidays as $key => $holiday) {
    if ($holiday['date'] === $holiday_date) {
        unset($schedule['holidays'][$key]);
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode([
        'success' => false,
        'failureCode' => 'store_delete_holiday_5' 
    ]);
    exit;
}

// 배열 재정렬
$schedule['holidays'] = array_values($schedule['holidays']);

// JSON 업데이트
$jsonSchedule = json_encode($schedule, JSON_UNESCAPED_UNICODE);
$sqlUpdate = "UPDATE egb_store SET store_schedule = :schedule WHERE uniq_id = :uniq_id";
$paramsUpdate = [
    ':schedule' => $jsonSchedule,
    ':uniq_id' => $uniq_id
];
$bindingUpdate = binding_sql(2, $sqlUpdate, $paramsUpdate);
$res = egb_sql($bindingUpdate);

if (isset($res[0]) && $res[0]) {
    echo json_encode([
        'success' => true,
        'successCode' => 'store_delete_holiday_6',
        'holiday_date' => $holiday_date
    ]);
} else {
    echo json_encode([
        'success' => false,
        'failureCode' => 'store_delete_holiday_7'
    ]);
}
?>
