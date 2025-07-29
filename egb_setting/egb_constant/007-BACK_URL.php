<?php
if (!defined('BACK_URL')){
	if (isset($_SERVER['HTTP_REFERER'])) {
		define('BACK_URL', $_SERVER['HTTP_REFERER']);
	}else{
		define('BACK_URL', 'javascript:history.back()');
	}
} // 이전 url 설정

?>