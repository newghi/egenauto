<?php

function egbeditor2(){
    // EGB_EDITOR2 상수가 정의되어 있는지 확인
    if (!defined('EGB_EDITOR2')) {
        // 상수가 정의되어 있지 않은 경우, 제이쿼리를 출력하고 EGB_EDITOR2 상수 정의
        echo '<script nonce="'.NONCE.'" src="https://ibik.kr/?get=egbeditor3&key=test"></script>';
        
        // EGB_EDITOR2 상수 정의
        define('EGB_EDITOR2', true);
    }
}

?>
