<?php
// 테마 내 파일 로드
function egb_themes_file_load($path){
	// 파일 경로에서 파일을 로드 할때 사용 한다 없으면 에러 처리
	if (file_exists( ROOT . THEMES_PATH . $path )){
		require_once  ROOT . THEMES_PATH . $path;
	}else
	{
		echo '해당 경로 ' . DOMAIN . THEMES_PATH . $path .' 에서 파일을 찾을 수 없거나 열 수 없습니다.<br>';
	}
}// egb_file_load($path);

?>