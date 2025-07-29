<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_management_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box  padding_px-u_020, 801-1200: flex_xs1_yc  padding_px-u_020">
                <div class="font_px_020 flv6">회원가입 승인설정</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">회원가입설정</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <?php
                // 옵션 그룹 조회
                $tree = egb_option_flat('community_user_grade');

                // 등급이 없는 경우 메시지 표시
                if (empty($tree)) {
                    ?>
                    <div class="flex_fl_yc width_box padding_px-a_020" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                        <div class="width_box text_align_center padding_px-y_020">
                            등록된 커뮤니티 회원 등급이 없습니다. 커뮤니티 회원 등급을 먼저 등록해주세요.
                        </div>
                    </div>
                    <?php
                } else {
                    // 등급 정보가 있는 경우 동적으로 표시
                    foreach ($tree as $grade) {
                        $grade_id = $grade['uniq_id'];
                        $grade_name = $grade['label'];
                        $option_is_active = $grade['option_is_active'];
                        $input_name = "crm_member_management_member_level_" . $grade_id;
                        ?>
                        <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                            <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                                data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                                data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010"><?php echo htmlspecialchars($grade_name); ?></div>
                            <div class="flex_ft border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                                data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                                data-xy="1-800: width_box flex_yc padding_px-y_010">
                                <form id="grade_approval_form_<?php echo $grade_id; ?>" action="<?php echo DOMAIN . '/?post=egb_grade_approval_form_input'; ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                                    <input type="hidden" name="grade_uniq_id" value="<?php echo $grade_id; ?>">
                                    <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                        <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="option_is_active" value="1"
                                            id="<?php echo $input_name; ?>_limit_off"
                                            data-xy="1-800: width_px_016 height_px_016" <?php echo ($option_is_active == 1) ? 'checked' : ''; ?>>
                                        <label class="padding_px-l_005 padding_px-r_010"
                                            for="<?php echo $input_name; ?>_limit_off">제한 안함</label>
                                    </div>
                                    <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                        <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="option_is_active" value="0"
                                            id="<?php echo $input_name; ?>_limit_no"
                                            data-xy="1-800: width_px_016 height_px_016" <?php echo ($option_is_active == 0) ? 'checked' : ''; ?>>
                                        <label class="padding_px-l_005 padding_px-r_010"
                                            for="<?php echo $input_name; ?>_limit_no">제한</label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">회원가입 연령설정</div>
            <?php
                 // 옵션 그룹 정보 조회
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_age_limit_setting' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $age_limit_enabled = $result[0]['group_required'];
                $min_age = $result[0]['group_description'];

            ?>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">가입연령 제한 설정</div>
                    <div class="flex_fl border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box flex_yc padding_px-y_010">
                        <div class="flex_fl_yc">
                            <form id="age_limit_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                            <input type="hidden" name="group_code" value="user_age_limit_setting">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required"
                                        id="crm_member_management_age_limit_off" value="1" data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($age_limit_enabled) ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_age_limit_off">제한 안함</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required"
                                        id="crm_member_management_age_limit_on" value="0" data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo (!$age_limit_enabled) ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_age_limit_on">제한</label>
                                </div>
                            </form>
                            <form id="min_age_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                                <input type="hidden" name="group_code" value="user_age_limit_setting">
                                <div class="flex_fl_yc padding_px-x_010 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <label class="padding_px-r_010" for="min_age_input">최소 연령:</label>
                                    <input class="width_px_060 height_px_030 border_px-a_001 padding_px-x_005 text_change_submit" data-bd-a-color="#888888"
                                        type="text" name="group_description" id="min_age_input" value="<?php echo $min_age; ?>" min="1" max="100">
                                    <span class="padding_px-l_005">세</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">간편 로그인 기본설정</div>
            <?php
                 // 옵션 그룹 정보 조회
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'easy_login_default_setting' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $easy_login_enabled = $result[0]['group_required'];

            ?>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">본인인증 제외설정</div>
                    <div class="flex_fl border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box flex_ft padding_px-y_010">
                        <div class="font_px_014 padding_px-t_005 padding_px-r_010"
                            data-xy="1-800: flex_xc font_px_012 padding_px-r_000">간편 로그인으로 회원가입 시 본인인증 절차</div>
                        <div class="flex_ft" data-xy="1-800: flex_fl width_box">
                            <form id="easy_login_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                                <input type="hidden" name="group_code" value="easy_login_default_setting">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required"
                                        id="crm_member_management_certification_on" value="1"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($easy_login_enabled) ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_certification_on">사용함</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required"
                                        id="crm_member_management_certification_off" value="0"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo (!$easy_login_enabled) ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_certification_off">제외함</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                // 옵션 그룹 정보 조회
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 're_join_setting' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $rejoin_enabled = $result[0]['group_required'];
                $rejoin_days = $result[0]['group_description'];
                $rejoin_enabled = $rejoin_enabled ? 'checked' : '';
                $rejoin_days = $rejoin_days ? $rejoin_days : 7;
            ?>
            <div class="font_px_020 flv6 padding_px-y_020">탈퇴/재가입 설정</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">재가입 기간제한</div>
                    <div class="flex_fl border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box flex_yc padding_px-y_010">
                        <div class="flex_fl_yc">
                            <form id="rejoin_restriction_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                                <input type="hidden" name="group_code" value="re_join_setting">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required"
                                        id="crm_member_management_resign_limit_on" value="1"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($rejoin_enabled) ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_resign_limit_on">사용함</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required"
                                        id="crm_member_management_resign_limit_off" value="0"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo (!$rejoin_enabled) ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_resign_limit_off">사용안함</label>
                                </div>
                            </form>
                            <form id="rejoin_days_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                                <input type="hidden" name="group_code" value="re_join_setting">
                                <div class="flex_fl_yc padding_px-x_010 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <label class="padding_px-r_010" for="rejoin_days_input">회원 탈퇴/삭제 후:</label>
                                    <input class="width_px_060 height_px_030 border_px-a_001 padding_px-x_005 text_change_submit" data-bd-a-color="#888888"
                                        type="text" name="group_description" id="rejoin_days_input" value="<?php echo $rejoin_days; ?>" min="1" max="365">
                                    <span class="padding_px-l_005">일동안 재가입 불가</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                // 옵션 그룹 정보 조회
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'signup_deny_keyword' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $signup_deny_keyword = $result[0]['group_description'];
                $signup_deny_keyword = $signup_deny_keyword ? $signup_deny_keyword : "admin, administration, administrator, master, webmaster, manage, manager, godo, godomall";

            ?>
            <div class="font_px_020 flv6 padding_px-y_020">가입불가 회원 아이디</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">포함단어</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <form id="words_that_cannot_be_registered_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">    
                            <input type="hidden" name="group_code" value="signup_deny_keyword">
                            <input class="width_box padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001 text_change_submit"
                                data-bd-a-color="#888888" type="text" name="group_description" id="words_that_cannot_be_registered_input" data-xy="1-800: width_box font_px_012"
                                value="<?php echo htmlspecialchars($signup_deny_keyword); ?>" placeholder="쉼표로 구분">
                        </form>
                    </div>
                </div>
            </div>
            <div class="padding_px-u_060"></div>
        </div>
    </div>
</section>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    .crm_member_management_color {
        background-color: #15376b;
    }

    .crm_member_management_1_bg {
        background-color: #E6E6E5;
        color: #15376b;
        font-weight: 600;
    }

    .sticky {
        top: 74px;
    }

    @media (max-width: 1200px) {
        .sticky {
            top: 117px;
        }
    }

    input {
        all: unset;
        font-family: fontstyle1;
        box-sizing: border-box;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"] {
        outline: none;
    }

    select {
        outline: none;
        background-color: #ffffff;
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
        width: 6px;
        height: 6px;
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
        width: 10px;
        height: 10px;
        background-color: #202020;
    }

    .email_custom_close {
        position: absolute;
        top: 50%;
        right: 2%;
        transform: translateY(-50%);
        display: none;
        cursor: pointer;
    }

    .hidden {
        opacity: 0;
        pointer-events: none;
        /* 클릭이나 포커스 불가능 */
    }
</style>