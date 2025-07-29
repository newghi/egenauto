
<?php
//admin-settingk로 부터 받은 post값을 변수에 할당
if (egb('admin_id') && egb('admin_password') && egb('admin_password_check')){
	$admin_id = egb('admin_id');
	$admin_password = egb('admin_password'); 
	$admin_password_check = egb('admin_password_check');
	
	if ($admin_password != $admin_password_check){
		echo "<script type='text/javascript' nonce='" . NONCE . "'> alert('비밀번호가 일치하지 않습니다.'); history.go(-1); </script>"; exit;
	}
	
	if (!preg_match('/^[a-zA-Z0-9]+$/', $admin_id)){
		echo "<script type='text/javascript' nonce='" . NONCE . "'> alert('아이디는 영문자와 숫자만 사용 가능합니다.'); history.go(-1); </script>"; exit;
	}
	
	error_reporting(1);
	ini_set("display_errors", 1);
	
	// 비밀번호 해싱
	$admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
	
	// 유니크 ID 생성 (13자)
	$uniq_id = uniqid();
	
	$db_connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	// 아이디 중복 체크
	$check_query = "SELECT COUNT(*) as cnt FROM egb_admin WHERE admin_id = '$admin_id'";
	$result = mysqli_query($db_connect, $check_query);
	$row = mysqli_fetch_assoc($result);

	if($row['cnt'] > 0) {
		mysqli_close($db_connect);
		echo "<script type='text/javascript' nonce='" . NONCE . "'> alert('이미 존재하는 아이디입니다.'); history.go(-1); </script>";
		exit;
	}
	
	$query_db = "INSERT INTO egb_admin (uniq_id, admin_id, admin_password, created_by) VALUES ('$uniq_id', '$admin_id', '$admin_password', '$admin_id')";
	
	/* DB 연결 확인 */
	if (mysqli_connect_error()){
		$sql_error = mysqli_connect_error();
		if(strpos($sql_error, 'password')) {$sql_error = '아이디 또는 비밀번호가 일치하지 않습니다.';}
		if(strpos($sql_error, 'gethostbyname failed')) {$sql_error = '호스트 정보를 찾을 수 없습니다.';}
		echo "<script type='text/javascript' nonce='" . NONCE . "'> alert('DB 접속에 실패했습니다.\\nDB 정보를 확인해주세요.\\n\\n에러 메시지: ". $sql_error ."'); history.go(-1); </script>";
	}
	//관리자 추가 하기 성공시
	if (mysqli_query($db_connect, $query_db)){

	//체크 파일 수정
	$site_check_file_path = DS;
	$site_check_file_name = "egb_site-check.php";
	$site_check_file_contents = '<?php define(\'SITE_CHECK\', \'4\'); ?>'; 
	
	// site-check.php 파일 내용 4로 수정
	egb_upload($site_check_file_path, $site_check_file_name, $site_check_file_contents);
	
	// robots.txt 파일 생성
	$site_check_file_path = DS;
	$site_check_file_name = "robots.txt";
	$site_check_file_contents = 'User-agent: *
	
	sitemap: ' . DOMAIN . DS . 'sitemap.xml
	'; 
	
	// site-check.php 파일 내용 4로 수정
	egb_upload($site_check_file_path, $site_check_file_name, $site_check_file_contents);	
	
	//DB연결 종료
	mysqli_close($db_connect);
	
	//관리자 세션 실행
	session_go();
	$_SESSION['admin_login'] = 'Y';
	
	//관리자 계정 생성 후 새로고침
	redirect(DOMAIN);
	
	}
}else{}


?>
