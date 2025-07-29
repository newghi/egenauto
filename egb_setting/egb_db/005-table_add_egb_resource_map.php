<?php
function table_add_egb_resource_map() {
    $query_db = "
CREATE TABLE IF NOT EXISTS egb_resource_map (
    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
    display_order INT DEFAULT 0 COMMENT '출력 순서',

    resource_path TEXT NOT NULL COMMENT '실제 저장 경로',
    resource_name VARCHAR(255) NOT NULL COMMENT '저장된 파일명',
    resource_original_name VARCHAR(255) NOT NULL COMMENT '업로드된 원본 파일명',
    resource_size INT NOT NULL COMMENT '파일 크기 (바이트)',
    resource_mime VARCHAR(100) NOT NULL COMMENT 'MIME 타입',
    resource_extension VARCHAR(20) NOT NULL COMMENT '확장자',
    resource_type VARCHAR(50) NOT NULL COMMENT '리소스 유형',

    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

    UNIQUE KEY `ux_egb_resource_map_uniq_id` (`uniq_id`),

    INDEX idx_egb_resource_map_created_at (created_at),
    INDEX idx_egb_resource_map_deleted_at (deleted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='모든 리소스 파일을 관리하는 맵핑 테이블';
";

    return $query_db;
}
?>
