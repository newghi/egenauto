<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_management_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020 fullpage" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">액셀일괄등록</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">액셀일괄등록</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
<?php
// 설정 값 불러오기
$query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'excel_shopping_mall_membership_classification' AND is_status = 1";
$binding = binding_sql(1, $query, []);
$result = egb_sql($binding);

$excel_shopping_mall_class = $result[0]['group_required'];

?>

<form id="excel_shopping_mall_membership_classification_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="group_code" value="excel_shopping_mall_membership_classification">
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
                    <?php echo ($excel_shopping_mall_class == '0') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_shoppingmall_member_unused">미사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                    type="radio" name="group_required" id="crm_member_management_shoppingmall_member_use" value="1"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($excel_shopping_mall_class == '1') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_shoppingmall_member_use">사용</label>
            </div>
            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                        type="radio" name="group_required" id="crm_member_management_shoppingmall_member_must" value="2"
                    data-xy="1-800: width_px_016 height_px_016"
                    <?php echo ($excel_shopping_mall_class == '2') ? 'checked' : ''; ?>>
                <label class="padding_px-l_005 padding_px-r_010"
                    for="crm_member_management_shoppingmall_member_must">필수</label>
            </div>
        </div>
    </div>
</form>
                <?php
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'excel_community_member_classification' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $excel_community_member_class = $result[0]['group_required'];
?>

                <form id="excel_community_member_classification_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="group_code" value="excel_community_member_classification">
                    <div class="flex_fl_yc width_box border_px-u_001" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                        data-bd-a-color="#d9d9d9">
                        <div class="min_width_180 height_px_060 padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">커뮤니티회원구분</div>
                        <div class="flex_fl_yc padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                            data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_community_member_unused" value="0"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($excel_community_member_class == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_community_member_unused">미사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_community_member_use" value="1"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($excel_community_member_class == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_community_member_use">사용</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" id="crm_member_management_community_member_must" value="2"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($excel_community_member_class == '2') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_community_member_must">필수</label>
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
    .fullpage {
        height: 90vh;
    }

    .crm_member_management_color {
        background-color: #15376b;
    }

    .crm_member_management_3_bg {
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