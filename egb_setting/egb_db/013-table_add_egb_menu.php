<?php
function table_add_egb_menu() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_menu (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        group_uniq_id VARCHAR(13) NOT NULL COMMENT '소속 메뉴 그룹 uniq_id',
        menu_name VARCHAR(100) NOT NULL COMMENT '메뉴 이름',
        menu_url VARCHAR(255) DEFAULT NULL COMMENT '메뉴 링크 URL',
        menu_target VARCHAR(10) DEFAULT '_self' COMMENT '링크 target (_self, _blank)',
        menu_access_level TINYINT(3) DEFAULT 0 COMMENT '메뉴 접근 레벨',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_menu_uniq_id` (`uniq_id`),

        INDEX idx_egb_menu_menu_name (menu_name),

        INDEX idx_egb_menu_created_at (created_at),
        INDEX idx_egb_menu_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='메뉴 항목 테이블';
    ";

    return $query_db;
}
?>
