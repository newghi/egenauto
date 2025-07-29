<?php

// 현재 실행 중인 스크립트 파일의 디렉토리 경로를 가져옴
$current_folder = __DIR__;

// 폴더명만 가져옴
$plugin_name = basename($current_folder);

//폴더의 경로
$plugin_constant_path = ROOT . SITE_PLUGIN . DS . "plugins" . DS . $plugin_name . DS ."constant";

$plugin_root_path = ROOT . SITE_PLUGIN . DS . "plugins" . DS . $plugin_name . DS;

$path_text = "<?php if (!defined('PLUGIN_PHPMAILER_PATH')) {define('PLUGIN_PHPMAILER_PATH', '" . addslashes($plugin_root_path) . "');} //플러그인 경로 상수 ?>";

// 폴더가 존재하는지 확인
if (is_dir($plugin_constant_path)) {
	
	// 경로 파일이 없다면 생성
	if (file_exists($plugin_constant_path . "/001-PLUGIN_PHPMAILER_PATH.php")){}else{
		
		$path = DS . SITE_PLUGIN . DS . "plugins" . DS . $plugin_name . DS . "constant" . DS;
		$name = "001-PLUGIN_PHPMAILER_PATH.php";
		$contents = $path_text;
		
		egb_upload($path, $name, $contents); 
		
	}
	
	//폴더가 존재 하는 경우.
	$plugin_constant = glob($plugin_constant_path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기
	
	sort($plugin_constant); // 파일명을 정렬한다.
	
	foreach ($plugin_constant as $plugin_constant_file) {require_once $plugin_constant_file;} // 파일을 하나씩 require_once 시킴
	
	
}else{
	
	//폴더가 존재 하지 않는 경우. 이 주석 아래에서 처리
	
}

//폴더의 경로
$plugin_function_path = ROOT . SITE_PLUGIN . DS . "plugins" . DS . $plugin_name . DS . "function";

// 폴더가 존재하는지 확인
if (is_dir($plugin_function_path)) {
	
	//폴더가 존재 하는 경우.
	$plugin_function = glob($plugin_function_path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기
	
	sort($plugin_function); // 파일명을 정렬한다.
	
	foreach ($plugin_function as $plugin_function_file) {require_once $plugin_function_file;} // 파일을 하나씩 require_once 시킴
	
	
}else{
	
	//폴더가 존재 하지 않는 경우. 이 주석 아래에서 처리
	
}

?>