<?php

/**
 * 페이지 정보를 데이터베이스에 삽입하는 함수
 * 
 * 필수 매개변수:
 * @param string $title 페이지 제목
 * @param string $name 페이지 이름
 * @param string $path 페이지 경로 및 내용
 * @param string $type 페이지 타입
 * 
 * 선택 매개변수:
 * @param int $access_level 접근 레벨 (기본값: 0, 99=관리자)
 * @param string $seo SEO 정보 사용 여부 (기본값: "Y")
 * @param string $source 페이지 생성 출처 (기본값: "기본")
 * @param string $use 페이지 사용 여부 (기본값: "Y")
 * @param string $rank 페이지 우선 순위 (기본값: "0")
 * @param string $view 페이지 조회수 (기본값: "0")
 * @param string $created_by 생성자 ID/이름 (기본값: "admin")
 * @return mixed 쿼리 실행 결과
 */
function egb_db_page_insert($title, $name, $path, $type, $access_level = 0, $seo = "Y", $source = "기본", $use = "Y", $rank = "0", $view = "0", $created_by = "admin"){
	try {
		// page_name 중복 체크
		$check_query = "SELECT COUNT(*) as cnt FROM egb_page WHERE page_name = :page_name AND deleted_at IS NULL";
		$check_param = [':page_name' => $name];
		$check_binding = binding_sql(2, $check_query, $check_param);
		$check_result = egb_sql($check_binding);
		
		if(!empty($check_result) && isset($check_result[0]['cnt']) && $check_result[0]['cnt'] > 0) {
			return true; // 이미 존재하면 true 반환하고 종료
		}

		$uniq_id = uniqid();

		$query = "INSERT INTO egb_page (
			uniq_id,
			is_status,
			display_order,
			page_title, 
			page_name, 
			page_path, 
			page_type, 
			page_seo, 
			page_source, 
			page_use, 
			page_rank, 
			page_view,
			seo_title,
			seo_subject,
			seo_description,
			seo_keywords,
			seo_robots,
			seo_canonical,
			seo_og_title,
			seo_og_description,
			seo_og_img,
			seo_author,
			setting_header_use,
			setting_footer_use,
			setting_comment_use,
			setting_access_level,
			created_by
		) VALUES (
			:uniq_id,
			1,
			0,
			:page_title, 
			:page_name, 
			:page_path, 
			:page_type, 
			:page_seo, 
			:page_source, 
			:page_use, 
			:page_rank, 
			:page_view,
			'SEO 제목',
			'SEO 주제',
			'SEO 설명',
			'SEO 키워드',
			'nofollow, noindex',
			'SEO 중복방지 링크',
			'SEO OG 제목',
			'SEO OG 설명', 
			'SEO OG 이미지 링크',
			'SEO 작성자',
			'N',
			'N',
			'N',
			:access_level,
			:created_by
		)";

		$param = [
			':uniq_id' => $uniq_id,
			':page_title' => $title,
			':page_name' => $name,
			':page_path' => $path,
			':page_type' => $type,
			':page_seo' => $seo,
			':page_source' => $source,
			':page_use' => $use,
			':page_rank' => $rank,
			':page_view' => $view,
			':access_level' => $access_level,
			':created_by' => $created_by
		];

		$binding = binding_sql(2, $query, $param);
		$sql = egb_sql($binding);

		return !empty($sql) && isset($sql[0]) ? $sql[0] : false;
		
	} catch (Exception $e) {
		error_log($e->getMessage());
		return false;
	}
}

?>