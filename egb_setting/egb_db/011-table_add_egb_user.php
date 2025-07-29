<?php
function table_add_egb_user() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_user (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        user_id VARCHAR(50) NOT NULL COMMENT '회원 아이디',
        user_password VARCHAR(255) NOT NULL COMMENT '비밀번호',
        user_name VARCHAR(50) NOT NULL COMMENT '이름',
        user_nick_name VARCHAR(50) DEFAULT NULL COMMENT '별명',
        user_email VARCHAR(100) NOT NULL COMMENT '이메일',
        user_phone1 VARCHAR(20) DEFAULT NULL COMMENT '전화번호1',
        user_phone2 VARCHAR(20) DEFAULT NULL COMMENT '전화번호2',

        user_zipcode VARCHAR(10) DEFAULT NULL COMMENT '우편번호',
        user_address VARCHAR(255) DEFAULT NULL COMMENT '기본주소',
        user_address_detail VARCHAR(255) DEFAULT NULL COMMENT '상세주소',

        user_deposit INT(11) DEFAULT 0 COMMENT '예치금',
        user_point INT(11) DEFAULT 0 COMMENT '적립금',
        user_mileage INT(11) DEFAULT 0 COMMENT '마일리지',

        user_ip VARCHAR(255) DEFAULT NULL COMMENT '가입시 ip',
        user_device VARCHAR(255) DEFAULT NULL COMMENT '가입시 기기',
        
        user_alarm_count INT(11) DEFAULT 0 COMMENT '알림카운트',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_user_uniq_id` (`uniq_id`),
        UNIQUE KEY `ux_egb_user_user_id` (`user_id`),

        INDEX `idx_egb_user_user_nick_name` (`user_nick_name`),
        INDEX `idx_egb_user_user_email` (`user_email`),
        INDEX `idx_egb_user_user_phone1` (`user_phone1`),

        INDEX idx_egb_user_created_at (created_at),
        INDEX idx_egb_user_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='기본 회원 테이블';
    ";


    return $query_db;
}
?>
