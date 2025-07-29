<?php
header('Content-Type: application/json');

// POST 요청으로 받은 데이터 읽기
$data = json_decode(file_get_contents('php://input'), true);

// 필수 데이터 확인
if (isset($data['path']) && isset($data['styles']) && isset($data['theme'])) {
    $egbPath = $data['path'];
    $egbStyles = $data['styles'];
    $egbTheme = $data['theme'];

    // 저장 경로 정의
    $savePath = ROOT . '/egb_themes/' . $egbTheme . '/style/' . $egbPath . '.json';

    // 디렉토리 생성 (존재하지 않을 경우)
    $directory = dirname($savePath);
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // 파일에 저장할 형식 정의
    $stylesData = [
        'path' => $egbPath,
        'styles' => $egbStyles,
        'theme' => $egbTheme
    ];

    // 파일에 저장
    file_put_contents($savePath, json_encode($stylesData, JSON_PRETTY_PRINT));

    // 성공 응답 반환
    echo json_encode(['success' => true]);
} else {
    // 오류 응답 반환
    //echo json_encode(['success' => false, 'message' => '필수 데이터가 누락되었습니다.']);
}
?>
