
<?php
function table_add_egb_api_management() {
	
    $query_db = "
    CREATE TABLE IF NOT EXISTS egb_api_management (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
        
        api_service_name VARCHAR(50) NOT NULL COMMENT '서비스 이름',
        api_service_description TEXT NULL COMMENT '서비스 설명',
        api_service_type VARCHAR(20) NOT NULL COMMENT 'API 타입 (REST, GraphQL, WebSocket 등)',
		
        api_service_concurrent_connections INT DEFAULT 0 COMMENT '동시접속 가능 수',
        
        api_per_second_usage INT DEFAULT 0 COMMENT '초당 사용량',
        api_per_minute_usage INT DEFAULT 0 COMMENT '분당 사용량',
        api_hourly_usage INT DEFAULT 0 COMMENT '시간당 사용량',        
        api_daily_usage INT DEFAULT 0 COMMENT '일일 사용량',
        api_monthly_usage INT DEFAULT 0 COMMENT '한달 사용량',
        api_annual_usage INT DEFAULT 0 COMMENT '연간 사용량',
        
        api_per_second_limit INT NOT NULL COMMENT '초당 사용량 한도',
        api_per_minute_limit INT NOT NULL COMMENT '분당 사용량 한도',
        api_hourly_limit INT NOT NULL COMMENT '시간당 사용량 한도',
        api_daily_limit INT NOT NULL COMMENT '일일 사용량 한도',
        api_monthly_limit INT NOT NULL COMMENT '한달 사용량 한도',
        api_annual_limit INT NOT NULL COMMENT '연간 사용량 한도',
        
        api_total_usage BIGINT DEFAULT 0 COMMENT '누적 사용량',
        api_metadata JSON NULL COMMENT '서비스 메타데이터',
        
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일'
    ) ENGINE=InnoDB 
      DEFAULT CHARSET=utf8mb4 
      COLLATE=utf8mb4_general_ci 
      COMMENT='API 서비스 사용량 및 한도 관리 테이블'
";

	return $query_db;
}
?>
