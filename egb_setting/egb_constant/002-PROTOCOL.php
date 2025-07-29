<?php
if (!defined('PROTOCOL')) {
	if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {
		define('PROTOCOL', 'https://');
	}else{
		define('PROTOCOL', 'http://');
	}
} // 프로토콜 상수 설정
?>