<?php
function egb_record_count_table_insert($table_name) {
    $uniq_id = uniqid(); // 유니크ID 13자리 자동 생성
    $created_by = 'system';

    $query = "
        INSERT INTO egb_record_count (
            uniq_id, record_table_name,
            record_total_count, record_active_count, record_inactive_count,
            record_soft_deleted_count, record_hard_deleted_count,
            created_by
        ) VALUES (
            :uniq_id, :table_name,
            0, 0, 0, 0, 0,
            :created_by
        )
    ";

    $params = [
        ':uniq_id' => $uniq_id,
        ':table_name' => $table_name,
        ':created_by' => $created_by
    ];

    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    if ($sql !== false && isset($sql[0])) {
        echo json_encode(['success' => true, 'successCode' => 1]);
    } else {
        echo json_encode(['success' => false, 'failureCode' => 1]);
    }
}
?>
