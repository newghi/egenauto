<?php
function session_go(){
	
	//세션이 시작 되었는지 체크
	if (session_status() == PHP_SESSION_NONE) {
		
		// 세션 쿠키 설정 - 일주일
		session_set_cookie_params(604800, '/', '', true, true);
		
		// 적절한 세션 만료 시간 설정 (일주일)
		ini_set('session.gc_maxlifetime', SESSION_MAX_LIFT_TIME);
		
		// 세션 ID를 HTTPOnly와 secure로 설정
		ini_set('session.cookie_httponly', SESSION_HTTPONLY);
		ini_set('session.cookie_secure', SESSION_SECURE);
		
		session_start();
		
		// CSRF 토큰 생성
		if (!isset($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
		
		if (PROTOCOL == 'http://'){
			//만약 프로토콜이 http 라면 쿠키를 사용 한다.
			setcookie('PHPSESSID', session_id(), time() + 604800, '/');
			
		}
	}

}

?>