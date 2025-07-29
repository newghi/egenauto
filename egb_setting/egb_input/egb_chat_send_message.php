<?php
// 필수 입력값이 있는지 확인
if (!isset($_POST['room_uniq_id']) || !isset($_POST['sender_uniq_id']) || !isset($_POST['message'])) {
    echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage1']); // 입력값 누락
    exit;
}

$room_uniq_id = trim($_POST['room_uniq_id']);
$sender_uniq_id = trim($_POST['sender_uniq_id']);
$message = trim($_POST['message']);

// 입력값 유효성 검사
if (empty($room_uniq_id) || empty($sender_uniq_id) || empty($message)) {
    echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage2']); // 입력값이 비어있음
    exit;
}

if (strlen($message) > 500) { // 메시지의 최대 길이 제한 (500자)
    echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage3']); // 메시지 길이 초과
    exit;
}

$message_uniq_id = uniqid(); // 메시지의 고유 ID 생성

// SQL 쿼리 작성
$query = "
    INSERT INTO egb_chat_message (
        message_uniq_id, room_uniq_id, sender_uniq_id, message, created_at
    ) VALUES (
        :message_uniq_id, :room_uniq_id, :sender_uniq_id, :message, NOW()
    )
";

$params = [
    ':message_uniq_id' => $message_uniq_id,
    ':room_uniq_id' => $room_uniq_id,
    ':sender_uniq_id' => $sender_uniq_id,
    ':message' => $message
];

// SQL 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// SQL 실행 결과 확인
if ($sql === false) {
    echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage4']); // SQL 실행 실패
} else {
    echo json_encode([
        'success' => true, 
        'successCode' => 'egbChatSendMessage2', 
		'room_uniq_id' => $room_uniq_id, 
        'msg' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
    ]);
}
?>
