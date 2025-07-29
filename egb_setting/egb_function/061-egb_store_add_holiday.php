<?php
function egb_store_add_holiday($uniq_id, $date, $holiday_name) {
    // 1) 기존 스케줄 조회
    $sqlSelect     = "SELECT store_schedule FROM egb_store WHERE uniq_id = :uniq_id";
    $paramsSelect  = [':uniq_id' => $uniq_id];
    $bindingSelect = binding_sql(1, $sqlSelect, $paramsSelect);
    $rowResult     = egb_sql($bindingSelect);
    if (!$rowResult || !isset($rowResult[0]['store_schedule'])) {
        return false;
    }

    // 2) JSON 파싱
    $schedule = json_decode($rowResult[0]['store_schedule'], true);
    if (!is_array($schedule)) {
        return false;
    }

    // 3) 중복 체크 및 holiday_name 업데이트
    if (isset($schedule['holidays']) && is_array($schedule['holidays'])) {
        foreach ($schedule['holidays'] as $key => $h) {
            if (isset($h['date']) && $h['date'] === $date) {
                // 같은 날짜인 경우 holiday_name만 업데이트
                $schedule['holidays'][$key]['holiday_name'] = $holiday_name;
                $found = true;
                break;
            }
        }
    } else {
        $schedule['holidays'] = [];
    }

    // 4) 새로운 날짜인 경우 추가
    if (!isset($found)) {
        $schedule['holidays'][] = [
            'date'         => $date,
            'holiday_name' => $holiday_name,
        ];
    }

    // 5) JSON 재인코딩 및 업데이트
    $jsonSchedule  = json_encode($schedule, JSON_UNESCAPED_UNICODE);
    $sqlUpdate     = "UPDATE egb_store SET store_schedule = :schedule WHERE uniq_id = :uniq_id";
    $paramsUpdate  = [
        ':schedule' => $jsonSchedule,
        ':uniq_id'  => $uniq_id,
    ];
    $bindingUpdate = binding_sql(2, $sqlUpdate, $paramsUpdate);
    $res           = egb_sql($bindingUpdate);

    return isset($res[0]) && $res[0];
}
?>
