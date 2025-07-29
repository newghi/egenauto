<?php
// 관리자 테이블 생성 쿼리
function table_egb_table_column_config(){
    $query_db = "
CREATE TABLE IF NOT EXISTS egb_table_column_config (
    no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
    uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
    is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
    display_order INT DEFAULT 0 COMMENT '출력 순서',

    column_config_table_name VARCHAR(100) NOT NULL COMMENT '대상 테이블명',
    column_config_user_uniq_id VARCHAR(50) DEFAULT NULL COMMENT '설정한 사용자 유니크 ID (없으면 공통 설정)',
    column_config_data_json TEXT NOT NULL COMMENT 'JSON 형식으로 저장된 칼럼 설정 정보',

    created_by VARCHAR(50) NOT NULL COMMENT '생성자',
    updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
    deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
    deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

    UNIQUE KEY `ux_egb_table_column_config_uniq_id` (`uniq_id`),
    UNIQUE KEY `ux_egb_table_column_config_column_config_table_name` (`column_config_table_name`),


    INDEX idx_egb_table_column_config_created_at (created_at),
    INDEX idx_egb_table_column_config_deleted_at (deleted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='테이블별 컬럼 보기 설정 (JSON 기반, 공통 또는 사용자별)';
";
    return $query_db;
}
?>
