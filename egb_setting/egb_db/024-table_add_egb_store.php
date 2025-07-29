<?php
function table_add_egb_store() {
	$query_db = "
    CREATE TABLE IF NOT EXISTS egb_store (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
    
    	store_registrant_uniq_id VARCHAR(13) NOT NULL COMMENT '스토어 등록자',
        store_name VARCHAR(100) NOT NULL COMMENT '스토어 이름',
        store_address VARCHAR(255) NULL COMMENT '주소',
        store_phone_number VARCHAR(20) NULL COMMENT '전화번호',
        store_region1 VARCHAR(100) NULL COMMENT '지역1',
        store_region2 VARCHAR(100) NULL COMMENT '지역2',
        store_latitude DOUBLE(10,6) NULL COMMENT '위도',
        store_longitude DOUBLE(10,6) NULL COMMENT '경도',
        store_image TEXT NULL COMMENT '스토어 이미지',
        store_data TEXT NULL COMMENT '스토어 데이터',
        store_hours TEXT NULL COMMENT '영업시간',
        store_holiday TEXT NULL COMMENT '휴일 안내',
        store_description TEXT NULL COMMENT '설명',
		store_schedule TEXT NULL COMMENT '예약 가능 시간',
    
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',
    
    	UNIQUE KEY `ux_egb_store_uniq_id` (`uniq_id`),
    	UNIQUE KEY `ux_egb_store_store_name` (`store_name`),

    	INDEX `idx_egb_store_created_at` (`created_at`),
    	INDEX `idx_egb_store_deleted_at` (`deleted_at`)
    
    ) ENGINE=InnoDB
      DEFAULT CHARSET=utf8mb4
      COLLATE=utf8mb4_general_ci
      COMMENT='스토어 정보를 관리하는 테이블';
    ";

	return $query_db;
}
?>
