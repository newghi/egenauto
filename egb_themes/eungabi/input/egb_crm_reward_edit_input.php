    
    <?php

// 필수 파라미터 체크
$uniq_id = egb('uniq_id', 58);
$mode = egb('mode', 59);
$reward_grant = egb('reward_grant', 60);
$reward_expired_days = egb('reward_expired_days', 61);
$target_grades = egb('target_grades[]', 62);
$target_grades = json_encode($target_grades);

if ($mode === 'edit') {
    // 업데이트 쿼리 실행
    $update_query = "UPDATE egb_reward SET 
        reward_data = :reward_data,
        reward_grant = :reward_grant, 
        reward_expired_days = :reward_expired_days,
        updated_at = NOW(),
        updated_by = :updated_by
        WHERE uniq_id = :uniq_id";
        
    $update_params = [
        ':reward_data' => $target_grades,
        ':reward_grant' => $reward_grant,
        ':reward_expired_days' => $reward_expired_days,
        ':updated_by' => 'admin',
        ':uniq_id' => $uniq_id
    ];
    
    $update_binding = binding_sql(2, $update_query, $update_params);
    $update_result = egb_sql($update_binding);

    // 업데이트 결과가 있으면 성공으로 처리
    if ($update_result) {
        echo json_encode(['success' => true, 'successCode' => 6]); // 수정 성공
        exit;
    } else {
        echo json_encode(['success' => false, 'failureCode' => 63]); // 수정 실패
        exit;
    }
} else {
    echo json_encode(['success' => false, 'failureCode' => 64]); // 잘못된 mode 값
    exit;
}
?>