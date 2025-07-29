<?php
function table_add_egb_option_group() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_option_group (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        group_code VARCHAR(50) NOT NULL COMMENT '옵션 그룹 코드',
        group_title VARCHAR(100) NOT NULL COMMENT '옵션 그룹 제목',
        group_required TINYINT(2) DEFAULT 1 COMMENT '옵션 필수 여부',
        group_description TEXT COMMENT '옵션 그룹 설명',
        group_access_level TINYINT(3) DEFAULT 0 COMMENT '그룹 접근 레벨',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_option_group_uniq_id` (`uniq_id`),
        UNIQUE KEY `ux_egb_option_group_group_code` (`group_code`),

        INDEX idx_egb_option_group_created_at (created_at),
        INDEX idx_egb_option_group_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='옵션 그룹을 정의하고 관리하는 테이블';
    ";

    return $query_db;
}
?>
