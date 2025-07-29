<?php
function table_add_egb_reservation() {
	$query_db = "
    CREATE TABLE IF NOT EXISTS egb_reservation (
        no INT AUTO_INCREMENT PRIMARY KEY COMMENT '자동 증가 번호',
        uniq_id VARCHAR(13) NOT NULL COMMENT '유니크ID',
        is_status TINYINT(2) DEFAULT 1 COMMENT '활성화 여부',
        display_order INT DEFAULT 0 COMMENT '출력 순서',
    
        reservation_group_uniq_id VARCHAR(13) NOT NULL COMMENT '예약 그룹ID',
        reservation_date DATE NOT NULL COMMENT '예약 날짜',
        reservation_time TIME NOT NULL COMMENT '예약 시간',
        reservation_weekday VARCHAR(10) NOT NULL COMMENT '예약 요일',
        reservation_store_uniq_id VARCHAR(13) NOT NULL COMMENT '스토어 유니크ID',
        reservation_user_uniq_id VARCHAR(13) NOT NULL COMMENT '예약자 유니크아이디',
        reservation_applied_at DATETIME NULL COMMENT '신청일',
        reservation_confirmed_at DATETIME NULL COMMENT '확정일',
        reservation_completed_at DATETIME NULL COMMENT '완료일',
        reservation_canceled_at DATETIME NULL COMMENT '취소일',
        reservation_no_show_at DATETIME NULL COMMENT '노쇼일',
        reservation_status TINYINT(2) NOT NULL COMMENT '예약 상태',
        reservation_confirmed_by VARCHAR(13) NULL COMMENT '예약확정 처리자 유니크아이디',
        reservation_completed_by VARCHAR(13) NULL COMMENT '예약완료 처리자 유니크아이디',
        reservation_canceled_by VARCHAR(13) NULL COMMENT '예약취소 처리자 유니크아이디',
        reservation_no_show_by VARCHAR(13) NULL COMMENT '예약노쇼 처리자 유니크아이디',
        reservation_manager_note TEXT NULL COMMENT '예약관리자용메모',
        reservation_canceled_note TEXT NULL COMMENT '예약취소메모',
        reservation_no_show_note TEXT NULL COMMENT '예약노쇼메모',
        reservation_data TEXT NULL COMMENT '예약데이터',
    
        created_by VARCHAR(50) NOT NULL COMMENT '생성자',
        updated_by VARCHAR(50) DEFAULT NULL COMMENT '수정자',
        deleted_by VARCHAR(50) DEFAULT NULL COMMENT '삭제자',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '생성일',
        deleted_at TIMESTAMP NULL DEFAULT NULL COMMENT '삭제일',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '수정일',

        UNIQUE KEY `ux_egb_reservation_uniq_id` (`uniq_id`),
        INDEX idx_egb_reservation_reservation_group_uniq_id (reservation_group_uniq_id),
        INDEX idx_egb_reservation_reservation_store_uniq_id (reservation_store_uniq_id),
        INDEX idx_egb_reservation_reservation_user_uniq_id (reservation_user_uniq_id),
        INDEX idx_egb_reservation_reservation_status (reservation_status),
        
        INDEX idx_egb_reservation_created_at (created_at),
        INDEX idx_egb_reservation_deleted_at (deleted_at)

    ) ENGINE=InnoDB
      DEFAULT CHARSET=utf8mb4
      COLLATE=utf8mb4_general_ci
      COMMENT='예약 정보를 관리하는 테이블';
    ";

	return $query_db;
}
?>
