<?php
function table_add_egb_integrated_data() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_integrated_data (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
    
        integrated_target_table VARCHAR(50) NOT NULL COMMENT '연결 대상 테이블명',
        integrated_target_uniq_id VARCHAR(13) NOT NULL COMMENT '연결 대상의 uniq_id',
        integrated_data_key VARCHAR(100) NOT NULL COMMENT '데이터 키',
        integrated_data_value TEXT COMMENT '데이터 값 (숫자, 문자열, JSON 등)',
    
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_integrated_data_uniq_id` (`uniq_id`),

        INDEX `idx_egb_integrated_data_integrated_target_table` (`integrated_target_table`),
        INDEX `idx_egb_integrated_data_integrated_target_uniq_id` (`integrated_target_uniq_id`),

        INDEX idx_egb_integrated_data_created_at (created_at),
        INDEX idx_egb_integrated_data_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='엔티티별 Key-Value 형식의 통합 데이터를 저장하는 범용 테이블';
    ";

    return $query_db;
}
?>
