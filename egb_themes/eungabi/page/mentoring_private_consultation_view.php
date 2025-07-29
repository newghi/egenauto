<?php
// 게시물 ID가 전달되었는지 확인
if (!isset($_GET['uniq_id']) || empty($_GET['uniq_id'])) {
    echo json_encode(['success' => false, 'errorCode' => 1]); // 에러 코드 1: uniq_id 없음
    exit;
}

$uniq_id = $_GET['uniq_id'];

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    $user_login = 'user';
}

if (isset($user_login)) {
    $login_user_uniq_id = $_SESSION['user_uniq_id'];
} else {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/mentoring_private_consultation_board_preview/?uniq_id=' . $uniq_id . "'; </script>";
    exit;
}

if (isset($_GET['alarm']) && $_GET['alarm'] === 'check') {
        $alarm_id = $_GET['alarm_id'];

        // 알림 읽음으로 표시하는 쿼리
        $query_update_read = "
            UPDATE auto_alarm_log
            SET auto_alarm_log_is_read = 1
            WHERE auto_alarm_log_uniq_id = :alarm_id
        ";

        $params = [
            ':alarm_id' => $alarm_id
        ];

        // 쿼리 바인딩 및 실행
        $binding_update = binding_sql(2, $query_update_read, $params);
        $result = egb_sql($binding_update);
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

$auto_board_user_uniq_id = $board_row['auto_mentoring_private_consultation_board_user_uniq_id'];

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
            <div class="flex_ft font_px_015 manual_content_1">
                <div class="mentoring_private_consultation_title_1 font_px_025 flv6 padding_px-u_010"><?php echo $post_data[0]['title']; ?></div>
            </div>
            <div class="width_box height_auto padding_px-u_020 display_none">
                <img src="<?php echo DOMAIN . $post_data[0]['image']; ?>"
                    class="mentoring_private_consultation_main_img width_box height_box" style="object-fit: cover;">
            </div>
			<div class="flex_ft font_px_015 mentoring_private_consultation_content_1">
				<div class="mentoring_private_consultation_contents_1"><?php echo nl2br($post_data[0]['content']); ?></div>
			</div>
            <script nonce="<?php echo NONCE; ?>">
                // Select all thumbnail images
                var thumbnails = document.querySelectorAll('[class*="mentoring_private_consultation_img_"]');
                // Select the main image
                var mainImage = document.querySelector('.mentoring_private_consultation_main_img');
                // Select all content divs
                var contentDivs = document.querySelectorAll('[class*="mentoring_private_consultation_content_"]');

                thumbnails.forEach(function (thumbnail) {
                    thumbnail.addEventListener('click', function () {
                        // Get the index from the class name
                        var classes = thumbnail.className.split(' ');
                        var indexClass = classes.find(function (cls) {
                            return cls.startsWith('mentoring_private_consultation_img_');
                        });
                        var index = indexClass.split('_').pop();

                        // Update the main image src
                        mainImage.src = thumbnail.src;

                        // Update the content divs
                        contentDivs.forEach(function (contentDiv) {
                            var contentClasses = contentDiv.className.split(' ');
                            var contentIndexClass = contentClasses.find(function (cls) {
                                return cls.startsWith('mentoring_private_consultation_content_');
                            });
                            var contentIndex = contentIndexClass.split('_').pop();

                            if (contentIndex === index) {
                                contentDiv.classList.remove('display_off');
                            } else {
                                contentDiv.classList.add('display_off');
                            }
                        });
                    });
                });
                const elements = document.querySelectorAll('.scrolls'); // 'scrolls' 클래스를 가진 모든 요소 선택

                elements.forEach(function (ele) {
                    ele.style.cursor = 'default';

                    let pos = { top: 0, left: 0, x: 0, y: 0 };

                    const startHandler = function (e) {
                        ele.style.cursor = 'grabbing';
                        //ele.style.userSelect = 'none';

                        pos = {
                            left: ele.scrollLeft,
                            top: ele.scrollTop,

                            x: e.touches ? e.touches[0].clientX : e.clientX,
                            y: e.touches ? e.touches[0].clientY : e.clientY,
                        };

                        document.addEventListener('mousemove', moveHandler);
                        document.addEventListener('mouseup', endHandler);
                        document.addEventListener('touchmove', moveHandler);
                        document.addEventListener('touchend', endHandler);
                    };

                    const moveHandler = function (e) {
                        const x = e.touches ? e.touches[0].clientX : e.clientX;
                        const y = e.touches ? e.touches[0].clientY : e.clientY;

                        const dx = x - pos.x;
                        const dy = y - pos.y;

                        ele.scrollTop = pos.top - dy;
                        ele.scrollLeft = pos.left - dx;
                    };

                    const endHandler = function () {
                        ele.style.cursor = 'grab';
                        //ele.style.removeProperty('user-select');

                        document.removeEventListener('mousemove', moveHandler);
                        document.removeEventListener('mouseup', endHandler);
                        document.removeEventListener('touchmove', moveHandler);
                        document.removeEventListener('touchend', endHandler);
                    };

                    ele.addEventListener('mousedown', startHandler);
                    ele.addEventListener('touchstart', startHandler);
                });

            </script>
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
                    <div class="border_px-a_001 border_bre-a_005 padding_px-x_020 padding_px-y_010 font_px_014 pointer"
                        data-bg-color="#15376b" data-bd-a-color="#15376b" data-color="#ffffff">팔로우</div>
                </div>
            </div>
            <div class="grid_xx padding_px-t_030 padding_px-u_060 display_off" data-xx="25% 25% 25% 25%"
                data-xy="1-800: xx-50per~50per">
                <?php

                // 최근 5개의 게시물을 가져오는 쿼리
                $query_post = "
    SELECT * FROM auto_mentoring_private_consultation_board 
    WHERE auto_mentoring_private_consultation_board_user_uniq_id = :uniq_id
    ORDER BY auto_mentoring_private_consultation_board_publish_date DESC
    LIMIT 4
";

                // 파라미터 바인딩
                $params_post = [
                    ':uniq_id' => $user_uniq_id
                ];

                // 바인딩 SQL 함수 호출
                $binding_post = binding_sql(0, $query_post, $params_post);

                // 쿼리 실행
                $sql_post = egb_sql($binding_post);

                // 결과 확인 및 게시물 출력
                if (isset($sql_post[0]) && !empty($sql_post[0])) {
                    // 게시물 개수 확인
                    $post_count = count($sql_post[0]);

                    // 최대 4개의 게시물만 출력
                    for ($i = 0; $i < min(3, $post_count); $i++) {
                        $post = $sql_post[0][$i];

                        // 게시물 데이터가 JSON으로 저장되어 있다면 디코딩
                        $posts_data = json_decode($post['auto_mentoring_private_consultation_board_post_data'], true);

                        // 첫 번째 이미지 출력
                        if (!empty($posts_data) && isset($posts_data[0])) {
                            $image = isset($posts_data[0]['image']) ? htmlspecialchars($posts_data[0]['image']) : '/img/default_image.webp';
                            ?>
                            <a class="padding_px-a_010"
                                href="<?php echo DOMAIN . '/page/mentoring_private_consultation_board_view/?uniq_id=' . $post['auto_mentoring_private_consultation_board_uniq_id']; ?>">
                                <div class="position1 height_px_180 width_box border_bre-a_005 overflow_hidden pointer a"
                                    data-xy="1-500: height_px_150, 501-800: height_px_200">
                                    <img class="pointer width_box height_box a_1" src="<?php echo DOMAIN . $image; ?>"
                                        style="object-fit: cover;">
                                </div>
                            </a>
                            <?php
                        }
                    }

                    // 5개 이상의 게시물이 있는 경우 +더보기 버튼 출력
                    if ($post_count > 3) {
                        ?>
                        <a class="padding_px-a_010" href="<?php echo DOMAIN . '/page/mentoring_private_consultation_board_plus_view'; ?>">
                            <div class="position1 height_px_180 width_box border_bre-a_005 overflow_hidden pointer a"
                                data-xy="1-500: height_px_150, 501-800: height_px_200">
                                <img class="pointer width_box height_box a_1" src="<?php echo DOMAIN . $image; ?>"
                                    style="object-fit: cover;">
                                <div class="position2 flex_xc_yc width_box height_box font_px_022 flv6" data-top="0%"
                                    data-bg-color="#00000080" data-color="#ffffff">+더보기</div>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    echo "No posts found for the given user.";
                }


                ?>
            </div>
        </div>
    </div>
</section>
<style>
    .more {
        flex-shrink: 0;
    }

    .a:hover .a_1 {
        scale: 1.2;
        transition: 0.4s;
    }
</style>
<?php
//댓글 출력
//프로팅 출력
 auto_commnet('auto_mentoring_private_consultation_board', $uniq_id, $auto_board_user_uniq_id); 
 auto_floating('auto_mentoring_private', $uniq_id, $auto_board_user_uniq_id); 
 
?>