<?php

$uniq_id = egb('uniq_id');

if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    $user_login = 'user';
}

if (isset($user_login)) {
    $login_user_uniq_id = $_SESSION['user_uniq_id'];
} else {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/manual_board_preview/?uniq_id=' . $uniq_id . "'; </script>";
    exit;
}


// 게시물 데이터를 조회하는 쿼리
$query_post = "
    SELECT * FROM egb_board_manual 
    WHERE uniq_id = :uniq_id
";
$params_post = [
    ':uniq_id' => $uniq_id
];
$binding_post = binding_sql(1, $query_post, $params_post);
$sql_post = egb_sql($binding_post);

// 결과 확인
if (!isset($sql_post[0]['uniq_id'])) {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/manual_board_list' . "'; </script>";
    exit;
}

$board_row = $sql_post[0];

// 게시물의 데이터를 JSON으로 파싱
$post_data = json_decode($board_row['board_data'], true);

$auto_board_user_uniq_id = $board_row['board_user_uniq_id'];

// 첫 번째 배열의 타이틀과 이미지 가져오기
$post_info = print_first_array_title_and_image($post_data);

// 유저 정보 가져오기
$query_user = "
    SELECT * FROM egb_user 
    WHERE uniq_id = :user_uniq_id
";
$params_user = [
    ':user_uniq_id' => $board_row['board_user_uniq_id']
];
$binding_user = binding_sql(1, $query_user, $params_user);
$sql_user = egb_sql($binding_user);

$user_name = isset($sql_user[0]['user_name']) ? $sql_user[0]['user_name'] : '관리자';
$user_uniq_id = $board_row['board_user_uniq_id'];

// 첫 번째 배열의 타이틀과 이미지를 출력하는 함수
    function print_first_array_title_and_image($data) 
{
    if (!is_array($data) || empty($data)) {
        return ['title' => 'No Title', 'image' => '/img/default_image.webp'];
    }

    $first_item = reset($data);

    $title = isset($first_item['title']) ? htmlspecialchars($first_item['title']) : 'No Title';
    $image = isset($first_item['image']) ? htmlspecialchars($first_item['image']) : '/img/default_image.webp';
    
    $manual_category = '';
    if (isset($first_item['manual_category'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['manual_category']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $manual_category = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }
    
    $manual_worker = isset($first_item['manual_worker']) ? $first_item['manual_worker'] : '';
    $manual_self_repair_shop = isset($first_item['manual_self_repair_shop']) ? $first_item['manual_self_repair_shop'] : '';
    $manual_worker_time = isset($first_item['manual_worker_time']) ? $first_item['manual_worker_time'] : '';
    $manual_worker_budget_part = isset($first_item['manual_worker_budget_part']) ? $first_item['manual_worker_budget_part'] : '';
    $manual_worker_budget_consumable = isset($first_item['manual_worker_budget_consumable']) ? $first_item['manual_worker_budget_consumable'] : '';
    
    $manual_worker_type = '';
    if (isset($first_item['manual_worker_type'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['manual_worker_type']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $manual_worker_type = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $manual_worker_brand = '';
    if (isset($first_item['manual_worker_brand'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['manual_worker_brand']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $manual_worker_brand = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $auto_manual_board_car_model = '';
    if (isset($first_item['auto_manual_board_car_model'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_model']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_model = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $auto_manual_board_car_type = '';
    if (isset($first_item['auto_manual_board_car_type'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_type']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_type = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $manual_car_model_name = isset($first_item['manual_car_model_name']) ? $first_item['manual_car_model_name'] : '';
    
    $auto_manual_board_car_oil_type = '';
    if (isset($first_item['auto_manual_board_car_oil_type'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_oil_type']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_oil_type = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $auto_manual_board_car_model_year = '';
    if (isset($first_item['auto_manual_board_car_model_year'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_model_year']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_model_year = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    return [
        'title' => $title,
        'image' => $image,
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

$view_total_count = $board_row['board_view'] + 1;

?>
<section class="position1 width_box height_box">
    <div class="padding_px-x_010">
        <div class="width_px_720 margin_x_auto padding_px-y_050" data-xy="1-800: width_box">
            <div class="flex_ft font_px_015 manual_content_1">
                <div class="manual_title_1 font_px_025 flv6"><?php echo $post_data[0]['title']; ?></div>
            </div>
            <div class="padding_px-y_020">
                <div class="border_px-a_001 border_bre-a_005 padding_px-a_020" data-bd-a-color="#dfdfdf">
                    <div class="flex_xs1_yc">
                        <div class="flex_fl_yc">
                            <div class="flex_xc_yc width_px_025 height_px_025 border_bre-a_030" data-bg-color="#15376b">
                                <div class="width_px_015 height_px_015">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="#ffffff"
                                        width="100%" height="100%">
                                        <g>
                                            <g>
                                                <path d="M498.125,92.38l-78.505-78.506c-18.496-18.497-48.436-18.5-66.935,0C339.518,27.043,50.046,316.516,44.525,322.035
            c-2.182,2.182-3.725,4.918-4.46,7.915L0.502,491.068c-3.036,12.368,8.186,23.44,20.431,20.432
            c8.361-2.053,153.718-37.747,161.117-39.564c2.996-0.735,5.734-2.278,7.915-4.46c5.816-5.816,293.677-293.677,308.161-308.161
            C516.622,140.818,516.627,110.879,498.125,92.38z M39.957,472.043l1.612-6.562l4.951,4.951L39.957,472.043z M84.874,461.014
            l-33.887-33.887l14.736-60.009l79.16,79.16L84.874,461.014z M178.022,431.647l-97.668-97.668L332.559,81.773l97.668,97.668
            L178.022,431.647z M474.24,135.429l-19.508,19.507l-97.667-97.668l19.507-19.507c5.294-5.293,13.867-5.298,19.163,0l78.506,78.507
            C479.536,121.563,479.536,130.132,474.24,135.429z" />
                                            </g>
                                        </g>
                                    </svg>

                                </div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: flex_ft">
                                <span class="font_px_016 flv6 padding_px-l_015 padding_px-r_010"
                                    data-xy="1-800: font_px_014 padding_px-l_010 padding_px-r_000">정비 매뉴얼</span>
                                <span class="font_px_012 padding_px-l_000" data-color="#888888"
                                    data-xy="1-800: font_px_010 padding_px-l_010">셀프 정비 매뉴얼 읽어주세요!</span>
                            </div>
                        </div>
                        <div class="width_px_015 height_px_015 pointer rotate openguide">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g
                                    transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                    <path
                                        d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                        data-name="chevron-right-Bold" fill="#888888" opacity="1"
                                        data-original="#000000" class=""></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="flex_ft padding_px-x_010 font_px_016 guidebox overflow_hidden"
                        data-xy="1-800: font_px_012">
                        <div class="padding_px-t_020"></div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft padding_px-y_010 del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">정비 카테고리
                            </div>
                            <div>
                                <div><?php echo $post_info['manual_category']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">작업 인원
                            </div>
                            <div class="flex_fl_yc">
                                <div><?php echo $post_info['manual_worker']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">셀프정비소
                            </div>
                            <div class="flex_fl_yc">
                                <div><?php echo $post_info['manual_self_repair_shop']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">작업기간</div>
                            <div class="flex_fl_yc">
                                <div><?php echo $post_info['manual_worker_time']; ?></div>
                            </div>
                        </div>
                            <div class="flex_fl padding_px-y_015" data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">예산</div>
                            <div class="flex_ft">
                                <div class="flex_fl_yc padding_px-u_010" data-xy="1-800: flex_ft">
                                    <div class="width_px_060 padding_px-u_000" data-xy="1-800:  padding_px-u_010">부품
                                    </div>
                                    <div class="budget">
                                        <div><?php echo $post_info['manual_worker_budget_part']; ?>만 원</div>
                                    </div>
                                </div>
                                <div class="flex_fl_yc padding_px-u_010" data-xy="1-800: flex_ft">
                                    <div class="width_px_060 padding_px-u_000" data-xy="1-800:  padding_px-u_010">소모품
                                    </div>
                                    <div class="budget">
                                        <div><?php echo $post_info['manual_worker_budget_consumable']; ?>만 원</div>
                                    </div>
                                </div>
                                <div class="flex_fl_yc padding_px-u_010" data-xy="1-800: flex_ft">
                                    <div class="width_px_060 padding_px-u_000" data-xy="1-800:  padding_px-u_010">총예산
                                    </div>
                                    <div class="budget">
                                        <div><?php echo $post_info['manual_worker_budget_part'] + $post_info['manual_worker_budget_consumable']; ?>만 원</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">유형
                            </div>
                            <div class="flex_fl_yc">
                                    <div><?php echo $post_info['manual_worker_type']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">제조사</div>
                            <div>
                                <div><?php echo $post_info['manual_worker_brand']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">차종</div>
                            <div>
                                <div><?php echo $post_info['auto_manual_board_car_model']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">외형</div>
                            <div>
                                <div><?php echo $post_info['auto_manual_board_car_type']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">모델명</div>
                            <div class="flex_fl_yc">
                                <div><?php echo $post_info['manual_car_model_name']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">유종</div>
                            <div>
                                <div><?php echo $post_info['auto_manual_board_car_oil_type']; ?></div>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">연식</div>
                            <div>
                                <div><?php echo $post_info['auto_manual_board_car_model_year']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<style>
    .budget::after{
        display: none;
    }
</style>
            <div class="width_box height_auto">
                <img src="<?php echo DOMAIN . $post_data[0]['image']; ?>" class="manual_main_img width_box height_box"
                    style="object-fit: cover;">
            </div>

            <div class="flex_ft font_px_015 manual_content_1 padding_px-y_020">
                    <div class="manual_contents_1"><?php echo html_entity_decode($post_data[0]['content']); ?></div>
            </div>

            <script nonce="<?php echo NONCE; ?>">
                // Select all thumbnail images
                var thumbnails = document.querySelectorAll('[class*="manual_img_"]');
                // Select the main image
                var mainImage = document.querySelector('.manual_main_img');
                // Select all content divs
                var contentDivs = document.querySelectorAll('[class*="manual_content_"]');

                thumbnails.forEach(function (thumbnail) {
                    thumbnail.addEventListener('click', function () {
                        // Get the index from the class name
                        var classes = thumbnail.className.split(' ');
                        var indexClass = classes.find(function (cls) {
                            return cls.startsWith('manual_img_');
                        });
                        var index = indexClass.split('_').pop();

                        // Update the main image src
                        mainImage.src = thumbnail.src;

                        // Update the content divs
                        contentDivs.forEach(function (contentDiv) {
                            var contentClasses = contentDiv.className.split(' ');
                            var contentIndexClass = contentClasses.find(function (cls) {
                                return cls.startsWith('manual_content_');
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
            <script nonce="<?php echo NONCE; ?>">
                document.querySelectorAll('.openguide').forEach(function (button, index) {
                    var guidebox = document.querySelectorAll('.guidebox')[index];
                    var rotateIcon = document.querySelectorAll('.rotate')[index];
                    var isGuideboxVisible = true;

                    button.addEventListener('click', function () {
                        if (isGuideboxVisible) {
                            guidebox.style.maxHeight = '0';  // 높이 0으로 설정 (접기)
                            rotateIcon.classList.add('reverse');  // 아이콘 반대 방향 회전
                        } else {
                            guidebox.style.maxHeight = guidebox.scrollHeight + "px";  // 높이 설정 (펼치기)
                            rotateIcon.classList.remove('reverse');  // 원래 방향 회전
                        }
                        isGuideboxVisible = !isGuideboxVisible;  // 상태 반전
                    });
                });

               
            </script>
            <?php

            // SQL 쿼리 작성 (auto_like_status가 1인 갯수 조회)
            $query = "SELECT COUNT(*) as like_count 
          FROM egb_board_like 
          WHERE board_like_post_uniq_id = :post_uniq_id 
          AND board_like_status = 1";

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
          FROM egb_board_scrap 
          WHERE board_scrap_post_uniq_id = :post_uniq_id 
          AND board_scrap_status = 1";

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
                <span><?php echo $board_row['created_at']; ?></span>
                <span class="padding_px-x_003">·</span>
                <span>좋아요&nbsp;<span class="manual_side_heart_count"><?php echo number_format($like_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>스크랩&nbsp;<span class="manual_side_scrap_count"><?php echo number_format($scrap_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>조회&nbsp<span class="manual_view_total_count"><?php echo number_format($view_total_count); ?></span></span>
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
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    textarea {
        all: unset;
        font-size: 14px;
        font-family: fontstyle1;
        resize: none;
    }

    .comment_textarea {
        width: 90%;
        min-height: 50px;
        max-height: 300px;
        resize: none;
        overflow-y: auto;
        word-break: break-all;
    }


    .faketextarea:focus {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
        transition: 0.3s;
        border-color: #15376b;
    }

    .faketextarea.focused {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
        border-color: #15376b;
        transition: 0.3s;
    }

    textarea:focus {
        outline: none;
    }

    .numberhover:hover {
        background-color: #09addb;
        border-color: #09addb;
    }

    .rotate {
        transform: rotate(180deg);
        transition: 0.5s;
    }

    .rotate.reverse {
        transform: rotate(0deg);
        /* 반대 방향 회전 */
    }

    .guidebox {
        max-height: 9999px;
        /* 처음에 보이도록 */
        transition: max-height 0.5s ease-out;
    }

    select {
        box-sizing: border-box;
        background-color: transparent;
        outline: none;
    }

    input,
    textarea {
        all: unset;
        box-sizing: border-box;
    }

    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"],
    textarea {
        outline: none;
    }

    select:focus {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
    }

    input[type="checkbox"]:checked {
        display: block;
        width: 20px;
        height: 20px;
        border: 1px solid #202020;
        border-radius: 4px;
        background: url('<?php echo $background_url; ?>') no-repeat 0 0px / cover;
    }

    input[type="text"]:focus:not(.nothover),
    input[type="password"]:focus:not(.nothover) {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
        transition: 0.3s;
        z-index: 3;
    }

    [type="radio"] {
        appearance: none;
        border: 1px solid #000000;
        border-radius: 50%;
        position: relative;
    }

    [type="radio"]::before {
        content: '';
        display: block;
        width: 15px;
        height: 15px;
        background-color: transparent;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.2s ease-in-out;
    }

    [type="radio"]:checked {
        background-color: #ffffff;
        border-color: #202020;
    }

    [type="radio"]:checked::before {
        width: 8px;
        height: 8px;
        background-color: #202020;
    }

    .budget {
        position: relative;
    }

    .budget input {
        padding-right: 40px;
        /* 만 원이 보일 공간을 만듦 */
    }

    .budget:after {
        content: '만 원';
        /* "만 원"을 input 필드 끝에 추가 */
        position: absolute;
        right: 10px;
        /* input 끝에서 조금 띄워서 위치 설정 */
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #888888;
        pointer-events: none;
        /* "만 원" 텍스트가 선택되지 않도록 설정 */
    }

    .budget2 input {
        padding-right: 40px;
        /* 만 원이 보일 공간을 만듦 */
    }

    .budget2:after {
        content: '0/80';
        /* "만 원"을 input 필드 끝에 추가 */
        position: absolute;
        right: 10px;
        /* input 끝에서 조금 띄워서 위치 설정 */
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #888888;
        pointer-events: none;
        /* "만 원" 텍스트가 선택되지 않도록 설정 */
    }
</style>
<?php
auto_comment('egb_comment_manual', $uniq_id, $auto_board_user_uniq_id); 
auto_floating('egb_board_manual', $uniq_id, 'manual');

 //조회수 1증가
 $query = "UPDATE egb_board_manual SET board_view = board_view + 1 WHERE uniq_id = :uniq_id";
 $params = [':uniq_id' => $uniq_id];
 $binding = binding_sql(1, $query, $params);
 $sql = egb_sql($binding);
?>