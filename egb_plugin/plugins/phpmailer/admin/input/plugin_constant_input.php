<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//플러그인 이름을 가져온다.
	$plugin_page_name = $_POST['plugin_name'] ?? null;
	$plugin_name = str_replace('plugin_', '', $plugin_page_name);

	echo $email = $_POST['PLUGIN_PHPMAILER_EMAIL'];
	echo $password = $_POST['PLUGIN_PHPMAILER_EMAIL_PASSWORD'];
	echo $host = $_POST['PLUGIN_PHPMAILER_HOST'];
	echo $smtp_secure = $_POST['PLUGIN_PHPMAILER_SMTP_SECURE'];
	echo $port = $_POST['PLUGIN_PHPMAILER_PORT'];
	
	//상수 생성
	$db_constant_file_path = SITE_PLUGIN . DS . 'plugins' . DS . $plugin_name . DS . 'constant' . DS;
	
	$db_constant_file_name = "002-PLUGIN_PHPMAILER_CONSTANT.php";
	
	$db_constant_file_contents = "<?php

// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset(\$_SERVER['HTTPS']) and \$_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo \"<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='\". PROTOCOL.\$_SERVER['HTTP_HOST'].\"'; </script>\";exit;}

//이메일 주소
if (!defined('PLUGIN_PHPMAILER_EMAIL')) {define('PLUGIN_PHPMAILER_EMAIL', '$email');}

//이메일 비밀번호 또는 앱번호
if (!defined('PLUGIN_PHPMAILER_EMAIL_PASSWORD')) {define('PLUGIN_PHPMAILER_EMAIL_PASSWORD', '$password');}

//이메일 SMTP HOST
if (!defined('PLUGIN_PHPMAILER_HOST')) {define('PLUGIN_PHPMAILER_HOST', '$host');}

//이메일 SMTP HOST SECURE
if (!defined('PLUGIN_PHPMAILER_SMTP_SECURE')) {define('PLUGIN_PHPMAILER_SMTP_SECURE', '$smtp_secure');}

//이메일 접속 PORT
if (!defined('PLUGIN_PHPMAILER_PORT')) {define('PLUGIN_PHPMAILER_PORT', '$port');}

//이메일 접속 CHARSET
if (!defined('PLUGIN_PHPMAILER_CHARSET')) {define('PLUGIN_PHPMAILER_CHARSET', 'UTF-8');}

//이메일 접속 ENCODING
if (!defined('PLUGIN_PHPMAILER_ENCODING')) {define('PLUGIN_PHPMAILER_ENCODING', 'base64');}

?>";

	// db-constant.php 파일 생성
	egb_upload($db_constant_file_path, $db_constant_file_name, $db_constant_file_contents);
	
	redirect(DOMAIN.'/?admin='.$plugin_page_name);
}
?>