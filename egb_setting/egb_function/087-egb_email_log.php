<?php
/**
 * 이메일 발송 로그 저장 함수
 * 
 * @param string $to_email 수신자 이메일
 * @param string $subject 이메일 제목
 * @param string $body 이메일 본문
 * @param array $params 추가 매개변수
 * @return string|false 성공시 uniq_id, 실패시 false
 */
function egb_email_log($to_email, $subject, $body, $params = []) {
    // 기본 파라미터 설정
    $default_params = [
        'sender_email' => PHPMAILER_EMAIL,
        'sender_name' => '운영자',
        'recipient_name' => '수신자',
        'email_type' => 'html',
        'attachments' => null,
        'cc_emails' => null, 
        'bcc_emails' => null,
        'send_status' => 'pending',
        'error_message' => null,
        'smtp_response' => null,
        'created_by' => 'system',
        'is_status' => 1,
        'display_order' => 0,
        'retry_count' => 0
    ];

    // 파라미터 병합
    $params = array_merge($default_params, $params);

    // 유니크 ID 생성 
    $uniq_id = uniqid();

    // SQL 쿼리 작성
    $query = "INSERT INTO egb_email_log 
        (uniq_id, is_status, display_order, sender_email, sender_name, 
        recipient_email, recipient_name, email_subject, email_content, 
        email_type, attachments, cc_emails, bcc_emails, send_status, 
        error_message, retry_count, smtp_response, created_by, created_at)
        VALUES 
        (:uniq_id, :is_status, :display_order, :sender_email, :sender_name,
        :recipient_email, :recipient_name, :email_subject, :email_content,
        :email_type, :attachments, :cc_emails, :bcc_emails, :send_status,
        :error_message, :retry_count, :smtp_response, :created_by, NOW())";

    // 바인딩 파라미터 설정
    $binding_params = [
        ':uniq_id' => $uniq_id,
        ':is_status' => $params['is_status'],
        ':display_order' => $params['display_order'],
        ':sender_email' => $params['sender_email'],
        ':sender_name' => $params['sender_name'],
        ':recipient_email' => $to_email,
        ':recipient_name' => $params['recipient_name'],
        ':email_subject' => $subject,
        ':email_content' => $body,
        ':email_type' => $params['email_type'],
        ':attachments' => $params['attachments'] ? json_encode($params['attachments']) : null,
        ':cc_emails' => $params['cc_emails'] ? json_encode($params['cc_emails']) : null,
        ':bcc_emails' => $params['bcc_emails'] ? json_encode($params['bcc_emails']) : null,
        ':send_status' => $params['send_status'],
        ':error_message' => $params['error_message'],
        ':retry_count' => $params['retry_count'],
        ':smtp_response' => $params['smtp_response'],
        ':created_by' => $params['created_by']
    ];

    // SQL 실행
    $binding = binding_sql(2, $query, $binding_params);
    $result = egb_sql($binding);

    return $result ? $uniq_id : false;
}

?>