<?php
			
// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo "<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='". PROTOCOL.$_SERVER['HTTP_HOST']."'; </script>";exit;}

//db_connect 상수 선언
//db host 를 입력 보통 localhost 또는 ip주소
if (!defined('DB_HOST')) {define('DB_HOST', '182.227.119.34');}

//db user id 를 입력
if (!defined('DB_USER')) {define('DB_USER', 'egenauto');}

//db 접속 비밀번호를 입력
if (!defined('DB_PASSWORD')) {define('DB_PASSWORD', 'Ea@!46941808');}

//접속할 db의 이름
if (!defined('DB_NAME')) {define('DB_NAME', 'dbegenauto');}

?>