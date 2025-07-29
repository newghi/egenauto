<?php
function egb_get_admin_page(){
	if (egb('admin')){
		$admin = egb('admin');
		
		$query = "SELECT * FROM egb_admin_page WHERE page_name = :page_name";
		$param = [':page_name' => $admin];
		$binding = binding_sql(1, $query, $param);
		
		$sql = egb_sql($binding);
		
		if (isset($sql[0]['page_path'])){egb_load($sql[0]['page_path']);}else{echo "올바른 경로가 아닙니다."; exit;}
		
	}else{}
}
?>