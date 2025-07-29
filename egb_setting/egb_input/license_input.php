<?php
//값이 전달 되었는지 체크
if (egb('license_key') && egb('domain')){
	$license_key = egb('license_key');
	$domain = egb('domain');
	// 라이선스 키가 24자리가 아닌 경우 처리
	if (strlen($license_key) !== 24) {header("Location: /?msg=비정상적인 라이선스 키 입니다.");exit;} else {$parts = explode("-", $license_key);}
	// 4자리 마다 - 로 구분 되어 있는지 확인 $parts[0]에는 E685, $parts[1]에는 C7B2 등이 저장됩니다.
	if (count($parts) === 5) {} else {header("Location: /?msg=비정상적인 라이선스 키 입니다.");exit;}
	// 전송받은 도메인과 호스트 도메인이 일치하는지 확인
	if ($domain !== DOMAIN) {header("Location: /?msg=도메인이 일치하지 않습니다.");exit;} else {}
	$_SESSION['setting_ip'] = egb('ip');
	// 라이선스 파일 저장
	$filename = ROOT . DS . 'egb_setting' . DS . "egb_info" . DS . "egb_license.txt";
	$file_contents = json_encode(array('license_key' => $license_key, 'domain' => $domain));
	if ($fp = fopen($filename, 'w')) {
		fwrite($fp, $file_contents);
		fclose($fp);
		// 권한 설정
		chmod($filename, 0777);
		//체크 파일 수정
		$path = DS;
		$name = "egb_site-check.php";
		$contents = '<?php define(\'SITE_CHECK\', \'1\'); ?>'; 
		// site-check.php 파일 내용 1로 수정
		$upload_check = egb_upload($path, $name, $contents);
		if ($upload_check){
			// 업로드 성공
			redirect(DOMAIN); 
			exit;
		}else{
			// 업로드 실패
			header("Location: /?msg=비정상적인 라이선스 키 입니다.");
		}
	} else {
		redirect(DOMAIN);
		exit;
	}
}else{
	header("Location: /?msg=비정상적인 라이선스 키 입니다.");
	}
?>