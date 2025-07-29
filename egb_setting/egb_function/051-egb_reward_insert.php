<?php
function egb_reward_insert($reward_code, $reward_title, $reward_name) {
    $query = "
    INSERT INTO egb_reward (
        uniq_id,
        reward_code,
        reward_title,
        reward_name,
        reward_type,
        reward_limit_count,
        reward_grant,
        reward_expired_days,
        reward_memo,
        reward_data,
        created_by
    ) VALUES (
        :uniq_id,
        :reward_code,
        :reward_title,
        :reward_name,
        :reward_type,
        :reward_limit_count,
        :reward_grant,
        :reward_expired_days,
        :reward_memo,
        :reward_data,
        :created_by
    )";

    $params = [
        ':uniq_id' => uniqid(),
        ':reward_code' => $reward_code,
        ':reward_title' => $reward_title,
        ':reward_name' => $reward_name,
        ':reward_type' => 1,
        ':reward_limit_count' => 1,
        ':reward_grant' => 1000,
        ':reward_expired_days' => 365,
        ':reward_memo' => '',
        ':reward_data' => '{}',
        ':created_by' => 'system'
    ];

    $binding = binding_sql(2, $query, $params);
    $result = egb_sql($binding);

    if ($result !== false) {
        increase_record_total_count('egb_reward');
        increase_record_active_count('egb_reward');
        return true;
    }
    return false;
}
?>
