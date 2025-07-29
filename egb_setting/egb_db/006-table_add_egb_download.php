<?php
function table_add_egb_download() {
    $query_db = "
CREATE TABLE IF NOT EXISTS egb_download (
	no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
	uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
	is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
	display_order INT DEFAULT 0 COMMENT '출력 순서',

	download_data_path VARCHAR(255) COMMENT '데이터 경로',
	download_data_name VARCHAR(255) COMMENT '데이터 이름',
	download_file_type VARCHAR(50) COMMENT '파일 형식',
	download_size VARCHAR(255) COMMENT '다운로드 용량',
	download_hash LONGTEXT COMMENT '다운로드 해시',
	download_level TINYINT(3) DEFAULT 0 COMMENT '접근 레벨',
	download_password VARCHAR(255) COMMENT '다운로드 비밀번호',
	download_expire_at DATETIME COMMENT '다운로드 만료일',
	download_count VARCHAR(255) COMMENT '다운로드 수',

	created_by VARCHAR(50) NOT NULL COMMENT '생성자',
	updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
	deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
	deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

	UNIQUE KEY `ux_egb_download_uniq_id` (`uniq_id`),

	INDEX idx_egb_download_created_at (created_at),
	INDEX idx_egb_download_deleted_at (deleted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='다운로드 정보를 관리하는 테이블';
";

    return $query_db;
}
?>
