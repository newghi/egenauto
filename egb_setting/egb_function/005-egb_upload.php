<?php

function egb_upload($file_path, $file_name, $file_contents){// 파일 경로, 파일 이름, 파일 내용 입력시 해당 경로에 파일 생성
if ($file_path == ""){$file_path = ROOT . DS;}else{$file_path = ROOT . $file_path;}
	// 폴더가 있는지 확인 없으면 생성
	if (!is_dir($file_path)) {
		mkdir($file_path, 0777, true);
	}
	$new_file = fopen($file_path.$file_name, "w+") or die("파일을 업로드 할 수 없습니다.");
	if (fwrite($new_file, $file_contents)) {
		fclose($new_file);
		return true; // 파일 업로드 성공
	} else {
		fclose($new_file);
		return false; // 파일 업로드 실패
	}
}//egb_upload($file_path, $file_name, $file_contents);

?>