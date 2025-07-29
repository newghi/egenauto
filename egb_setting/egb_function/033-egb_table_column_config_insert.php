<?php
function egb_table_column_config_insert($table_name, $user_uniq_id = NULL) {
    // 1. 해당 테이블의 칼럼 목록과 코멘트, 타입 정보 추출
    $query = "
    SELECT 
        COLUMN_NAME,
        COLUMN_COMMENT,
        DATA_TYPE,
        COLUMN_TYPE
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = :table_name
    ORDER BY ORDINAL_POSITION
    ";
    $params = [':table_name' => $table_name];
    $binding = binding_sql(0, $query, $params);
    $sql = egb_sql($binding);

    if (!$sql || empty($sql[0])) {
        return ['success' => false, 'failureCode' => 1]; // 칼럼 목록 추출 실패
    }

    // 2. 기본 JSON 구조 생성
    $json_array = [];
    $order = 1;
    foreach ($sql[0] as $column) {
        $column_name = $column['COLUMN_NAME'];
        $comment = $column['COLUMN_COMMENT'] ?: $column_name;
        $data_type = strtolower($column['DATA_TYPE']);
$column_type = $column['COLUMN_TYPE'];
$precision = null;
if (preg_match('/\((\d+)\)/', $column_type, $matches)) {
    $precision = (int)$matches[1];
}

        // filter_type 판별
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

        $json_array[] = [
            'name' => $column_name,
            'comment' => $comment,
            'visible' => 1,
            'order' => $order++,
            'width' => 200,
            'align' => 'center',
            'keyword_filter' => 0,
            'detail_filter' => 0,
            'filter_type' => $filter_type
        ];
    }

    $json_encoded = json_encode($json_array, JSON_UNESCAPED_UNICODE);

    // 3. INSERT 실행
    $query_insert = "
    INSERT INTO egb_table_column_config (
        uniq_id, column_config_table_name, column_config_user_uniq_id, column_config_data_json, created_by
    ) VALUES (
        :uniq_id, :table_name, :user_uniq_id, :json_data, 'system'
    )";
    $params_insert = [
        ':uniq_id' => uniqid(),
        ':table_name' => $table_name,
        ':user_uniq_id' => $user_uniq_id,
        ':json_data' => $json_encoded
    ];
    $binding_insert = binding_sql(2, $query_insert, $params_insert);
    $sql_insert = egb_sql($binding_insert);

    if (!empty($sql_insert) && isset($sql_insert[0])) {
        increase_record_total_count('egb_table_column_config');
        increase_record_active_count('egb_table_column_config');
        return ['success' => true, 'successCode' => 1];
    }

    return ['success' => false, 'failureCode' => 2]; // INSERT 실패
}
?>
