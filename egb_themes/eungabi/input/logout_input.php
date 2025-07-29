<?php

// 캐시 방지 헤더 설정
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// 모든 세션 변수 해제
$_SESSION = [];

// 세션 쿠키가 있다면 삭제
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 추가 쿠키들도 삭제 (브라우저별 호환성)
setcookie('PHPSESSID', '', time() - 42000, '/');
setcookie('remember_me', '', time() - 42000, '/');

// 세션 파기
session_destroy();

// 리다이렉트 전에 캐시 방지 헤더 재설정
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

redirect(DOMAIN);

?>
