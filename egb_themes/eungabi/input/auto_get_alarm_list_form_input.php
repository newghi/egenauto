<?php

// 사용자 ID 가져오기
$login_user_uniq_id = $_SESSION['user_uniq_id'];

// 알림 목록 조회
$query_alarm_list = "
    SELECT * 
    FROM egb_alarm_log
    WHERE alarm_log_user_uniq_id = :login_user_uniq_id
    AND alarm_log_is_read = 0 
    AND is_status = 1
    AND deleted_at IS NULL
    ORDER BY created_at DESC
";
$params_alarm = [':login_user_uniq_id' => $login_user_uniq_id];
$binding_alarm_list = binding_sql(0, $query_alarm_list, $params_alarm);
$sql_alarm_list = egb_sql($binding_alarm_list);

$alarm_data = [];

if (!empty($sql_alarm_list[0])) {
    foreach ($sql_alarm_list[0] as $alarm) {
        $alarm_data[] = [
            'uniq_id' => $alarm['uniq_id'],
            'title' => $alarm['alarm_log_title'],
            'message' => $alarm['alarm_log_message'],
            'link' => $alarm['alarm_log_link'],
            'created_at' => $alarm['created_at']
        ];
    }
}

// 읽지 않은 알림 개수 조회
$query_alarm_count = "
    SELECT COUNT(*) as unread_count 
    FROM egb_alarm_log 
    WHERE alarm_log_user_uniq_id = :login_user_uniq_id 
    AND alarm_log_is_read = 0
    AND is_status = 1
    AND deleted_at IS NULL
";
$binding_alarm_count = binding_sql(1, $query_alarm_count, $params_alarm);
$sql_alarm_count = egb_sql($binding_alarm_count);

$unread_count = 0;
if (!empty($sql_alarm_count[0])) {
    $unread_count = $sql_alarm_count[0]['unread_count'];
}

echo json_encode([
    'success' => true,
    'successCode' => 30,
    'data' => [
        'alarms' => $alarm_data,
        'unread_count' => $unread_count
    ]
]);

?>
