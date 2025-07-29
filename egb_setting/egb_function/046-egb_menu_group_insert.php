<?php
function egb_menu_group_insert($group_code, $group_name, $parent_group_uniq_id = null) {
    $created_by = 'system'; // 필요시 사용자 ID로 변경
    $group_access_level = 0;
    $display_order = 0;
    $is_status = 1;

    $uniq_id = uniqid();

    $query = "
        INSERT INTO egb_menu_group (
            uniq_id, group_code, group_name, group_access_level, 
            display_order, is_status, created_by, parent_group_uniq_id
        ) VALUES (
            :uniq_id, :group_code, :group_name, :group_access_level,
            :display_order, :is_status, :created_by, :parent_group_uniq_id
        )
    ";
    $params = [
        ':uniq_id' => $uniq_id,
        ':group_code' => $group_code,
        ':group_name' => $group_name,
        ':group_access_level' => $group_access_level,
        ':display_order' => $display_order,
        ':is_status' => $is_status,
        ':created_by' => $created_by,
        ':parent_group_uniq_id' => $parent_group_uniq_id
    ];

    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    if (isset($sql[0]) && $sql[0]) {
        increase_record_total_count('egb_menu_group');
        increase_record_active_count('egb_menu_group');
        return $uniq_id;
    } else {
        return false;
    }
}
?>
