<?php

// 데이터베이스 연결이 이미 설정되었다고 가정합니다.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // POST 요청 데이터 받기
    $roomUniqId = $_POST['roomUniqId'] ?? '';
    $userId = $_POST['userId'] ?? '';

    if (!$roomUniqId) {
		echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage1']);
		exit;
    }

    // **SQL 쿼리 작성**
    $query = "
        SELECT 
            message_uniq_id, 
            sender_uniq_id, 
            message, 
            created_at 
        FROM 
            egb_chat_message 
        WHERE 
            room_uniq_id = :room_uniq_id 
            AND is_deleted_sender = 0 
            AND is_deleted_receiver = 0 
        ORDER BY created_at ASC 
    ";

    // 파라미터 바인딩
    $params = [':room_uniq_id' => $roomUniqId];

    // **binding_sql 및 egb_sql 함수 사용**
    $binding = binding_sql(0, $query, $params);
    $sql = egb_sql($binding);

    if ($sql && isset($sql[0])) {
		echo json_encode(['success' => true, 'successCode' => 'egbChatSendMessage3', 'all_msg' => $sql[0], 'user_uniq_id' => $userId]);
		exit;
    } else {
		echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage5']);
		exit;
    }

    exit;
}
