<?php

function auto_floating($target_table, $target_uniq_id, $page)
{

    $login_user_uniq_id = $_SESSION['user_uniq_id'] ?? null;

    ?>
        <?php
    // 좋아요 로그 테이블에서 좋아요 수 조회
    $query = "SELECT COUNT(*) as like_count 
          FROM egb_like_log 
          WHERE like_target_table = :target_table
          AND like_target_uniq_id = :target_uniq_id 
          AND like_type = 1
          AND is_status = 1";

    // 바인딩할 파라미터 설정  
    $params = [
        ':target_table' => $target_table,
        ':target_uniq_id' => $target_uniq_id
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
    // 스크랩 로그 테이블에서 스크랩 수 조회
    $query = "SELECT COUNT(*) as scrap_count 
          FROM egb_scrap_log 
          WHERE scrap_target_table = :target_table
          AND scrap_target_uniq_id = :target_uniq_id 
          AND scrap_type = 1
          AND is_status = 1";

    // 바인딩할 파라미터 설정
    $params = [
        ':target_table' => $target_table,
        ':target_uniq_id' => $target_uniq_id
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
    <?php
    // 댓글 수 조회
    $query = "SELECT COUNT(*) as comment_count 
          FROM egb_comment_{$page}
          WHERE comment_board_uniq_id = :target_uniq_id
          AND is_status = 1";

    // 바인딩할 파라미터 설정
    $params = [
        ':target_uniq_id' => $target_uniq_id
    ];

    // 바인딩 쿼리 생성 
    $binding = binding_sql(1, $query, $params);

    // 쿼리 실행
    $sql = egb_sql($binding);

    // 결과 확인 및 출력
    if (isset($sql[0]['comment_count'])) {
        $comment_count = $sql[0]['comment_count'];
    } else {
        $comment_count = 0;
    }
    ?>
    <?php

    // SQL 쿼리 작성 (공유 수 조회)
    $query = "SELECT COUNT(*) as share_count 
          FROM egb_share_log 
          WHERE share_target_table = :target_table
          AND share_target_uniq_id = :target_uniq_id 
          AND share_type = 1
          AND is_status = 1";

    // 바인딩할 파라미터 설정
    $params = [
        ':target_table' => $target_table,
        ':target_uniq_id' => $target_uniq_id
    ];

    // 바인딩 쿼리 생성
    $binding = binding_sql(1, $query, $params);

    // 쿼리 실행
    $sql = egb_sql($binding);

    // 결과 확인 및 출력
    if (isset($sql[0]['share_count'])) {
        $share_count = $sql[0]['share_count'];
    } else {
        $share_count = 0;
    }
    ?>

    <div class="position3 z-index_4" data-top="25%" data-right="7%" data-xy="1-800: flex_fl_yc width_box bottom-0per del-right-7per del-top-25per bg-color-ffffff">
        <div class="flex_ft" data-xy="1-800: min_width_200 grid_xx xx-25per~25per~25per~25per bg-color-ffffff">

            <?php
            if ($login_user_uniq_id) {
                $user_login_check = 'div';
                $user_login_check_close = 'div';
            } else {
                $user_login_check = 'a href="' . DOMAIN . '/page/login' . '" ';
                $user_login_check_close = 'a';
            }
            ?>

            <form id="heart_form" method="post" action="<?php echo DOMAIN . '/?post=side_heart_input'; ?>" class="padding_pe-u_015" data-xy="1-800: flex_ft_xc_yc padding_pe-a_010 del-padding_pe-u_015">
                <div class="<?php echo $page; ?>_side_heart_box width_px_060 height_px_060 border_bre-a_060 border_px-a_001 flex_xc_yc pointer floating box_shadow_1 egb_submit"
                    data-bd-a-color="#c2c8cc" data-bg-color="#ffffff"
                    data-xy="1-800: border_px-a_000 border_bre-a_000 del-width_px_060 del-height_px_060 del-bg-color-ffffff del-bd-a-color-#c2c8cc del-box_shadow_1">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="like_target_table" value="<?php echo $target_table; ?>">
                    <input type="hidden" name="like_target_uniq_id" value="<?php echo $target_uniq_id; ?>">
                    <input type="hidden" name="like_user_uniq_id" value="<?php echo $login_user_uniq_id; ?>">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">

                    <?php
                    $post_uniq_id = $target_uniq_id;
                    $query = "SELECT COUNT(*) as like_count 
                             FROM egb_like_log 
                             WHERE like_target_table = :target_table
                             AND like_target_uniq_id = :target_uniq_id 
                             AND like_user_uniq_id = :user_uniq_id
                             AND like_type = 1
                             AND is_status = 1";

                    $params = [
                        ':target_table' => $target_table,
                        ':target_uniq_id' => $post_uniq_id,
                        ':user_uniq_id' => $login_user_uniq_id
                    ];

                    $binding = binding_sql(1, $query, $params);
                    $sql = egb_sql($binding);

                    if (isset($sql[0]['like_count']) && $sql[0]['like_count'] > 0) {
                        echo '
<svg class="' . $page . '_side_heart_check width_px_025 height_px_025" xmlns="http://www.w3.org/2000/svg" id="Layer_1" height="512" viewBox="0 0 512 512" width="512" data-name="Layer_1">
  <g transform="translate(256, 256) rotate(1) translate(-256, -256)">
    <path fill="#15376b" d="M256 436a54.62 54.62 0 0 1-29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1-29.53 8.68z"/>
  </g>
</svg>
	';
                    } else {
                        echo '<svg class="' . $page . '_side_heart width_px_025 height_px_025" xmlns="http://www.w3.org/2000/svg" id="Layer_1" height="512" viewBox="0 0 512 512" width="512" data-name="Layer_1"><path d="m256 436a54.62 54.62 0 0 1 -29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1 -29.53 8.68zm-101.84-334.94a89.41 89.41 0 0 0 -23.42 3.1 90.93 90.93 0 0 0 -48.15 32.44c-13.14 17.22-20.09 39-20.09 63 0 35.52 22.81 76.12 67.81 120.68 39 38.66 85.47 70.5 109.67 86a29.72 29.72 0 0 0 32 0c24.2-15.54 70.63-47.38 109.67-86 45-44.56 67.81-85.16 67.81-120.68 0-24-6.95-45.74-20.09-63a90.93 90.93 0 0 0 -48.15-32.44c-34.17-9.28-82.18.42-114.48 55.48a12.49 12.49 0 0 1 -21.56 0c-25.38-43.34-60.54-58.58-91.02-58.58z"/></svg>';
                    }
                    ?>
                </div>
                <div class="<?php echo $page; ?>_side_heart_count flex_xc font_px_014" data-color="#888888">
                    <?php echo $like_count; ?>
                </div>
            </form>

            <form id="scrap_form" method="post" action="<?php echo DOMAIN . '/?post=side_scrap_input'; ?>" class="padding_pe-u_015" data-xy="1-800: flex_ft_xc_yc padding_pe-a_010 del-padding_pe-u_015">
                <div class="<?php echo $page; ?>_side_scrap_box width_px_060 height_px_060 border_bre-a_060 border_px-a_001 flex_xc_yc pointer floating box_shadow_1 egb_submit"
                    data-bd-a-color="#c2c8cc" data-bg-color="#ffffff"
                    data-xy="1-800: border_px-a_000 border_bre-a_000 del-width_px_060 del-height_px_060 del-bg-color-ffffff del-bd-a-color-#c2c8cc del-box_shadow_1">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="scrap_target_table" value="<?php echo $target_table; ?>">
                    <input type="hidden" name="scrap_target_uniq_id" value="<?php echo $target_uniq_id; ?>">
                    <input type="hidden" name="scrap_user_uniq_id" value="<?php echo $login_user_uniq_id; ?>">
                    <input type="hidden" name="scrap_type" value="1">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">

                    <?php
                    $post_uniq_id = $target_uniq_id;
                    $query = "SELECT COUNT(*) as scrap_count 
                             FROM egb_scrap_log 
                             WHERE scrap_target_table = :target_table
                             AND scrap_target_uniq_id = :target_uniq_id 
                             AND scrap_user_uniq_id = :user_uniq_id
                             AND scrap_type = 1
                             AND is_status = 1";

                    $params = [
                        ':target_table' => $target_table,
                        ':target_uniq_id' => $post_uniq_id,
                        ':user_uniq_id' => $login_user_uniq_id
                    ];

                    $binding = binding_sql(1, $query, $params);
                    $sql = egb_sql($binding);

                    if (isset($sql[0]['scrap_count']) && $sql[0]['scrap_count'] > 0) {
                        echo '
<svg class="' . $page . '_side_scrap_check width_px_025 height_px_020" xmlns="http://www.w3.org/2000/svg" height="512" viewBox="0 0 100 100" width="512">
  <g id="Layer_50" data-name="Layer_50">
    <path d="M90.59766 2.28174H9.40234a2 2 0 0 0-2 2v90.71826a2 2 0 0 0 3.00391 1.73l39.59375-22.97414 39.59375 22.97414a2 2 0 0 0 3.00391-1.73V4.28174a2 2 0 0 0-2-2z" fill="#15376b"/>
    <path d="M88.59766 91.52734l-37.59375-21.814a2 2 0 0 0-2.00782 0L11.40234 91.52734V6.28174h77.19532z" fill="#15376b"/>
  </g>
</svg>
	';
                    } else {
                        echo '
	<svg class="' . $page . '_side_scrap width_px_025 height_px_020" xmlns="http://www.w3.org/2000/svg" height="512" viewBox="0 0 100 100" width="512"><g id="Layer_50" data-name="Layer_50"><path d="m90.59766 2.28174h-81.19532a2.0001 2.0001 0 0 0 -2 2v90.71826a2.0004 2.0004 0 0 0 3.00391 1.73l39.59375-22.97414 39.59375 22.97414a2.0004 2.0004 0 0 0 3.00391-1.73v-90.71826a2.0001 2.0001 0 0 0 -2-2zm-2 89.2456-37.59375-21.814a2.00123 2.00123 0 0 0 -2.00782 0l-37.59375 21.814v-85.2456h77.19532z"/></g></svg>
	';
                    }
                    ?>
                </div>
                <div class="<?php echo $page; ?>_side_scrap_count flex_xc font_px_014" data-color="#888888">
                    <?php echo $scrap_count; ?>
                </div>
            </form>

            <div class="padding_pe-u_015" data-xy="1-800: flex_ft_xc_yc padding_pe-a_010 del-padding_pe-u_015">
                <div class="width_px_060 height_px_060 border_bre-a_060 border_px-a_001 flex_xc_yc pointer floating2 egb_submit"
                    data-bd-a-color="#f7f9fa" data-bg-color="#f7f9fa"
                    data-xy="1-800: border_px-a_000 border_bre-a_000 del-width_px_060 del-height_px_060 del-bg-color-f7f9fa del-bd-a-color-#f7f9fa">
                    <img class="width_px_025 height_px_020"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/talk.svg'; ?>">
                </div>
                <div class="<?php echo $page; ?>_side_commnet_count flex_xc font_px_014" data-color="#888888">
                    <?php echo $comment_count; ?>
                </div>
            </div>

            <form id="share_form" method="post" action="<?php echo DOMAIN . '/?post=side_share_input'; ?>" class="<?php echo $page; ?>_side_share_box padding_pe-u_015"
                data-xy="1-800: flex_ft_xc_yc padding_pe-a_010 del-padding_pe-u_015">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="share_target_table" value="<?php echo $target_table; ?>">
                <input type="hidden" name="share_target_uniq_id" value="<?php echo $target_uniq_id; ?>">
                <input type="hidden" name="share_user_uniq_id" value="<?php echo $login_user_uniq_id; ?>">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <input type="hidden" name="share_url" value="<?php echo URL; ?>">
                <div class="width_px_060 height_px_060 border_bre-a_060 border_px-a_001 flex_xc_yc pointer floating2 egb_submit"
                    data-bd-a-color="#f7f9fa" data-bg-color="#f7f9fa"
                    data-xy="1-800: border_px-a_000 border_bre-a_000 del-width_px_060 del-height_px_060 del-bg-color-f7f9fa del-bd-a-color-#f7f9fa">
                    <img class="width_px_025 height_px_020"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/share.svg'; ?>">
                </div>
                <div class="<?php echo $page; ?>_side_share_count flex_xc font_px_014" data-color="#888888">
                    <?php echo $share_count; ?>
                </div>
            </form>
        </div>
        <div class="display_none" data-xy="1-800: width_box del-display_none" data-bg-color="#ffffff">
            <div class="width_box padding_pe-a_010 font_px_016" data-xy="1-500: font_px_012">
                <div class="flex_xc_yc width_box padding_pe-y_010 border_bre-a_005" data-color="#ffffff"
                    data-bg-color="#15376b">상품 모아보기</div>
            </div>
        </div>
    </div>
    <style>
        .floating:hover {
            border-color: #a4acb3;
            transition: 0.3s;
        }

        .floating2:hover {
            background-color: #eaedef;
            transition: 0.3s;
        }

        .box_shadow_1 {
            box-shadow: rgba(63, 71, 77, 0.15) 0px 2px 6px;
        }
    </style>
    <section id="scrap_msg_box1" class="position3 width_box flex_xc display_off z-index_9999" data-bottom="5%"
        data-left="50%" style="transform: translateX(-50%)">
        <div class="width_px_480 padding_pe-x_010" data-xy="1-480: width_box">
            <div class="width_px_460 flex_xs1_yc padding_pe-a_015 border_px-a_001 border_bre-a_005 font_px_014 flv6"
                data-xy="1-480: width_box" data-color="#ffffff" data-bd-a-color="#ffffff" data-bg-color="#444444ef">
                <div>스크랩을 했습니다.</div>
                <a href="<?php echo DOMAIN . '/page/user_collections/?uniq_id=' . $login_user_uniq_id; ?>">
                    <div class="pointer" data-xy="1-480: display_none" data-color="#efefef">스크랩북 보기</div>
                </a>
            </div>
        </div>
    </section>
    <section id="scrap_msg_box2" class="position3 width_box flex_xc display_off z-index_9999" data-bottom="5%"
        data-left="50%" style="transform: translateX(-50%)">
        <div class="width_px_480 padding_pe-x_010" data-xy="1-480: width_box">
            <div class="width_px_460 flex_xs1_yc padding_pe-a_015 border_px-a_001 border_bre-a_005 font_px_014 flv6"
                data-xy="1-480: width_box" data-color="#ffffff" data-bd-a-color="#ffffff" data-bg-color="#444444ef">
                <div>스크랩을 취소 했습니다.</div>
            </div>
        </div>
    </section>
    <section id="share_msg_box1" class="position3 width_box flex_xc display_off z-index_9999" data-bottom="5%"
        data-left="50%" style="transform: translateX(-50%)">
        <div class="width_px_480 padding_pe-x_010" data-xy="1-480: width_box">
            <div class="width_px_460 flex_xs1_yc padding_pe-a_015 border_px-a_001 border_bre-a_005 font_px_014 flv6"
                data-xy="1-480: width_box" data-color="#ffffff" data-bd-a-color="#ffffff" data-bg-color="#444444ef">
                <div>클립보드에 복사 되었습니다.</div>
            </div>
        </div>
    </section>
    <?php

}

?>