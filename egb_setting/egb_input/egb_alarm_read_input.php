<?php
$alarm_uniq_id  = egb('alarm_uniq_id', 'egb_alarm_read_1');
$redirect_url   = egb('redirect_url');
$from_page      = egb('from_page');

$params = [':alarm_uniq_id' => $alarm_uniq_id];

// 1) 알림 읽음 처리
$query1   = "
    UPDATE egb_alarm_log 
    SET alarm_log_is_read = 1,
        alarm_log_read_at = NOW(),
        updated_by = 'system'
    WHERE uniq_id = :alarm_uniq_id
";
$binding1 = binding_sql(2, $query1, $params);

// 2) 사용자 알림 카운트 감소
$query2   = "
    UPDATE egb_user u
    SET u.user_alarm_count = GREATEST(u.user_alarm_count - 1, 0)
    WHERE u.uniq_id = (
        SELECT alarm_log_user_uniq_id 
        FROM egb_alarm_log 
        WHERE uniq_id = :alarm_uniq_id
    )
";
$binding2 = binding_sql(2, $query2, $params);

// 3) 아카이브로 이동 (INSERT)
$query3   = "
    INSERT INTO egb_alarm_log_archive
    SELECT * FROM egb_alarm_log
    WHERE uniq_id = :alarm_uniq_id
";
$binding3 = binding_sql(2, $query3, $params);

// 4) 원본 알림 삭제 (DELETE)
$query4   = "
    DELETE FROM egb_alarm_log
    WHERE uniq_id = :alarm_uniq_id
";
$binding4 = binding_sql(2, $query4, $params);

// 5) 트랜잭션 실행
$result = egb_sql($binding1, $binding2, $binding3, $binding4);

if ($result && $result[0] && $result[1] && $result[2] && $result[3]) {
    echo json_encode([
        'success'     => true,
        'successCode'=> 'egb_alarm_read_1',
        'redirect_url'=> $redirect_url,
        'alarm_uniq_id'=> $alarm_uniq_id,
        'from_page'=> $from_page
    ]);
} else {
    echo json_encode([
        'success'     => false,
        'failureCode'=> 'egb_alarm_read_2'
    ]);
}

?>