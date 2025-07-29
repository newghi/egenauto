<?php
function egb_option_group_insert($group_code, $group_title, $group_description = null) {

    $created_by = 'system'; // 또는 로그인 사용자 등으로 교체 가능
    $group_description = $group_description ?? $group_title;
    $group_access_level = 0;
    $display_order = 0;
    $is_status = 1;
    $group_required = 1;

    $uniq_id = uniqid();

    $query = "
        INSERT INTO egb_option_group (
            uniq_id, group_code, group_title, group_description,
            group_access_level, display_order, created_by,
            is_status, group_required
        ) VALUES (
            :uniq_id, :group_code, :group_title, :group_description,
            :group_access_level, :display_order, :created_by,
            :is_status, :group_required
        )
    ";
    $params = [
        ':uniq_id' => $uniq_id,
        ':group_code' => $group_code,
        ':group_title' => $group_title,
        ':group_description' => $group_description,
        ':group_access_level' => $group_access_level,
        ':display_order' => $display_order,
        ':created_by' => $created_by,
        ':is_status' => $is_status,
        ':group_required' => $group_required
    ];

    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    if (isset($sql[0]) && $sql[0]) {
            // 레코드 카운트 증가
        increase_record_total_count('egb_option_group');
        increase_record_active_count('egb_option_group');
        return $uniq_id;
    } else {
        return false;
    }
}
?>
