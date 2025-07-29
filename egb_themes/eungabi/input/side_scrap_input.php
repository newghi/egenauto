<?php

    $scrap_page_type = egb('scrap_target_table', 83); 
    $post_uniq_id = egb('scrap_target_uniq_id', 84);
    $login_user_uniq_id = egb('scrap_user_uniq_id', 85);
    $page = egb('page', 86);

    // 이미 존재하는 스크랩 데이터 확인
    $check_query = "SELECT uniq_id, scrap_type 
                    FROM egb_scrap_log 
                    WHERE scrap_target_table = :target_table
                    AND scrap_target_uniq_id = :target_uniq_id 
                    AND scrap_user_uniq_id = :user_uniq_id
                    AND is_status = 1";

    $check_params = [
        ':target_table' => $scrap_page_type,
        ':target_uniq_id' => $post_uniq_id,
        ':user_uniq_id' => $login_user_uniq_id
    ];

    $check_binding = binding_sql(1, $check_query, $check_params);
    $check_result = egb_sql($check_binding);

    if ($check_result === false) {
        echo json_encode(['success' => false, 'failureCode' => 87]);
        exit;
    }

    if (is_array($check_result) && !empty($check_result) && isset($check_result[0]['scrap_type'])) {
        // 기존 데이터가 있으면 scrap_type만 토글(1->0 또는 0->1)
        $current_scrap_type = $check_result[0]['scrap_type'];
        $new_scrap_type = ($current_scrap_type == 1) ? 0 : 1;
        
        $update_query = "UPDATE egb_scrap_log 
                        SET scrap_type = :scrap_type,
                            updated_by = :updated_by,
                            updated_at = CURRENT_TIMESTAMP
                        WHERE uniq_id = :uniq_id";

        $update_params = [
            ':scrap_type' => $new_scrap_type,
            ':updated_by' => $login_user_uniq_id,
            ':uniq_id' => $check_result[0]['uniq_id']
        ];

        $update_binding = binding_sql(2, $update_query, $update_params);
        
        if (egb_sql($update_binding) === false) {
            echo json_encode(['success' => false, 'failureCode' => 88]);
            exit;
        }

        echo json_encode([
            'success' => true, 
            'successCode' => 10, 
            'status' => $new_scrap_type,
            'page' => $page
        ]);

    } else {
        // 처음 스크랩을 누르는 경우 새로운 레코드 생성
        $uniq_id = uniqid();
        
        $insert_query = "INSERT INTO egb_scrap_log (
            uniq_id,
            scrap_target_table,
            scrap_target_uniq_id,
            scrap_user_uniq_id,
            scrap_type,
            created_by,
            is_status
        ) VALUES (
            :uniq_id,
            :target_table,
            :target_uniq_id,
            :user_uniq_id,
            1,
            :created_by,
            1
        )";
        
        $insert_params = [
            ':uniq_id' => $uniq_id,
            ':target_table' => $scrap_page_type,
            ':target_uniq_id' => $post_uniq_id,
            ':user_uniq_id' => $login_user_uniq_id,
            ':created_by' => $login_user_uniq_id
        ];

        $insert_binding = binding_sql(2, $insert_query, $insert_params);
        
        if (egb_sql($insert_binding) === false) {
            echo json_encode(['success' => false, 'failureCode' => 89]);
            exit;
        }

        // 게시글 작성자 정보 조회
        $board_query = "
            SELECT board_user_uniq_id 
            FROM {$scrap_page_type}
            WHERE uniq_id = :board_id
            AND is_status = 1
        ";
        $board_params = [':board_id' => $post_uniq_id];
        $board_binding = binding_sql(1, $board_query, $board_params);
        $board_result = egb_sql($board_binding);

        $board_user_id = $board_result[0]['board_user_uniq_id'] ?? null;

        // 게시글 작성자에게 알림 (본인이 아닌 경우에만)
        if ($board_user_id && $board_user_id != $login_user_uniq_id) {
            // 스크랩한 사용자 정보 조회
            $user_query = "
                SELECT user_nick_name, user_name 
                FROM egb_user 
                WHERE uniq_id = :user_id
                AND is_status = 1
            ";
            $user_params = [':user_id' => $login_user_uniq_id];
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

            $message = "{$user_nick_name}님이 회원님의 게시글을 스크랩했습니다.";
            
            // scrap_page_type에서 board_type 추출 (egb_board_news -> news)
            $board_type = str_replace('egb_board_', '', $scrap_page_type);
            $view_path = "/page/{$board_type}_board_view/?uniq_id={$post_uniq_id}";

            egb_alarm_insert(
                $board_user_id,
                '새 스크랩 알림',
                $message,
                $view_path,
                'scrap'
            );

            egb_send_push_event(
                "public-user-{$board_user_id}",
                'new-scrap',
                [
                    'uniq_id' => $uniq_id,
                    'user_nick_name' => $user_nick_name,
                    'board_type' => $board_type,
                    'board_uniq_id' => $post_uniq_id,
                    'scrap_target_table' => $scrap_page_type,
                    'scrap_user_uniq_id' => $login_user_uniq_id,
                    'message' => $message,
                    'view_path' => $view_path,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }

        echo json_encode([
            'success' => true, 
            'successCode' => 10, 
            'status' => 1,
            'page' => $page
        ]);
    }
    ?>
