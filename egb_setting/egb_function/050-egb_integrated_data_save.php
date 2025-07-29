<?php
function egb_integrated_data_save($target_table, $target_uniq_id, $data_key, $data_value) {
    $created_by = 'system';

    // 중복 확인
    $check_query = "
    SELECT uniq_id FROM egb_integrated_data
    WHERE integrated_target_table = :table
      AND integrated_target_uniq_id = :uniq_id
      AND integrated_data_key = :key
    ";
    $check_params = [
        ':table' => $target_table,
        ':uniq_id' => $target_uniq_id,
        ':key' => $data_key
    ];
    $check_binding = binding_sql(1, $check_query, $check_params);
    $check = egb_sql($check_binding);

    if ($check && isset($check[0]['uniq_id'])) {
        // UPDATE
        $update_query = "
        UPDATE egb_integrated_data
        SET integrated_data_value = :value,
            updated_by = :created_by
        WHERE integrated_target_table = :table
          AND integrated_target_uniq_id = :uniq_id
          AND integrated_data_key = :key
        ";
        $update_params = [
            ':value' => $data_value,
            ':created_by' => $created_by,
            ':table' => $target_table,
            ':uniq_id' => $target_uniq_id,
            ':key' => $data_key
        ];
        $update_binding = binding_sql(2, $update_query, $update_params);
        $result = egb_sql($update_binding);
    } else {
        // INSERT
        $uniq_id = uniqid();
        $insert_query = "
        INSERT INTO egb_integrated_data (
            uniq_id, integrated_target_table, integrated_target_uniq_id,
            integrated_data_key, integrated_data_value, created_by
        ) VALUES (
            :uniq_id, :table, :uniq_id2, :key, :value, :created_by
        )";
        $insert_params = [
            ':uniq_id' => $uniq_id,
            ':table' => $target_table,
            ':uniq_id2' => $target_uniq_id,
            ':key' => $data_key,
            ':value' => $data_value,
            ':created_by' => $created_by
        ];
        $insert_binding = binding_sql(2, $insert_query, $insert_params);
        $result = egb_sql($insert_binding);
    }

    return (isset($result[0]) && $result[0]) ? true : false;
}
?>
