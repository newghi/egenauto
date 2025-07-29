<?php
function table_add_egb_board_management() {
	$query_db = "
	CREATE TABLE IF NOT EXISTS egb_management_board (
	    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
	    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
	    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
	    display_order INT DEFAULT 0 COMMENT '출력 순서',
	
	    board_admin_uniq_id VARCHAR(255) COMMENT '게시판 관리자 고유 식별자',
	    board_themes TEXT COMMENT '게시판 테마',
	    board_editor TEXT COMMENT '게시판 에디터',
	    table_board_name VARCHAR(255) COMMENT '테이블 게시판 이름',
	    table_comment_name VARCHAR(255) COMMENT '테이블 댓글 이름',
	    route_board_name VARCHAR(255) COMMENT '라우트 게시판 이름',
	    route_board_type VARCHAR(255) COMMENT '라우트 게시판 타입',
	    board_name VARCHAR(255) COMMENT '게시판 이름',
	    comment_name VARCHAR(255) COMMENT '댓글 이름',
	    board_custom_name VARCHAR(255) COMMENT '게시판 커스텀 이름',
	    board_category_name VARCHAR(255) COMMENT '게시판 카테고리 이름',
	    board_class_name VARCHAR(255) COMMENT '게시판 분류 이름',
	
	    board_status TINYINT(1) DEFAULT 1 COMMENT '게시판 상태 (1: on, 0: off)',
	    comment_status TINYINT(1) DEFAULT 1 COMMENT '댓글 상태 (1: on, 0: off)',
	    board_list_count INT DEFAULT 5 COMMENT '리스트 출력 수',
	    board_pagination_count INT DEFAULT 5 COMMENT '페이지네이션 수',
	    board_write_after_page VARCHAR(50) DEFAULT 'list' COMMENT '글 작성 후 이동',
	
	    board_view_level TINYINT(3) DEFAULT 1 COMMENT '열람 레벨',
	    board_write_level TINYINT(3) DEFAULT 1 COMMENT '쓰기 레벨',
	    board_edit_level TINYINT(3) DEFAULT 1 COMMENT '수정 레벨',
	    board_delete_level TINYINT(3) DEFAULT 1 COMMENT '삭제 레벨',
	    board_upload_level TINYINT(3) DEFAULT 1 COMMENT '업로드 레벨',
	    board_download_level TINYINT(3) DEFAULT 1 COMMENT '다운로드 레벨',
	    board_reply_level TINYINT(3) DEFAULT 1 COMMENT '답변 레벨',
	    board_link_level TINYINT(3) DEFAULT 1 COMMENT '링크 접근 레벨',
	
	    comment_view_level TINYINT(3) DEFAULT 1 COMMENT '댓글 열람 레벨',
	    comment_write_level TINYINT(3) DEFAULT 1 COMMENT '댓글 쓰기 레벨',
	    comment_edit_level TINYINT(3) DEFAULT 1 COMMENT '댓글 수정 레벨',
	    comment_delete_level TINYINT(3) DEFAULT 1 COMMENT '댓글 삭제 레벨',
	    comment_upload_level TINYINT(3) DEFAULT 1 COMMENT '댓글 업로드 레벨',
	    comment_download_level TINYINT(3) DEFAULT 1 COMMENT '댓글 다운로드 레벨',
	    comment_reply_level TINYINT(3) DEFAULT 1 COMMENT '댓글 답변 레벨',
	    comment_link_level TINYINT(3) DEFAULT 1 COMMENT '댓글 링크 레벨',
	
	    board_comment_edit_level TINYINT(3) DEFAULT 1 COMMENT '댓글 존재 시 원글 수정 제한 레벨',
	    board_comment_delete_level TINYINT(3) DEFAULT 1 COMMENT '댓글 존재 시 원글 삭제 제한 레벨',
	
	    board_is_notice TINYINT(1) DEFAULT 1 COMMENT '공지 여부',
	    board_is_secret TINYINT(1) DEFAULT 0 COMMENT '비밀글 여부',
	    comment_is_secret TINYINT(1) DEFAULT 0 COMMENT '댓글 비밀글 여부',
	    board_use_realname TINYINT(1) DEFAULT 0 COMMENT '실명 사용 여부',
	    board_use_signature TINYINT(1) DEFAULT 0 COMMENT '서명 사용 여부',
	    board_show_ip TINYINT(1) DEFAULT 0 COMMENT 'IP 보이기 여부',
	    board_use_like TINYINT(1) DEFAULT 0 COMMENT '좋아요 기능 여부',
	    board_use_dislike TINYINT(1) DEFAULT 0 COMMENT '싫어요 기능 여부',
	    board_upload_file_count TINYINT(3) DEFAULT 1 COMMENT '업로드 파일 수',
	    board_upload_file_size INT DEFAULT 0 COMMENT '업로드 용량 (byte)',
	
	    board_min_length INT DEFAULT 0 COMMENT '최소 글자 수',
	    board_max_length INT DEFAULT 0 COMMENT '최대 글자 수',
	    comment_min_length INT DEFAULT 0 COMMENT '댓글 최소 글자 수',
	    comment_max_length INT DEFAULT 0 COMMENT '댓글 최대 글자 수',
	
	    board_use_share TINYINT(1) DEFAULT 0 COMMENT '공유 사용 여부',
	    board_use_user_captcha TINYINT(1) DEFAULT 0 COMMENT '회원 캡차 사용 여부',
	    board_use_guest_captcha TINYINT(1) DEFAULT 0 COMMENT '비회원 캡차 사용 여부',
	
	    board_contents_top LONGTEXT COMMENT '상단 내용',
	    board_contents_bottom LONGTEXT COMMENT '하단 내용',
	    board_contents_default LONGTEXT COMMENT '기본 입력 내용',
	    board_list_sort TEXT COMMENT '리스트 정렬 기준',
	
	    board_view_point INT DEFAULT 0 COMMENT '열람 포인트',
	    board_write_point INT DEFAULT 0 COMMENT '쓰기 포인트',
	    board_edit_point INT DEFAULT 0 COMMENT '수정 포인트',
	    board_delete_point INT DEFAULT 0 COMMENT '삭제 포인트',
	    board_upload_point INT DEFAULT 0 COMMENT '업로드 포인트',
	    board_download_point INT DEFAULT 0 COMMENT '다운로드 포인트',
	
	    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
	    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
	    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
	    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
	    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
	    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

		UNIQUE KEY `ux_egb_board_mangement_uniq_id` (`uniq_id`),

		INDEX idx_egb_board_mangement_created_at (created_at),
		INDEX idx_egb_board_mangement_deleted_at (deleted_at)

	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='게시판 관리 테이블';
	";

	return $query_db;
}
?>
