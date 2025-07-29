<?php
function egb_board_log($log_target_table, $log_board_uniq_id, $log_user_uniq_id) {
    // 필수 파라미터 검증
    if(empty($log_target_table) || empty($log_board_uniq_id) || empty($log_user_uniq_id)) {
        return false;
    }
    
    // 유니크ID 생성
    $uniq_id = uniqid();
    
    // 게시판 로그 테이블에 데이터 삽입
    $query = "INSERT INTO egb_board_log SET uniq_id = :uniq_id, log_target_table = :log_target_table, log_board_uniq_id = :log_board_uniq_id, log_user_uniq_id = :log_user_uniq_id";
    $binding = binding_sql(2, $query, [
        ':uniq_id' => $uniq_id,
        ':log_target_table' => $log_target_table,
        ':log_board_uniq_id' => $log_board_uniq_id,
        ':log_user_uniq_id' => $log_user_uniq_id
    ]);
    
    $result = egb_sql($binding);
    
    // 성공 여부 반환
    return $result;
}
?>