<?php
//폴더의 경로 사이트가 최초 시작시 필요한 상수 로드
$constant_path = ROOT . DS . 'egb_setting' . DS . 'egb_constant';

// 폴더가 존재하는지 확인
if (is_dir($constant_path)) {
	
	//폴더가 존재 하는 경우.
	$constant = glob($constant_path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기
	
	sort($constant); // 파일명을 정렬
	
	foreach ($constant as $constant_file) {require_once $constant_file;} // 파일을 하나씩 require_once 시킴
	
	
}else{
	
	//폴더가 존재 하지 않는 경우. 이 주석 아래에서 처리
	echo "상수 폴더가 존재하지 않습니다.";
	exit;
}

// 함수 정의
function egb_site_start($directory) {
	$path = ROOT . $directory;
	if (is_dir($path)) {
		$files = glob($path . DS . '*.php');
		sort($files);
		foreach ($files as $file) {
			require_once $file;
		}
	} else {
		// 폴더가 존재하지 않을 때 처리
		echo "'{$directory}' 폴더가 존재하지 않습니다.";
		exit;
	}
}

egb_site_start(DS . 'egb_setting' . DS . 'egb_constant_2');
egb_site_start(DS . 'egb_setting' . DS . 'egb_config');
egb_site_start(DS . 'egb_setting' . DS . 'egb_function');
egb_site_start(DS . 'egb_setting' . DS . 'egb_js');

//사이트 체크가 1인 경우에만 인클루드
if (file_exists(ROOT . DS ."egb_site-check.php" )){
	
	require_once ROOT . DS . "egb_site-check.php";
	
	if (SITE_CHECK == '4'){
		

//테마 폴더 로드
$constant_path = ROOT . THEMES_PATH . DS . 'constant';
if (is_dir($constant_path)) {
	$constant = glob($constant_path . DS . '*.php');
	sort($constant);
	foreach ($constant as $constant_file) { require_once $constant_file;}
}

$config_path = ROOT . THEMES_PATH . DS . 'config';
if (is_dir($config_path)) {
	$config = glob($config_path . DS . '*.php');
	sort($config);
	foreach ($config as $config_file) { require_once $config_file;}
}

$function_path = ROOT . THEMES_PATH . DS . 'function';
if (is_dir($function_path)) {
	$function = glob($function_path . DS . '*.php');
	sort($function);
	foreach ($function as $function_file) { require_once $function_file;}
}

$js_path = ROOT . THEMES_PATH . DS . 'js';
if (is_dir($js_path)) {
	$js = glob($js_path . DS . '*.php');
	sort($js);
	foreach ($js as $js_file) { require_once $js_file;}
}

$db_path = ROOT . THEMES_PATH . DS . 'db';
if (is_dir($db_path)) {
	$db = glob($db_path . DS . '*.php');
	sort($db);
	foreach ($db as $db_file) { require_once $db_file;}
}

	}else{
		// 상수값이 1이 아닌 경우
	}
	
}else{
	// 상수값이 없는 경우
}


// 기본 시간 설정 한국
date_default_timezone_set(TIMEZONE);

// 기본 문자셋 설정
// 기본 문자 인코딩을 UTF-8로 설정
ini_set('default_charset', DEFAULT_CHARSET);
// PHP 내부 문자 인코딩을 UTF-8로 설정
mb_internal_encoding(INTERNAL_ENCODING);
// HTTP 출력 문자 인코딩을 UTF-8로 설정 
mb_http_output(HTTP_OUTPUT_ENCODING);


egb_get_device();

// 세션 함수 실행
if (function_exists('session_go')) {
    session_go();
} else {
    echo "session_go 함수가 정의되어 있지 않습니다.";
    exit;
}


//사이트 체크가 1인 경우에만 인클루드
if (file_exists(ROOT . DS ."egb_site-check.php" )){
	
	require_once ROOT . DS . "egb_site-check.php";
	
	if (SITE_CHECK == '1'){
		
		egb_site_start(DS . 'egb_setting'  . DS . 'egb_db');

	}else{
		// 상수값이 1이 아닌 경우
	}
	
}else{
	// 상수값이 없는 경우
}

?>
