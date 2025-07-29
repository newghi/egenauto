
<?php
function table_add_egb_email_log() {
	
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_email_log (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
        
        sender_email VARCHAR(100) NOT NULL COMMENT '발신자 이메일',
        sender_name VARCHAR(100) NULL COMMENT '발신자 이름',
        recipient_email VARCHAR(100) NOT NULL COMMENT '수신자 이메일',
        recipient_name VARCHAR(100) NULL COMMENT '수신자 이름',
        
        email_subject VARCHAR(255) NOT NULL COMMENT '이메일 제목',
        email_content TEXT NOT NULL COMMENT '이메일 내용',
        email_type VARCHAR(10) DEFAULT 'html' COMMENT '이메일 타입',
        
        attachments JSON NULL COMMENT '첨부파일 정보',
        cc_emails JSON NULL COMMENT '참조 이메일 목록',
        bcc_emails JSON NULL COMMENT '숨은참조 이메일 목록',
        
        send_status VARCHAR(10) DEFAULT 'pending' COMMENT '발송 상태',
        error_message TEXT NULL COMMENT '에러 메시지',
        retry_count INT DEFAULT 0 COMMENT '재시도 횟수',
        
        smtp_response TEXT NULL COMMENT 'SMTP 응답 내용',
        
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일'
    ) ENGINE=InnoDB 
      DEFAULT CHARSET=utf8mb4 
      COLLATE=utf8mb4_general_ci 
      COMMENT='이메일 발송 로그 테이블'
";

	return $query_db;
}
?>
