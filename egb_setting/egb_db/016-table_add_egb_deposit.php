<?php
function table_add_egb_deposit() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_deposit (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        deposit_target_uniq_id VARCHAR(13) NOT NULL COMMENT '예치금 대상 유니크ID',
        deposit_amount INT NOT NULL COMMENT '예치금 금액',
        deposit_type TINYINT(1) NOT NULL COMMENT '지급(1) 또는 차감(0)',
        deposit_before_balance INT NOT NULL COMMENT '변경 전 예치금 잔액',
        deposit_after_balance INT NOT NULL COMMENT '변경 후 예치금 잔액',
        deposit_status TINYINT(2) DEFAULT 1 COMMENT '예치금 상태 (1: 정상, 2: 보류 등)',
        deposit_reason VARCHAR(255) NOT NULL COMMENT '예치금 처리 사유',
        deposit_memo TEXT COMMENT '예치금 관련 메모',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_deposit_uniq_id` (`uniq_id`),

        INDEX idx_egb_deposit_deposit_target_uniq_id (deposit_target_uniq_id),
        INDEX idx_egb_deposit_deposit_type (deposit_type),
        INDEX idx_egb_deposit_deposit_status (deposit_status),

        INDEX idx_egb_deposit_created_at (created_at),
        INDEX idx_egb_deposit_deleted_at (deleted_at)

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='예치금 관리 테이블';
    ";


    return $query_db;
}
?>
