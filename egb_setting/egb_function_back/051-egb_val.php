<?php

function egb_val($fields, $default = []) {
    $fieldValues = []; // 필드 값들을 저장할 배열 초기화
    foreach ($fields as $index => $field) {
        $defaultValue = isset($default[$index]) ? $default[$index] : null;
        $fieldValues[$field] = gpos($field, $defaultValue); // 필드와 해당하는 값을 배열에 추가
        if (!isset($fieldValues[$field]) || empty($fieldValues[$field])) {
            return false;
        }
    }
    return $fieldValues; // 필드 값들을 배열로 반환
}

?>
