
<?php
function table_egb_board($name = '') {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_board_{$name} (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        board_user_uniq_id VARCHAR(255) COMMENT '이용자 유니크ID',
        board_user_ip VARCHAR(255) COMMENT '이용자 IP',
        board_user_agent TEXT COMMENT 'User-Agent',
        board_user_password VARCHAR(255) COMMENT '비밀번호',

        board_thumbnail_url VARCHAR(255) COMMENT '썸네일 URL',
        board_title VARCHAR(255) COMMENT '제목',
        board_contents LONGTEXT COMMENT '내용',
		board_data LONGTEXT COMMENT '데이터',

        board_view INT DEFAULT 0 COMMENT '조회수',
        board_is_notice TINYINT(1) DEFAULT 0 COMMENT '공지 여부',
        board_is_secret TINYINT(1) DEFAULT 0 COMMENT '비밀글 여부',
        board_recommended INT DEFAULT 0 COMMENT '추천 수',
        board_not_recommended INT DEFAULT 0 COMMENT '비추천 수',

        board_url VARCHAR(255) COMMENT 'URL',
        board_short_url VARCHAR(255) COMMENT '단축 URL',
        board_route_url VARCHAR(255) COMMENT '라우트 URL',
        board_slug_url VARCHAR(255) COMMENT '슬러그 URL',
        board_route_slug_url VARCHAR(255) COMMENT '라우트 슬러그 URL',
        board_number_url VARCHAR(255) COMMENT '숫자 URL',
        board_route_number_url VARCHAR(255) COMMENT '라우트 숫자 URL',

        board_source VARCHAR(255) COMMENT '출처',
        board_report INT DEFAULT 0 COMMENT '신고 수',
        board_comment_count INT DEFAULT 0 COMMENT '댓글 수',

        board_seo_title VARCHAR(255) COMMENT 'SEO 제목',
        board_seo_subject VARCHAR(255) COMMENT 'SEO 주제',
        board_seo_description VARCHAR(255) COMMENT 'SEO 설명',
        board_seo_keywords VARCHAR(255) COMMENT 'SEO 키워드',
        board_seo_robots VARCHAR(255) DEFAULT 'nofollow, noindex' COMMENT 'SEO 로봇설정',
        board_seo_canonical VARCHAR(255) COMMENT 'SEO Canonical 링크',
        board_seo_og_title VARCHAR(255) COMMENT 'OG 제목',
        board_seo_og_description VARCHAR(255) COMMENT 'OG 설명',
        board_seo_og_img VARCHAR(255) COMMENT 'OG 이미지',
        board_seo_author VARCHAR(255) COMMENT '작성자 표기',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_board_{$name}_uniq_id` (`uniq_id`),

        INDEX `idx_egb_board_{$name}_board_title` (`board_title`),
        FULLTEXT INDEX `ft_idx_egb_board_{$name}_board_contents` (`board_contents`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='게시판 게시글 테이블';
    ";

    return $query_db;
}
?>
