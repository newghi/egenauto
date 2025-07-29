<?php
// 세션에서 유저 유니크 ID 확인
if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'failureCode' => 98]); // 로그인하지 않은 경우
    exit;
}

$user_uniq_id = $_SESSION['user_uniq_id'];  // 세션에서 유저 유니크 ID 가져오기

if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
    echo json_encode(['success' => false, 'failureCode' => 99]); // 이미지 누락
    exit;
}

$titles = egb('titles', 100);
$contents = egb('contents', 101);

$uniq_id = uniqid();
$is_status = 1;
$created_by = '이젠오토';

$post_data = [];

// 단일 파일인 경우에도 처리할 수 있도록 수정
$file_count = is_array($_FILES['images']['name']) ? count($_FILES['images']['name']) : 1;

for ($i = 0; $i < $file_count; $i++) {
    // 단일/다중 파일에 따라 데이터 구성을 다르게 처리
    if($file_count == 1) {
        $single_file = [
            'name' => $_FILES['images']['name'],
            'type' => $_FILES['images']['type'], 
            'tmp_name' => $_FILES['images']['tmp_name'],
            'error' => $_FILES['images']['error'],
            'size' => $_FILES['images']['size']
        ];
    } else {
        $single_file = [
            'name' => $_FILES['images']['name'][$i],
            'type' => $_FILES['images']['type'][$i],
            'tmp_name' => $_FILES['images']['tmp_name'][$i],
            'error' => $_FILES['images']['error'][$i],
            'size' => $_FILES['images']['size'][$i]
        ];
    }
    
    $_FILES['file'] = $single_file;
    
    $resource_uniq_id = egb_resource_insert('file');
    
    if (!$resource_uniq_id) {
        echo json_encode(['success' => false, 'failureCode' => 102]); // 파일 업로드 실패
        exit;
    }

    $img_url = "/?img3=" . $resource_uniq_id;

    $post_data[] = [
        'title' => is_array($titles) ? $titles[$i] : $titles,
        'content' => is_array($contents) ? $contents[$i] : $contents,
        'image' => $img_url
    ];
}

$post_data_json = json_encode($post_data);

// egb_board_blog 테이블에 데이터 삽입 쿼리 작성
$query_board = "
INSERT INTO egb_board_blog (
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
    ':board_title' => $post_data[0]['title'],
    ':board_contents' => $post_data[0]['content'],
    ':board_data' => $post_data_json,
    ':board_thumbnail_url' => $post_data[0]['image'],
    ':is_status' => $is_status,
    ':created_by' => $created_by
];
$binding_board = binding_sql(2, $query_board, $params_board);

// 트랜잭션 실행
$result = egb_sql($binding_board);

if ($result) {
    // 레코드 카운트 증가
    increase_record_total_count('egb_board_blog');
    increase_record_active_count('egb_board_blog');

    // 게시판 로그 추가
    egb_board_log('egb_board_blog', $uniq_id, $user_uniq_id);

    // 리워드 지급
    egb_reward_dispatch($user_uniq_id, 'reward_community_blog_upload', 'point', 0, 'auto_grade_check');

    // sitemap 추가
    egb_sitemap_insert('blog', DOMAIN . '/page/blog_board_view/?uniq_id=' . $uniq_id);

    echo json_encode(['success' => true, 'successCode' => 12, 'url' => DOMAIN . '/page/blog_board_view/?uniq_id=' . $uniq_id]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 103]); // DB 저장 실패
}
?>
