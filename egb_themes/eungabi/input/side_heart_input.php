            <?php

    $like_target_table = egb('like_target_table', 76);
    $like_target_uniq_id = egb('like_target_uniq_id', 77);
    $like_user_uniq_id = egb('like_user_uniq_id', 78);
    $page = egb('page', 79);

    // 이미 존재하는 좋아요 데이터 확인
    $check_query = "SELECT uniq_id, like_type 
                    FROM egb_like_log 
                    WHERE like_target_table = :target_table
                    AND like_target_uniq_id = :target_uniq_id 
                    AND like_user_uniq_id = :user_uniq_id";

    $check_params = [
        ':target_table' => $like_target_table,
        ':target_uniq_id' => $like_target_uniq_id,
        ':user_uniq_id' => $like_user_uniq_id
    ];

    $check_binding = binding_sql(1, $check_query, $check_params);
    $check_result = egb_sql($check_binding);

    if ($check_result === false) {
        echo json_encode(['success' => false, 'failureCode' => 80]);
        exit;
    }

    if (is_array($check_result) && !empty($check_result) && isset($check_result[0]['like_type'])) {
        // 기존 데이터가 있으면 like_type만 토글(1->0 또는 0->1)
        $current_like_type = $check_result[0]['like_type'];
        $new_like_type = ($current_like_type == 1) ? 0 : 1;
        
        $update_query = "UPDATE egb_like_log 
                        SET like_type = :like_type,
                            updated_by = :updated_by,
                            updated_at = CURRENT_TIMESTAMP
                        WHERE uniq_id = :uniq_id";

        $update_params = [
            ':like_type' => $new_like_type,
            ':updated_by' => $like_user_uniq_id,
            ':uniq_id' => $check_result[0]['uniq_id']
        ];

        $update_binding = binding_sql(2, $update_query, $update_params);
        
        if (egb_sql($update_binding) === false) {
            echo json_encode(['success' => false, 'failureCode' => 81]);
            exit;
        }

        echo json_encode([
            'success' => true, 
            'successCode' => 9, 
            'status' => $new_like_type,
            'page' => $page
        ]);

    } else {
        // 처음 좋아요를 누르는 경우 새로운 레코드 생성
        $uniq_id = uniqid();
        
        $insert_query = "INSERT INTO egb_like_log (
            uniq_id,
            like_target_table,
            like_target_uniq_id,
            like_user_uniq_id,
            like_type,
            created_by
        ) VALUES (
            :uniq_id,
            :target_table,
            :target_uniq_id,
            :user_uniq_id,
            1,
            :created_by
        )";
        
        $insert_params = [
            ':uniq_id' => $uniq_id,
            ':target_table' => $like_target_table,
            ':target_uniq_id' => $like_target_uniq_id,
            ':user_uniq_id' => $like_user_uniq_id,
            ':created_by' => $like_user_uniq_id
        ];

        $insert_binding = binding_sql(2, $insert_query, $insert_params);
        
        if (egb_sql($insert_binding) === false) {
            echo json_encode(['success' => false, 'failureCode' => 82]);
            exit;
        }

        // 게시글 작성자 정보 조회
        $board_query = "
            SELECT board_user_uniq_id 
            FROM {$like_target_table}
            WHERE uniq_id = :board_id
            AND is_status = 1
        ";
        $board_params = [':board_id' => $like_target_uniq_id];
        $board_binding = binding_sql(1, $board_query, $board_params);
        $board_result = egb_sql($board_binding);

        $board_user_id = $board_result[0]['board_user_uniq_id'] ?? null;

        // 게시글 작성자에게 알림 (본인이 아닌 경우에만)
        if ($board_user_id && $board_user_id != $like_user_uniq_id) {
            // 좋아요 누른 사용자 정보 조회
            $user_query = "
                SELECT user_nick_name, user_name 
                FROM egb_user 
                WHERE uniq_id = :user_id
                AND is_status = 1
            ";
            $user_params = [':user_id' => $like_user_uniq_id];
            $user_binding = binding_sql(1, $user_query, $user_params);
            $user_result = egb_sql($user_binding);

            $user_nick_name = '알 수 없음';
            if (!empty($user_result[0])) {
                if (!empty($user_result[0]['user_nick_name'])) {
                    $user_nick_name = $user_result[0]['user_nick_name'];
                } else if (!empty($user_result[0]['user_name'])) {
                    $user_nick_name = $user_result[0]['user_name'];
                }
            }

            $message = "{$user_nick_name}님이 회원님의 게시글을 좋아합니다.";
            
            // like_target_table에서 board_type 추출 (egb_board_news -> news)
            $board_type = str_replace('egb_board_', '', $like_target_table);
            // 좋아요 알림은 앵커 없이 게시글 전체로 이동
            $view_path = "/page/{$board_type}_board_view/?uniq_id={$like_target_uniq_id}";

            egb_alarm_insert(
                $board_user_id,
                '새 좋아요 알림',
                $message,
                $view_path,
                'like'
            );

            // like_target_table에서 board_type 추출 (egb_board_news -> news)
            $board_type = str_replace('egb_board_', '', $like_target_table);
            
            egb_send_push_event(
                "public-user-{$board_user_id}",
                'new-like',
                [
                    'uniq_id' => $uniq_id,
                    'user_nick_name' => $user_nick_name,
                    'board_type' => $board_type,
                    'board_uniq_id' => $like_target_uniq_id,
                    'like_target_table' => $like_target_table,
                    'like_user_uniq_id' => $like_user_uniq_id,
                    'message' => $message,
                    'view_path' => $view_path,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        echo json_encode([
            'success' => true, 
            'successCode' => 9, 
            'status' => 1,
            'page' => $page
        ]);
    }
    ?>
