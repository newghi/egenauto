<?php
function egb_store_delete_holiday($uniq_id, $date) {
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
    if (!is_array($schedule) || !isset($schedule['holidays']) || !is_array($schedule['holidays'])) {
        return false;
    }

    // 3) 삭제 전후 비교를 위한 카피
    $originalCount = count($schedule['holidays']);
    // 4) 해당 날짜를 제외하고 재구성
    $schedule['holidays'] = array_values(array_filter(
        $schedule['holidays'],
        function($h) use ($date) {
            return !(isset($h['date']) && $h['date'] === $date);
        }
    ));
    // 5) 삭제된 항목이 없으면 false 반환
    if (count($schedule['holidays']) === $originalCount) {
        return false;
    }

    // 6) JSON 재인코딩 및 업데이트
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
