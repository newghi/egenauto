<?php
function egb_menu_insert($group_uniq_id, $menu_name, $menu_url = null) {

    $created_by = 'system';
    $is_status = 1;
    $display_order = 0;
    $menu_access_level = 0;
    $menu_target = '_self'; // 기본 고정값

    $uniq_id = uniqid();

    $query = "
        INSERT INTO egb_menu (
            uniq_id, group_uniq_id, menu_name, menu_url,
            menu_access_level, menu_target, is_status, 
            display_order, created_by
        ) VALUES (
            :uniq_id, :group_uniq_id, :menu_name, :menu_url,
            :menu_access_level, :menu_target, :is_status,
            :display_order, :created_by
        )
    ";

    $params = [
        ':uniq_id' => $uniq_id,
        ':group_uniq_id' => $group_uniq_id,
        ':menu_name' => $menu_name,
        ':menu_url' => $menu_url,
        ':menu_access_level' => $menu_access_level,
        ':menu_target' => $menu_target,
        ':is_status' => $is_status,
        ':display_order' => $display_order,
        ':created_by' => $created_by
    ];

    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    if (isset($sql[0]) && $sql[0]) {
        increase_record_total_count('egb_menu');
        increase_record_active_count('egb_menu');
        return $uniq_id;
    } else {
        return false;
    }
}
?>
