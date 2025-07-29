<?php
			
// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo "<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='". PROTOCOL.$_SERVER['HTTP_HOST']."'; </script>";exit;}

if (!defined('EGB_MENU_GROUP_UNIQ_ID')) {define('EGB_MENU_GROUP_UNIQ_ID', '6844ca4fb8685');}

?>