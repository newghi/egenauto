
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$bNo = egb('b_no', 'publicDataPortal4');

$bNm = egb('b_nm', 'publicDataPortal5');

// API URL 및 서비스 키
$apiUrl = "https://api.odcloud.kr/api/nts-businessman/v1/status";
$serviceKey = "vWQCkWwWlf8lOXwzEVq7EHdaPItDT8VHOqHfvESc6b74u60F2OczzzSprKAp8JovN2JIopON3WZqrhTi2cbV9g%3D%3D";
$apiRequestUrl = $apiUrl . "?serviceKey=" . $serviceKey;

// API 요청 데이터 준비
$requestData = ['b_no' => $bNo];
if ($bNm !== null) {
    $requestData['b_nm'] = $bNm;
}

// CURL 초기화
$ch = curl_init($apiRequestUrl);

// CURL 설정
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

// API 요청 실행
$response = curl_exec($ch);

// CURL 오류 확인
if (curl_errno($ch)) {
    echo json_encode(['success' => false, 'failureCode' => 'publicDataPortal6', 'error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

// HTTP 응답 코드 확인
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode([
        'success' => false,
        'failureCode' => 'publicDataPortal7',
        'httpCode' => $httpCode,
        'msg' => $response
    ]);
    exit;
}

// 성공 여부와 응답 반환
echo json_encode([
    'success' => true,
    'successCode' => 'publicDataPortal2',
    'data' => json_decode($response, true),
    'corporationNumber' => $bNo,
    'corporationName' => $bNm
]);
?>
