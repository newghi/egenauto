<?php
// 입력값의 자릿수 검증 함수
function gposlength($input, $length) {
	// 입력값의 길이를 확인하고 지정된 길이와 일치하는지 확인
	return strlen($input) === $length;
}
?>