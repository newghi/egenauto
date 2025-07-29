<?php 
// 개별 페이지 직접 접근 차단
if (!defined('_EUNGABI_')) {

    // 프로토콜 상수 설정
    if (!defined('PROTOCOL')) {
        $isHttps = (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        );
        define('PROTOCOL', $isHttps ? 'https://' : 'http://');
    }

    // 리디렉션 방식 (조용히 루트로 이동)
    header("Location: " . PROTOCOL . $_SERVER['HTTP_HOST']);
    exit;

    // 또는 403 Forbidden 방식
    // http_response_code(403);
    // exit;
}

?>


<?php
	if (egb('admin')){
		echo '<div id="egb_body" class="egb_admin_page">';
		require_once ROOT . DS . 'egb_admin' . DS . 'page' . DS . 'header.php';
        echo '<div class="egb_contents_fade_box">';
        echo '<main id="egb_contents">';
		egb_get_admin_page();
        echo '</main>';
        echo '</div>';
		require_once ROOT . DS . 'egb_admin' . DS . 'page' . DS . 'footer.php';
		echo '</div>';
    // AJAX 코드 파일 로드
    $ajaxFiles = [
        'egbsuccessCode.js',
        'egbFailureCode.js',
        'egbErrorCode.js',
        'egbCompleteCode.js',
    ];
	echo '<script id="egb_code_msg" nonce="'.NONCE.'">';
    foreach ($ajaxFiles as $file) {
        require_once (ROOT . DS . 'egb_admin' . DS . 'ajax' . DS . $file);
    }
	echo '</script>';
	}else{
			
	}
?>
