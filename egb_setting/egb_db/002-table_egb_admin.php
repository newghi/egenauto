<?php
// 관리자 테이블 생성 쿼리
function table_egb_admin(){
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_admin (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        admin_id VARCHAR(255) UNIQUE COMMENT '관리자 아이디',
        admin_password VARCHAR(255) COMMENT '관리자 비밀번호',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_admin_admin_id` (`admin_id`),

        INDEX idx_egb_admin_created_at (created_at),
        INDEX idx_egb_admin_deleted_at (deleted_at)
    ) ENGINE=InnoDB 
    DEFAULT CHARSET=utf8mb4 
    COLLATE=utf8mb4_general_ci 
    COMMENT='관리자 정보를 저장하는 테이블';
    ";
    return $query_db;
}
?>
