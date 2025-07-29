<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_level_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">등급평가방식</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">등급평가설정</div>
                    </div>
                </div>
            </div>
            <div class="flex_ft width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9"
                data-xy="1-800: font_px_014">
                <div class="flex_fl width_box height_box border_px-u_001" data-xy="1-800: flex_ft"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="flex_yc min_width_180 height_auto padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">자동/수동 평가</div>
                    <div class="flex_ft padding_px-x_010 padding_px-y_005 width_box" data-bd-a-color="#d9d9d9"
                        data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-x_010 padding_px-y_010">
                        <?php
                         // 옵션 그룹 정보 조회
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'shopping_grading_method' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $grading_method = $result[0]['group_required'];

                        ?>
                        <form id="shopping_grading_method_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="shopping_grading_method">
                            <div class="flex_fl_yc">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        <?php echo ($grading_method == '0') ? 'checked' : ''; ?>
                                        type="radio" name="group_required" value="0"
                                        id="crm_member_level_evaluation_auto_manual"
                                        data-xy="1-800: width_px_016 height_px_016">
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_level_evaluation_auto_manual">수동평가</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        <?php echo ($grading_method == '1') ? 'checked' : ''; ?>
                                        type="radio" name="group_required" value="1"
                                        id="crm_member_level_evaluation_auto" data-xy="1-800: width_px_016 height_px_016">
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_level_evaluation_auto">자동평가</label>
                                </div>
                            </div>
                        </form>
                        <div class="flex_ft font_px_012" data-color="#999999">
                            <span class="padding_px-y_002">자동 평가 선택 시 설정된 평가방법 및 평가기준의 산출기간/등급산정일에 따라 회원등급이 자동
                                평가됩니다.</span>
                            <span class="padding_px-y_002">수동 평가 선택 시 회원등급이 자동으로 평가되지 않습니다. 실적에 따른 평가 필요 시 [회원등급 수동평가]를
                                늘러
                                회원등급을 평가합니다.</span>
                        </div>
                    </div>
                </div>
                <div class="flex_fl width_box height_box border_px-u_001" data-xy="1-800: flex_ft"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="flex_yc min_width_180 height_auto padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">하향평가 사용여부</div>
                    <div class="flex_ft padding_px-x_010 padding_px-y_005 width_box" data-bd-a-color="#d9d9d9"
                        data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-x_010 padding_px-y_010">
                        <?php
                        // 옵션 그룹 정보 조회
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'shopping_whether_to_use_downgrade' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $downgrade = $result[0]['group_required'];

                        ?>
                        <form id="shopping_whether_to_use_downgrade_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="shopping_whether_to_use_downgrade">
                            <div class="flex_fl_yc">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        <?php echo ($downgrade == '1') ? 'checked' : ''; ?>
                                        type="radio" name="group_required" value="1"
                                        id="crm_member_level_downgrade_on" data-xy="1-800: width_px_016 height_px_016">
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_level_downgrade_on">사용함</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        <?php echo ($downgrade == '0') ? 'checked' : ''; ?>
                                        type="radio" name="group_required" value="0"
                                        id="crm_member_level_downgrade_off" data-xy="1-800: width_px_016 height_px_016">
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_level_downgrade_off">사용안함</label>
                                </div>
                            </div>
                        </form>
                        <div class="flex_ft font_px_012" data-color="#999999">
                            <span class="padding_px-y_002">사용안함으로 설정할 경우, 자동/수동 평가에 따라 회원의 등급순서가 하향되지 않습니다.</span>
                        </div>
                    </div>
                </div>
                <div class="flex_fl width_box height_box border_px-u_001" data-xy="1-800: flex_ft"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="flex_yc min_width_180 height_auto padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">실적 수치제</div>
                    <div class="flex_ft padding_px-x_010 padding_px-y_005 width_box" data-bd-a-color="#d9d9d9"
                        data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-x_010 padding_px-y_010">
                        <?php
                        // 옵션 그룹 정보 조회
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'shopping_performance_numerical_system' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $numerical = $result[0]['group_required'];
                        ?>
                        <form id="shopping_performance_numerical_system_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="shopping_performance_numerical_system">
                            <div class="flex_fl_yc">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="min_width_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        <?php echo ($numerical == '1') ? 'checked' : ''; ?>
                                        type="radio" name="group_required" value="1"
                                        id="performance_numerical_system_on" data-xy="1-800: min_width_016 height_px_016">
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="performance_numerical_system_on">주문금액, 상품주문건수, 주문상품후기횟수를 종합하여 평가하는 방법입니다. 회원등급별
                                        평가기준을 입력하세요.</label>
                                </div>
                            </div>
                        </form>
                        <div class="flex_ft font_px_012" data-color="#999999">
                            <span class="padding_px-y_002">수동 평가 선택 시 회원등급이 자동으로 평가되지 않고 [회원등급 수동평가]를 늘러 회원등급을
                                평가합니다.</span>
                        </div>
                    </div>
                </div>
                <div class="flex_fl width_box height_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff"
                    data-bd-a-color="#d9d9d9">
                    <div class="flex_yc min_width_180 height_auto padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010 font_px_016 flv6 flex_xc border_px-u_001">
                        실적 점수제</div>
                    <div class="flex_ft width_box" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box">
                        <?php
                        // 옵션 그룹 정보 조회
                        $tree = egb_option_flat('shopping_performance_point_system');
                        // 옵션 그룹 정보 조회
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'shopping_performance_point_system' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $group_required = $result[0]['group_required'];
                        // 옵션이 없는 경우 메시지 표시 
                        if (empty($tree)) {
                            ?>
                            <div class="flex_fl_yc width_box padding_px-a_020" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                                <div class="width_box text_align_center padding_px-y_020">
                                    등록된 실적 점수제 옵션이 없습니다. 실적 점수제 옵션을 먼저 등록해주세요.
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                                    <form class="flex_ft" ction="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="group_code" value="shopping_performance_point_system">
                                        <?php
                            $index = 1;
                            // 옵션 정보가 있는 경우 동적으로 표시
                            foreach ($tree as $option) {
                                $option_id = $option['uniq_id'];
                                $option_name = $option['label'];
                                $option_is_active = $option['option_is_active'];
                                $input_name = "performance_point_system_" . $option_id;
                                $option_data = json_decode($option['option_data'], true);
                                ?>
                                <div class="flex_fl width_box height_box border_px-u_001" data-xy="1-800: flex_ft"
                                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                                        <div class="flex_fl_yc min_width_180 height_auto padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                                            data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">
                                            <input class="min_width_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                                type="radio" name="group_required" value="<?php echo $index; ?>"
                                                id="<?php echo $input_name; ?>_on"
                                                data-xy="1-800: min_width_016 height_px_016" <?php echo ($group_required == $index) ? 'checked' : ''; ?>>
                                            <label class="padding_px-l_005"
                                                for="<?php echo $input_name; ?>_on"><?php echo htmlspecialchars($option_name); ?></label>
                                        </div>
                                    <div class="flex_fl_yc padding_px-x_010 padding_px-y_005 width_box" 
                                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                                        data-xy="1-800: flex_ft width_box padding_px-x_010 padding_px-y_010">
                                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                                            <input class="width_px_150 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001 text_change_submit"
                                                data-bd-a-color="#888888" type="text" name="value1" 
                                                value="<?php echo $option_data['value1']; ?>"
                                                data-xy="1-800: width_box font_px_012">
                                            <span class="min_width_030 flex_xc font_px_012"
                                                data-xy="1-800: font_px_010"><?php echo $option_name == '주문금액' ? '원당' : '건당'; ?></span>
                                            <input class="width_px_150 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001 text_change_submit"
                                                data-bd-a-color="#888888" type="text" name="value2"
                                                value="<?php echo $option_data['value2']; ?>"
                                                data-xy="1-800: width_box font_px_012">
                                            <span class="min_width_030 flex_xc font_px_012"
                                                data-xy="1-800: font_px_010">점</span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $index++;
                            }
                            ?>
                        </form>
                        <?php
                        }
                        ?>
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
    .crm_member_level_color {
        background-color: #15376b;
    }

    .crm_member_level_2_bg {
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