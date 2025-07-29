<?php
// 📌 SSE 헤더 설정
header('Content-Type: text/event-stream');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Connection: keep-alive');

// 📌 클라이언트가 연결을 끊었는지 인식하기 위해 필요한 설정
ignore_user_abort(true);

// 📌 유니크 룸 ID 확인
$room_uniq_id = $_GET['room_uniq_id'] ?? null;

if (!$room_uniq_id) {
    echo "event: error\n";
    echo "data: Missing room_uniq_id\n\n";
    exit;
}

// 📌 최근 메시지 시간 (초기값: 현재 시간)
$last_message_time = date('Y-m-d H:i:s');

// 📌 무한 루프 시작 (SSE는 연결이 끊길 때까지 데이터를 지속적으로 보냅니다)
while (true) {
    // 1️⃣ 연결이 끊어졌는지 확인
    if (connection_aborted()) {
        break; // 클라이언트가 SSE를 끊으면 루프 탈출
    }

    // 2️⃣ MySQL "WAIT FOR" 방식의 쿼리
    $query = "
        SELECT * 
        FROM egb_chat_message 
        WHERE room_uniq_id = :room_uniq_id 
          AND created_at > :last_message_time 
        ORDER BY created_at ASC 
        LIMIT 10
        FOR UPDATE WAIT 5
    ";

    $params = [':room_uniq_id' => $room_uniq_id, ':last_message_time' => $last_message_time];

    $binding = binding_sql(0, $query, $params);
    $sql = egb_sql($binding);

    // 3️⃣ 새 메시지가 있으면 전송
    if ($sql && isset($sql[0])) {
        foreach ($sql[0] as $message) {
            echo "event: message\n";
            echo "data: " . json_encode($message) . "\n\n";
            ob_flush();
            flush();

            // 최근 메시지 시간 업데이트
            $last_message_time = $message['created_at'];
        }
    }

    // 4️⃣ Keep-Alive 메시지 전송
    echo ": heartbeat\n\n";
    ob_flush();
    flush();
}

