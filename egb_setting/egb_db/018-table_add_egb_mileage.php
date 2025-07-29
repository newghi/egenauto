<?php
function table_add_egb_mileage() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_mileage (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
    
        mileage_target_uniq_id VARCHAR(13) NOT NULL COMMENT '마일리지 대상 유니크ID',
        mileage_amount INT NOT NULL COMMENT '마일리지 금액',
        mileage_type TINYINT(1) NOT NULL COMMENT '지급(1) 또는 차감(0)',
        mileage_before_balance INT NOT NULL COMMENT '변경 전 마일리지 잔액',
        mileage_after_balance INT NOT NULL COMMENT '변경 후 마일리지 잔액',
        mileage_status TINYINT(2) DEFAULT 1 COMMENT '마일리지 상태 (1: 정상, 2: 보류 등)',
        mileage_reason VARCHAR(255) NOT NULL COMMENT '마일리지 처리 사유',
        mileage_memo TEXT COMMENT '마일리지 관련 메모',
    
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_mileage_uniq_id` (`uniq_id`),

        INDEX idx_egb_mileage_mileage_target_uniq_id (mileage_target_uniq_id),
        INDEX idx_egb_mileage_mileage_type (mileage_type),
        INDEX idx_egb_mileage_mileage_status (mileage_status),

        INDEX idx_egb_mileage_created_at (created_at),
        INDEX idx_egb_mileage_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='마일리지 관리 테이블';
    ";
    
    return $query_db;
}
?>
