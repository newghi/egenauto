<?php
$uniq_id = egb('uniq_id', 'toggle_weekday_status_1');
$weekday = egb('weekday', 'toggle_weekday_status_2');
$request_page = egb('request_page', 'toggle_weekday_status_3');

// 요일 값 정규화
$weekday_map = [
    // 한글 짧은 형식
    '월' => '월', '화' => '화', '수' => '수', '목' => '목', 
    '금' => '금', '토' => '토', '일' => '일',
    // 한글 긴 형식
    '월요일' => '월', '화요일' => '화', '수요일' => '수', '목요일' => '목', 
    '금요일' => '금', '토요일' => '토', '일요일' => '일',
    // 한글 긴 형식
    '월요일' => '월', '화요일' => '화', '수요일' => '수', '목요일' => '목', 
    '금요일' => '금', '토요일' => '토', '일요일' => '일',
    // 영어 전체 형식
    'Monday' => '월', 'Tuesday' => '화', 'Wednesday' => '수', 'Thursday' => '목',
    'Friday' => '금', 'Saturday' => '토', 'Sunday' => '일',
    // 영어 짧은 형식
    'Mon' => '월', 'Tue' => '화', 'Wed' => '수', 'Thu' => '목',
    'Fri' => '금', 'Sat' => '토', 'Sun' => '일',
    // 숫자 형식 (1:월요일 ~ 7:일요일)
    '1' => '월', '2' => '화', '3' => '수', '4' => '목',
    '5' => '금', '6' => '토', '7' => '일',
    // 숫자 형식 (0:일요일 ~ 6:토요일)
    '0' => '일', 
    // 소문자 영어도 처리
    'monday' => '월', 'tuesday' => '화', 'wednesday' => '수', 'thursday' => '목',
    'friday' => '금', 'saturday' => '토', 'sunday' => '일',
    'mon' => '월', 'tue' => '화', 'wed' => '수', 'thu' => '목',
    'fri' => '금', 'sat' => '토', 'sun' => '일'
];

// 입력값 전처리 (공백 제거 및 소문자 변환)
$weekday = trim($weekday);
if (is_numeric($weekday)) {
    $weekday = (string)$weekday; // 숫자를 문자열로 변환
} else {
    $weekday = str_replace(' ', '', $weekday); // 공백 제거
}

// 입력된 요일값이 매핑 배열에 있으면 변환, 없으면 오류 처리
if (isset($weekday_map[$weekday])) {
    $weekday = $weekday_map[$weekday];
} else {
    echo json_encode(['success' => false, 'failureCode' => 'toggle_weekday_status_4']);
    exit;
}

$result = egb_store_toggle_weekday_status($uniq_id, $weekday);

if ($result) {
    echo json_encode(['success' => true, 'successCode' => 'toggle_weekday_status_1', 'request_page' => $request_page, 'weekday' => $weekday]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 'toggle_weekday_status_5']);
}
?>
