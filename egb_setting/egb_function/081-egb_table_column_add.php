<?php
function egb_table_column_add($table_name, $column_name, $column_type, $comment, $after_column, $default = null) {
    $checkQuery = "
    SELECT COUNT(*) as cnt 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_NAME = :table 
      AND COLUMN_NAME = :column 
      AND TABLE_SCHEMA = DATABASE()
    ";
    $checkParams = [
        ':table' => $table_name,
        ':column' => $column_name
    ];
    $checkBinding = binding_sql(1, $checkQuery, $checkParams);
    $checkResult = egb_sql($checkBinding);

    if (isset($checkResult[0]) && $checkResult[0]['cnt'] == 0) {
        // TEXT, BLOB 등 DEFAULT를 지원하지 않는 타입 체크
        $noDefaultTypes = ['TEXT', 'BLOB', 'MEDIUMTEXT', 'MEDIUMBLOB', 'LONGTEXT', 'LONGBLOB'];
        $isNoDefaultType = false;
        foreach($noDefaultTypes as $type) {
            if (stripos($column_type, $type) !== false) {
                $isNoDefaultType = true;
                break;
            }
        }

        $defaultClause = $isNoDefaultType ? '' : " DEFAULT " . ($default === null ? "NULL" : $default);
        
        $alterQuery = "
        ALTER TABLE {$table_name}
        ADD COLUMN {$column_name} {$column_type}{$defaultClause} COMMENT '{$comment}' AFTER {$after_column}
        ";
        $alterParams = [];
        $alterBinding = binding_sql(3, $alterQuery, $alterParams);
        $sql = egb_sql($alterBinding);
    }
}

?>
