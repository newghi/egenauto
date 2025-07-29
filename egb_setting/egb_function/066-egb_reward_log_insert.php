
<?php

function egb_reward_log_insert($user_uniq_id, $reward_code, $expire_type = 0, $check_callback = null) {
    if (!$user_uniq_id || !$reward_code) {
        return false;
    }

    $query1 = "
        SELECT reward_title, reward_name, reward_grant, reward_expired_days, reward_limit_count, reward_data
        FROM egb_reward
        WHERE reward_code = :reward_code
          AND is_status = 1
        LIMIT 1
    ";
    $params1 = [':reward_code' => $reward_code];
    $binding1 = binding_sql(1, $query1, $params1);
    $result = egb_sql($binding1);

    if (!$result || empty($result[0])) {
        return false;
    }

    $reward = $result[0];
    $limit_count = (int)$reward['reward_limit_count'];

    // ✅ 외부에서 전달된 조건 검사 함수 실행
    if (is_callable($check_callback)) {
        $check_result = call_user_func($check_callback, $user_uniq_id, $reward_code, $reward['reward_data'] ?? null);
        if (!$check_result) {
            return false;
        }
    }

    // ✅ 지급 횟수 제한 검사
    if ($limit_count > 0) {
        $query_check = "
            SELECT COUNT(*) AS cnt
            FROM egb_reward_log
            WHERE reward_log_user_uniq_id = :user_uniq_id
              AND reward_log_title = :reward_title
              AND reward_log_name = :reward_name
        ";
        $params_check = [
            ':user_uniq_id' => $user_uniq_id,
            ':reward_title' => $reward['reward_title'],
            ':reward_name' => $reward['reward_name']
        ];
        $binding_check = binding_sql(1, $query_check, $params_check);
        $check_result = egb_sql($binding_check);

        if ($check_result && $check_result[0]['cnt'] >= $limit_count) {
            return false;
        }
    }

    $uniq_id = uniqid();
    $grant_amount = (int)$reward['reward_grant'];
    $expired_days = (int)$reward['reward_expired_days'];
    $expired_at = ($expired_days > 0)
        ? date('Y-m-d H:i:s', strtotime("+{$expired_days} days"))
        : null;

    $query2 = "
        INSERT INTO egb_reward_log (
            uniq_id,
            reward_log_user_uniq_id,
            reward_log_title,
            reward_log_name,
            reward_log_grant_amount,
            reward_log_used_amount,
            reward_log_expired_at,
            reward_log_expire_type,
            created_by
        ) VALUES (
            :uniq_id,
            :user_uniq_id,
            :reward_title,
            :reward_name,
            :grant_amount,
            0,
            :expired_at,
            :expire_type,
            'system'
        )
    ";
    $params2 = [
        ':uniq_id' => $uniq_id,
        ':user_uniq_id' => $user_uniq_id,
        ':reward_title' => $reward['reward_title'],
        ':reward_name' => $reward['reward_name'],
        ':grant_amount' => $grant_amount,
        ':expired_at' => $expired_at,
        ':expire_type' => $expire_type
    ];
    $binding2 = binding_sql(2, $query2, $params2);
    $result_tx = egb_sql($binding2);

    if ($result_tx && isset($result_tx[0]) && $result_tx[0]) {
        increase_record_total_count('egb_reward_log');
        increase_record_active_count('egb_reward_log');

        return [
            'uniq_id' => $uniq_id,
            'grant_amount' => $grant_amount,
            'reward_title' => $reward['reward_title'],
            'reward_name' => $reward['reward_name']
        ];
    }

    return false;
}
?>
