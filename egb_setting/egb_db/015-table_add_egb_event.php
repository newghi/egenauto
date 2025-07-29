<?php
function table_add_egb_event() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_event (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        event_title VARCHAR(255) NOT NULL COMMENT '이벤트 제목',
        event_category VARCHAR(100) NOT NULL COMMENT '이벤트 카테고리',
        event_description TEXT COMMENT '이벤트 설명',
        event_data TEXT COMMENT '이벤트 데이터',
        event_start_date DATE NOT NULL COMMENT '이벤트 시작일',
        event_end_date DATE NOT NULL COMMENT '이벤트 종료일',
        event_type VARCHAR(100) NOT NULL COMMENT '이벤트 유형',
        event_status TINYINT(2) DEFAULT 0 COMMENT '이벤트 상태값',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_event_uniq_id` (`uniq_id`),

        INDEX `idx_egb_event_event_title` (`event_title`),
        INDEX `idx_egb_event_event_category` (`event_category`),

        INDEX idx_egb_event_event_dates (event_start_date, event_end_date),
        INDEX idx_egb_event_event_status (event_status),

        INDEX idx_egb_event_created_at (created_at),
        INDEX idx_egb_event_deleted_at (deleted_at)

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='이벤트 관리 테이블';
    ";

    return $query_db;
}
?>
