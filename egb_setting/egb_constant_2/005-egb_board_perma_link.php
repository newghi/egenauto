<?php

// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo "<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='". PROTOCOL.$_SERVER['HTTP_HOST']."'; </script>";exit;}

//head의 기본 mata 데이터 상수 선언
if (!defined('MATA_TITLE')) {define('MATA_TITLE', '');}
if (!defined('MATA_SUBJECT')) {define('MATA_SUBJECT', '');}
if (!defined('MATA_DESCRIPTION')) {define('MATA_DESCRIPTION', '');}
if (!defined('MATA_KEYWORD')) {define('MATA_KEYWORD', '');}
if (!defined('MATA_ROBOTS')) {define('MATA_ROBOTS', '');}
if (!defined('MATA_AUTHOR')) {define('MATA_AUTHOR', '');}
if (!defined('SITE_TITLE')) {define('SITE_TITLE', '');}

if (!defined('BOARD_PERMA_LINK')) {define('BOARD_PERMA_LINK', 'short_url_route_short_url');}

?>
