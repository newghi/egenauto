<?php

// 로그 상수의 참 거짓 여부에 따라 페이지 로드 요청 시간 스타트
function log_start(){
	
	if (LOG_BOOL === true){define('REQUEST_TIME', microtime(true));}// 로그 상수의 참 거짓 여부에 따라 페이지 로드 요청 시간 스타트
	
}//log_start();

?>