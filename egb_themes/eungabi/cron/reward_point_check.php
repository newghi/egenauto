<?php

// 백엔드 처리 설정
ignore_user_abort(true);
set_time_limit(0);

egb_cron_log('[테마 크론] 리워드 적립금 소멸 처리 시작');

// 1. 소멸 대상 리워드 로그 조회 (잔여 포인트 있음 + 소멸일 지남)
$query1 = "
    SELECT *
    FROM egb_reward_log
    WHERE reward_log_grant_amount > reward_log_used_amount
      AND reward_log_expired_at IS NOT NULL
      AND reward_log_expired_at <= NOW()
      AND is_status = 1
";
$params1 = [];
$binding1 = binding_sql(0, $query1, $params1);
$result = egb_sql($binding1);

if ($result && isset($result[0]) && count($result[0]) > 0) {
    foreach ($result[0] as $log) {
        $user_uniq_id = $log['reward_log_user_uniq_id'];
        $remain_amount = (int)$log['reward_log_grant_amount'] - (int)$log['reward_log_used_amount'];

        // ✅ 잔여 포인트가 있는 경우에만 차감 처리
        if ($remain_amount > 0) {
            egb_point_insert(
                $user_uniq_id,
                $remain_amount,
                0, // 차감
                '리워드 소멸',
                '소멸 처리로 인한 잔여 포인트 차감'
            );
        }

        // ✅ 아카이브 테이블로 이동
        $query2 = "
            INSERT INTO egb_reward_log_archive
            SELECT * FROM egb_reward_log
            WHERE uniq_id = :uniq_id
        ";
        $params2 = [':uniq_id' => $log['uniq_id']];
        $binding2 = binding_sql(2, $query2, $params2);

        // ✅ 원본 삭제
        $query3 = "
            DELETE FROM egb_reward_log
            WHERE uniq_id = :uniq_id
        ";
        $params3 = [':uniq_id' => $log['uniq_id']];
        $binding3 = binding_sql(2, $query3, $params3);

        // ✅ 트랜잭션 실행
        egb_sql($binding2, $binding3);
    }

    // ✅ 성공 로그 기록
    egb_cron_log('[테마 크론] 소멸 리워드 처리 완료');
}

?>
