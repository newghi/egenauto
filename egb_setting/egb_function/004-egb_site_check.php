<?php
// 사이트 체크
function egb_site_check(){
	
	if (file_exists( ROOT . DS . "egb_site-check.php" )){
		require_once ROOT . DS ."egb_site-check.php";
		// 웹 서버 정보 확인
		$serverSoftware = $_SERVER['SERVER_SOFTWARE'];
		// 서버 소프트웨어 식별
		if (strpos($serverSoftware, 'Apache') !== false) {
			$serverType = 'Apache';
		} elseif (strpos($serverSoftware, 'Nginx') !== false) {
			$serverType = 'Nginx';
		} else {
			$serverType = '알 수 없음';
		}
		switch (SITE_CHECK){// 상수 값에 따라 아래의 케이스를 실행 한다.
	
		case '0' : egb_constant_2_delete(); egb_load(DS . 'egb_setting' . DS . 'egb_setting_page' . DS . 'license_setting.php'); exit; // 라이선스 인증
		case '1' : egb_constant_2_delete(); egb_load(DS . 'egb_setting' . DS . 'egb_setting_page' . DS . 'db_setting.php'); exit; // DB 생성
		case '2' : egb_load(DS . 'egb_setting' . DS . 'egb_setting_page' . DS . 'head_setting.php'); exit; // head 생성
		case '3' : egb_load(DS . 'egb_setting' . DS . 'egb_setting_page' . DS . 'admin_setting.php'); exit; // admin 생성
		case '4' :
			//서버 정보 확인
			if ($serverType == 'Apache'){
				// .htaccess 가 있는 경우 라우트 사용 없는 경우 파라미터 사용
				if (file_exists( ROOT . DS . ".htaccess" )){
					egb_plugin_file_load(); egb_route(); exit; 
				}else{
					egb_img(); egb_video(); egb_plugin_file_load(); egb_post(); egb_page_check(); exit; // 사이트 실행
				}
			}else{
				//Nginx
				egb_plugin_file_load(); egb_route(); exit;  // 사이트 실행
			}
		default  : egb_load( '/변수값이 없거나 케이스에 없는 경우 변수값을 0으로 초기화 하고 재시작 한다.php'); exit; //초기화
		}
	}else{
	
	$path = DS;
	$name = "egb_site-check.php";
	$contents = '<?php define(\'SITE_CHECK\', \'0\'); ?>';

	egb_upload($path, $name, $contents); 
	
	redirect(DOMAIN);
	
	}

}//function egb_site_check();

?>