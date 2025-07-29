<?php
function gpos($inputName, $defaultValue = null) {
    // HTTP 요청 방법 확인 (GET 또는 POST)
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    
    // 입력값이 GET 또는 POST 요청에 존재하는지 확인
    if ($requestMethod === 'GET' && isset($_GET[$inputName])) {
        // 입력값이 존재하고 유효한지 검사
        $inputValue = $_GET[$inputName];
        if (isValidInput($inputValue)) {
            return $inputValue; // 유효한 입력값 반환
        } else {
            return $defaultValue; // 유효하지 않은 입력값이면 기본값 반환
        }
    } elseif ($requestMethod === 'POST' && isset($_POST[$inputName])) {
        // 입력값이 존재하고 유효한지 검사
        $inputValue = $_POST[$inputName];
        if (isValidInput($inputValue)) {
            return $inputValue; // 유효한 입력값 반환
        } else {
            return $defaultValue; // 유효하지 않은 입력값이면 기본값 반환
        }
    } else {
        // 입력값이 존재하지 않으면 기본값 반환
        return $defaultValue;
    }
}

// 입력값을 검증하는 함수
function isValidInput($input) {
    // 상대 경로와 관련된 단어를 제거하고 유효성을 검사
    $inputWithoutRelativePath = str_replace(['../', '..\\', './', '.\\'], '', $input);
    
    // 입력값이 상대 경로와 관련된 단어를 제거했을 때 원본 입력값과 같은지 확인
    if ($input === $inputWithoutRelativePath) {
        // 상대 경로와 관련된 단어가 없으면 유효함
        return true;
    } else {
        // 상대 경로와 관련된 단어가 있으면 유효하지 않음
        return false;
    }
}
?>
