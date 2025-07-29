<?php
//인풋값 체크
function gpos_var($inputName){
	// HTTP 요청 방법 확인 (GET 또는 POST)
	$requestMethod = $_SERVER['REQUEST_METHOD'];
	// 입력값이 GET 또는 POST 요청에 존재하는지 확인
	if ($requestMethod === 'GET' && isset($_GET[$inputName])) {
		return $_GET[$inputName]; // 입력값이 존재함
	} elseif ($requestMethod === 'POST' && isset($_POST[$inputName])) {
		return $_POST[$inputName]; // 입력값이 존재함
	} else {
		// 입력값이 존재하지 않음
		return null;
	}
}
?>