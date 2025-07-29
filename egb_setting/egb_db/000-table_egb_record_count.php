<?php
// 관리자 테이블 생성 쿼리
function table_egb_record_count(){
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_record_count (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        record_table_name VARCHAR(100) NOT NULL COMMENT '대상 테이블 이름',
        record_total_count INT NOT NULL DEFAULT 0 COMMENT '전체 등록 수',
        record_active_count INT NOT NULL DEFAULT 0 COMMENT '활성화된 수',
        record_inactive_count INT NOT NULL DEFAULT 0 COMMENT '비활성화된 수',
        record_soft_deleted_count INT NOT NULL DEFAULT 0 COMMENT '소프트 삭제 수',
        record_hard_deleted_count INT NOT NULL DEFAULT 0 COMMENT '하드 삭제 수',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_record_count_uniq_id` (`uniq_id`),
        UNIQUE KEY `ux_egb_record_count_record_table_name` (`record_table_name`),

        INDEX idx_egb_record_count_created_at (created_at),
        INDEX idx_egb_record_count_deleted_at (deleted_at)

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='여러 테이블의 상태별 레코드 수 및 삭제 이력을 관리하는 통계 테이블';
    ";
    return $query_db;
}
?>
