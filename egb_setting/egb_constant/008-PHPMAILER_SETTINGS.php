<?php
/**
 * PHPMailer 설정 상수
 * 이메일 발송을 위한 SMTP 설정값들
 */

// SMTP 서버 설정
if (!defined('PHPMAILER_HOST')) {
    define('PHPMAILER_HOST', 'smtps.hiworks.com'); // SMTP 서버 주소
}

if (!defined('PHPMAILER_PORT')) {
    define('PHPMAILER_PORT', '465'); // SMTP 포트 (587: TLS, 465: SSL)
}

if (!defined('PHPMAILER_SMTP_SECURE')) {
    define('PHPMAILER_SMTP_SECURE', 'ssl'); // 보안 연결 방식 (tls, ssl)
}

// 이메일 계정 설정
if (!defined('PHPMAILER_EMAIL')) {
    define('PHPMAILER_EMAIL', 'ibik@ibik.kr'); // 발신자 이메일 주소
}

if (!defined('PHPMAILER_EMAIL_PASSWORD')) {
    define('PHPMAILER_EMAIL_PASSWORD', 'qkdgodls1!'); // 이메일 비밀번호 또는 앱 비밀번호
}

// 인코딩 설정
if (!defined('PHPMAILER_CHARSET')) {
    define('PHPMAILER_CHARSET', 'UTF-8'); // 문자 인코딩
}

if (!defined('PHPMAILER_ENCODING')) {
    define('PHPMAILER_ENCODING', 'base64'); // 이메일 인코딩 방식
}



?>