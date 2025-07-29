<?php

if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    echo "<script nonce='" . NONCE . "'>window.location.href = '" . DOMAIN . "';</script>";
    exit;
}

?>
<section class="position1 width_box height_vh_1080 flex_xc_yc" data-bg-color="#fafafa">
    <div class="width_px_300 margin_x_auto font_px_015">
        <div class="flex_xc_yc padding_px-u_030">
            <a class="pointer" href="<?php echo DOMAIN; ?>"><img class="width_px_150 height_px_060"
                    src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.webp'; ?>"></a>
        </div>
        <form id="login_input" class="flex_ft_xc_yc" method="post" action="<?php echo DOMAIN . "/?post=login_input"; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="position1 width_px_300 height_px_049">
                <div class="position2 width_px_300 height_px_050 flex_" data-top="0%">
                    <input name="user_id"
                        class="position1 z-index_1 width_px_300 border_px-a_001 border_bre-tx_004 height_px_050 fontstyle1 font_px_015 padding_px-x_015"
                        type="text" placeholder="아이디" data-bd-a-color="#dbdbdb" data-bg-color="#ffffff" required>
                </div>
                <div class="position2 width_px_300 height_px_050 flex_" data-bottom="-100%">
                    <input name="user_password"
                        class="position1 z-index_1 width_px_300 border_px-a_001 border_bre-ux_004 height_px_050 fontstyle1 font_px_015 padding_px-x_015"
                        type="password" placeholder="비밀번호" data-bd-a-color="#dbdbdb" data-bg-color="#ffffff" required>
                </div>
            </div>
            <div class="padding_px-t_060 flex_fl_yc width_box">
                <input class="pointer border_px-a_001 border_bre-a_004 width_px_015 height_px_015"
                    data-bd-a-color="#ebebeb" data-bg-color="#ffffff" id="saveid" type="checkbox"><label
                    class="pointer padding_px-l_005" for="saveid" data-color="#424242">아이디
                    저장</label>
            </div>
            <div class="padding_px-y_015">
                <div class="egb_submit flex_xc_yc check border_px-a_000 width_px_300 height_px_050 margin_x_auto font_px_017 flv6 fontstyle1 font_style_center border_bre-a_004 pointer"
                    data-color="#ffffff" data-bg-color="#202020" data-bd-a-color="#202020">로그인
                </div>
            </div>
        </form>
        <div class="flex_xs1_yc padding_px-u_015" data-color="#636363">
            <div class="flex_xs1_yc font_px_013">
                <div class="flex_xc">
                    <a class="pointer" href="<?php echo DOMAIN . '/page/find_id'; ?>">아이디
                        찾기</a>
                </div>
                <div class="padding_px-x_005">｜</div>
                <div class="flex_xc">
                    <a class="pointer" href="<?php echo DOMAIN . '/page/find_pw'; ?>">비밀번호
                        찾기</a>
                </div>
            </div>
            <div>
                <div class="flex_xc" data-color="#424242"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/signup'; ?>">회원가입</a></div>
            </div>
        </div>
    </div>
</section>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"] {
        outline: none;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
        transition: 0.3s;
        z-index: 3;
    }

    input {
        all: unset;
        box-sizing: border-box;
    }

    input[type="checkbox"]:checked {
        display: block;
        border: 1px solid #202020;
        border-radius: 4px;
        background: url('<?php echo $background_url; ?>') no-repeat 0 0px / cover;
    }

    .check:hover {
        background-color: #15376b;
    }
</style>