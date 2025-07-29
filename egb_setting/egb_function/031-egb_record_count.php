<?php

// 전체 등록 수 증가
function increase_record_total_count($table_name) {
    return update_record_field($table_name, 'record_total_count', +1);
}

// 전체 등록 수 감소 
function decrease_record_total_count($table_name) {
    return update_record_field($table_name, 'record_total_count', -1);
}

// 활성화 수 증가
function increase_record_active_count($table_name) {
    return update_record_field($table_name, 'record_active_count', +1);
}

// 활성화 수 감소
function decrease_record_active_count($table_name) {
    return update_record_field($table_name, 'record_active_count', -1);
}

// 비활성화 수 증가
function increase_record_inactive_count($table_name) {
    return update_record_field($table_name, 'record_inactive_count', +1);
}

// 비활성화 수 감소
function decrease_record_inactive_count($table_name) {
    return update_record_field($table_name, 'record_inactive_count', -1);
}

// 소프트 삭제 수 증가
function increase_record_soft_deleted_count($table_name) {
    return update_record_field($table_name, 'record_soft_deleted_count', +1);
}

// 소프트 삭제 수 감소
function decrease_record_soft_deleted_count($table_name) {
    return update_record_field($table_name, 'record_soft_deleted_count', -1);
}

// 하드 삭제 수 증가
function increase_record_hard_deleted_count($table_name) {
    return update_record_field($table_name, 'record_hard_deleted_count', +1);
}

// 하드 삭제 수 감소
function decrease_record_hard_deleted_count($table_name) {
    return update_record_field($table_name, 'record_hard_deleted_count', -1);
}

// 내부 공통 함수: 특정 필드 값을 1 증가 또는 감소 (음수로 내려가지 않도록 보호됨)
function update_record_field($table_name, $field, $diff) {
    try {
        $op = $diff > 0 ? '+' : '-';
        $abs_diff = abs($diff);
        
        // 현재 값 조회
        $check_query = "SELECT {$field} FROM egb_record_count WHERE record_table_name = :table_name";
        $check_params = [':table_name' => $table_name];
        $check_binding = binding_sql(1, $check_query, $check_params);
        $current = egb_sql($check_binding);

        // 테이블/레코드가 없으면 생성
        if (!$current) {
            $insert_query = "INSERT INTO egb_record_count (record_table_name, {$field}, updated_by) VALUES (:table_name, 0, 'system')";
            $insert_binding = binding_sql(2, $insert_query, $check_params);
            egb_sql($insert_binding);
        }

        // 업데이트 수행
        $update_query = "
            UPDATE egb_record_count 
            SET {$field} = GREATEST(0, {$field} {$op} {$abs_diff}),
                updated_by = 'system',
                updated_at = NOW()
            WHERE record_table_name = :table_name
        ";
        $update_binding = binding_sql(2, $update_query, $check_params);
        $result = egb_sql($update_binding);

        return $result !== false;

    } catch (Exception $e) {
        error_log("Record count update failed: " . $e->getMessage());
        return false;
    }
}

?>
