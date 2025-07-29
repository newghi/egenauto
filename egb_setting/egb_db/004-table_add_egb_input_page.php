<?php
function table_add_egb_input_page() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS `egb_input_page` (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        page_title VARCHAR(255) DEFAULT '페이지 제목' COMMENT '페이지 제목',
        page_name VARCHAR(255) DEFAULT '페이지 이름' COMMENT '페이지 이름', 
        page_path LONGTEXT COMMENT '페이지 경로',
        page_use TINYINT(1) DEFAULT 1 COMMENT '페이지 사용 여부',

        setting_access_level TINYINT(3) DEFAULT 0 COMMENT '접근 레벨',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_input_page_uniq_id` (`uniq_id`),
        UNIQUE KEY `ux_egb_input_page_page_name` (`page_name`),

        INDEX idx_egb_input_page_created_at (created_at),
        INDEX idx_egb_input_page_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='페이지 정보를 저장하는 테이블';
    ";

    return $query_db;
}
?>
