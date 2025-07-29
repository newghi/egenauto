<?php
// 필터 값 가져오기
$filter_table_name = egb('filter_table_name');
$filter_page_name = egb('filter_page_name'); 
$filter_menu_name = egb('filter_menu_name');
$filter_page = egb('filter_page');
$filter_per_page = egb('filter_per_page');
$filter_order = egb('filter_order');
$filter_is_status = egb('filter_is_status');
$filter_search_input = egb('filter_search_input');
$filter_user_id = egb('filter_user_id');

// 옵션 정보 가져오기
$uniq_id = egb('uniq_id', 89);
$option_group_uniq_id = egb('option_group_uniq_id', 90);
$option_parent_uniq_id = egb('option_parent_uniq_id');
$option_label = egb('option_label', 91);
$option_access_level = egb('option_access_level');
$display_order = egb('display_order');

// 기존 옵션 정보 가져오기
$current_query = "SELECT option_group_uniq_id, option_parent_uniq_id, option_depth FROM egb_option WHERE uniq_id = :uniq_id";
$current_params = [':uniq_id' => $uniq_id];
$current_binding = binding_sql(1, $current_query, $current_params);
$current_result = egb_sql($current_binding);

$current_group_id = $current_result[0]['option_group_uniq_id'];
$current_parent_id = $current_result[0]['option_parent_uniq_id'];
$current_depth = $current_result[0]['option_depth'];

// 중복 체크 쿼리
$dup_query = "
    SELECT COUNT(*) as cnt
    FROM egb_option
    WHERE option_group_uniq_id = :group_id
      AND option_parent_uniq_id <=> :parent_id
      AND option_label = :label
      AND uniq_id != :uniq_id
      AND deleted_at IS NULL
";
$dup_params = [
    ':group_id' => $option_group_uniq_id,
    ':parent_id' => $option_parent_uniq_id,
    ':label' => $option_label,
    ':uniq_id' => $uniq_id
];
$dup_binding = binding_sql(1, $dup_query, $dup_params);
$dup_result = egb_sql($dup_binding);

if (isset($dup_result[0]['cnt']) && $dup_result[0]['cnt'] > 0) {
    echo json_encode(['success' => false, 'failureCode' => 92]); // 중복 에러 코드
    exit;
}

// 옵션 깊이 계산
$option_depth = 0;
if (!empty($option_parent_uniq_id)) {
    $parent_query = "SELECT option_depth FROM egb_option WHERE uniq_id = :parent_id";
    $parent_params = [':parent_id' => $option_parent_uniq_id];
    $parent_binding = binding_sql(1, $parent_query, $parent_params);
    $parent_result = egb_sql($parent_binding);

    if ($parent_result[0]) {
        $option_depth = $parent_result[0]['option_depth'] + 1;
    }
}

// 현재 옵션 업데이트
$query = "UPDATE egb_option SET
    display_order = :display_order,
    option_group_uniq_id = :option_group_uniq_id,
    option_parent_uniq_id = :option_parent_uniq_id,
    option_label = :option_label,
    option_depth = :option_depth,
    option_access_level = :option_access_level,
    updated_by = :updated_by,
    updated_at = NOW()
WHERE uniq_id = :uniq_id";

$params = [
    ':uniq_id' => $uniq_id,
    ':display_order' => $display_order,
    ':option_group_uniq_id' => $option_group_uniq_id,
    ':option_parent_uniq_id' => $option_parent_uniq_id,
    ':option_label' => $option_label,
    ':option_depth' => $option_depth,
    ':option_access_level' => $option_access_level,
    ':updated_by' => $filter_user_id
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// RECURSIVE 쿼리가 불가능한 경우 수동으로 하위 업데이트
if ($sql[0] && ($current_group_id != $option_group_uniq_id || $current_parent_id != $option_parent_uniq_id)) {
    $stack = [ ['id' => $uniq_id, 'depth' => $option_depth] ];
    while (!empty($stack)) {
        $current = array_pop($stack);
        $parent_id = $current['id'];
        $parent_depth = $current['depth'];

        $query = "SELECT uniq_id FROM egb_option WHERE option_parent_uniq_id = :parent_id AND deleted_at IS NULL";
        $params = [':parent_id' => $parent_id];
        $binding = binding_sql(0, $query, $params);
        $result = egb_sql($binding);

        if (!empty($result[0])) {
            foreach ($result[0] as $row) {
                $child_id = $row['uniq_id'];
                $child_depth = $parent_depth + 1;

                $update_query = "UPDATE egb_option SET
                    option_group_uniq_id = :group_id,
                    option_depth = :depth,
                    updated_by = :updated_by,
                    updated_at = NOW()
                WHERE uniq_id = :child_id";

                $update_params = [
                    ':group_id' => $option_group_uniq_id,
                    ':depth' => $child_depth,
                    ':updated_by' => $filter_user_id,
                    ':child_id' => $child_id
                ];
                $update_binding = binding_sql(2, $update_query, $update_params);
                egb_sql($update_binding);

                $stack[] = ['id' => $child_id, 'depth' => $child_depth];
            }
        }
    }
}

// 결과 반환
if ($sql[0]) {
    echo json_encode([
        'success' => true,
        'successCode' => 14,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_per_page,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input,
        'filter_user_id' => $filter_user_id,
        'filter_table_name' => $filter_table_name
    ]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 93]);
}
?>