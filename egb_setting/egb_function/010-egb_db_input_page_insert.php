<?php

function egb_db_input_page_insert($title, $name, $path) {
	try {
		// 파일 존재 여부 확인
		if (!file_exists(ROOT . $path)) {
			return false;
		}

		// 중복 체크 
		$check_query = "SELECT uniq_id FROM egb_input_page WHERE page_name = :page_name LIMIT 1";
		$check_param = [':page_name' => $name];
		$check_binding = binding_sql(1, $check_query, $check_param);
		$check_result = egb_sql($check_binding);
		
		if (isset($check_result[0]['uniq_id'])) {
			// 이미 존재하는 경우 false 반환하여 중복 등록 방지
			return false;
		}

		$uniq_id = uniqid();

		// 기본값으로만 구성
		$query = "INSERT INTO egb_input_page (
			uniq_id, is_status, display_order,
			page_title, page_name, page_path, page_use,
			setting_access_level, created_by
		) VALUES (
			:uniq_id, 1, 0,
			:page_title, :page_name, :page_path, 1,
			0, 'admin'
		)";

		$params = [
			':uniq_id'     => $uniq_id,
			':page_title'  => $title,
			':page_name'   => $name,
			':page_path'   => $path
		];

		$binding = binding_sql(2, $query, $params);
		$sql = egb_sql($binding);

		if (!empty($sql) && isset($sql[0])) {
			// 레코드 카운트 증가
			increase_record_total_count('egb_input_page');
			increase_record_active_count('egb_input_page');
			return $sql[0];
		}
		return false;

	} catch (Exception $e) {
		error_log($e->getMessage());
		return false;
	}
}

?>