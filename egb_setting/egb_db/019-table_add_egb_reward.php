<?php
function table_add_egb_reward() {
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_reward (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',

        reward_code VARCHAR(50) NOT NULL COMMENT '리워드 코드',
        reward_title VARCHAR(255) NOT NULL COMMENT '리워드 제목',
        reward_name VARCHAR(100) NOT NULL COMMENT '리워드 이름',
        reward_type TINYINT(2) NOT NULL COMMENT '리워드 타입',
        reward_limit_count INT DEFAULT 0 COMMENT '지급 횟수',
        reward_grant INT NOT NULL COMMENT '지급 리워드 금액 또는 포인트',
        reward_expired_days INT DEFAULT 0 COMMENT '소멸일',
        reward_memo TEXT COMMENT '리워드 설명 또는 메모',
        reward_data TEXT COMMENT '추가 JSON 데이터',

        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_reward_uniq_id` (`uniq_id`),
        UNIQUE KEY `ux_egb_reward_reward_code` (`reward_code`),

        INDEX idx_egb_reward_reward_type (reward_type),
        INDEX idx_egb_reward_reward_name (reward_name),
        INDEX idx_egb_reward_reward_title (reward_title),
        INDEX idx_egb_reward_reward_code (reward_code),

        INDEX idx_egb_reward_created_at (created_at),
        INDEX idx_egb_reward_deleted_at (deleted_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='리워드 정의 테이블';
    ";


    return $query_db;
}
?>
