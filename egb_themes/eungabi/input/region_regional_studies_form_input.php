<?php
// 세션에서 유저 유니크 ID 확인
if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'failureCode' => 134]); // 로그인하지 않은 경우
    exit;
}

$user_uniq_id = $_SESSION['user_uniq_id'];  // 세션에서 유저 유니크 ID 가져오기

$title = egb('title', 135);
$content = egb('content', 136);

$uniq_id = uniqid();

$query = "INSERT INTO egb_board_region_regional_studies (
    uniq_id,
    board_user_uniq_id,
    board_title,
    board_contents,
    created_by,
    created_at
) VALUES (
    :uniq_id,
    :user_uniq_id,
    :title,
    :content,
    :created_by,
    NOW()
)";

$params = [
    ':uniq_id' => $uniq_id,
    ':user_uniq_id' => $user_uniq_id,
    ':title' => $title,
    ':content' => $content,
    ':created_by' => $user_uniq_id
];

$binding = binding_sql(2, $query, $params);
$result = egb_sql($binding);

if ($result) {
    // 레코드 카운트 증가
    increase_record_total_count('egb_board_region_regional_studies');
    increase_record_active_count('egb_board_region_regional_studies');

    // 게시판 로그 추가
    egb_board_log('egb_board_region_regional_studies', $uniq_id, $user_uniq_id);

    // 리워드 지급
    egb_reward_dispatch($user_uniq_id, 'reward_mentoring_release_upload', 'point', 0, 'auto_grade_check');

    // sitemap 추가
    egb_sitemap_insert('region_regional_studies_board', DOMAIN . '/page/region_regional_studies_view/?uniq_id=' . $uniq_id);

    echo json_encode(['success' => true, 'successCode' => 16, 'url' => DOMAIN . '/page/region_regional_studies_view/?uniq_id=' . $uniq_id]);
} else {
    // 게시글 삽입 실패 시 처리
    echo json_encode(['success' => false, 'failureCode' => 137]);
}

?>
