<?php

function egb_alarm_insert($user_uniq_id, $title, $message, $link = null, $type = null) {
    if (!$user_uniq_id || !$title || !$message) {
        return false;
    }

    $uniq_id = uniqid();

    // 알림 INSERT 쿼리
    $query1 = "
        INSERT INTO egb_alarm_log (
            uniq_id,
            alarm_log_user_uniq_id,
            alarm_log_title,
            alarm_log_message,
            alarm_log_link,
            alarm_log_type,
            alarm_log_is_read,
            created_by
        ) VALUES (
            :uniq_id,
            :user_uniq_id,
            :title,
            :message,
            :link,
            :type,
            0,
            'system'
        )
    ";
    $params1 = [
        ':uniq_id'      => $uniq_id,
        ':user_uniq_id' => $user_uniq_id,
        ':title'        => $title,
        ':message'      => $message,
        ':link'         => $link,
        ':type'         => $type
    ];
    $binding1 = binding_sql(2, $query1, $params1);

    // 사용자 알림 카운터 증가 쿼리
    $query2 = "
        UPDATE egb_user 
        SET user_alarm_count = user_alarm_count + 1
        WHERE uniq_id = :user_uniq_id
    ";
    $params2 = [
        ':user_uniq_id' => $user_uniq_id
    ];
    $binding2 = binding_sql(2, $query2, $params2);

    // 트랜잭션 실행
    $result = egb_sql($binding1, $binding2);

    if ($result && $result[0] && $result[1]) {
        increase_record_total_count('egb_alarm_log');
        increase_record_active_count('egb_alarm_log');
        return true;
    }

    return false;
}
?>
