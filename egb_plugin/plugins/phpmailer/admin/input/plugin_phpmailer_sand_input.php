<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// PHPMailer 라이브러리를 가져옵니다.
	require PLUGIN_PHPMAILER_PATH . "src" . DS . "Exception.php";
	require PLUGIN_PHPMAILER_PATH . "src" . DS . "PHPMailer.php";
	require PLUGIN_PHPMAILER_PATH . "src" . DS . "SMTP.php";
	
	// 이메일을 보낼 SMTP 설정
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = PLUGIN_PHPMAILER_HOST; // SMTP 서버 주소
	$mail->SMTPAuth = true;
	$mail->Username = PLUGIN_PHPMAILER_EMAIL; // SMTP 계정 이메일
	$mail->Password = PLUGIN_PHPMAILER_EMAIL_PASSWORD; // SMTP 계정 비밀번호
	$mail->SMTPSecure = PLUGIN_PHPMAILER_SMTP_SECURE;
	$mail->Port = PLUGIN_PHPMAILER_PORT;
	$mail->CharSet    = PLUGIN_PHPMAILER_CHARSET; // 한글 설정 문자셋 인코딩
	$mail->Encoding   = PLUGIN_PHPMAILER_ENCODING; //
	
	//보내는 사람
	$from_email = $_POST['from_email'] ?? PLUGIN_PHPMAILER_EMAIL;
	$from_name = $_POST['from_name'] ?? MATA_AUTHOR;
	
	//받는 사람
	$to_email = $_POST['to_email'] ?? PLUGIN_PHPMAILER_EMAIL;
	$to_name = $_POST['to_name'] ?? MATA_AUTHOR;
	
	//참조
	$cc_email = $_POST['cc_email'] ?? null;
	$cc_name = $_POST['cc_name'] ?? null;
	
	//숨은참조
	$bcc_email = $_POST['bcc_email'] ?? null;
	$bcc_name = $_POST['bcc_name'] ?? null;
	
	//제목
	$Subject = $_POST['email_subject'] ?? '제목없음';
	
	//제목 유효성 검사
	if (strlen($Subject) > 255) {
		// 제목이 너무 긴 경우
		echo json_encode(['success' => false, 'errorCode' => 8]);
		exit;
	}
	
	// 허용할 문자 패턴 정의
	$allowed_pattern = '/^[\p{L}0-9!@#\$%\^&\*\(\)_\+\-=\{\}\[\]\|\\:\;\"\'<>,\.\/\?\s]+$/u';
	
	// 제목이 허용되지 않는 문자를 포함하고 있는지 검사
	if (!preg_match($allowed_pattern, $Subject)) {
		// 허용되지 않는 문자가 포함된 경우
		//echo $Subject;
		echo json_encode(['success' => false, 'errorCode' => 7]);
		exit;
	}
	
	//내용
	$body = $_POST['email_body'] ?? '내용없음';
	// 자바스크립트 태그 제거
	$body = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $body);
	
	//메일 검증 함수
	function phpmailer_check_email($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// 이메일 주소가 유효하지 않은 경우
			echo json_encode(['success' => false, 'errorCode' => 6]);
			exit;
		}
	}
	
	phpmailer_check_email($to_email);
	
	
	$parts = explode('@', $to_email); // "@" 기준으로 분리
	
	if (count($parts) == 2) {
		$domain = $parts[1]; // 두 번째 부분이 도메인
		// 이제 $domain 변수에 있는 도메인에 대해 DNS 및 MX 레코드를 확인할 수 있습니다.
	
		// MX 레코드의 존재 여부 확인
		if (checkdnsrr($domain, 'MX')) {
			//echo "도메인 $domain 에는 MX 레코드가 존재합니다.<br>";
	
			// MX 레코드 정보를 저장할 배열
			$mx_records = [];
	
			// MX 레코드 정보 가져오기
			if (getmxrr($domain, $mx_records)) {
				//echo "도메인 $domain 의 MX 레코드는 다음과 같습니다:<br>";
				foreach ($mx_records as $record) {
					//echo "$record<br>";
				}
			} else {
				//echo "도메인 $domain 의 MX 레코드를 가져오는 데 실패했습니다.";
				echo json_encode(['success' => false, 'errorCode' => 5]);
				exit;
			}
		} else {
			//echo "도메인 $domain 에는 MX 레코드가 존재하지 않습니다.";
			echo json_encode(['success' => false, 'errorCode' => 4]);
			exit;
		}
	} else {
		//echo "유효하지 않은 이메일 주소입니다.";
		echo json_encode(['success' => false, 'errorCode' => 3]);
		exit;
	}
	
	
	// 이메일을 보내는 사람
	$mail->setFrom($from_email, $from_name);
	
	// 이메일 수신자
	$mail->addAddress($to_email, $to_name); // 받는 사람의 이메일 주소
	
	if (isset($cc_email)){
		
		phpmailer_check_email($cc_email);
		$mail->addCC($cc_email, $cc_name);
		
	} //참조
	
	if (isset($bcc_email)){
		
		phpmailer_check_email($bcc_email);
		
		$mail->addBCC($bcc_email, $bcc_name);
	} //숨은참조
	
	
	// 이메일 콘텐츠
	$mail->isHTML(true);
	
	// 첨부 파일 처리
	if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
		$file_path = $_FILES['file']['tmp_name'];
		$file_name = $_FILES['file']['name'];
		
		if (is_uploaded_file($file_path)) {
			// 파일을 메일에 첨부
			$mail->addAttachment($file_path, $file_name);
		} else {
			//echo '파일 업로드에 실패했습니다.';
		echo json_encode(['success' => false, 'errorCode' => 2]);
		exit;
		}
	}
	$mail->Subject = $Subject;
	$mail->Body = $body;
	
	// 이메일 전송
	if(!$mail->send()) {
		echo 'Mailer 오류: ' . $mail->ErrorInfo;
		echo json_encode(['success' => false, 'errorCode' => 1]);
		exit;
	} else {
		// 파일 전송 후 파일 삭제
		if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
			unlink($file_path); // 파일 삭제
		}
		
		//로그기록
		plugin_phpmailer_db_log_insert($to_email, $cc_email, $bcc_email, $from_email, $Subject, $body);
		
		echo json_encode(['success' => true]);
		exit;
	}
}else{
	echo '<script> window.location.href = "' .DOMAIN . '"; </script>';
}
?>
