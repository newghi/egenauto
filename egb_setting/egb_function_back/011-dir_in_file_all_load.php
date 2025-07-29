<?php
function dir_in_file_all_load($path){
// 폴더가 존재하는지 확인
if (is_dir($path)) {
//폴더가 존재 하는 경우.
$dir = glob($path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기
sort($dir); // 파일명을 정렬한다.
foreach ($dir as $dir_file) {require_once $dir_file;} // 파일을 하나씩 require_once 시킴
}else{
	//폴더가 존재 하지 않는 경우. 이 주석 아래에서 처리
	echo "011-폴더가 없습니다.";
}
}