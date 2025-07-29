<?php
// 게시물 ID가 전달되었는지 확인
if (!isset($_GET['uniq_id']) || empty($_GET['uniq_id'])) {
    echo json_encode(['success' => false, 'errorCode' => 1]); // 에러 코드 1: uniq_id 없음
    exit;
}

$uniq_id = $_GET['uniq_id'];

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){$user_login = 'user';}

if (isset($user_login)){
	echo "<script nonce=".NONCE." type='text/javascript'>window.location.href='". DOMAIN.'/page/mentoring_private_consultation_board_view/?uniq_id='.$uniq_id."'; </script>";exit;
}else{
	
}


// 게시물 데이터를 조회하는 쿼리
$query_post = "
    SELECT * FROM auto_mentoring_private_consultation_board 
    WHERE auto_mentoring_private_consultation_board_uniq_id = :uniq_id
";
$params_post = [
    ':uniq_id' => $uniq_id
];
$binding_post = binding_sql(1, $query_post, $params_post);
$sql_post = egb_sql($binding_post);

// 결과 확인
if (!isset($sql_post[0])) {
    echo json_encode(['success' => false, 'errorCode' => 2]); // 에러 코드 2: 게시물 없음
    exit;
}

$board_row = $sql_post[0];

// 게시물의 데이터를 JSON으로 파싱
$post_data = json_decode($board_row['auto_mentoring_private_consultation_board_post_data'], true);

// 첫 번째 배열의 타이틀과 이미지 가져오기
$post_info = print_first_array_title_and_image($post_data);

// 유저 정보 가져오기
$query_user = "
    SELECT * FROM auto_user 
    WHERE user_uniq_id = :user_uniq_id
";
$params_user = [
    ':user_uniq_id' => $board_row['auto_mentoring_private_consultation_board_user_uniq_id']
];
$binding_user = binding_sql(1, $query_user, $params_user);
$sql_user = egb_sql($binding_user);

$user_name = isset($sql_user[0]['user_name']) ? $sql_user[0]['user_name'] : 'Unknown';
$user_uniq_id = $board_row['auto_mentoring_private_consultation_board_user_uniq_id'];

// 첫 번째 배열의 타이틀과 이미지를 출력하는 함수
function print_first_array_title_and_image($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // 첫 번째 배열의 타이틀과 이미지 출력
                $title = isset($value['title']) ? htmlspecialchars($value['title']) : 'No Title';
                $image = isset($value['image']) ? htmlspecialchars($value['image']) : '/img/default_image.webp'; // 기본 이미지 설정
                return ['title' => $title, 'image' => $image];
            }
        }
    }
    return ['title' => 'No Title', 'image' => '/img/default_image.webp']; // 기본값
}

// 필요한 변수 선언
$view_count_post_uniq_id = $uniq_id ?? null;
$view_count_user_uniq_id = $user_uniq_id ?? null;
$view_count_table_name = 'auto_mentoring_private_consultation_board';
$view_count_post_ip = egb_ip(); // IP 주소 가져오는 함수

// 동일한 날 동일 IP로 접속한 기록이 있는지 확인하는 쿼리
$check_query = "
    SELECT 1 FROM auto_post_view_count 
    WHERE auto_view_count_post_ip = :post_ip 
      AND DATE(auto_view_count_publish_date) = CURDATE()
      AND auto_view_count_post_uniq_id = :post_uniq_id
    LIMIT 1;
";

$check_params = [
    ':post_ip' => $view_count_post_ip,
    ':post_uniq_id' => $view_count_post_uniq_id,
];

// 바인딩 및 실행 (조회)
$check_binding = binding_sql(1, $check_query, $check_params);
$check_result = egb_sql($check_binding);

// 동일한 기록이 없을 경우 새 레코드 삽입
if (!$check_result[0]) {
    $insert_query = "
        INSERT INTO auto_post_view_count (
            auto_view_count_uniq_id,
            auto_view_count_user_uniq_id,
            auto_view_count_table_name,
            auto_view_count_post_uniq_id,
            auto_view_count_post_ip,
            auto_view_count_status
        ) VALUES (
            :uniq_id,
            :user_uniq_id,
            :table_name,
            :post_uniq_id,
            :post_ip,
            1
        );
    ";

    $insert_params = [
        ':uniq_id' => uniqid(), // 고유 식별자 생성
        ':user_uniq_id' => $view_count_user_uniq_id,
        ':table_name' => $view_count_table_name,
        ':post_uniq_id' => $view_count_post_uniq_id,
        ':post_ip' => $view_count_post_ip,
    ];

    // 바인딩 및 실행 (삽입)
    $insert_binding = binding_sql(2, $insert_query, $insert_params);
    $insert_result = egb_sql($insert_binding);

    // 결과 반환
    if (isset($insert_result[0])) {
        //echo json_encode(['success' => true]);
    } else {
        //echo json_encode(['success' => false, 'errorCode' => 2]);
    }
} else {
    // 이미 동일한 날 동일 IP로 접속한 경우
    //echo json_encode(['success' => false, 'errorCode' => 1]);
}

// 해당 게시물과 일치하는 모든 레코드의 합계를 조회하는 쿼리
$count_query = "
    SELECT COUNT(*) as total_count 
    FROM auto_post_view_count 
    WHERE auto_view_count_post_uniq_id = :post_uniq_id;
";

$count_params = [
    ':post_uniq_id' => $view_count_post_uniq_id,
];

// 바인딩 및 실행 (조회)
$count_binding = binding_sql(1, $count_query, $count_params);
$count_result = egb_sql($count_binding);

// 결과 확인 및 출력
if (isset($count_result[0]['total_count'])) {
	$view_total_count = $count_result[0]['total_count'];
} else {
	$view_total_count =0;
}

?>
<section class="position1 width_box height_box">
    <div class="padding_px-x_010">
        <div class="width_px_720 margin_x_auto padding_px-y_050" data-xy="1-800: width_box">
            <div class="position1">
                <div class="width_box height_px_400">
                    
                </div>
                <div class="position2 width_box height_px_800" data-bottom="0%">
                    <div class="width_box height_px_500"
                        style="background: linear-gradient(rgba(255, 255, 255, 0) 0%, rgb(255, 255, 255) 100%);"></div>
                    <div class="width_box height_px_300 font_style_center font_px_020 line_height_140"
                        data-bg-color="#ffffff">
                        <div class="flv6">해당 게시물이 궁금한가요?</div>
                        <div class="flv6">해당 게시물은 멘토와 멘티만 볼 수 있어요.</div>
                        <div class="flex_xc padding_px-t_020">
                            <a href="<?php echo DOMAIN . '/page/login' ?>">
                                <div class="border_bre-a_005 border_px-a_001 pointer padding_px-x_030 padding_px-y_010 font_px_018 loginbutton"
                                    data-bg-color="#15376b" data-bd-a-color="#15376b" data-color="#ffffff">멘토 찾으러 가기
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            // SQL 쿼리 작성 (auto_like_status가 1인 갯수 조회)
            $query = "SELECT COUNT(*) as like_count 
          FROM auto_post_like 
          WHERE auto_like_post_uniq_id = :post_uniq_id 
          AND auto_like_status = 1";

            // 바인딩할 파라미터 설정
            $params = [
                ':post_uniq_id' => $uniq_id
            ];

            // 바인딩 쿼리 생성
            $binding = binding_sql(1, $query, $params);

            // 쿼리 실행
            $sql = egb_sql($binding);

            // 결과 확인 및 출력
            if (isset($sql[0]['like_count'])) {
                $like_count = $sql[0]['like_count'];
            } else {
                $like_count = 0;
            }
            ?>
            <?php

            // SQL 쿼리 작성 (auto_like_status가 1인 갯수 조회)
            $query = "SELECT COUNT(*) as scrap_count 
          FROM auto_post_scrap 
          WHERE auto_scrap_post_uniq_id = :post_uniq_id 
          AND auto_scrap_status = 1";

            // 바인딩할 파라미터 설정
            $params = [
                ':post_uniq_id' => $uniq_id
            ];

            // 바인딩 쿼리 생성
            $binding = binding_sql(1, $query, $params);

            // 쿼리 실행
            $sql = egb_sql($binding);

            // 결과 확인 및 출력
            if (isset($sql[0]['scrap_count'])) {
                $scrap_count = $sql[0]['scrap_count'];
            } else {
                $scrap_count = 0;
            }
            ?>
            <div class="flex_fl_yc_wrap padding_px-y_030 font_px_013" data-color="#828c94">
                <span><?php echo $board_row['auto_mentoring_private_consultation_board_publish_date']; ?></span>
                <span class="padding_px-x_003">·</span>
                <span>좋아요&nbsp;<span class="mentoring_private_consultation_side_heart_count"><?php echo number_format($like_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>스크랩&nbsp;<span class="mentoring_private_consultation_side_scrap_count"><?php echo number_format($scrap_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>조회&nbsp<span class="mentoring_private_consultation_view_total_count"><?php echo number_format($view_total_count); ?></span></span>
            </div>
            <div class="flex_xs1_yc">
                <div class="flex_fl_yc font_px_011">
                    <div class="flex_yc padding_px-r_010">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                            class="width_px_040 height_px_040 border_bre-a_035">
                    </div>
                    <div class="flex_ft">
                        <div class="flex_yc font_px_014 flv6"><?php echo $user_name; ?></div>
                        <div class="flex_yc font_px_013" data-color="#828c94">소개말</div>
                    </div>
                </div>
                <div class="flex_xc">
                    <div class="border_px-a_001 border_bre-a_005 padding_px-x_020 padding_px-y_010 font_px_014"
                        data-bg-color="#15376b" data-bd-a-color="#15376b" data-color="#ffffff">팔로우</div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .more {
        flex-shrink: 0;
    }

    img {
        pointer-events: none;
    }

    .a:hover .a_1 {
        scale: 1.2;
        transition: 0.4s;
    }

    .loginbutton:hover {
        background-color: #09addb;
        border-color: #09addb;
    }
</style>
<?php
//댓글 출력
//프로팅 출력
 auto_commnet('auto_mentoring_private_consultation_board', $uniq_id); 
 auto_floating('blog', $uniq_id); 
 
?>