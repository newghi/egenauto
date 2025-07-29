<?php
function egb_img() {
	// post 파라미터에 대한 페이지 출력 form에서 전달되는 경우에만 반응 하도록 한다.
	$img = gpos_var('img');
	if (isset($img)) {
		$query = "SELECT * FROM egb_img WHERE page_name = :page_name";
		$param = [':page_name' => $img];
		$binding = binding_sql(0, $query, $param);

		$sql = egb_sql($binding);

		if (isset($sql[0])) {

			// 같은 이름이 여러개인 경우 일 수도.
			foreach ($sql[0] as $row) {

				// 테마에 따라 적용되는 이미지
				if ($row['page_source'] === 'theme_' . THEMES_NAME) {

					if (isset($row['page_use']) and $row['page_use'] === "사용") {

						if (isset($row['page_type']) and $row['page_type'] === "html") {
							echo $row['page_path'];
						}
						if (isset($row['page_type']) and $row['page_type'] === "php") {
							eval($row['page_path']);
						}
						if (isset($row['page_type']) and $row['page_type'] === "path") {

							$img_path = ROOT . $row['page_path'];

							// 파일이 존재하는지 확인
							if (!file_exists($img_path)) {

								echo "파일을 찾을 수 없습니다: ";
								exit;

							}

							// 파일이 이미지인지 확인
							$info = getimagesize($img_path);

							if (!$info) {

								if (pathinfo($img_path, PATHINFO_EXTENSION) === "svg") {

									// Content-Type 헤더 설정
									header('Content-Type: image/svg+xml');

								} else {
									echo "유효한 이미지 파일이 아닙니다: ";
									exit;
								}

							} else {

								// Content-Type 헤더 설정
								header('Content-Type: ' . $info['mime']);
							}

							// 출력 버퍼를 비우고 이미지 데이터 출력
							ob_clean();
							flush();
							readfile($img_path);
							exit;

						}
					} else {
						echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
						exit;
					}

				} else {

					if (isset($row['page_use']) and $row['page_use'] === "사용") {

						if (isset($row['page_type']) and $row['page_type'] === "html") {
							echo $row['page_path'];
						}
						if (isset($row['page_type']) and $row['page_type'] === "php") {
							eval($row['page_path']);
						}
						if (isset($row['page_type']) and $row['page_type'] === "path") {

							$img_path = ROOT . $row['page_path'];

							// 파일이 존재하는지 확인
							if (!file_exists($img_path)) {

								echo "파일을 찾을 수 없습니다: ";
								exit;

							}

							// 파일이 이미지인지 확인
							$info = getimagesize($img_path);

							if (!$info) {

								if (pathinfo($img_path, PATHINFO_EXTENSION) === "svg") {

									// Content-Type 헤더 설정
									header('Content-Type: image/svg+xml');

								} else {
									echo "유효한 이미지 파일이 아닙니다: ";
									exit;
								}

							} else {

								// Content-Type 헤더 설정
								header('Content-Type: ' . $info['mime']);
							}

							// 출력 버퍼를 비우고 이미지 데이터 출력
							ob_clean();
							flush();
							readfile($img_path);
							exit;

						}
					} else {
						echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
						exit;
					}
				}

			}

		} else {
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 올바른 경로가 아니거나, 없는 페이지 입니다.</div>';
			exit;
		}
	}

}

?>