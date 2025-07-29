<?php

function egb_theme_db_updatae($theme_name) {
	
	//파일 생성이 완료되면 쿼리를 업데이트 한다.
	$name = "site_main_page_setting";
	
	$query = "SELECT * FROM egb_admin_page WHERE page_name = :page_name";
	$param = [':page_name' => $name];
	$binding = binding_sql(1, $query, $param);
	$page = egb_sql($binding);
	
	if ($page[0]){
		
	$query = "UPDATE egb_admin_page SET page_path = '/egb_themes/" . $theme_name . "/admin/page/admin_main_page.php' WHERE page_name = :page_name";
	$param = [':page_name' => $name];
	$binding = binding_sql(1, $query, $param);
	$page = egb_sql($binding);
	
	}else{}
	
	//파일 생성이 완료되면 쿼리를 업데이트 한다.
	$name = "site_main_page_input";
	
	$query = "SELECT * FROM egb_input_page WHERE page_name = :page_name";
	$param = [':page_name' => $name];
	$binding = binding_sql(1, $query, $param);
	$page = egb_sql($binding);
	
	if ($page[0]){
		
	$query = "UPDATE egb_input_page SET page_path = '/egb_themes/" . $theme_name . "/admin/input/admin_main_page_input.php' WHERE page_name = :page_name";
	$param = [':page_name' => $name];
	$binding = binding_sql(1, $query, $param);
	$page = egb_sql($binding);
	
	}else{}
	
	//파일 생성이 완료되면 쿼리를 업데이트 한다.
	$name = "theme_logo";
	
	$query = "SELECT * FROM egb_img WHERE page_name = :page_name";
	$param = [':page_name' => $name];
	$binding = binding_sql(1, $query, $param);
	$page = egb_sql($binding);
	
	if ($page[0]){
		
	$query = "UPDATE egb_img SET page_path = '/egb_themes/" . $theme_name . "/img/theme_logo/theme_logo.svg' WHERE page_name = :page_name";
	$param = [':page_name' => $name];
	$binding = binding_sql(1, $query, $param);
	$page = egb_sql($binding);
	
	}else{}
	
}
?>
