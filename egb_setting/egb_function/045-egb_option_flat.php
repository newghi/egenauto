<?php
function egb_option_flat($group_code) {
    // 그룹 uniq_id 조회
    $query1 = "
        SELECT uniq_id
        FROM egb_option_group
        WHERE group_code = :group_code AND is_status = 1
        LIMIT 1
    ";
    $params1 = [':group_code' => $group_code];
    $binding1 = binding_sql(1, $query1, $params1);
    $result1 = egb_sql($binding1);

    if (!isset($result1[0]['uniq_id'])) {
        return [];
    }

    $group_uniq_id = $result1[0]['uniq_id'];

    // 전체 옵션 조회
    $query2 = "
        SELECT no, uniq_id, is_status, display_order, 
               option_group_uniq_id, option_label, option_access_level,
               option_is_active, option_data, created_by, updated_by,
               deleted_by, created_at, deleted_at, updated_at
        FROM egb_option
        WHERE option_group_uniq_id = :group_uniq_id AND is_status = 1
        ORDER BY display_order ASC, no ASC
    ";
    $params2 = [':group_uniq_id' => $group_uniq_id];
    $binding2 = binding_sql(0, $query2, $params2);
    $result2 = egb_sql($binding2);

    $all = $result2[0] ?? [];
    if (!$all) return [];

    // 배열로 매핑
    $flat = [];
    foreach ($all as $item) {
        $flat[] = [
            'no' => $item['no'],
            'uniq_id' => $item['uniq_id'], 
            'is_status' => $item['is_status'],
            'display_order' => $item['display_order'],
            'option_group_uniq_id' => $item['option_group_uniq_id'],
            'label' => $item['option_label'],
            'option_access_level' => $item['option_access_level'],
            'option_is_active' => $item['option_is_active'],
            'option_data' => $item['option_data'],
            'created_by' => $item['created_by'],
            'updated_by' => $item['updated_by'],
            'deleted_by' => $item['deleted_by'],
            'created_at' => $item['created_at'],
            'deleted_at' => $item['deleted_at'],
            'updated_at' => $item['updated_at']
        ];
    }

    return $flat;
}
?>