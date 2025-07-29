<?php
function table_add_egb_board_log() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_board_log (
    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
    display_order INT DEFAULT 0 COMMENT '출력 순서',

    log_target_table VARCHAR(50) NOT NULL COMMENT '타겟 테이블명',
    log_board_uniq_id VARCHAR(13) NOT NULL COMMENT '작성된 게시글 유니크ID',
    log_user_uniq_id VARCHAR(13) NOT NULL COMMENT '게시판 작성자 ID',

    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

    INDEX `idx_log_user` (`log_user_uniq_id`, `created_at`),
    INDEX `idx_log_board` (`log_target_table`, `log_board_uniq_id`),
    INDEX `idx_log_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='게시판 로그 테이블';
";

	return $query_db;
}
?>