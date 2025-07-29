<?php
function table_egb_board_management_insert($board_name) {
    // 보드 이름이 설정되지 않았을 경우 함수 종료 
    if (!isset($board_name) || empty($board_name)) {
        return;
    }

    // 보드와 댓글 테이블 이름 설정
    $board_table_name = 'egb_board_' . $board_name;
    $comment_table_name = 'egb_comment_' . $board_name;

    // 보드 테이블이 이미 존재하는지 확인
    $check_table = "
        SELECT COUNT(*) as count 
        FROM information_schema.tables 
        WHERE table_schema = DATABASE() 
        AND (table_name = :board_table_name OR table_name = :comment_table_name)
    ";

    $params_check = [
        ':board_table_name' => $board_table_name,
        ':comment_table_name' => $comment_table_name
    ];

    $binding_check_table = binding_sql(1, $check_table, $params_check);
    $check_result = egb_sql($binding_check_table);

    // 보드 또는 댓글 테이블이 이미 존재할 경우 함수 종료
    if ($check_result[0]['count'] > 0) {
        return;
    }

    // 특정 보드 테이블 생성
    $create_board = table_egb_board($board_name);
    $binding_board = binding_sql(3, $create_board, []);
    egb_sql($binding_board);

    // 특정 댓글 테이블 생성
    $create_comment = table_egb_comment($board_name);
    $binding_comment = binding_sql(3, $create_comment, []);
    egb_sql($binding_comment);

    // 보드 관리 테이블에 삽입
    $insert_management = "
        INSERT INTO egb_management_board (
            uniq_id,
            is_status,
            display_order,
            table_board_name,
            table_comment_name,
            route_board_name,
            board_name,
            comment_name,
            board_custom_name,
            created_by
        ) VALUES (
            :uniq_id,
            1,
            0,
            :table_board_name,
            :table_comment_name,
            :route_board_name,
            :board_name,
            :comment_name,
            :board_custom_name,
            'system'
        )
    ";

    $params_management = [
        ':uniq_id' => uniqid(),
        ':table_board_name' => $board_table_name,
        ':table_comment_name' => $comment_table_name, 
        ':route_board_name' => $board_name,
        ':board_name' => $board_name,
        ':comment_name' => $board_name,
        ':board_custom_name' => $board_name
    ];

    $binding_insert_management = binding_sql(2, $insert_management, $params_management);
    $result = egb_sql($binding_insert_management);

    if ($result) {
        // 보드 테이블 레코드 카운트
        egb_record_count_table_insert($board_table_name);
        // 댓글 테이블 레코드 카운트
        egb_record_count_table_insert($comment_table_name);
        // 보드 관리 테이블 칼럼 설정
        egb_table_column_config_insert($board_table_name);
        // 댓글 테이블 칼럼 설정
        egb_table_column_config_insert($comment_table_name);
        // 사이트맵 생성
        egb_index_sitemap_insert($board_name);
    }
}
?>
