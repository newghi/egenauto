<?php
function table_egb_board_mangement_insert($board_name = null) {
    // 보드 이름이 설정되지 않았을 경우 임의의 이름 생성
    if (!isset($board_name)) {
        $board_name = egb_random_string(5);
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

    // 보드 또는 댓글 테이블이 이미 존재할 경우 임의의 새로운 이름 생성
    while ($check_result[0]['count'] > 0) {
        $board_name = egb_random_string(5);
        $board_table_name = 'egb_board_' . $board_name;
        $comment_table_name = 'egb_comment_' . $board_name;
        $params_check[':board_table_name'] = $board_table_name;
        $params_check[':comment_table_name'] = $comment_table_name;
        $binding_check_table = binding_sql(1, $check_table, $params_check);
        $check_result = egb_sql($binding_check_table);
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
        INSERT INTO egb_board_mangement (
            board_mangement_uniq_id, 
            board_mangement_table_board_name, 
            board_mangement_table_comment_name, 
			board_mangement_route_board_name, 
            board_mangement_board_name, 
            board_mangement_comment_name, 
			board_mangement_custom_name 
        ) VALUES (
            :board_mangement_uniq_id, 
            :board_mangement_table_board_name, 
            :board_mangement_table_comment_name, 
            :board_mangement_board_name, 
            :board_mangement_comment_name, 
			:board_mangement_route_board_name, 
			:board_mangement_custom_name
        )
    ";

    $params_management = [
        ':board_mangement_uniq_id' => uniqid(), // 고유 ID 생성
        ':board_mangement_table_board_name' => $board_table_name,
        ':board_mangement_table_comment_name' => $comment_table_name,
		':board_mangement_route_board_name' => $board_name,
        ':board_mangement_board_name' => $board_name,
        ':board_mangement_comment_name' => $board_name,
		':board_mangement_custom_name' => $board_name
    ];

    $binding_insert_management = binding_sql(2, $insert_management, $params_management);
    $result = egb_sql($binding_insert_management);

    if (isset($result[0])) {
        //echo "테이블이 성공적으로 생성되었고 관리 레코드가 삽입되었습니다.";
    } else {
        //echo "테이블 생성 또는 관리 레코드 삽입에 실패했습니다.";
    }
}

?>
