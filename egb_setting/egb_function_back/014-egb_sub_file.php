<?php
// 서브 파일 로드
function egb_sub_file($path){
	//기본 파일에서 서브로 내용을 추가 하고 싶을 경우 해당 함수를 사용
	if (file_exists($path)) {
		require_once $path;
	}
}//egb_sub_file($path);

?>