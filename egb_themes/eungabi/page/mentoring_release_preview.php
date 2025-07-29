
<?php
$uniq_id = egb('uniq_id', 69);
$login_user_uniq_id = $_SESSION['user_uniq_id'] ?? null;
$is_admin = isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1;

// 로그인한 경우 view 페이지로 리다이렉트
if ($login_user_uniq_id) {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/mentoring_release_view/?uniq_id=' . $uniq_id . "'; </script>";
    exit;
}

// 게시물 데이터를 조회하는 쿼리
$query_post = "SELECT p.*, u.user_mentor_id 
               FROM egb_board_mentoring_release p
               LEFT JOIN egb_user u ON p.board_user_uniq_id = u.uniq_id
               WHERE p.uniq_id = :uniq_id";
$params_post = [':uniq_id' => $uniq_id];
$binding_post = binding_sql(1, $query_post, $params_post);
$sql_post = egb_sql($binding_post);

// 결과 확인
if (!isset($sql_post[0]['uniq_id'])) {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/mentoring_release_list' . "'; </script>";
    exit;
}

$board_row = $sql_post[0];
$user_uniq_id = $board_row['board_user_uniq_id'];

// 유저 정보 가져오기
$query_user = "SELECT user_name, user_nick_name FROM egb_user WHERE uniq_id = :uniq_id";
$params_user = [':uniq_id' => $user_uniq_id];
$binding_user = binding_sql(1, $query_user, $params_user);
$sql_user = egb_sql($binding_user);

$user_nick_name = isset($sql_user[0]['user_nick_name']) ? $sql_user[0]['user_nick_name'] : 'Unknown';

$view_total_count = $board_row['board_view'];

// 좋아요 수 조회
$query = "SELECT COUNT(*) as like_count 
         FROM egb_like_log 
         WHERE like_target_table = 'egb_board_mentoring_release'
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
         WHERE scrap_target_table = 'egb_board_mentoring_release'
         AND scrap_target_uniq_id = :post_uniq_id
         AND is_status = 1";

$params = [':post_uniq_id' => $uniq_id];
$binding = binding_sql(1, $query, $params);
$sql = egb_sql($binding);
$scrap_count = isset($sql[0]['scrap_count']) ? $sql[0]['scrap_count'] : 0;
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
                        <div class="flv6">로그인 후 이용해주세요.</div>
                        <div class="flex_xc padding_px-t_020">
                            <a href="<?php echo DOMAIN . '/page/login' ?>">
                                <div class="border_bre-a_005 border_px-a_001 pointer padding_px-x_030 padding_px-y_010 font_px_018 loginbutton"
                                    data-bg-color="#15376b" data-bd-a-color="#15376b" data-color="#ffffff">로그인하러 가기
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex_fl_yc_wrap padding_px-y_030 font_px_013" data-color="#828c94">
                <span><?php echo $board_row['created_at']; ?></span>
                <span class="padding_px-x_003">·</span>
                <span>좋아요&nbsp;<span class="mentoring_release_side_heart_count"><?php echo number_format($like_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>스크랩&nbsp;<span class="mentoring_release_side_scrap_count"><?php echo number_format($scrap_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>조회&nbsp<span class="mentoring_release_view_total_count"><?php echo number_format($view_total_count); ?></span></span>
            </div>
            <div class="flex_xs1_yc">
                <div class="flex_fl_yc font_px_011">
                    <div class="flex_yc padding_px-r_010">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                            class="width_px_040 height_px_040 border_bre-a_035">
                    </div>
                    <div class="flex_ft">
                        <div class="flex_yc font_px_014 flv6"><?php echo $user_nick_name; ?></div>
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
auto_comment('egb_board_mentoring_release', $uniq_id, $user_uniq_id); 
auto_floating('egb_board_mentoring_release', $uniq_id, 'mentoring_release'); 
?>