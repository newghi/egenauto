<?php
function egb_cron_log($message) {
    $logFile = ROOT . DS . 'egb_cron.log';

    // 파일이 없으면 생성
    if (!file_exists($logFile)) {
        // 빈 파일 생성 (쓰기 권한 포함)
        file_put_contents($logFile, '');
        chmod($logFile, 0644); // 권한 설정 (rw-r--r--)
    }

    // 로그 메시지 형식: [YYYY-MM-DD HH:MM:SS] 메시지
    $formattedMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;

    // 로그 쓰기
    file_put_contents($logFile, $formattedMessage, FILE_APPEND);
}
?>
