<?php
function table_add_egb_reward_log() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_reward_log (
    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
    display_order INT DEFAULT 0 COMMENT '출력 순서',

    reward_log_user_uniq_id VARCHAR(13) NOT NULL COMMENT '유저 유니크 ID',
    reward_log_title VARCHAR(255) NOT NULL COMMENT '리워드 제목',
    reward_log_name VARCHAR(100) NOT NULL COMMENT '리워드 이름',
    reward_log_grant_amount INT NOT NULL COMMENT '지급된 리워드 포인트',
    reward_log_used_amount INT DEFAULT 0 COMMENT '사용된 리워드 포인트',
    reward_log_expired_at TIMESTAMP NULL DEFAULT NULL COMMENT '리워드 소멸일',
    reward_log_expire_type TINYINT(2) DEFAULT 0 COMMENT '리워드 소멸 유형',

    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

    UNIQUE KEY `ux_egb_reward_log_uniq_id` (`uniq_id`),
    INDEX `idx_egb_reward_log_user_uniq_id` (`reward_log_user_uniq_id`),
    
    INDEX `idx_egb_reward_log_created_at` (`created_at`),
    INDEX `idx_egb_reward_log_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='리워드 지급 로그 테이블';
";

	return $query_db;
}
?>
