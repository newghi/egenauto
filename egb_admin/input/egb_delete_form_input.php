<?php


$filter_table_name = egb('filter_table_name', 26);
$uniq_id = egb('uniq_id', 27);

$filter_page_name = egb('filter_page_name');
$filter_menu_name = egb('filter_menu_name');
$filter_page = egb('filter_page');
$filter_perPage = egb('filter_per_page');
$filter_order = egb('filter_order');
$filter_is_status = egb('filter_is_status');
$filter_user_id = egb('filter_user_id');

$filter_search_input = egb('filter_search_input');

// 소프트 삭제를 위한 현재 시간과 사용자 정보 가져오기
$current_time = date('Y-m-d H:i:s');
$deleted_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $filter_user_id;

// 현재 상태 확인
$check_query = "SELECT is_status FROM $filter_table_name WHERE uniq_id = :uniq_id";
$check_params = [':uniq_id' => $uniq_id];
$check_binding = binding_sql(1, $check_query, $check_params);
$current_status = egb_sql($check_binding);

if ($current_status && isset($current_status[0]['is_status'])) {
    $old_status = $current_status[0]['is_status'];
    
    if ($old_status == 2) {
        // 영구 삭제 쿼리 실행
        $query = "DELETE FROM $filter_table_name WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $uniq_id];
        
        $binding = binding_sql(2, $query, $params);
        $result = egb_sql($binding);

        if ($result && isset($result[0]) && $result[0]) {
            // 소프트 삭제 카운트 감소
            decrease_record_soft_deleted_count($filter_table_name);
            // 하드 삭제 카운트 증가 
            increase_record_hard_deleted_count($filter_table_name);
            // 전체 레코드 카운트 감소
            decrease_record_total_count($filter_table_name);

            echo json_encode([
                'success' => true, 
                'successCode' => 6,
                'filter_page_name' => $filter_page_name,
                'filter_menu_name' => $filter_menu_name,
                'filter_page' => $filter_page,
                'filter_per_page' => $filter_perPage,
                'filter_order' => $filter_order,
                'filter_is_status' => $filter_is_status,
                'filter_search_input' => $filter_search_input,
                'filter_user_id' => $filter_user_id,
                'filter_table_name' => $filter_table_name
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'failureCode' => 28
            ]);
        }
    } else {
        // 소프트 삭제 쿼리 실행 (deleted_at, deleted_by 업데이트)
        $query = "UPDATE $filter_table_name 
                  SET deleted_at = :deleted_at,
                      deleted_by = :deleted_by,
                      is_status = 2
                  WHERE uniq_id = :uniq_id";

        $params = [
            ':deleted_at' => $current_time,
            ':deleted_by' => $deleted_by,
            ':uniq_id' => $uniq_id
        ];

        $binding = binding_sql(2, $query, $params);
        $result = egb_sql($binding);

        if ($result && isset($result[0]) && $result[0]) {
            // 이전 상태에 따라 카운트 업데이트
            if ($old_status == 0) {
                decrease_record_inactive_count($filter_table_name);
            } else if ($old_status == 1) {
                decrease_record_active_count($filter_table_name);
            }
            
            // 소프트 삭제 카운트 증가
            increase_record_soft_deleted_count($filter_table_name);

            echo json_encode([
                'success' => true, 
                'successCode' => 5,
                'filter_page_name' => $filter_page_name,
                'filter_menu_name' => $filter_menu_name,
                'filter_page' => $filter_page,
                'filter_per_page' => $filter_perPage,
                'filter_order' => $filter_order,
                'filter_is_status' => $filter_is_status,
                'filter_search_input' => $filter_search_input,
                'filter_user_id' => $filter_user_id,
                'filter_table_name' => $filter_table_name
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'failureCode' => 28
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'failureCode' => 28
    ]);
}
?>
