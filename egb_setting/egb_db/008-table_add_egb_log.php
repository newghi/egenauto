<?php
function table_add_egb_log() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_log (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
    
        log_message TEXT COMMENT '로그 메시지',
        log_ip VARCHAR(45) NOT NULL COMMENT '접속 IP',
        log_uri TEXT NOT NULL COMMENT '접속 URI',
        log_method VARCHAR(10) NOT NULL COMMENT '요청 메서드',
        log_agent TEXT COMMENT 'User-Agent',
        log_referer TEXT COMMENT 'Referer',
        log_device VARCHAR(20) COMMENT '기기 타입',
        log_platform VARCHAR(50) COMMENT '운영체제',
        log_browser VARCHAR(50) COMMENT '브라우저',
        log_browser_ver VARCHAR(30) COMMENT '브라우저 버전',
        log_is_bot TINYINT(1) DEFAULT 0 COMMENT '봇 여부',
        log_render_time VARCHAR(50) DEFAULT NULL COMMENT '페이지 렌더링 소요시간(ms)',
    
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_log_uniq_id` (`uniq_id`),

        INDEX idx_egb_log_log_ip (log_ip),
        INDEX idx_egb_log_created_at (created_at),
        INDEX idx_egb_log_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='웹 접근 로그 기록 테이블';
    ";

    return $query_db;
}
?>
