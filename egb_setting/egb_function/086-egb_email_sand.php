<?php
/**
 * 이메일 전송 함수 (직접 발송)
 * 
 * @param string $to_email 수신자 이메일
 * @param string $subject 이메일 제목
 * @param string $message 이메일 내용
 * @param array $params 추가 매개변수
 * @return bool 성공 여부
 */
function egb_email_sand($to_email, $subject, $message, $params = []) {
    try {
        // 입력값 검증
        if (empty($to_email) || empty($subject) || empty($message)) {
            egb_error_log("이메일 전송 에러: 필수 파라미터 누락");
            return false;
        }

        // 이메일 형식 검증
        if (!filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
            egb_error_log("이메일 전송 에러: 잘못된 이메일 형식 - '$to_email'");
            return false;
        }

        // 공백 제거
        $to_email = trim($to_email);
        $subject = trim($subject);
        $message = trim($message);

        // PHPMailer 상수 확인
        if (!defined('PHPMAILER_EMAIL') || !defined('PHPMAILER_HOST')) {
            egb_error_log("이메일 전송 에러: PHPMailer 상수가 정의되지 않음");
            return false;
        }

        egb_error_log("이메일 전송 시작 - to_email: '$to_email', subject: '$subject'");

        // 이메일 전송 로그 저장을 위한 파라미터 설정
        $log_params = [
            'sender_email' => PHPMAILER_EMAIL,
            'sender_name' => '시스템',
            'recipient_name' => '',
            'email_type' => 'html',
            'send_status' => 'pending',
            'created_by' => 'system'
        ];

        // 이메일 로그 저장
        $log_id = egb_email_log($to_email, $subject, $message, $log_params);
        
        if ($log_id) {
            egb_error_log("이메일 로그 저장 성공: $log_id");
            
            // PHPMailer 라이브러리 로드
            require_once ROOT . DS . 'egb_library' . DS . 'phpmailer' . DS . 'src' . DS . 'PHPMailer.php';
            require_once ROOT . DS . 'egb_library' . DS . 'phpmailer' . DS . 'src' . DS . 'SMTP.php';
            require_once ROOT . DS . 'egb_library' . DS . 'phpmailer' . DS . 'src' . DS . 'Exception.php';
            
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            
            // SMTP 설정
            $mail->isSMTP();
            $mail->Host = PHPMAILER_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = PHPMAILER_EMAIL;
            $mail->Password = PHPMAILER_EMAIL_PASSWORD;
            $mail->SMTPSecure = PHPMAILER_SMTP_SECURE;
            $mail->Port = PHPMAILER_PORT;
            $mail->CharSet = PHPMAILER_CHARSET;
            $mail->Encoding = PHPMAILER_ENCODING;
            
            // 타임아웃 설정
            $mail->Timeout = 30;
            $mail->SMTPKeepAlive = true;
            
            // 발신자 설정
            $mail->setFrom(PHPMAILER_EMAIL, '시스템');
            
            // 수신자 설정
            $mail->addAddress($to_email);
            
            // 이메일 내용 설정
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);
            
            egb_error_log("이메일 전송 시도: '$to_email'");
            
            // 이메일 전송
            if ($mail->send()) {
                egb_error_log("이메일 전송 성공: '$to_email'");
                
                // 성공 로그 업데이트
                $update_params = [
                    'sender_email' => PHPMAILER_EMAIL,
                    'sender_name' => '시스템',
                    'send_status' => 'sent',
                    'created_by' => 'system'
                ];
                
                egb_email_log($to_email, $subject, $message, $update_params);
                
                return true;
                
            } else {
                throw new Exception('이메일 전송에 실패했습니다.');
            }
            
        } else {
            throw new Exception('로그 저장에 실패했습니다.');
        }
        
    } catch (Exception $e) {
        // 에러 로깅
        egb_error_log("이메일 전송 에러: " . $e->getMessage());
        
        // 실패 로그 업데이트
        if (isset($log_id) && $log_id) {
            $error_params = [
                'sender_email' => PHPMAILER_EMAIL,
                'sender_name' => '시스템',
                'send_status' => 'failed',
                'error_message' => $e->getMessage(),
                'created_by' => 'system'
            ];
            
            egb_email_log($to_email, $subject, $message, $error_params);
        }
        
        return false;
    }
}

?>