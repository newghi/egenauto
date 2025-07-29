<?php
// 세션에서 유저 유니크 ID 확인
if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'failureCode' => 104]); // 로그인하지 않은 경우
    exit;
}

$user_uniq_id = $_SESSION['user_uniq_id'];  // 세션에서 유저 유니크 ID 가져오기

$title = egb('title', 105);
$content = egb('content', 106);

$uniq_id = uniqid();
$is_status = 1;
$created_by = '이젠오토';

// 동영상 파일 처리
$_FILES['file'] = $_FILES['video'];
$video_uniq_id = egb_resource_insert('file');

if (!$video_uniq_id) {
    echo json_encode(['success' => false, 'failureCode' => 107]); // 동영상 업로드 실패
    exit;
}

// 썸네일 파일 처리  
$_FILES['file'] = $_FILES['thumbnail'];
$thumbnail_uniq_id = egb_resource_insert('file');

if (!$thumbnail_uniq_id) {
    echo json_encode(['success' => false, 'failureCode' => 108]); // 썸네일 업로드 실패
    exit;
}

$video_url = "/?video3=" . $video_uniq_id;
$thumbnail_url = "/?img3=" . $thumbnail_uniq_id;

$post_data = [
    'title' => $title,
    'content' => $content,
    'video' => $video_url,
    'thumbnail' => $thumbnail_url
];

$post_data_json = json_encode($post_data);

// egb_board_youtube 테이블에 데이터 삽입
$query_board = "
INSERT INTO egb_board_youtube (
    uniq_id,
    board_user_uniq_id,
    board_title,
    board_contents,
    board_data,
    board_thumbnail_url,
    display_order,
    is_status,
    created_by,
    updated_by
) VALUES (
    :uniq_id,
    :user_uniq_id,
    :board_title,
    :board_contents,
    :board_data,
    :board_thumbnail_url,
    0,
    :is_status,
    :created_by,
    NULL
)";

$params_board = [
    ':uniq_id' => $uniq_id,
    ':user_uniq_id' => $user_uniq_id,
    ':board_title' => $title,
    ':board_contents' => $content,
    ':board_data' => $post_data_json,
    ':board_thumbnail_url' => $thumbnail_url,
    ':is_status' => $is_status,
    ':created_by' => $created_by
];

$binding_board = binding_sql(2, $query_board, $params_board);

// 트랜잭션 실행
$result = egb_sql($binding_board);

if ($result) {
    // 레코드 카운트 증가
    increase_record_total_count('egb_board_youtube');
    increase_record_active_count('egb_board_youtube');

    // 게시판 로그 추가
    egb_board_log('egb_board_youtube', $uniq_id, $user_uniq_id);

    // 리워드 지급
    egb_reward_dispatch($user_uniq_id, 'reward_community_youtube_long_upload', 'point', 0, 'auto_grade_check');

    // sitemap 추가
    egb_sitemap_insert('youtube', DOMAIN . '/page/youtube_board_view/?uniq_id=' . $uniq_id);

    echo json_encode(['success' => true, 'successCode' => 13, 'url' => DOMAIN . '/page/youtube_board_view/?uniq_id=' . $uniq_id]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 109]); // DB 저장 실패
}
?>
