<?php
function egb_get_device() {
    // User-Agent 가져오기
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // 모바일, 태블릿, PC를 구분하기 위한 키워드 목록
    $mobileAgents = [
        'iPhone', 'Android', 'webOS', 'BlackBerry', 
        'iPod', 'Symbian', 'Windows Phone', 'Opera Mini', 
        'Mobile', 'Silk', 'Kindle', 'Fennec', 'Maemo', 'MeeGo',
        'IEMobile', 'Opera Mobi', 'Opera Mobile', 'Mobile Safari',
        'Samsung', 'LG', 'Nokia', 'SonyEricsson', 'Motorola',
        'SAMSUNG', 'HTC', 'Huawei', 'Xiaomi', 'OPPO', 'vivo'
    ];

    $tabletAgents = [
        'iPad', 'Android 3.', 'Tablet', 'Kindle', 
        'Nexus 7', 'Nexus 10', 'SM-T', 'PlayBook',
        'Galaxy Tab', 'Surface', 'Transformer', 'Xoom',
        'MediaPad', 'KFTT', 'KFJWI', 'KFSOWI', 'KFTHWI',
        'ASUS Pad', 'Mi Pad', 'Lenovo Tab'
    ];

    $pcAgents = [
        'Windows NT', 'Macintosh', 'Mac OS X', 'Linux x86_64', 
        'X11', 'Ubuntu', 'CrOS', 'Win64', 'WOW64',
        'Intel Mac', 'PowerPC Mac', 'FreeBSD', 'OpenBSD',
        'SunOS', 'BeOS', 'OS/2', 'Windows 10', 'Windows 8',
        'Windows 7', 'Windows Vista', 'Windows XP'
    ];

    // 태블릿 디바이스 판별 (태블릿을 먼저 확인해야 함)
    foreach ($tabletAgents as $agent) {
        if (stripos($userAgent, $agent) !== false) {
            return 'TB'; // 태블릿 기기
        }
    }

    // 모바일 디바이스 판별
    foreach ($mobileAgents as $agent) {
        if (stripos($userAgent, $agent) !== false) {
            return 'MO'; // 모바일 기기
        }
    }

    // PC 디바이스 판별
    foreach ($pcAgents as $agent) {
        if (stripos($userAgent, $agent) !== false) {
            return 'PC'; // PC 기기
        }
    }

    // 알 수 없는 기기 로그 기록
    logUnknownDevice($userAgent);

    // 알 수 없는 기기는 'UNKNOWN'으로 반환
    return 'UNKNOWN';
}

function logUnknownDevice($userAgent) {
    $logFile = ROOT. DS . 'unknown_devices.log'; // 로그 파일 경로
    $dateTime = date('Y-m-d H:i:s'); // 현재 시간
    $logMessage = "[$dateTime] 알 수 없는 기기: $userAgent" . PHP_EOL;

    // 로그 파일에 기록 (쓰기 모드로 열고 추가)
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

/* // 결과 출력
$deviceType = getDeviceType();
echo "접속한 기기는: " . $deviceType; */
?>