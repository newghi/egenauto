<?php
function egb_option_insert($option_group_uniq_id, $option_label, $option_data_json = null) {
    $created_by = 'system';
    $is_status = 1;
    $display_order = 0;
    $option_access_level = 0;
    $option_is_active = 1;
    $option_data = $option_data_json;

    $uniq_id = uniqid();

    $query = "
        INSERT INTO egb_option (
            uniq_id, option_group_uniq_id, option_label,
            option_access_level, is_status, display_order,
            option_is_active, option_data, created_by,
            updated_by, deleted_by, created_at,
            deleted_at, updated_at
        ) VALUES (
            :uniq_id, :option_group_uniq_id, :option_label,
            :option_access_level, :is_status, :display_order,
            :option_is_active, :option_data, :created_by,
            NULL, NULL, CURRENT_TIMESTAMP,
            NULL, CURRENT_TIMESTAMP
        )
    ";
    $params = [
        ':uniq_id' => $uniq_id,
        ':option_group_uniq_id' => $option_group_uniq_id,
        ':option_label' => $option_label,
        ':option_access_level' => $option_access_level,
        ':is_status' => $is_status,
        ':display_order' => $display_order,
        ':option_is_active' => $option_is_active,
        ':option_data' => $option_data,
        ':created_by' => $created_by
    ];

    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    if (isset($sql[0]) && $sql[0]) {
        // 레코드 카운트 증가
        increase_record_total_count('egb_option');
        increase_record_active_count('egb_option');
        return $uniq_id;
    } else {
        return false;
    }
}
?>