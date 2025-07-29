<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_management_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">회원구분</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">회원가입항목</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'shopping_mall_user_type' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $shopping_mall_class = $result[0]['group_required'];
?>

<form id="shopping_mall_user_type" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="shopping_mall_user_type">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">쇼핑몰회원구분</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_shoppingmall_member_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($shopping_mall_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_shoppingmall_member_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_shoppingmall_member_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($shopping_mall_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_shoppingmall_member_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_shoppingmall_member_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($shopping_mall_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_shoppingmall_member_must">필수</label>
            </div>
        </div>
    </div>
</form>

<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'shopping_mall_user_type_business' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $shopping_mall_user_type_business_class = $result[0]['group_required'];
?>

<form id="shopping_mall_user_type_business_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="shopping_mall_user_type_business">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">사업자구분</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_mentoid_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($shopping_mall_user_type_business_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_mentoid_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_mentoid_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($shopping_mall_user_type_business_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_mentoid_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_mentoid_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($shopping_mall_user_type_business_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_mentoid_must">필수</label>
            </div>
        </div>
    </div>
</form>

<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'community_user_grade' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $community_class = $result[0]['group_required'];
?>

<form id="community_member_classification_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="community_user_grade">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">커뮤니티회원구분</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_community_member_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($community_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_community_member_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_community_member_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($community_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_community_member_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_community_member_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($community_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_community_member_must">필수</label>
            </div>
        </div>
    </div>
</form>

<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_mentor_id' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $mentor_id_class = $result[0]['group_required'];
?>

<form id="mentor_id_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_mentor_id">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">멘토아이디</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_mentoid_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($mentor_id_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_mentoid_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_mentoid_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($mentor_id_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_mentoid_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_mentoid_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($mentor_id_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_mentoid_must">필수</label>
            </div>
        </div>
    </div>
</form>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">기본정보</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
<?php

    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_id' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_id_class = $result[0]['group_required'];
?>

<form id="basic_id_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_id">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">아이디</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_id_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_id_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_id_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                        type="radio" name="group_required" id="crm_member_management_id_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_id_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_id_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_id_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_id_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_id_must">필수</label>
            </div>
        </div>
    </div>
</form>

<?php

    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_password' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_password_class = $result[0]['group_required'];
?>

<form id="basic_password_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_password">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">비밀번호</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_password_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_password_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_password_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_password_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_password_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_password_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_password_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_password_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_password_must">필수</label>
            </div>
        </div>
    </div>
</form>
<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_password_check' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_verify_password_class = $result[0]['group_required'];
?>

<form id="basic_verify_password_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_password_check">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">비밀번호 확인</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_verify_password_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_verify_password_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_verify_password_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_verify_password_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_verify_password_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_verify_password_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_verify_password_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_verify_password_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_verify_password_must">필수</label>
            </div>
        </div>
    </div>
</form>
<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_name' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_name_class = $result[0]['group_required'];
?>

<form id="basic_name_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_name">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">이름</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_name_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_name_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_name_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_name_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_name_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_name_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_name_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_name_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_name_must">필수</label>
            </div>
        </div>
    </div>
</form>
<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_nick_name' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_nickname_class = $result[0]['group_required'];
?>

<form id="basic_nickname_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_nick_name">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">별명</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_nickname_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                        <?php echo ($basic_nickname_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_nickname_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_nickname_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_nickname_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_nickname_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_nickname_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                        <?php echo ($basic_nickname_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_nickname_must">필수</label>
            </div>
        </div>
    </div>
</form>                
<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_zipcode' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_zipcode_class = $result[0]['group_required'];
?>

<form id="basic_zipcode_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_zipcode">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
        data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">우편번호</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_zipcode_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                        <?php echo ($basic_zipcode_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_zipcode_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_zipcode_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_zipcode_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_zipcode_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_zipcode_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_zipcode_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_zipcode_must">필수</label>
            </div>
        </div>
    </div>
</form>

<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_address' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_address_class = $result[0]['group_required'];
?>

<form id="basic_address_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_address">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
        data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">기본주소</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_address_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                        <?php echo ($basic_address_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_address_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_address_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_address_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_address_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_address_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_address_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_address_must">필수</label>
            </div>
        </div>
    </div>
</form>

<?php
    // 옵션 그룹 정보 조회
    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_address_detail' AND is_status = 1";
    $binding = binding_sql(1, $query, []);
    $result = egb_sql($binding);

    $basic_address_detail_class = $result[0]['group_required'];
?>

    <form id="basic_address_detail_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="user_address_detail">
    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
        data-bd-a-color="#d9d9d9">
        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">상세주소</div>
        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_address_detail_unused" value="0"
                    data-xy="1-800: width_px_016 height_px_016"
                        <?php echo ($basic_address_detail_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_address_detail_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_address_detail_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_address_detail_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_address_detail_use">사용
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_address_detail_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($basic_address_detail_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_address_detail_must">필수</label>
            </div>
        </div>
    </div>
</form>

                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'phone_number1' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $basic_phone1_class = $result[0]['group_required'];
                ?>

                <form id="basic_phone_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="phone_number1">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">휴대전화</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_cellphone_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_phone1_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_cellphone_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_cellphone_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_phone1_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_cellphone_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_cellphone_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_phone1_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_cellphone_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'phone_number2' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $basic_phone2_class = $result[0]['group_required'];
                ?>

                <form id="basic_another_phone_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="phone_number2">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">기타연락처</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_otherphone_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($basic_phone2_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_otherphone_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_otherphone_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_phone2_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_otherphone_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_otherphone_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($basic_phone2_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_otherphone_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_email1' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $basic_email1_class = $result[0]['group_required'];
                ?>

                <form id="basic_email_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_email1">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">이메일</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_email1_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($basic_email1_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_email1_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_email1_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_email1_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_email1_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_email1_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($basic_email1_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_email1_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_gender' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $basic_gender_class = $result[0]['group_required'];
                ?>

                <form id="basic_gender_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_gender">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">성별</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_gender_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_gender_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_gender_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_gender_use" value="1"  
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($basic_gender_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_gender_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_gender_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($basic_gender_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_gender_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">추가정보</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_homepage' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_homepage_class = $result[0]['group_required'];
                ?>

                <form id="add_homepage_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_homepage">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">홈페이지</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_homepage_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_homepage_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_homepage_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_homepage_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_homepage_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_homepage_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_homepage_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_homepage_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_homepage_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_registration_purpose' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_registration_purpose_class = $result[0]['group_required'];
                ?>

                <form id="add_registration_purpose_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_registration_purpose">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">등록목적</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_registration_purpose_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                            <?php echo ($add_registration_purpose_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_registration_purpose_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_registration_purpose_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_registration_purpose_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_registration_purpose_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_registration_purpose_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_registration_purpose_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_registration_purpose_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_funnel_source' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_funnel_source_class = $result[0]['group_required'];
                ?>

                <form id="add_funnel_source_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_funnel_source">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">유입경로</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_funnel_source_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_funnel_source_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_funnel_source_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_funnel_source_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_funnel_source_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_funnel_source_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_funnel_source_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_funnel_source_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_funnel_source_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_birthday' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_birthday_class = $result[0]['group_required'];
                ?>

                <form id="add_birth_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_birthday">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">생일</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_birth_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_birthday_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_birth_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_birth_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_birthday_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_birth_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_birth_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_birthday_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_birth_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_custom_day' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_custom_day_class = $result[0]['group_required'];
                ?>

                <form id="add_anniversary_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_custom_day">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">기념일</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_anniversary_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_custom_day_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_anniversary_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_anniversary_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_custom_day_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_anniversary_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_anniversary_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_custom_day_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_anniversary_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_bank_alias' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_bank_alias_class = $result[0]['group_required'];
                ?>

                <form id="add_account_nickname_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_bank_alias">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">계좌별칭</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_account_nickname_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_bank_alias_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_nickname_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_account_nickname_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_bank_alias_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_nickname_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_account_nickname_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_bank_alias_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_nickname_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_bank_account' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_bank_account_class = $result[0]['group_required'];
                ?>

                <form id="add_account_number_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_bank_account">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">계좌번호</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_account_number_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_bank_account_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_number_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_account_number_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_bank_account_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_number_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_account_number_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_bank_account_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_number_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_bank_holder' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_bank_holder_class = $result[0]['group_required'];
                ?>

                <form id="add_account_name_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_bank_holder">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">예금주</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_account_name_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_bank_holder_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_name_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_account_name_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_bank_holder_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_name_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_account_name_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_bank_holder_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_account_name_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_job' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_job_class = $result[0]['group_required'];
                ?>

                <form id="add_job_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_job">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">직업</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_job_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_job_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_job_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_job_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_job_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_job_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_job_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_job_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_job_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_company_name3' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_company_name3_class = $result[0]['group_required'];
                ?>

                <form id="add_company_name_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_company_name3">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">회사명</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_company_name_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_company_name3_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_company_name_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_company_name_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_company_name3_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_company_name_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_company_name_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_company_name3_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_company_name_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_department' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_department_class = $result[0]['group_required'];
                ?>

                <form id="add_department_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_department">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">부서</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_department_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_department_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_department_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_department_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_department_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_department_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_department_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_department_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_department_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_position' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_position_class = $result[0]['group_required'];
                ?>

                <form id="add_position_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_position">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">직급</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_position_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_position_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_position_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_position_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_position_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_position_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_position_must" value="2"   
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_position_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_position_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_work_phone' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_work_phone_class = $result[0]['group_required'];
                ?>

                <form id="add_work_phone_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_work_phone">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">직장전화</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_phone_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_work_phone_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_phone_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_phone_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_work_phone_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_phone_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_phone_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_work_phone_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_phone_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_work_fax' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_work_fax_class = $result[0]['group_required'];
                ?>

                <form id="add_work_fax_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_work_fax">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">직장팩스</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_fax_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_work_fax_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_fax_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_fax_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_work_fax_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_fax_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_fax_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_work_fax_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_fax_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_work_address' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_work_address_class = $result[0]['group_required'];
                ?>

                <form id="add_work_address_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_work_address">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">직장주소</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_address_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_work_address_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_address_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_address_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_work_address_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_address_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_work_address_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_work_address_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_work_address_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_activity_area' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_activity_area_class = $result[0]['group_required'];
                ?>

                <form id="add_activity_area_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_activity_area">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">활동지역</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_activity_area_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_activity_area_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_activity_area_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_activity_area_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_activity_area_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_activity_area_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_activity_area_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_activity_area_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_activity_area_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기 
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_car_cc' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_car_cc_class = $result[0]['group_required'];
                ?>

                <form id="add_car_cc_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_car_cc">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">자동차</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_car_cc_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_car_cc_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_car_cc_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_car_cc_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_car_cc_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_car_cc_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_car_cc_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_car_cc_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_car_cc_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // 설정 값 불러오기 
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'user_region' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $add_region_class = $result[0]['group_required'];
                ?>

                <form id="add_area_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="user_region">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">지역</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_area_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_region_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_area_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_area_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($add_region_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_area_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" id="crm_member_management_area_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($add_region_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_area_must">필수</label>
                            </div>
                        </div>
                    </div>
                </form>
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

    .crm_member_management_2_bg {
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
