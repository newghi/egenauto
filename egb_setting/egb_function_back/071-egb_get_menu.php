<?php
function egb_get_menu($index) {
    static $menuCache = [];

    // 캐시에 이미 있다면 DB 재조회 없이 반환
    if (isset($menuCache[$index])) {
        return $menuCache[$index];
    }

    // 1. egb_menu_position에서 index에 해당하는 uniq_id 가져오기
    $query = "SELECT menu_position_uniq_id 
              FROM egb_menu_position
              ORDER BY menu_position_uniq_id ASC
              LIMIT 1 OFFSET :offset";
    $params = [':offset' => $index];
    $binding = binding_sql(1, $query, $params);
    $result = egb_sql($binding);

    if (!isset($result[0]['menu_position_uniq_id'])) {
        // 해당 인덱스의 menu_position 없음
        $menuCache[$index] = [];
        return [];
    }

    $menu_position_uniq_id = $result[0]['menu_position_uniq_id'];

    // 2. 해당 menu_position_uniq_id로 메뉴 전체 가져오기
    $query2 = "SELECT *
               FROM egb_menu
               WHERE menu_position_uniq_id = :menu_position_uniq_id
               ORDER BY menu_depth ASC, menu_position ASC";
    $params2 = [
        ':menu_position_uniq_id' => $menu_position_uniq_id
    ];
    $binding2 = binding_sql(0, $query2, $params2);
    $sql2 = egb_sql($binding2);

    if (!isset($sql2[0])) {
        // 메뉴가 없는 경우
        $menuCache[$index] = [];
        return [];
    }

    $menus = $sql2[0];

    // 트리 구성
    $menuMap = [];
    foreach ($menus as $menu) {
        $menu['children'] = [];
        $menuMap[$menu['menu_id']] = $menu;
    }

    $tree = [];
    foreach ($menuMap as $menu_id => &$menuData) {
        if ($menuData['menu_parent_id'] === null) {
            // 최상위 메뉴
            $tree[] = &$menuData;
        } else {
            $parent_id = $menuData['menu_parent_id'];
            if (isset($menuMap[$parent_id])) {
                $menuMap[$parent_id]['children'][] = &$menuData;
            }
        }
    }

    // 캐시에 저장
    $menuCache[$index] = $tree;
    return $tree;
}

/**
 * 특정 depth와 position을 가진 노드를 찾는 함수
 * 여러 개가 나올 수 있으므로 배열로 반환
 */
function egb_menu_find($menus, $depth = null, $position = null) {
    $result = [];
    foreach ($menus as $menu) {
        // depth와 position 조건 체크
        $depthMatch = ($depth === null || $menu['menu_depth'] == $depth);
        $positionMatch = ($position === null || $menu['menu_position'] == $position);

        if ($depthMatch && $positionMatch) {
            $result[] = $menu;
        }

        // 자식 노드도 탐색
        if (!empty($menu['children'])) {
            $subResult = egb_menu_find($menu['children'], $depth, $position);
            if (!empty($subResult)) {
                $result = array_merge($result, $subResult);
            }
        }
    }
    return $result;
}
/*
// ===================== 사용 예제 =====================

// 1. 먼저 전체 트리를 가져온다. (예: 첫 번째 menu_position)
$allMenus = egb_get_menu(0);

// 2. 예를 들어, depth=1, position=2인 메뉴 노드를 찾는다고 해보자.
//    menu_parent_id를 알 필요 없이, depth와 position으로 식별한다.
$targetDepth = 0;
$targetPosition = 2;
$nodes = egb_menu_find($allMenus, $targetDepth, $targetPosition);


// 3. 찾은 노드들에 대해서 children을 출력해본다.
foreach ($nodes as $node) {
    echo "선택된 노드: {$node['menu_name']} (depth={$node['menu_depth']}, position={$node['menu_position']})\n";

    // 해당 노드의 하위메뉴 그룹 출력
    if (!empty($node['children'])) {
        echo "하위메뉴 목록:\n";
        foreach ($node['children'] as $child) {
            echo "- {$child['menu_name']} (depth={$child['menu_depth']}, position={$child['menu_position']})\n";
        }
    } else {
        echo "하위메뉴가 없습니다.\n";
    }
}
*/
?>