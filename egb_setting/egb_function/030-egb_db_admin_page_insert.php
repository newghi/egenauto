<?php

function egb_db_admin_page_insert($title, $name, $path, $type) {
	try {
		// 중복 체크
		$check_query = "SELECT uniq_id FROM egb_admin_page WHERE page_name = :page_name AND deleted_at IS NULL LIMIT 1";
		$check_param = [':page_name' => $name];
		$check_binding = binding_sql(1, $check_query, $check_param);
		$check_result = egb_sql($check_binding);
		
		if (isset($check_result[0]['uniq_id'])) {
			return false; // 이미 존재하면 등록하지 않음
		}

		$uniq_id = uniqid();

		// 기본값으로만 구성
		$query = "INSERT INTO egb_admin_page (
			uniq_id, is_status, display_order,
			page_title, page_name, page_path, page_type,
			page_seo, page_source, page_use, page_rank, page_view,
			seo_title, seo_subject, seo_description, seo_keywords,
			seo_robots, seo_canonical, seo_og_title, seo_og_description,
			seo_og_img, seo_author, setting_header_use, setting_footer_use,
			setting_comment_use, setting_access_level, created_by
		) VALUES (
			:uniq_id, 1, 0,
			:page_title, :page_name, :page_path, :page_type,
			1, '기본', 1, '0', '0',
			'SEO 제목', 'SEO 주제', 'SEO 설명', 'SEO 키워드',
			'nofollow, noindex', 'SEO 중복방지 링크', 'SEO OG 제목', 'SEO OG 설명',
			:seo_og_img, 'SEO 작성자', 1, 1,
			1, 99, 'admin'
		)";

		$params = [
			':uniq_id'     => $uniq_id,
			':page_title'  => $title,
			':page_name'   => $name,
			':page_path'   => $path,
			':page_type'   => $type,
			':seo_og_img'  => DS . 'egb_thumbnail.webp'
		];

		$binding = binding_sql(2, $query, $params);
		$sql = egb_sql($binding);

		if (!empty($sql) && isset($sql[0])) {
			// 레코드 카운트 증가
			increase_record_total_count('egb_admin_page');
			increase_record_active_count('egb_admin_page');
			return $sql[0];
		}
		return false;

	} catch (Exception $e) {
		error_log($e->getMessage());
		return false;
	}
}

?>