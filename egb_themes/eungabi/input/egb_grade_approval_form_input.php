    <?php
    $grade_uniq_id = egb('grade_uniq_id', 48);
    $option_is_active = egb('option_is_active', 49);
    $option_is_active = (int)$option_is_active;

    $query = "
        UPDATE egb_option 
        SET option_is_active = :option_is_active,
            updated_by = :updated_by,
            updated_at = CURRENT_TIMESTAMP
        WHERE uniq_id = :grade_uniq_id
    ";
    $params = [
        ':option_is_active' => $option_is_active,
        ':updated_by' => 'system', // 실제 적용 시 로그인된 관리자 ID로 대체
        ':grade_uniq_id' => $grade_uniq_id
    ];
    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    if ($sql && $sql[0]) {
        echo json_encode(['success' => true, 'successCode' => 3]);
    } else {
        echo json_encode(['success' => false, 'failureCode' => 50]); // DB 업데이트 실패
    }
    ?>
