<?php
// head 파일을 로드할 때 사용. 테마에 head.php가 있다면 테마 파일 로드, 없다면 코어 head.php 로드
function egb_head($path = ROOT.THEMES_PATH_HEAD){
	//테마의 head.php 파일이 있다면 테마 head.php 를 사용하고, 없다면 기본 세팅된 head.php를 사용 한다.
	if (file_exists($path)) {
		require_once $path;
	}else
	{
		require_once ROOT . DS ."egb_setting" . DS . "egb_default" . DS . "egb_head.php";
	}
	
}//egb_head($path = THEMES_PATH_HEAD);

?>