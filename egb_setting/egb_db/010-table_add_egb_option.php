<?php
function table_add_egb_option() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_option (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
    
        option_group_uniq_id VARCHAR(13) NOT NULL COMMENT '옵션 그룹 uniq_id',
        option_label TEXT COMMENT '옵션 표시 라벨 (label)',
        option_access_level TINYINT(3) DEFAULT 0 COMMENT '옵션 접근 레벨',
        option_is_active TINYINT(1) DEFAULT 1 COMMENT '옵션 활성화 여부',
        option_data TEXT COMMENT '옵션 데이터',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_option_uniq_id` (`uniq_id`),

        INDEX idx_egb_option_created_at (created_at),
        INDEX idx_egb_option_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='옵션 항목을 관리하며 계층 구조와 접근 레벨을 지원하는 테이블';
    ";

    return $query_db;
}
?>
