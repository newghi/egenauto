<?php
function table_add_egb_alarm_log() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_alarm_log (
    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
    display_order INT DEFAULT 0 COMMENT '출력 순서',

    alarm_log_user_uniq_id VARCHAR(13) NOT NULL COMMENT '알림 대상 유저 ID',
    alarm_log_title VARCHAR(255) NOT NULL COMMENT '알림 제목',
    alarm_log_message TEXT COMMENT '알림 메시지',
    alarm_log_type VARCHAR(50) DEFAULT NULL COMMENT '알림 타입(시스템, 마케팅 등)',
    alarm_log_link TEXT DEFAULT NULL COMMENT '이동 링크',
    alarm_log_is_read TINYINT(1) DEFAULT 0 COMMENT '읽음 여부',
    alarm_log_read_at TIMESTAMP NULL DEFAULT NULL COMMENT '읽은 시간',

    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

    INDEX `idx_alarm_log_user` (`alarm_log_user_uniq_id`),
    
    INDEX `idx_alarm_log_created_at` (`created_at`),
    INDEX `idx_alarm_log_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='알림 로그 테이블';
";

	return $query_db;
}
?>