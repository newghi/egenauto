<?php
function egb_store_toggle_weekday_status($uniq_id, $weekday) {
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
    if (!isset($schedule[$weekday]) || !isset($schedule[$weekday]['status'])) {
        return false;
    }

    // 3) 상태 토글
    $current = (int)$schedule[$weekday]['status'];
    $schedule[$weekday]['status'] = $current === 1 ? 0 : 1;

    // 4) JSON 재인코딩 및 업데이트
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
