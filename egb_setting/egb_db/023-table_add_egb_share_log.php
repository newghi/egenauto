<?php
function table_add_egb_share_log() {
	$query_db = "
	CREATE TABLE IF NOT EXISTS egb_share_log (
	    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
	    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
	    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
	    display_order INT DEFAULT 0 COMMENT '출력 순서',

	    share_target_table VARCHAR(100) NOT NULL COMMENT '공유 대상 테이블명',
	    share_target_uniq_id VARCHAR(13) NOT NULL COMMENT '공유 대상 유니크ID',
	    share_user_uniq_id VARCHAR(13) NOT NULL COMMENT '공유한 사용자 ID',
	    share_type TINYINT(1) DEFAULT 1 COMMENT '1: 공유, 0: 취소 요청',
		share_url VARCHAR(255) DEFAULT NULL COMMENT '공유 URL',
	    share_channel VARCHAR(50) DEFAULT 'direct' COMMENT '공유 경로 (예: kakao, link, email)',

	    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
	    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
	    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
	    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
	    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
	    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

		UNIQUE KEY `ux_egb_share_log_uniq_id` (`uniq_id`),

		INDEX `idx_egb_share_log_share_target_table` (`share_target_table`),
		INDEX `idx_egb_share_log_share_user_uniq_id` (`share_user_uniq_id`),
		INDEX `idx_egb_share_log_share_type` (`share_type`),

		INDEX `idx_egb_share_log_created_at` (`created_at`),
		INDEX `idx_egb_share_log_deleted_at` (`deleted_at`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='공유 로그 테이블';
	";

	return $query_db;
}
?>
