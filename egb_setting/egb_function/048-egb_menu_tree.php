<?php
function egb_menu_tree($start_group_code = 'egb_menu', $depth_limit = 2) {
    $params = [];
    $query_where = 'is_status = 1';

    // 시작 그룹 코드 조건 추가 
    $query_where .= ' AND group_code = :group_code';
    $params[':group_code'] = $start_group_code;

    // 하나의 부모 메뉴를 가져옵니다.
    $query1 = "SELECT uniq_id, group_code, group_name, parent_group_uniq_id FROM egb_menu_group WHERE $query_where ORDER BY display_order ASC, no ASC LIMIT 1";
    $binding1 = binding_sql(1, $query1, $params);
    $result1 = egb_sql($binding1);
    $parent = $result1[0] ?? null;

    // 부모 메뉴가 없으면 빈 배열 반환
    if (!$parent) return [];

    // 부모 메뉴를 맵핑
    $map = [
        $parent['uniq_id'] => [
            'uniq_id' => $parent['uniq_id'],
            'group_code' => $parent['group_code'], 
            'group_name' => $parent['group_name'],
            'parent' => $parent['parent_group_uniq_id'],
            'children' => [],
            'depth' => 1
        ]
    ];

    // 모든 하위 메뉴를 재귀적으로 가져오기
    $get_children = function($parent_id, $current_depth, $depth_limit, &$map) use (&$get_children) {
        // depth_limit을 넘지 않으면 자식 메뉴 가져오기
        if ($current_depth >= $depth_limit) {
            return;
        }

        $query = "SELECT uniq_id, group_code, group_name, parent_group_uniq_id FROM egb_menu_group WHERE parent_group_uniq_id = :parent_id AND is_status = 1 ORDER BY display_order ASC, no ASC";
        $params = [':parent_id' => $parent_id];
        $binding = binding_sql(0, $query, $params);
        $result = egb_sql($binding);

        // 자식 메뉴 처리
        foreach ($result[0] ?? [] as $child) {
            // 자식 메뉴 맵핑
            $map[$child['uniq_id']] = [
                'uniq_id' => $child['uniq_id'],
                'group_code' => $child['group_code'],
                'group_name' => $child['group_name'],
                'parent' => $child['parent_group_uniq_id'],
                'children' => [],
                'depth' => $current_depth + 1
            ];

            // 부모의 children 배열에 자식 추가
            $map[$parent_id]['children'][] = &$map[$child['uniq_id']];

            // 자식의 자식들을 재귀적으로 가져오기
            $get_children($child['uniq_id'], $current_depth + 1, $depth_limit, $map);
        }
    };

    // 재귀적으로 모든 하위 메뉴 가져오기
    $get_children($parent['uniq_id'], 1, $depth_limit, $map);

    // 트리 형태로 반환
    return [$map[$parent['uniq_id']]]; // 부모 메뉴부터 시작하는 트리 구조 반환
}
?>
