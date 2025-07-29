<?php

function egb_mileage_insert($target_uniq_id, $amount, $type, $reason, $memo = '') {
    if (!$target_uniq_id || !in_array($type, [0, 1]) || $amount < 0) {
        return false;
    }

    // 1. 현재 마일리지 조회
    $query1 = "
        SELECT user_mileage
        FROM egb_user
        WHERE uniq_id = :user_uniq_id
        LIMIT 1
    ";
    $params1 = [':user_uniq_id' => $target_uniq_id];
    $binding1 = binding_sql(1, $query1, $params1);
    $result = egb_sql($binding1);

    if (!$result || !isset($result[0]['user_mileage'])) {
        return false;
    }

    $before = (int)$result[0]['user_mileage'];
    $after = $type == 1 ? $before + $amount : $before - $amount;

    if ($after < 0) {
        return false;
    }

    $uniq_id = uniqid();

    // 2. 마일리지 로그 인서트
    $query2 = "
        INSERT INTO egb_mileage (
            uniq_id,
            mileage_target_uniq_id,
            mileage_amount,
            mileage_type,
            mileage_before_balance,
            mileage_after_balance,
            mileage_status,
            mileage_reason,
            mileage_memo,
            created_by
        ) VALUES (
            :uniq_id,
            :target_uniq_id,
            :amount,
            :type,
            :before,
            :after,
            1,
            :reason,
            :memo,
            'system'
        )
    ";
    $params2 = [
        ':uniq_id' => $uniq_id,
        ':target_uniq_id' => $target_uniq_id,
        ':amount' => $amount,
        ':type' => $type,
        ':before' => $before,
        ':after' => $after,
        ':reason' => $reason,
        ':memo' => $memo
    ];
    $binding2 = binding_sql(2, $query2, $params2);

    // 3. 사용자 마일리지 반영
    $query3 = "
        UPDATE egb_user
        SET user_mileage = :after
        WHERE uniq_id = :user_uniq_id
    ";
    $params3 = [
        ':after' => $after,
        ':user_uniq_id' => $target_uniq_id
    ];
    $binding3 = binding_sql(2, $query3, $params3);

    // 4. 트랜잭션 실행
    $result_tx = egb_sql($binding2, $binding3);

    if ($result_tx && isset($result_tx[0]) && $result_tx[0] && isset($result_tx[1]) && $result_tx[1]) {
        // ✅ 마일리지 로그 통계 증가
        increase_record_total_count('egb_mileage');
        if ($type == 1) {
            increase_record_active_count('egb_mileage');
        } else {
            increase_record_inactive_count('egb_mileage');
        }

        return true;
    }

    return false;
}
?>
