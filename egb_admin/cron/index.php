<?php
// 백그라운드 실행 설정
ignore_user_abort(true);
set_time_limit(0);

// 한국 시간대 설정
date_default_timezone_set('Asia/Seoul');

// 크론 시작 로그
egb_cron_log('[관리자 크론] 시작');

// 현재 시간 확인 (0~23)
$current_hour = (int)date('G');

// 모든 시간에 공통으로 실행될 URL 목록
$common_urls = [
    
];

// 시간별 개별 URL 정의 (추가될 경우만 지정)
$schedule = [
    0  => [],
    1  => [],
    2  => [],
    3  => [],
    4  => [],
    5  => [],
    6  => [],
    7  => [],
    8  => [],
    9  => [],
    10 => [],
    11 => [],
    12 => [],
    13 => [],
    14 => [],
    15 => [],
    16 => [],
    17 => [],
    18 => [],
    19 => [],
    20 => [],
    21 => [],
    22 => [],
    23 => []
];

// 시간별 URL + 공통 URL 병합
$urls = array_merge($common_urls, $schedule[$current_hour] ?? []);

// cURL 초기화
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);

// 각 URL 호출
foreach ($urls as $url) {
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_exec($ch);

    if (curl_errno($ch)) {
        egb_cron_log('[관리자 크론] URL 실패: ' . $url . ' - ' . curl_error($ch));
    } else {
        egb_cron_log('[관리자 크론] URL 호출 완료: ' . $url);
    }
}

curl_close($ch);

// 크론 종료 로그
egb_cron_log('[관리자 크론] 종료');
?>
