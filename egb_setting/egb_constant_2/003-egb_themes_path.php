<?php

// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo "<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='". PROTOCOL.$_SERVER['HTTP_HOST']."'; </script>";exit;}

if (!defined('THEMES_NAME')) {define('THEMES_NAME', 'eungabi');}

if (!defined('THEMES_PATH')) {define('THEMES_PATH', DS . 'egb_themes' . DS . THEMES_NAME);}

if (!defined('THEMES_PATH_INDEX')) {define('THEMES_PATH_INDEX', DS . 'egb_themes' . DS . THEMES_NAME. DS . 'index.php');}

if (!defined('THEMES_PATH_HEAD')) {define('THEMES_PATH_HEAD', DS . 'egb_themes' . DS .THEMES_NAME . DS . 'head.php');}

if (!defined('THEMES_PATH_SUB_HEAD')) {define('THEMES_PATH_SUB_HEAD', DS . 'egb_themes' . DS . THEMES_NAME . DS . 'sub_head.php');}

if (!defined('THEMES_STYLE')) {define('THEMES_STYLE', 'http://xn--9w3bp8ctg02v8nr.net' . DS . 'egb_themes' . DS . THEMES_NAME . DS . 'style.css');}

?>