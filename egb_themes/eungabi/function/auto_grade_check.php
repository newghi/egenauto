<?php
// 외부에 정의된 등급 확인 함수
function auto_grade_check($user_uniq_id, $reward_code, $reward_data) {
    error_log("[auto_grade_check] 시작 - user_uniq_id: $user_uniq_id, reward_code: $reward_code");

    if (!$user_uniq_id || !$reward_code) {
        return false;
    }

    // 리워드 코드에 대한 데이터 조회
    $query = "
        SELECT reward_data
        FROM egb_reward
        WHERE reward_code = :reward_code
        LIMIT 1
    ";
    $params = [':reward_code' => $reward_code];
    $binding = binding_sql(1, $query, $params);
    $reward_result = egb_sql($binding);

    if (!$reward_result || empty($reward_result[0]['reward_data'])) {
        return false;
    }


    // 사용자의 현재 등급 조회
    $query = "
        SELECT community_user_grade
        FROM egb_user 
        WHERE uniq_id = :user_uniq_id
        LIMIT 1
    ";
    $params = [':user_uniq_id' => $user_uniq_id];
    $binding = binding_sql(1, $query, $params);
    $user_result = egb_sql($binding);

    if (!$user_result) {
        return false;
    }


    $user_grades = [
        'community_' . $user_result[0]['community_user_grade']
    ];

    $reward_grades = json_decode($reward_result[0]['reward_data'], true);

    if (!is_array($reward_grades)) {
        return false;
    }

    // 사용자의 등급이 리워드 등급 중 하나와 일치하는지 확인
    foreach ($user_grades as $user_grade) {
        if (in_array($user_grade, $reward_grades, true)) {
            return true;
        }
    }

    return false;
}
?>