<?php

$filter_page_name = egb('filter_page_name', 1);
$filter_menu_name = egb('filter_menu_name', 2);
$filter_page = egb('filter_page', 3);
$filter_perPage = egb('filter_per_page', 4);
$filter_order = egb('filter_order', 5);
$filter_is_status = egb('filter_is_status', 6);
$filter_user_id = egb('filter_user_id', 7);
$filter_table_name = egb('filter_table_name', 8);

$filter_search_input = egb('filter_search_input');    


$columns = egb('columns', 9);
$order = egb('order', 10);
$width = egb('width', 11);
$align = egb('align', 12);
$hidden = egb('hidden', 13);
$comment = egb('comment', 14);
$keyword_filter = egb('keyword_filter', 15);
$detail_filter = egb('detail_filter', 16);
$viewer_filter = egb('viewer_filter', 17);

// 테이블 컬럼 정보 조회
$query = "
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    COLUMN_TYPE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = :table_name
ORDER BY ORDINAL_POSITION
";
$params = [':table_name' => $filter_table_name];
$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);

$column_types = [];
foreach($sql[0] as $column) {
    $data_type = strtolower($column['DATA_TYPE']);
$column_type = $column['COLUMN_TYPE'];
$precision = null;
if (preg_match('/\((\d+)\)/', $column_type, $matches)) {
    $precision = (int)$matches[1];
}

    if (in_array($data_type, ['date', 'datetime', 'timestamp'])) {
        $filter_type = 'date';
    } else if ($data_type == 'tinyint') {
        if ($precision == 1) {
            $filter_type = 'boolean';
        } else if ($precision == 2) {
            $filter_type = 'status'; 
        } else {
            $filter_type = 'number';
        }
    } else if (in_array($data_type, ['int', 'bigint', 'smallint', 'decimal', 'float', 'double'])) {
        $filter_type = 'number';
    } else {
        $filter_type = 'text';
    }
    
    $column_types[$column['COLUMN_NAME']] = $filter_type;
}

$config_array = [];
$sort_index = 1;
foreach ($columns as $column) {
    $config_array[] = [
        'name' => $column,
        'comment' => $comment[$column] ?? $column,
        'visible' => isset($hidden[$column]) ? (int)$hidden[$column] : 1,
        'order' => isset($order[$column]) ? (int)$order[$column] : $sort_index,
        'width' => isset($width[$column]) ? (int)$width[$column] : 200,
        'align' => $align[$column] ?? 'center',
        'keyword_filter' => isset($keyword_filter[$column]) ? (int)$keyword_filter[$column] : 0,
        'detail_filter' => isset($detail_filter[$column]) ? (int)$detail_filter[$column] : 0,
        'viewer_filter' => isset($viewer_filter[$column]) ? (int)$viewer_filter[$column] : 0,
        'filter_type' => $column_types[$column] ?? 'text'
    ];
    $sort_index++;
}
$json_data = json_encode($config_array, JSON_UNESCAPED_UNICODE);

// 기존 존재 여부 확인
$check_query = "
SELECT COUNT(*) as cnt FROM egb_table_column_config
WHERE column_config_table_name = :table_name
  AND column_config_user_uniq_id IS NULL
  AND deleted_at IS NULL
";
$check_params = [':table_name' => $filter_table_name];
$check_binding = binding_sql(1, $check_query, $check_params);
$check_result = egb_sql($check_binding);

if ($check_result && isset($check_result[0]['cnt']) && (int)$check_result[0]['cnt'] > 0) {
    // UPDATE 처리
    $update_query = "
    UPDATE egb_table_column_config
    SET column_config_data_json = :json_data, updated_by = 'system'
    WHERE column_config_table_name = :table_name
      AND column_config_user_uniq_id IS NULL
      AND deleted_at IS NULL
    ";
    $update_params = [
        ':table_name' => $filter_table_name,
        ':json_data' => $json_data
    ];
    $update_binding = binding_sql(2, $update_query, $update_params);
    $update_result = egb_sql($update_binding);

    if (!empty($update_result) && isset($update_result[0])) {
        echo json_encode([
            'success' => true, 
            'successCode' => 1,
            'filter_page_name' => $filter_page_name,
            'filter_menu_name' => $filter_menu_name,
            'filter_page' => $filter_page,
            'filter_per_page' => $filter_perPage,
            'filter_order' => $filter_order,
            'filter_is_status' => $filter_is_status,
            'filter_search_input' => $filter_search_input,
            'filter_user_id' => $filter_user_id,
            'filter_table_name' => $filter_table_name
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'failureCode' => 17]); // 업데이트 실패
    exit;
} else {
    // INSERT 처리
    $insert_query = "
    INSERT INTO egb_table_column_config (
        uniq_id, column_config_table_name, column_config_user_uniq_id, column_config_data_json, created_by
    ) VALUES (
        :uniq_id, :table_name, NULL, :json_data, 'system'
    )";
    $insert_params = [
        ':uniq_id' => uniqid(),
        ':table_name' => $filter_table_name,
        ':json_data' => $json_data
    ];
    $insert_binding = binding_sql(2, $insert_query, $insert_params);
    $insert_result = egb_sql($insert_binding);

    if (!empty($insert_result) && isset($insert_result[0])) {
        increase_record_total_count('egb_table_column_config');
        increase_record_active_count('egb_table_column_config');
        echo json_encode([
            'success' => true, 
            'successCode' => 1,
            'filter_page_name' => $filter_page_name,
            'filter_menu_name' => $filter_menu_name,
            'filter_page' => $filter_page,
            'filter_per_page' => $filter_perPage,
            'filter_order' => $filter_order,
            'filter_is_status' => $filter_is_status,
            'filter_search_input' => $filter_search_input,
            'filter_user_id' => $filter_user_id,
            'filter_table_name' => $filter_table_name
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'failureCode' => 18]); // 삽입 실패
    exit;
}
?>
