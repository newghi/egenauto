<?php
if (!isset($_POST['user_uniq_id_1']) || !isset($_POST['user_uniq_id_2'])) {
    echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage1']);
    exit;
}

$user_uniq_id_1 = $_POST['user_uniq_id_1'];
$user_uniq_id_2 = $_POST['user_uniq_id_2'];

// 1️⃣ 기존의 방이 있는지 확인
$query = "
    SELECT room_uniq_id FROM egb_chat_room 
    WHERE LEAST(user_uniq_id_1, user_uniq_id_2) = LEAST(:user_uniq_id_1, :user_uniq_id_2) 
    AND GREATEST(user_uniq_id_1, user_uniq_id_2) = GREATEST(:user_uniq_id_1, :user_uniq_id_2)
";

$params = [
    ':user_uniq_id_1' => $user_uniq_id_1,
    ':user_uniq_id_2' => $user_uniq_id_2
];

$binding = binding_sql(1, $query, $params);
$sql = egb_sql($binding);

if ($sql && isset($sql[0]['room_uniq_id'])) {
    // 2️⃣ 이미 방이 존재하는 경우 기존 room_uniq_id 반환
    echo json_encode(['success' => true, 'room_uniq_id' => $sql[0]['room_uniq_id']]);
    exit;
} 

// 3️⃣ 방이 존재하지 않으므로 새 채팅방 생성
$room_uniq_id = uniqid(); // 새로운 방의 고유 ID 생성
$query = "
    INSERT INTO egb_chat_room (
        room_uniq_id, user_uniq_id_1, user_uniq_id_2
    ) VALUES (
        :room_uniq_id, :user_uniq_id_1, :user_uniq_id_2
    )
";

$params = [
    ':room_uniq_id' => $room_uniq_id,
    ':user_uniq_id_1' => $user_uniq_id_1,
    ':user_uniq_id_2' => $user_uniq_id_2
];

$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if ($sql === false) {
    echo json_encode(['success' => false, 'failureCode' => 'egbChatSendMessage2']);
	exit;
} else {
    echo json_encode(['success' => true, 'successCode' => 'egbChatSendMessage1', 'room_uniq_id' => $room_uniq_id]);
	exit;
}
?>
