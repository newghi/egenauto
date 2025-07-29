<?php
function egb_csrf_check() {
    // 요청 헤더에서 CSRF 토큰을 가져옴
    $request_headers = getallheaders();
    echo $received_csrf_token = $request_headers['X-CSRF-Token'] ?? 'received';

    // 세션에 저장된 CSRF 토큰을 가져옴
    echo $csrf_token = $_SESSION['csrf_token'] ?? 'csrf';

    // CSRF 토큰이 세션에 저장된 값과 일치하는지 확인
    return $received_csrf_token === $csrf_token && !empty($csrf_token);
}
?>