
<?php

function egb_reward_dispatch($user_uniq_id, $reward_code, $target_type = 'point', $expire_type = 0, $check_callback = null) {
    if (!$user_uniq_id || !$reward_code || !in_array($target_type, ['point', 'deposit', 'mileage'])) {
        return false;
    }

    // 1. 리워드 로그 기록 및 정보 반환
    $reward_result = egb_reward_log_insert($user_uniq_id, $reward_code, $expire_type, $check_callback);

    if (!$reward_result || !isset($reward_result['grant_amount'])) {
        return false;
    }

    $amount = (int)$reward_result['grant_amount'];
    $title  = $reward_result['reward_title'];
    $uniq_id = $reward_result['uniq_id'];

    // 2. 포인트/예치금/마일리지 분기 처리
    if ($target_type == 'point') {
        return egb_point_insert($user_uniq_id, $amount, 1, $title, '리워드 로그 ID: ' . $uniq_id);
    }

    if ($target_type == 'deposit') {
        return egb_deposit_insert($user_uniq_id, $amount, 1, $title, '리워드 로그 ID: ' . $uniq_id);
    }

    if ($target_type == 'mileage') {
        return egb_mileage_insert($user_uniq_id, $amount, 1, $title, '리워드 로그 ID: ' . $uniq_id);
    }

    return false;
}
?>
