<?php
function egb_route() {
	
	// 현재 요청된 URL 경로 추출
	$request_uri = $_SERVER['REQUEST_URI'];
	$script_name = $_SERVER['SCRIPT_NAME'];
	$base_path = rtrim(dirname($script_name), '/');
	$path_info = substr($request_uri, strlen($base_path));
	
	// 경로를 /로 분리하여 배열로 저장
	$segments = explode('/', trim($path_info, '/'));
	
	if (strpos($segments[0], '?') === 0 && strpos($segments[0], '?') !== false) {egb_img(); egb_video(); egb_plugin_file_load(); egb_post(); egb_page_check(); exit;}
	if ($segments[0] === '') {egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30'); 	admin_top_box(); egb_load(THEMES_PATH_INDEX); exit;}
	if ($segments[0] === 'admin') {
		if (isset($segments[1])){
			$_GET['admin'] = $segments[1];
		}else{
			$_GET['admin'] = 'page';
		}
		egb_admin_meta(); admin_top_box(); egb_file_load(SITE_ADMIN . DS . 'index.php' );
		exit;
	}
	if ($segments[0] === 'post') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
			if (egb_csrf_check()){
			//post 파라미터에 대한 페이지 출력 form에서 전달되는 경우에만 반응 하도록 한다.
				if (isset($segments[1])){
					$post = $segments[1];
					$query = "SELECT * FROM egb_input_page WHERE page_name = :page_name";
					$param = [':page_name' => $post];
					$binding = binding_sql(1, $query, $param);
					
					$sql = egb_sql($binding);
					
					if (isset($sql[0]['page_path'])){egb_file_load($sql[0]['page_path']); exit;}else{echo "올바른 경로가 아닙니다."; exit;}
				}
			}else{
				echo json_encode(['success' => false, 'failureCode' => 0]);
				exit;
			}
		}
	}
	if ($segments[0] === 'img') {
		if (isset($segments[1])) {
			// 이미지에 대한 처리
			$img = $segments[1];
			$query = "SELECT * FROM egb_img WHERE page_name = :page_name";
			$param = [':page_name' => $img];
			$binding = binding_sql(1, $query, $param);
			$sql = egb_sql($binding);
			if (isset($sql[0])) {
				// 같은 이름이 여러개인 경우 일 수도.
				if (isset($sql[0]['page_use']) and $sql[0]['page_use'] === "사용") {
					if (isset($sql[0]['page_type']) and $sql[0]['page_type'] === "html") {
						echo $sql[0]['page_path'];
					}
					if (isset($sql[0]['page_type']) and $sql[0]['page_type'] === "php") {
						eval($sql[0]['page_path']);
					}
					if (isset($sql[0]['page_type']) and $sql[0]['page_type'] === "path") {
						$img_path = ROOT . $sql[0]['page_path'];
						// 파일이 존재하는지 확인
						if (!file_exists($img_path)) {
							echo "파일을 찾을 수 없습니다.";
							exit;
						}
						// 파일이 이미지인지 확인
						$info = getimagesize($img_path);
						if (!$info) {
							if (pathinfo($img_path, PATHINFO_EXTENSION) === "svg") {
								// SVG 파일의 경우
								header('Content-Type: image/svg+xml');
							} else {
								echo "유효한 이미지 파일이 아닙니다.";
								exit;
							}
						} else {
							// 다른 이미지 파일의 경우
							header('Content-Type: ' . $info['mime']);
						}
						
						// 캐싱 처리
						$lastModifiedTime = filemtime($img_path);
						$etag = md5_file($img_path);

						if (
							isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) &&
							strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) === $lastModifiedTime
						) {
							header("HTTP/1.1 304 Not Modified");
							exit;
						}

						if (
							isset($_SERVER['HTTP_IF_NONE_MATCH']) &&
							trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag
						) {
							header("HTTP/1.1 304 Not Modified");
							exit;
						}

						header("Last-Modified: " . gmdate("D, d M Y H:i:s", $lastModifiedTime) . " GMT");
						header("ETag: $etag");
						header("Cache-Control: public, max-age=31536000");
							
						// 이미지 파일의 내용을 읽어서 출력
						ob_clean();  // 출력 버퍼를 비웁니다.
						flush();     // 출력 버퍼를 비웁니다.
	
						readfile($img_path);
						exit;
					}
				} else {
					echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
					exit;
				}
			} else {
				echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 올바른 경로가 아니거나, 없는 페이지 입니다.</div>';
				exit;
			}
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] === 'download') {
		if (isset($segments[1])) {
			$download = $segments[1];
			// 유니크 아이디로 파일 정보 조회
			$query = "SELECT * FROM egb_download WHERE download_board_id = :download_board_id";
			$params = [':download_board_id' => $download];
			$binding = binding_sql(1, $query, $params);
			$result = egb_sql($binding);
			if ($result) {
				$fileInfo = $result[0];
				if ($fileInfo) {
					$filePath = ROOT . $fileInfo['download_data_path'];
					$originalFileName = $fileInfo['download_data_name'];
					$downloadCount = intval($fileInfo['download_count']);
					$storedHash = $fileInfo['download_hash'];
					if (file_exists($filePath)) {
						// 파일 해시 확인
						$currentHash = hash_file('sha256', $filePath);
						if ($currentHash !== $storedHash) {
							echo json_encode(['success' => false, 'errorCode' => 10, 'message' => 'File hash mismatch']); // 파일 해시 불일치
							exit;
						}
						// 다운로드 횟수 증가
						$downloadCount++;
						$updateQuery = "UPDATE egb_download SET download_count = :download_count WHERE download_board_id = :download_board_id";
						$updateParams = [
							':download_count' => $downloadCount,
							':download_board_id' => $download
						];
						$updateBinding = binding_sql(2, $updateQuery, $updateParams);
						egb_sql($updateBinding);
						// 파일 다운로드 처리
						$encodedFileName = rawurlencode($originalFileName);
						$encodedFileName = str_replace("%20", " ", $encodedFileName);
						// Clean the output buffer to avoid any other output
						if (ob_get_level()) {
							ob_end_clean();
						}
						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename="' . basename($originalFileName) . '"; filename*=UTF-8\'\'' . $encodedFileName);
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize($filePath));
						// Clear output buffer before sending the file
						if (ob_get_level()) {
							ob_end_clean();
						}
						// Read and output the file
						readfile($filePath);
						exit;
					} else {
						echo json_encode(['success' => false, 'errorCode' => 7, 'message' => 'File does not exist']); // 파일이 존재하지 않음
						exit;
					}
				} else {
					echo json_encode(['success' => false, 'errorCode' => 8, 'message' => 'No file info for unique ID']); // 유니크 아이디에 해당하는 파일 정보 없음
					exit;
				}
			} else {
				echo json_encode(['success' => false, 'errorCode' => 1, 'message' => 'Query failed']); // 쿼리 실패
				exit;
			}
		} else {
			echo json_encode(['success' => false, 'errorCode' => 9, 'message' => 'Unique ID not provided']); // 유니크 아이디가 없음
			exit;
		}
	}
	if ($segments[0] === 'font') {
		if (isset($segments[1])) {
			// 폰트 파일 이름 가져오기
			$fontFile = $segments[1];
			
			// 실제 폰트 파일의 경로 설정
			$fontPath = ROOT . THEMES_PATH . '/font/' . $fontFile;
			
			if (file_exists($fontPath)) {
				// 폰트 파일의 MIME 타입을 결정합니다.
				$mimeType = mime_content_type($fontPath);
				
				// 헤더 설정
				header("Content-Type: $mimeType");
				header("Content-Disposition: inline"); // 'inline'으로 설정하여 다운로드 방지
				header("Expires: " . gmdate("D, d M Y H:i:s", time() + 31536000) . " GMT");
				header("Cache-Control: public, max-age=31536000, immutable");
				
				// 폰트 파일을 읽어들여서 반환합니다.
				readfile($fontPath);
				exit;
			} else {
				// 폰트 파일이 존재하지 않는 경우
				header("HTTP/1.0 404 Not Found");
				echo '<div class="g_c_c p_h_20 f_s_20">해당 폰트 파일이 존재하지 않습니다.</div>';
				exit;
			}
		} else {
			// 폰트 세그먼트는 있지만 폰트 파일이 제공되지 않은 경우
			header("HTTP/1.0 400 Bad Request");
			echo '<div class="g_c_c p_h_20 f_s_20">폰트 파일이 제공되지 않았습니다.</div>';
			exit;
		}
	}
	if ($segments[0] === 'template') {
		if (isset($segments[0])){
			require_once ROOT.SITE_ADMIN.'/template/index.php'; exit;
		}
	}
	if ($segments[0] === 'egb') {
		if (isset($segments[1])){
			require_once ROOT.THEMES_PATH.'/'.$segments[0].'/'.$segments[1].'/'.$segments[2].'.php'; exit;
		}
	}
	if ($segments[0] === 'page') {
		if (isset($segments[1])){
			$page = $segments[1];
			$query = "SELECT * FROM " . "egb_page" . " WHERE page_name = :page_name";
			$param = [':page_name' => $page];
			$binding = binding_sql(1, $query, $param);
			$sql = egb_sql($binding);
			
			$board_view = $_GET['view'] ?? null;
			
			$board_name = str_replace('_view', '', $page);
			$table_board_name = 'egb_board_'.$board_name;
			
			$var_query = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
			$var_param = [':board_uniq_id' => $board_view];
			$var_binding = binding_sql(1, $var_query, $var_param);
			$var_sql = egb_sql($var_binding);
			
			if (isset($var_sql[0]['board_uniq_id'])){$var_sql_check = true;}else{$var_sql_check = false;}
		
			if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
			if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
			if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
			if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
			if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
			
			if (defined('PAGE_USE') and (PAGE_USE === "사용")){
				
				if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] === '사용'){
					if ($var_sql_check){
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
				echo '페이지를 사용 할 수 없거나, 미사용 상태 입니다.';
				exit;
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
		}else{
			// 경로가 일치하지 않을 때 기본 처리
			egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
		}
	}
	if (BOARD_PERMA_LINK === 'short_url_long_url'){egb_img(); egb_video(); egb_plugin_file_load(); egb_post(); egb_page_check(); exit;}
	if (BOARD_PERMA_LINK === 'short_url_short_url'){
		$shortlink = $segments[0];
		$query = "SELECT * FROM egb_short_url WHERE short_url_short_url = :short_url_short_url";
		$param = [':short_url_short_url' => $shortlink];
		$binding = binding_sql(1, $query, $param);
		
		$sql = egb_sql($binding);
		if (isset($sql[0]['short_url_long_url'])){
			$short_script_name = $_SERVER['SCRIPT_NAME'];
			$short_base_path = rtrim(dirname($short_script_name), '/');
			$short_path_info = substr(str_replace(DOMAIN, '', $sql[0]['short_url_long_url']), strlen($short_base_path));
			$short_query_str = parse_url($sql[0]['short_url_long_url'], PHP_URL_QUERY);
			$params = [];
			parse_str($short_query_str, $params);
			// 파라미터 설정
			$_GET = array_merge($_GET, $params);
			
			// 경로를 /로 분리하여 배열로 저장
			$short_segments = explode('/', trim($short_path_info, '/'));
			if ($short_segments[0] === 'page') {
				if (isset($short_segments[1])){
					$page = $short_segments[1];
					$query = "SELECT * FROM " . "egb_page" . " WHERE page_name = :page_name";
					$param = [':page_name' => $page];
					$binding = binding_sql(1, $query, $param);
					$sql = egb_sql($binding);
					
					$board_view = $_GET['view'] ?? null;
					
					$board_name = str_replace('_view', '', $page);
					$table_board_name = 'egb_board_'.$board_name;
					
					$var_query = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
					$var_param = [':board_uniq_id' => $board_view];
					$var_binding = binding_sql(1, $var_query, $var_param);
					$var_sql = egb_sql($var_binding);
					
					if (isset($var_sql[0]['board_uniq_id'])){$var_sql_check = true;}else{$var_sql_check = false;}
			
					if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
					if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
					if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
					if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
					if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
					
					if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] === '사용'){
						if ($var_sql_check){
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
				}else{
					// 경로가 일치하지 않을 때 기본 처리
					egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
				}
			}
		}
	}
	if (BOARD_PERMA_LINK === 'short_url_route_short_url'){
		$route_name = $segments[0] ?? null;
		$short_url = $segments[1] ?? null;
		$query = "SELECT * FROM egb_board_mangement WHERE board_mangement_route_board_name = :board_mangement_route_board_name";
		$param = [':board_mangement_route_board_name' => $route_name];
		$binding = binding_sql(1, $query, $param);
		$sql = egb_sql($binding);
		
		if (isset($sql[0]['board_mangement_route_board_name'])){
			$query = "SELECT * FROM ".$sql[0]['board_mangement_table_board_name']." WHERE board_short_url = :board_short_url";
			$param = [':board_short_url' => $short_url];
			$binding = binding_sql(1, $query, $param);
			$sql = egb_sql($binding);
			
			$short_script_name = $_SERVER['SCRIPT_NAME'];
			$short_base_path = rtrim(dirname($short_script_name), '/');
			$short_path_info = substr(str_replace(DOMAIN, '', $sql[0]['board_url']), strlen($short_base_path));
			$short_query_str = parse_url($sql[0]['board_url'], PHP_URL_QUERY);
			$params = [];
			parse_str($short_query_str, $params);
			// 파라미터 설정
			$_GET = array_merge($_GET, $params);
			
			// 경로를 /로 분리하여 배열로 저장
			$short_segments = explode('/', trim($short_path_info, '/'));
			if ($short_segments[0] === 'page') {
				if (isset($short_segments[1])){
					$page = $short_segments[1];
					$query = "SELECT * FROM " . "egb_page" . " WHERE page_name = :page_name";
					$param = [':page_name' => $page];
					$binding = binding_sql(1, $query, $param);
					$sql = egb_sql($binding);
					
					$board_view = $_GET['view'] ?? null;
					
					$board_name = str_replace('_view', '', $page);
					$table_board_name = 'egb_board_'.$board_name;
					
					$var_query = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
					$var_param = [':board_uniq_id' => $board_view];
					$var_binding = binding_sql(1, $var_query, $var_param);
					$var_sql = egb_sql($var_binding);
					
					if (isset($var_sql[0]['board_uniq_id'])){$var_sql_check = true;}else{$var_sql_check = false;}
					
					if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
					if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
					if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
					if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
					if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
					
					if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] === '사용'){
						if ($var_sql_check){
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
				}else{
					// 경로가 일치하지 않을 때 기본 처리
					egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
				}
			}
		}else{
			// 경로가 일치하지 않을 때 기본 처리
			egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
		}
	}
	if (BOARD_PERMA_LINK === 'short_url_number_url'){
		$numberlink = $segments[0];
		$query = "SELECT * FROM egb_short_url WHERE short_url_number_url = :short_url_number_url";
		$param = [':short_url_number_url' => $numberlink];
		$binding = binding_sql(1, $query, $param);
		
		$sql = egb_sql($binding);
		if (isset($sql[0]['short_url_long_url'])){
			$short_script_name = $_SERVER['SCRIPT_NAME'];
			$short_base_path = rtrim(dirname($short_script_name), '/');
			$short_path_info = substr(str_replace(DOMAIN, '', $sql[0]['short_url_long_url']), strlen($short_base_path));
			$short_query_str = parse_url($sql[0]['short_url_long_url'], PHP_URL_QUERY);
			$params = [];
			parse_str($short_query_str, $params);
			// 파라미터 설정
			$_GET = array_merge($_GET, $params);
			
			// 경로를 /로 분리하여 배열로 저장
			$short_segments = explode('/', trim($short_path_info, '/'));
			if ($short_segments[0] === 'page') {
				if (isset($short_segments[1])){
					$page = $short_segments[1];
					$query = "SELECT * FROM " . "egb_page" . " WHERE page_name = :page_name";
					$param = [':page_name' => $page];
					$binding = binding_sql(1, $query, $param);
					$sql = egb_sql($binding);
					
					$board_view = $_GET['view'] ?? null;
					
					$board_name = str_replace('_view', '', $page);
					$table_board_name = 'egb_board_'.$board_name;
					
					$var_query = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
					$var_param = [':board_uniq_id' => $board_view];
					$var_binding = binding_sql(1, $var_query, $var_param);
					$var_sql = egb_sql($var_binding);
					
					if (isset($var_sql[0]['board_uniq_id'])){$var_sql_check = true;}else{$var_sql_check = false;}
					
					if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
					if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
					if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
					if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
					if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
					
					if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] === '사용'){
						if ($var_sql_check){
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
				}else{
					// 경로가 일치하지 않을 때 기본 처리
					egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
				}
			}
		}
	}
	if (BOARD_PERMA_LINK === 'short_url_route_number_url'){
		$route_name = $segments[0];
		$route_number_url = $segments[1] ?? null;
		$query = "SELECT * FROM egb_board_mangement WHERE board_mangement_route_board_name = :board_mangement_route_board_name";
		$param = [':board_mangement_route_board_name' => $route_name];
		$binding = binding_sql(1, $query, $param);
		$sql = egb_sql($binding);
		
		if (isset($sql[0]['board_mangement_route_board_name'])){
			$query = "SELECT * FROM ".$sql[0]['board_mangement_table_board_name']." WHERE board_route_number_url = :board_route_number_url";
			$param = [':board_route_number_url' => $route_number_url];
			$binding = binding_sql(1, $query, $param);
			$sql = egb_sql($binding);
			
			$short_script_name = $_SERVER['SCRIPT_NAME'];
			$short_base_path = rtrim(dirname($short_script_name), '/');
			$short_path_info = substr(str_replace(DOMAIN, '', $sql[0]['board_url']), strlen($short_base_path));
			$short_query_str = parse_url($sql[0]['board_url'], PHP_URL_QUERY);
			$params = [];
			parse_str($short_query_str, $params);
			// 파라미터 설정
			$_GET = array_merge($_GET, $params);
			
			// 경로를 /로 분리하여 배열로 저장
			$short_segments = explode('/', trim($short_path_info, '/'));
			if ($short_segments[0] === 'page') {
				if (isset($short_segments[1])){
					$page = $short_segments[1] ?? null;
					$query = "SELECT * FROM " . "egb_page" . " WHERE page_name = :page_name";
					$param = [':page_name' => $page];
					$binding = binding_sql(1, $query, $param);
					$sql = egb_sql($binding);
					
					$board_view = $_GET['view'] ?? null;
					
					$board_name = str_replace('_view', '', $page);
					$table_board_name = 'egb_board_'.$board_name;
					
					$var_query = "SELECT * FROM " . $table_board_name . " WHERE board_uniq_id = :board_uniq_id";
					$var_param = [':board_uniq_id' => $board_view];
					$var_binding = binding_sql(1, $var_query, $var_param);
					$var_sql = egb_sql($var_binding);
					
					if (isset($var_sql[0]['board_uniq_id'])){$var_sql_check = true;}else{$var_sql_check = false;}
					
					if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
					if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
					if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
					if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
					if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
					
					if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] === '사용'){
						if ($var_sql_check){
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
				}else{
					// 경로가 일치하지 않을 때 기본 처리
					egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
				}
			}
		}else{
			// 경로가 일치하지 않을 때 기본 처리
			egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
		}
	}
	if (BOARD_PERMA_LINK === 'short_url_slug_url'){}
	if (BOARD_PERMA_LINK === 'short_url_route_slug_url'){}

	// 이 부분에서 admin_top_box()와 egb_load() 함수 호출을 하도록 처리
	admin_top_box();
	egb_load(THEMES_PATH_INDEX);
	
	//태그 닫기
	echo '</body>';
	echo '</html>';
	
	exit;
}
?>