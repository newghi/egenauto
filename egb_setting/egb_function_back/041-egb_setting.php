<?php

function egb_setting(){
	
$setting = $_GET['setting'] ?? null;

	if (isset($setting)){
		
		switch ($setting) {

			// 라이선스 세팅 페이지 로드
			case "license_input" : egb_load('/egb_setting/egb_input/license_input.php'); break; exit;
			
			// 데이터베이스 세팅 페이지 로드
			case "db_input" : egb_load('/egb_setting/egb_input/db_input.php'); break; exit;
			
			// head 세팅 페이지 로드
			case "head_input" : egb_load('/egb_setting/egb_input/head_input.php'); break; exit;
			
			// admin 세팅 페이지 로드
			case "admin_input" : egb_load('/egb_setting/egb_input/admin_input.php'); break; exit;
		}
		
	}else{}
}
?>