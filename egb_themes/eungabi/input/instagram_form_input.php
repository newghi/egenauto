<?php
// 세션에서 유저 유니크 ID 확인
if (!isset($_SESSION['user_uniq_id'])) {
    egb_error_log("인스타그램 업로드 실패: 로그인되지 않은 사용자");
    echo json_encode(['success' => false, 'failureCode' => 65]); // 로그인하지 않은 경우
    exit;
}

$user_uniq_id = $_SESSION['user_uniq_id'];  // 세션에서 유저 유니크 ID 가져오기
egb_error_log("인스타그램 업로드 시작 - 사용자: " . $user_uniq_id);

if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
    egb_error_log("인스타그램 업로드 실패: 이미지 파일 누락 - 사용자: " . $user_uniq_id);
    echo json_encode(['success' => false, 'failureCode' => 66]); // 이미지 누락
    exit;
}

$titles = egb('titles', 67);
$contents = egb('contents', 68);

$uniq_id = uniqid();
$is_status = 1;
$created_by = '이젠오토';

egb_error_log("인스타그램 업로드 데이터 - uniq_id: " . $uniq_id . ", 이미지 개수: " . count($_FILES['images']['name']));

$post_data = [];

// 이미지 파일 하나씩 처리
for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
    egb_error_log("이미지 " . ($i+1) . " 처리 시작 - 파일명: " . $_FILES['images']['name'][$i]);
    
    // 단일 파일 데이터 구성
    $single_file = [
        'name' => $_FILES['images']['name'][$i],
        'type' => $_FILES['images']['type'][$i],
        'tmp_name' => $_FILES['images']['tmp_name'][$i],
        'error' => $_FILES['images']['error'][$i],
        'size' => $_FILES['images']['size'][$i]
    ];
    
    // 임시로 $_FILES 배열 구성
    $_FILES['file'] = $single_file;
    
    $resource_uniq_id = egb_resource_insert('file');
    
    if (!$resource_uniq_id) {
        egb_error_log("인스타그램 업로드 실패: 파일 업로드 실패 - 파일명: " . $_FILES['images']['name'][$i]);
        echo json_encode(['success' => false, 'failureCode' => 69]); // 파일 업로드 실패
        exit;
    }

    egb_error_log("이미지 " . ($i+1) . " 업로드 성공 - resource_uniq_id: " . $resource_uniq_id);

    $img_url = "/?img3=" . $resource_uniq_id;

    $post_data[] = [
        'title' => $titles[$i],
        'content' => $contents[$i],
        'image' => $img_url
    ];
}

$post_data_json = json_encode($post_data);

// egb_board_instagram 테이블에 데이터 삽입 쿼리 작성
$query_board = "
INSERT INTO egb_board_instagram (
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
    ':board_title' => $titles[0],
    ':board_contents' => $contents[0],
    ':board_data' => $post_data_json,
    ':board_thumbnail_url' => $post_data[0]['image'],
    ':is_status' => $is_status,
    ':created_by' => $created_by
];
$binding_board = binding_sql(2, $query_board, $params_board);

egb_error_log("인스타그램 게시글 DB 저장 시도 - uniq_id: " . $uniq_id);

// 트랜잭션 실행
$result = egb_sql($binding_board);

if ($result) {
    egb_error_log("인스타그램 게시글 DB 저장 성공 - uniq_id: " . $uniq_id);
    
    // 레코드 카운트 증가
    increase_record_total_count('egb_board_instagram');
    increase_record_active_count('egb_board_instagram');

    // 게시판 로그 추가
    egb_board_log('egb_board_instagram', $uniq_id, $user_uniq_id);

    // 리워드 지급
    egb_reward_dispatch($user_uniq_id, 'reward_community_instagram_upload', 'point', 0, 'auto_grade_check');

    // sitemap 추가
    egb_sitemap_insert('instagram', DOMAIN . '/page/instagram_board_view/?uniq_id=' . $uniq_id);

    egb_error_log("인스타그램 업로드 완료 처리 성공 - uniq_id: " . $uniq_id);
    echo json_encode(['success' => true, 'successCode' => 7, 'url' => DOMAIN . '/page/instagram_board_view/?uniq_id=' . $uniq_id]);
} else {
    egb_error_log("인스타그램 게시글 DB 저장 실패 - uniq_id: " . $uniq_id);
    echo json_encode(['success' => false, 'failureCode' => 70]); // DB 저장 실패
}
?>
