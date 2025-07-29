<?php
function egb_post(){
//post 파라미터에 대한 페이지 출력 form에서 전달되는 경우에만 반응 하도록 한다.
$post = $_GET['post'] ?? null;
	if (isset($post)){
		
		$query = "SELECT * FROM egb_input_page WHERE page_name = :page_name";
		$param = [':page_name' => $post];
		$binding = binding_sql(1, $query, $param);
		
		$sql = egb_sql($binding);
		
		if (isset($sql[0]['page_path'])){egb_file_load($sql[0]['page_path']); exit;}else{echo "올바른 경로가 아닙니다."; exit;}
		
	}else{}
}
?>