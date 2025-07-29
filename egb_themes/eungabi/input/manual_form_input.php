<?php
// 세션에서 유저 유니크 ID 확인
if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'failureCode' => 115]); // 로그인하지 않은 경우
    exit;
}

$user_uniq_id = $_SESSION['user_uniq_id'];  // 세션에서 유저 유니크 ID 가져오기

if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
    echo json_encode(['success' => false, 'failureCode' => 116]); // 이미지 누락
    exit;
}

$titles = egb('titles', 117);
$contents = egb('contents', 118);
$manual_category = egb('manual_category', 119);
$manual_worker = egb('manual_worker', 120);
$manual_self_repair_shop = egb('manual_self_repair_shop', 121);
$manual_worker_time = egb('manual_worker_time', 122);
$manual_worker_budget_part = egb('manual_worker_budget_part', 123);
$manual_worker_budget_consumable = egb('manual_worker_budget_consumable', 124);
$manual_worker_type = egb('manual_worker_type', 125);
$manual_worker_brand = egb('manual_worker_brand', 126);
$auto_manual_board_car_model = egb('auto_manual_board_car_model', 127);
$auto_manual_board_car_type = egb('auto_manual_board_car_type', 128);
$manual_car_model_name = egb('manual_car_model_name', 129);
$auto_manual_board_car_oil_type = egb('auto_manual_board_car_oil_type', 130);
$auto_manual_board_car_model_year = egb('auto_manual_board_car_model_year', 131);

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
        echo json_encode(['success' => false, 'failureCode' => 132]); // 파일 업로드 실패
        exit;
    }

    $img_url = "/?img3=" . $resource_uniq_id;

    $post_data[] = [
        'title' => is_array($titles) ? $titles[$i] : $titles,
        'content' => is_array($contents) ? $contents[$i] : $contents,
        'image' => $img_url,
        'manual_category' => $manual_category,
        'manual_worker' => $manual_worker,
        'manual_self_repair_shop' => $manual_self_repair_shop,
        'manual_worker_time' => $manual_worker_time,
        'manual_worker_budget_part' => $manual_worker_budget_part,
        'manual_worker_budget_consumable' => $manual_worker_budget_consumable,
        'manual_worker_type' => $manual_worker_type,
        'manual_worker_brand' => $manual_worker_brand,
        'auto_manual_board_car_model' => $auto_manual_board_car_model,
        'auto_manual_board_car_type' => $auto_manual_board_car_type,
        'manual_car_model_name' => $manual_car_model_name,
        'auto_manual_board_car_oil_type' => $auto_manual_board_car_oil_type,
        'auto_manual_board_car_model_year' => $auto_manual_board_car_model_year
    ];
}

$post_data_json = json_encode($post_data);

// egb_board_manual 테이블에 데이터 삽입 쿼리 작성
$query_board = "
INSERT INTO egb_board_manual (
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
    increase_record_total_count('egb_board_manual');
    increase_record_active_count('egb_board_manual');

    // 게시판 로그 추가
    egb_board_log('egb_board_manual', $uniq_id, $user_uniq_id);

    // 리워드 지급
    egb_reward_dispatch($user_uniq_id, 'reward_selfcare_manual_upload', 'point', 0, 'auto_grade_check');

    // sitemap 추가
    egb_sitemap_insert('manual', DOMAIN . '/page/manual_board_view/?uniq_id=' . $uniq_id);

    echo json_encode(['success' => true, 'successCode' => 15, 'url' => DOMAIN . '/page/manual_board_view/?uniq_id=' . $uniq_id]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 133]); // DB 저장 실패
}
?>