<?php
function table_add_egb_page() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS `egb_page` (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        page_title VARCHAR(255) DEFAULT '페이지 제목' COMMENT '페이지 제목',
        page_name VARCHAR(255) NOT NULL COMMENT '페이지 이름', 
        page_type VARCHAR(255) DEFAULT '페이지 타입' COMMENT '페이지 타입',
        page_seo TINYINT(1) DEFAULT 1 COMMENT '페이지 SEO 사용 여부',
        page_use TINYINT(1) DEFAULT 1 COMMENT '페이지 사용 여부',
        page_rank INT DEFAULT 0 COMMENT '페이지 우선 순위',
        page_view INT DEFAULT 0 COMMENT '페이지 조회수',

        page_theme VARCHAR(255) DEFAULT 'eungabi' COMMENT '테마',
        page_plugin VARCHAR(255) DEFAULT NULL COMMENT '플러그인',
        page_path LONGTEXT COMMENT '페이지 경로',
        page_source VARCHAR(255) DEFAULT '시스템' COMMENT '출처',

        seo_title VARCHAR(255) DEFAULT 'SEO 제목' COMMENT 'SEO 제목',
        seo_subject VARCHAR(255) DEFAULT 'SEO 주제' COMMENT 'SEO 주제',
        seo_description VARCHAR(255) DEFAULT 'SEO 설명' COMMENT 'SEO 설명',
        seo_keywords VARCHAR(255) DEFAULT 'SEO 키워드' COMMENT 'SEO 키워드',
        seo_robots VARCHAR(255) DEFAULT 'nofollow, noindex' COMMENT 'SEO 로봇설정',
        seo_canonical VARCHAR(255) DEFAULT 'SEO 중복방지 링크' COMMENT 'SEO 중복방지 링크',
        seo_og_title VARCHAR(255) DEFAULT 'SEO OG 제목' COMMENT 'SEO OG 제목',
        seo_og_description VARCHAR(255) DEFAULT 'SEO OG 설명' COMMENT 'SEO OG 설명',
        seo_og_img VARCHAR(255) DEFAULT 'SEO OG 이미지 링크' COMMENT 'SEO OG 이미지 링크',
        seo_author VARCHAR(255) DEFAULT 'SEO 작성자' COMMENT 'SEO 작성자',

        setting_header_use TINYINT(1) DEFAULT 1 COMMENT 'header 사용 여부',
        setting_footer_use TINYINT(1) DEFAULT 1 COMMENT 'footer 사용 여부', 
        setting_comment_use TINYINT(1) DEFAULT 1 COMMENT 'comment 사용 여부',
        setting_access_level TINYINT(3) DEFAULT 0 COMMENT '접근 레벨',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_page_uniq_id` (`uniq_id`),
        UNIQUE KEY `ux_egb_page_page_name` (`page_name`),

        INDEX idx_egb_page_page_type (page_type),

        INDEX idx_egb_page_created_at (created_at),
        INDEX idx_egb_page_deleted_at (deleted_at)
        
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='페이지 정보를 저장하는 테이블';
    ";

    return $query_db;
}
?>
