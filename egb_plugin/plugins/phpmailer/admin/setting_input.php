<?php
//플러그인 이름을 가져온다.
$plugin_page_name = $_POST['plugin_name'] ?? null;
$plugin_name = str_replace('plugin_', '', $plugin_page_name);

// 데이터베이스에 테이블을 등록한다.
$sql = table_phpmailer();
$binding = binding_sql(3, $sql);
$result = egb_sql($binding);

if ($result){
	// 플러그인 고유 주소 생성
	egb_db_page_insert('egb_admin_page', '이메일 관리 페이지', $plugin_page_name . '_setting', SITE_PLUGIN . DS . 'plugins' . DS . $plugin_name . DS . 'admin' . DS . 'page' . DS . 'setting_page.php', 'path', '미사용', $plugin_page_name);
	egb_db_page_insert('egb_input_page', '이메일 관리 페이지 인풋', $plugin_page_name . '_setting_input', SITE_PLUGIN . DS . 'plugins' . DS . $plugin_name . DS . 'admin' . DS . 'input' . DS . 'setting_page_input.php', 'path', '미사용', $plugin_page_name);
	egb_db_page_insert('egb_input_page', '이메일 상수 페이지 인풋', $plugin_page_name . '_constant_input', SITE_PLUGIN . DS . 'plugins' . DS . $plugin_name . DS . 'admin' . DS . 'input' . DS . 'plugin_constant_input.php', 'path', '미사용', $plugin_page_name);
	egb_db_page_insert('egb_input_page', '이메일 발송 페이지 인풋', $plugin_page_name . '_sand_input', SITE_PLUGIN . DS . 'plugins' . DS . $plugin_name . DS . 'admin' . DS . 'input' . DS . 'plugin_phpmailer_sand_input.php', 'path', '미사용', $plugin_page_name);
	// 성공인 경우
	$path = DS . SITE_PLUGIN . DS . "plugins" . DS . $plugin_name . DS;
	$name = "plugin_check.php";
	$contents = '4';
	
	egb_upload($path, $name, $contents); 
	
}else{
	// 실패인 경우
	
}
	// 새로고침
	redirect(DOMAIN.'/?admin=site_plugin_setting');
?>