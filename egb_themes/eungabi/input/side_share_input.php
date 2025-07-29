    <?php

    $share_page_type = egb('share_target_table', 90); 
    $share_target_uniq_id = egb('share_target_uniq_id', 91);
    $share_user_uniq_id = egb('share_user_uniq_id', 92);
    $page = egb('page', 93);
    $share_url = egb('share_url', 94);

    // 이미 존재하는 공유 데이터 확인
    $check_query = "SELECT uniq_id
                    FROM egb_share_log 
                    WHERE share_target_table = :target_table
                    AND share_target_uniq_id = :target_uniq_id 
                    AND share_user_uniq_id = :user_uniq_id";

    $check_params = [
        ':target_table' => $share_page_type,
        ':target_uniq_id' => $share_target_uniq_id,
        ':user_uniq_id' => $share_user_uniq_id,
    ];

    $check_binding = binding_sql(1, $check_query, $check_params);
    $check_result = egb_sql($check_binding);

    if ($check_result === false || !isset($check_result[0])) {
        echo json_encode(['success' => false, 'failureCode' => 95]);
        exit;
    }

    if (isset($check_result[0]['uniq_id'])) {
        // 이미 공유한 경우 - 성공 응답만 반환
        echo json_encode([
            'success' => true,
            'successCode' => 11,
            'status' => 0,
            'page' => $page
        ]);
    } else {
        // 처음 공유하는 경우 새로운 레코드 생성
        $uniq_id = uniqid();
        
        $insert_query = "INSERT INTO egb_share_log (
            uniq_id,
            share_target_table,
            share_target_uniq_id,
            share_user_uniq_id,
            share_url,
            created_by
        ) VALUES (
            :uniq_id,
            :target_table,
            :target_uniq_id,
            :user_uniq_id,
            :share_url,
            :created_by
        )";
        
        $insert_params = [
            ':uniq_id' => $uniq_id,
            ':target_table' => $share_page_type,
            ':target_uniq_id' => $share_target_uniq_id,
            ':user_uniq_id' => $share_user_uniq_id,
            ':share_url' => $share_url,
            ':created_by' => $share_user_uniq_id
        ];

        $insert_binding = binding_sql(2, $insert_query, $insert_params);
        
        if (egb_sql($insert_binding) === false) {
            echo json_encode(['success' => false, 'failureCode' => 97]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'successCode' => 11,
            'status' => 1,
            'page' => $page
        ]);
    }
    ?>
