<?php
function egb_option_tree($group_code) {
    // 그룹 uniq_id 조회
    $query1 = "
        SELECT uniq_id
        FROM egb_option_group
        WHERE group_code = :group_code AND is_status IN (0, 1)
        LIMIT 1
    ";
    $params1 = [':group_code' => $group_code];
    $binding1 = binding_sql(1, $query1, $params1);
    $result1 = egb_sql($binding1);

    if (!isset($result1[0]['uniq_id'])) {
        return [];
    }

    $group_uniq_id = $result1[0]['uniq_id'];

    // 전체 옵션 조회 (is_status 상관없이)
    $query2 = "
        SELECT uniq_id, option_label, is_status
        FROM egb_option
        WHERE option_group_uniq_id = :group_uniq_id
        ORDER BY display_order ASC, no ASC
    ";
    $params2 = [':group_uniq_id' => $group_uniq_id];
    $binding2 = binding_sql(0, $query2, $params2);
    $result2 = egb_sql($binding2);

    $all = $result2[0] ?? [];
    if (!$all) return [];

    // ID 기준 맵 생성
    $map = [];
    foreach ($all as $item) {
        $map[$item['uniq_id']] = [
            'uniq_id' => $item['uniq_id'],
            'label' => $item['option_label'],
            'status' => (int)$item['is_status'],
            'children' => []
        ];
    }

    // 트리 구성
    $tree = [];
    foreach ($map as $id => &$node) {
        $tree[] =& $node;
    }
    unset($node);

    return $tree;
}
?>
