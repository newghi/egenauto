<?php
//사이트 시작

// 현재 파일의 경로를 출력하고 wp-content 포함 여부 확인
$current_path = __DIR__;
if (strpos($current_path, 'wp-content') !== false) {
    define('ROOT', $current_path);
    // CMS 타입 상수 정의
    if (!defined('CMS_TYPE')) {
        define('CMS_TYPE', 'wordpress');
    }
} else {
    define('ROOT', $_SERVER['DOCUMENT_ROOT']);
    // CMS 타입 상수 정의
    if (!defined('CMS_TYPE')) {
        define('CMS_TYPE', 'egb');
    }
}

// 개발 모드 상수 정의
if (!defined('EGB_DEV_MODE')) {
    define('EGB_DEV_MODE', true); // 기본값은 false로 설정
}

// 성능최적화 모드 상수 정의
if (!defined('EGB_PERFORMANCE_OPTIMIZATION_MODE')) {
    define('EGB_PERFORMANCE_OPTIMIZATION_MODE', false); // 기본값은 false로 설정
}

// 사이트 시작 시간 상수 정의
if (!defined('EGB_START_TIME')) {
    define('EGB_START_TIME', microtime(true));
}

// 슈퍼글로벌 사용 감지 로거 등록
register_shutdown_function(function () {
    // 제외할 URI 목록
    $excluded_uris = [
        '/?post=page_style_input',
    ];

    $current_uri = $_SERVER['REQUEST_URI'] ?? '';

    foreach ($excluded_uris as $excluded) {
        if (strpos($current_uri, $excluded) == 0) {
            return; // 감지 제외
        }
    }

    foreach (['_GET', '_POST', '_REQUEST'] as $superglobal) {
        if (!empty($GLOBALS[$superglobal]) && !isset($GLOBALS[$superglobal]['__BLOCKED__'])) {
            error_log("⚠️ {$superglobal} 직접 사용 감지됨: {$current_uri}");
        }
    }
});

//경로 구분자
if (!defined('DS')) {define('DS', '/');}

// 모든 오류 캐치
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 인클루드 경로 패치를 추가
$originalIncludePath = get_include_path();
set_include_path($originalIncludePath . PATH_SEPARATOR . ROOT);

function egb_csp_url($urls) {
    if (trim($urls) == '') {
        return;
    }

    // 줄바꿈 또는 공백(스페이스/탭 등) 기준으로 분리 
    $url_list = preg_split('/[\s]+/', $urls);

    $url_pattern = "/^(wss?:\/\/|https?:\/\/|\/\/)([\w\.-]+\.[a-zA-Z]{2,})(\/[\/\w\.-]*)*\/?$/";

    foreach ($url_list as $url) {
        if (!preg_match($url_pattern, $url)) {
            echo 'CSP 정책으로 허용하지 않은 출처의 리소스를 탐지하여 사이트를 이용할 수 없습니다. 관리자에게 문의해주세요.';
            exit;
        }
    }
}


function get_csp_policy_file_content($file_path) {
    if (file_exists($file_path)) {
        return file_get_contents($file_path);
    } else {
        echo 'CSP 정책에 위반 되어 사이트를 이용 할 수 없습니다.관리자에게 문의해주세요.';
        exit;
    }
}

$base_path = ROOT . DS . 'egb_csp' . DS;

$default = get_csp_policy_file_content($base_path . 'default.txt');
$script = get_csp_policy_file_content($base_path . 'script.txt'); 
$style = get_csp_policy_file_content($base_path . 'style.txt');
$img = get_csp_policy_file_content($base_path . 'img.txt');
$font = get_csp_policy_file_content($base_path . 'font.txt');
$media = get_csp_policy_file_content($base_path . 'media.txt');
$object = get_csp_policy_file_content($base_path . 'object.txt');
$frame = get_csp_policy_file_content($base_path . 'frame.txt');
$connect = get_csp_policy_file_content($base_path . 'connect.txt');
$video = get_csp_policy_file_content($base_path . 'video.txt');
$worker = get_csp_policy_file_content($base_path . 'worker.txt');

// URL 리스트의 유효성을 검증
egb_csp_url($default);
egb_csp_url($script);
egb_csp_url($style);
egb_csp_url($img);
egb_csp_url($font);
egb_csp_url($media);
egb_csp_url($object);
egb_csp_url($frame);
egb_csp_url($connect);
egb_csp_url($video);
egb_csp_url($worker);

// nonce 값을 생성
$nonce = base64_encode(random_bytes(16));
if (!defined('NONCE')) {define('NONCE', $nonce);}

$csp_policy = '';

$csp_policy .= "default-src 'self' " . $default . ";";
$csp_policy .= "script-src 'self' 'nonce-" . NONCE . "' " . $script . " 'unsafe-inline' 'strict-dynamic';";
$csp_policy .= "style-src 'self' " . $style . " 'unsafe-inline';";
$csp_policy .= "img-src 'self' " . $img . " data: blob:;";
$csp_policy .= "font-src 'self' " . $font . ";";
$csp_policy .= "media-src 'self' " . $media . " blob:;";
$csp_policy .= "object-src 'self' " . $object . ";";
$csp_policy .= "frame-src 'self' " . $frame . ";";
$csp_policy .= "connect-src 'self' " . $connect . ";";
$csp_policy .= "worker-src 'self' " . $worker . ";";

header("Content-Security-Policy: " . $csp_policy);


// 사이트의 세팅을 위한 파일이 존재 하는지 확인 한다.
//사이트의 세팅을 위한 egb_function.php 파일을 로드 한다.
if (file_exists(ROOT . DS ."egb_load.php")){

	require_once ROOT . DS .'egb_load.php';

}else{

	echo "사이트를 세팅하기 위한 파일 egb_load.php 가 존재 하지 않습니다.<br>";
}

// 함수가 존재하는지 확인하고, 실행 한다.
// 세팅 변수값을 받으면 post 처리 한다.
if (function_exists('egb_setting')) {egb_setting();} else {echo "egb_setting(); 함수가 정의 되어 있지 않습니다. <br>"; exit;}

// 함수가 존재하는지 확인하고, 실행 한다.
//사이트의 상태를 체크하고 그에 맞는 단계를 실행;

if (function_exists('egb_site_check')) {egb_site_check();} else {echo "egb_site_check(); 함수가 정의 되어 있지 않습니다. <br>"; exit;}

?>
