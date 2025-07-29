<?php
$uniq_id = egb('uniq_id', 69);

if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    $user_login = 'user';
}

if (isset($user_login)) {
    $login_user_uniq_id = $_SESSION['user_uniq_id'];
} else {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/instagram_board_preview/?uniq_id=' . $uniq_id . "'; </script>";
    exit;
}


// 게시물 데이터를 조회하는 쿼리
$query_post = "
    SELECT * FROM egb_board_instagram 
    WHERE uniq_id = :uniq_id
";
$params_post = [
    ':uniq_id' => $uniq_id
];
$binding_post = binding_sql(1, $query_post, $params_post);
$sql_post = egb_sql($binding_post);


// 결과 확인
if (!isset($sql_post[0]['uniq_id'])) {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/instagram_board_list' . "'; </script>";
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

$user_name = isset($sql_user[0]['user_name']) ? $sql_user[0]['user_name'] : 'Unknown';
$user_uniq_id = $board_row['board_user_uniq_id'];

// 첫 번째 배열의 타이틀과 이미지를 출력하는 함수
function print_first_array_title_and_image($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // 첫 번째 배열의 타이틀과 이미지 출력
                $title = isset($value['title']) ? htmlspecialchars($value['title']) : 'No Title';
                $image = isset($value['image']) ? htmlspecialchars($value['image']) : '/egb_thumbnail.webp'; // 기본 이미지 설정
                return ['title' => $title, 'image' => $image];
            }
        }
    }
    return ['title' => 'No Title', 'image' => '/egb_thumbnail.webp']; // 기본값
}

$view_total_count = $board_row['board_view'] + 1;
?>
<section class="position1 width_box height_box">
    <div class="padding_px-x_010">
        <div class="width_px_720 margin_x_auto padding_px-t_050" data-xy="1-800: width_box">
            <div class="width_box height_auto">
                <img src="<?php echo DOMAIN . $post_data[0]['image']; ?>"
                    class="instagram_main_img width_px_720 height_px_511" style="object-fit: cover;">
            </div>
            <div class="width_box scrolls overflow_hidden padding_px-y_030" data-xy="1-800: padding_px-y_010">
                <div class="flex_fl_yc">
                    <?php
                    foreach ($post_data as $index => $item) {
                        $image = isset($item['image']) ? htmlspecialchars($item['image']) : '/egb_thumbnail.webp';
                        ?>
                        <div class="margin_px-r_010 border_bre-a_032 width_px_100 height_px_100 border_px-a_001 overflow_hidden more"
                            data-bd-a-color="#00000014" data-xy="1-800: border_bre-a_010 width_px_070 height_px_070">
                            <img src="<?php echo DOMAIN . $image; ?>"
                                class="instagram_img_<?php echo $index; ?> width_box height_box"
                                style="object-fit: cover; object-position: 50% 50%; width: 100%; height: 100%;">

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            foreach ($post_data as $index => $item) {
                $title = isset($item['title']) ? htmlspecialchars($item['title']) : 'No Title';
                $contents = isset($item['content']) ? htmlspecialchars($item['content']) : 'No Contents';

                // 첫 번째 항목만 기본적으로 표시, 나머지는 숨김 (display_off 클래스 추가)
                $display_class = $index === 0 ? '' : 'display_off';
                ?>
                <div class="flex_ft font_px_015 instagram_content_<?php echo $index; ?> <?php echo $display_class; ?>">
                    <div class="instagram_title_<?php echo $index; ?> flv6 padding_px-u_010"><?php echo $title; ?></div>
                    <div class="instagram_contents_<?php echo $index; ?>"><?php echo nl2br($contents); ?></div>
                </div>
                <?php
            }
            ?>
            <script nonce="<?php echo NONCE; ?>">
                // Select all thumbnail images
                var thumbnails = document.querySelectorAll('[class*="instagram_img_"]');
                // Select the main image
                var mainImage = document.querySelector('.instagram_main_img');
                // Select all content divs
                var contentDivs = document.querySelectorAll('[class*="instagram_content_"]');

                thumbnails.forEach(function (thumbnail) {
                    thumbnail.addEventListener('click', function () {
                        // Get the index from the class name
                        var classes = thumbnail.className.split(' ');
                        var indexClass = classes.find(function (cls) {
                            return cls.startsWith('instagram_img_');
                        });
                        var index = indexClass.split('_').pop();

                        // Update the main image src
                        mainImage.src = thumbnail.src;

                        // Update the content divs
                        contentDivs.forEach(function (contentDiv) {
                            var contentClasses = contentDiv.className.split(' ');
                            var contentIndexClass = contentClasses.find(function (cls) {
                                return cls.startsWith('instagram_content_');
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
            // 좋아요 수 조회
            $query = "SELECT COUNT(*) as like_count 
                     FROM egb_like_log 
                     WHERE like_target_table = 'egb_board_instagram'
                     AND like_target_uniq_id = :post_uniq_id 
                     AND like_type = 1
                     AND is_status = 1";

            $params = [':post_uniq_id' => $uniq_id];
            $binding = binding_sql(1, $query, $params);
            $sql = egb_sql($binding);
            $like_count = isset($sql[0]['like_count']) ? $sql[0]['like_count'] : 0;

            // 스크랩 수 조회  
            $query = "SELECT COUNT(*) as scrap_count 
                     FROM egb_scrap_log
                     WHERE scrap_target_table = 'egb_board_instagram'
                     AND scrap_target_uniq_id = :post_uniq_id
                     AND is_status = 1";

            $params = [':post_uniq_id' => $uniq_id];
            $binding = binding_sql(1, $query, $params);
            $sql = egb_sql($binding);
            $scrap_count = isset($sql[0]['scrap_count']) ? $sql[0]['scrap_count'] : 0;

            // 댓글 수 조회
            $query = "SELECT COUNT(*) as comment_count 
                     FROM egb_comment_instagram 
                     WHERE egb_comment_post_uniq_id = :post_uniq_id 
                     AND egb_comment_status = 1";

            $params = [':post_uniq_id' => $uniq_id];
            $binding = binding_sql(1, $query, $params);
            $sql = egb_sql($binding);
            $comment_count = isset($sql[0]['comment_count']) ? $sql[0]['comment_count'] : 0;

            // 공유 수 조회
            $query = "SELECT COUNT(*) as share_count 
                     FROM egb_share_log
                     WHERE share_target_table = 'egb_board_instagram'
                     AND share_target_uniq_id = :post_uniq_id
                     AND share_type = 1 
                     AND is_status = 1";

            $params = [':post_uniq_id' => $uniq_id];
            $binding = binding_sql(1, $query, $params);
            $sql = egb_sql($binding);
            $share_count = isset($sql[0]['share_count']) ? $sql[0]['share_count'] : 0;
            ?>
            <div class="flex_fl_yc_wrap padding_px-y_030 font_px_013" data-color="#828c94">
                <span><?php echo isset($board_row['created_at']) ? $board_row['created_at'] : ''; ?></span>
                <span class="padding_px-x_003">·</span>
                <span>좋아요&nbsp;<span class="instagram_side_heart_count"><?php echo number_format($like_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>스크랩&nbsp;<span class="instagram_side_scrap_count"><?php echo number_format($scrap_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>조회&nbsp<span class="instagram_view_total_count"><?php echo number_format($view_total_count); ?></span></span>
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
            <div class="grid_xx padding_px-t_030" data-xx="25% 25% 25% 25%"
                data-xy="1-800: xx-50per~50per">
                <?php
            // 현재 페이지를 제외한 최근 게시물을 가져오는 쿼리
            $query_post = "
            SELECT * FROM egb_board_instagram 
            WHERE board_user_uniq_id = :uniq_id
            AND uniq_id != :current_uniq_id
            ORDER BY created_at DESC
            LIMIT 4
        ";

                // 파라미터 바인딩
                $params_post = [
                    ':uniq_id' => $user_uniq_id,
                    ':current_uniq_id' => $uniq_id
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
                        $posts_data = json_decode($post['board_data'], true);

                        // 첫 번째 이미지 출력
                        if (!empty($posts_data) && isset($posts_data[0])) {
                            $image = isset($posts_data[0]['image']) ? htmlspecialchars($posts_data[0]['image']) : '/img/default_image.webp';
                            ?>
                            <a class="padding_px-a_010"
                                    href="<?php echo DOMAIN . '/page/instagram_board_view/?uniq_id=' . $post['uniq_id']; ?>">
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
                        <a class="padding_px-a_010" href="<?php echo DOMAIN . '/page/instagram_board_plus_view'; ?>">
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
                    echo "해당 사용자의 게시물을 찾을 수 없습니다.";
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

 auto_comment('egb_comment_instagram', $uniq_id, $auto_board_user_uniq_id); 
 auto_floating('egb_board_instagram', $uniq_id, 'instagram');

 //조회수 1증가
 $query = "UPDATE egb_board_instagram SET board_view = board_view + 1 WHERE uniq_id = :uniq_id";
 $params = [':uniq_id' => $uniq_id];
 $binding = binding_sql(1, $query, $params);
 $sql = egb_sql($binding);

?>