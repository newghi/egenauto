<?php
function egb_page_check(){
	$page_admin = $_GET['admin'] ?? null;
	if (isset($page_admin)){
		// 어드민 변수가 있는 경우.
		egb_admin_meta(); admin_top_box(); egb_file_load(SITE_ADMIN . DS . 'index.php' ); exit;
	}else{
		$page = $_GET['page'] ?? null;
		// $_GET 배열의 키와 값을 순회하여 배열로 저장
		$params = array_keys($_GET);
		
		// 두 번째 파라미터가 존재하는지 확인
		if (isset($params[1])) {
			$param_name1 = $params[0];
			$param_value1 = $_GET[$param_name1];
			$param_name2 = $params[1];
			$param_value2 = $_GET[$param_name2];
			
			$board_name = str_replace('_view', '', $param_value1);
			$table_board_name = 'egb_board_'.$board_name;
			
			$var_query = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
			$var_param = [':board_uniq_id' => $param_value2];
			$var_binding = binding_sql(1, $var_query, $var_param);
			$var_sql = egb_sql($var_binding);
			
		}
		
		if (isset($page)){
			$query = "SELECT * FROM " . "egb_page" . " WHERE page_name = :page_name";
			$param = [':page_name' => $page];
			$binding = binding_sql(1, $query, $param);
			$sql = egb_sql($binding);
			
			if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
			if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
			if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
			if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
			if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
			
			if (defined('PAGE_USE') and (PAGE_USE === "사용")){
				
				if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] === '사용'){
					if ($var_sql[0]){
						$query1 = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
						$param1 = [':board_uniq_id' => $var_sql[0]['board_uniq_id']];
					}else{
						$query1 = "SELECT * FROM " . "egb_seo" . " WHERE seo_uniq_id = :seo_uniq_id";
						$param1 = [':seo_uniq_id' => $sql[0]['uniq_id']];
					}
					$binding1 = binding_sql(1, $query1, $param1);
					$sql1 = egb_sql($binding1);
					
					if (isset($sql1[0]['seo_uniq_id'])){
						//메타 정보 출력
						egb_page_meta($sql[0]['page_title'], $sql[0]['page_path'], $sql1[0]['seo_title'], $sql1[0]['seo_subject'], $sql1[0]['seo_description'], $sql1[0]['seo_keywords'], $sql1[0]['seo_robots'], $sql1[0]['seo_author'], $sql1[0]['seo_og_img'], $sql1[0]['seo_publish_date'], $sql1[0]['seo_last_modified_at']);
					}
					if (isset($sql1[0]['board_uniq_id'])){
						//메타 정보 출력
						egb_page_meta($sql1[0]['board_seo_title'], $sql1[0]['board_contents'], $sql1[0]['board_seo_title'], $sql1[0]['board_seo_subject'], $sql1[0]['board_seo_description'], $sql1[0]['board_seo_keywords'], $sql1[0]['board_seo_robots'], $sql1[0]['board_seo_author'], $sql1[0]['board_seo_og_img'], $sql1[0]['board_publish_date'], $sql1[0]['board_last_modified_at']);
					}
				}else{
					//메타 정보 출력
					egb_page_meta($sql[0]['page_title'], $sql[0]['page_path'], null, null, null, null, 'index, nofollow', 'Eungabi', DS . 'egb_icon.webp', '2023-12-30', '2023-12-30');
				}
			}else{
				// 경로가 일치하지 않을 때 기본 처리
				echo '페이지를 사용 할 수 없거나, 미사용 상태 입니다.'; exit;
			}
		}else{
			//페이지 값이 없는 경우
			//메타 정보 출력
			egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
		}
		if (defined('UNIQ_ID')){
			$query2 = "SELECT * FROM " . "egb_setting" . " WHERE setting_uniq_id = :setting_uniq_id";
			$param2 = [':setting_uniq_id' => UNIQ_ID];
			$binding2 = binding_sql(1, $query2, $param2);
			$sql2 = egb_sql($binding2);
			
			if (isset($sql2[0]['setting_uniq_id'])){
				if (!defined('PAGE_HEADER_USE')) {define('PAGE_HEADER_USE', $sql2[0]['setting_header_use'] ?? '미사용');}
				if (!defined('PAGE_FOOTER_USE')) {define('PAGE_FOOTER_USE', $sql2[0]['setting_footer_use'] ?? '미사용');}
				if (!defined('PAGE_COMMENT_USE')) {define('PAGE_COMMENT_USE', $sql2[0]['setting_comment_use'] ?? '미사용');}
				if (!defined('PAGE_ACCESS_LEVEL')) {define('PAGE_ACCESS_LEVEL', $sql2[0]['setting_access_level'] ?? '0');}
				if (defined('PAGE_HEADER_USE') and PAGE_HEADER_USE === '사용'){
					$query3 = "SELECT * FROM " . "egb_page" . " WHERE page_source = :page_source";
					$param3 = [':page_source' => 'header'];
					$binding3 = binding_sql(1, $query3, $param3);
					$sql3 = egb_sql($binding3);
					if (!defined('PAGE_HEADER')) {define('PAGE_HEADER', $sql3[0]['page_path'] ?? '없음');}
					if (!defined('PAGE_HEADER_TYPE')) {define('PAGE_HEADER_TYPE', $sql3[0]['page_type'] ?? '없음');}
				}else{
					if (!defined('PAGE_HEADER')) {define('PAGE_HEADER', $sql3[0]['page_path'] ?? '없음');}
					if (!defined('PAGE_HEADER_TYPE')) {define('PAGE_HEADER_TYPE', $sql3[0]['page_type'] ?? '없음');}
				}
				if (defined('PAGE_FOOTER_USE') and PAGE_FOOTER_USE === '사용'){
					$query3 = "SELECT * FROM " . "egb_page" . " WHERE page_source = :page_source";
					$param3 = [':page_source' => 'footer'];
					$binding3 = binding_sql(1, $query3, $param3);
					$sql3 = egb_sql($binding3);
					if (!defined('PAGE_FOOTER')) {define('PAGE_FOOTER', $sql3[0]['page_path'] ?? '없음');}
					if (!defined('PAGE_FOOTER_TYPE')) {define('PAGE_FOOTER_TYPE', $sql3[0]['page_type'] ?? '없음');}
				}else{
					if (!defined('PAGE_FOOTER')) {define('PAGE_FOOTER', $sql3[0]['page_path'] ?? '없음');}
					if (!defined('PAGE_FOOTER_TYPE')) {define('PAGE_FOOTER_TYPE', $sql3[0]['page_type'] ?? '없음');}
				}
			}else{
				
			}
		}else{
			
		}
		// 어드민 변수가 없는 경우.
		admin_top_box(); egb_load(THEMES_PATH_INDEX); exit;
	}
}
?>