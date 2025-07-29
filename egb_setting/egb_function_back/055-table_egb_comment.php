<?php
function table_egb_comment($name = '') {
	$query_db = "
	CREATE TABLE egb_comment".'_'.$name." (
		no INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '순번',
		comment_uniq_id VARCHAR(255) COMMENT '고유 식별자',
		comment_board_uniq_id VARCHAR(255) COMMENT '댓글이 작성된 게시글 식별자',
		comment_name VARCHAR(255) COMMENT '댓글 이름',
		comment_admin VARCHAR(255) COMMENT '댓글 관리자',
		comment_status VARCHAR(255) COMMENT '댓글 상태',
		comment_user_type VARCHAR(255) COMMENT '댓글 이용자 타입',
		comment_user_nick_name VARCHAR(255) COMMENT '댓글 이용자 닉네임',
		comment_user_ip VARCHAR(255) COMMENT '댓글 이용자 ip',
		comment_user_agent VARCHAR(255) COMMENT '댓글 이용자 agent',
		comment_user_password VARCHAR(255) COMMENT '댓글 이용자 비밀번호',
		comment_user_homepage VARCHAR(255) COMMENT '댓글 이용자 홈페이지',
		comment_contents LONGTEXT COMMENT '댓글 내용',
		comment_secret VARCHAR(255) COMMENT '댓글 비밀글 여부',
		comment_recommended VARCHAR(255) COMMENT '댓글 추천',
		comment_not_recommended VARCHAR(255) COMMENT '댓글 비추천',
		comment_report  VARCHAR(255) COMMENT '댓글 신고',
		comment_etc1 VARCHAR(255) COMMENT 'etc1',
		comment_etc2 VARCHAR(255) COMMENT 'etc2',
		comment_etc3 VARCHAR(255) COMMENT 'etc3',
		comment_etc4 VARCHAR(255) COMMENT 'etc4',
		comment_etc5 VARCHAR(255) COMMENT 'etc5',
		comment_etc6 VARCHAR(255) COMMENT 'etc6',
		comment_etc7 VARCHAR(255) COMMENT 'etc7',
		comment_etc8 VARCHAR(255) COMMENT 'etc8',
		comment_etc9 VARCHAR(255) COMMENT 'etc9',
		comment_publish_date VARCHAR(255) COMMENT '최초 등록 날짜',
		comment_last_modified_at VARCHAR(255) COMMENT '마지막 수정 날짜'
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
	";

	return $query_db;
}
?>
