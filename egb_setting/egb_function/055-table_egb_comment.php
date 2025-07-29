
<?php
function table_egb_comment($name = '') {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_comment_{$name} (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

		comment_board_uniq_id VARCHAR(255) COMMENT '게시글 유니크아이디',
        comment_user_uniq_id VARCHAR(255) COMMENT '이용자 유니크ID',
        comment_user_ip VARCHAR(255) COMMENT '이용자 IP',
        comment_user_agent TEXT COMMENT 'User-Agent',
        comment_user_password VARCHAR(255) COMMENT '비밀번호',

        comment_contents LONGTEXT COMMENT '댓글 내용',
		comment_data LONGTEXT COMMENT '데이터',

        comment_is_notice TINYINT(1) DEFAULT 0 COMMENT '공지 여부',
        comment_is_secret TINYINT(1) DEFAULT 0 COMMENT '비밀글 여부',
        comment_recommended INT DEFAULT 0 COMMENT '추천 수',
        comment_not_recommended INT DEFAULT 0 COMMENT '비추천 수',
        comment_report INT DEFAULT 0 COMMENT '신고 수',
        comment_reply_count INT DEFAULT 0 COMMENT '답글 수',

        comment_parent_uniq_id VARCHAR(255) NULL COMMENT '부모 댓글 유니크ID',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_comment_{$name}_uniq_id` (`uniq_id`),

        FULLTEXT INDEX `ft_idx_egb_comment_{$name}_comment_contents` (`comment_contents`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='게시판 댓글 테이블';
    ";

    return $query_db;
}
?>
