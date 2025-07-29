<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_management_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">휴면회원 사용 설정</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">휴면회원정책</div>
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
                        data-bg-color="#ffffff" data-xy="1-800: width_box padding_px-y_010">
                        <?php
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'dormant_mode' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $dormant_mode = $result[0]['group_required'];
                        ?>
                        <form id="dormant_mode_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="dormant_mode">
                            <div class="flex_fl_yc">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="1"
                                        id="dormant_mode_auto"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($dormant_mode == '1') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="dormant_mode_auto">사용함</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required" value="0"
                                        id="dormant_mode_manual"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($dormant_mode == '0') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="dormant_mode_manual">사용안함</label>
                                </div>
                            </div>
                        </form>
                        <div class="flex_ft font_px_012" data-color="#999999">
                            <span class="padding_px-y_002">2023년 9월 15일 개인정보 보호법 개정으로 인해 개인정보 유효기간제가 폐지됨에 따라 상점별로 운영정책에
                                맞게 자율적으로 휴면회원 사용 여부를 설정할
                                수 있습니다.</span>
                            <span class="padding_px-y_002">휴면회원 기능을 '사용안함' 으로 설정 시 다음 휴면전환 처리 시점부터 휴면 전환 대상자의 휴면 처리가
                                진행되지 않습니다. 단, 기존 처리된 휴면회원에
                                대해서는 영향이 없습니다. </span>
                            <span class="padding_px-y_002">휴면회원 기능을 '사용안함' 으로 설정 시 기존 휴면상태로 전환된 회원은 회원 > 회원 관리 > 휴면 회원
                                관리에서 수동으로 휴면해제해주시면
                                됩니다.</span>
                            <span class="padding_px-y_002">휴면회원 기능을 '사용안함' 으로 설정 시 기존 등록된 평생회원 이벤트와 휴면해제 감사 쿠폰의 진행 및 발급을
                                원치 않으시다면 수동으로 중지해주시면
                                됩니다. 회원정보 이벤트 바로가기 쿠폰 리스트 바로가기</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">휴면회원 정책</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl width_box height_box border_px-u_001" data-xy="1-800: flex_ft"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="flex_yc min_width_180 height_auto padding_px-y_018 padding_px-l_010 border_px-r_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">일반회원 전환방법</div>
                    <?php
                    $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'inactive_member_how_to_convert' AND is_status = 1";
                    $binding = binding_sql(1, $query, []);
                    $result = egb_sql($binding);
                    $inactive_member_how_to_convert = $result[0]['group_required'];
                    ?>
                    <div class="flex_ft padding_px-x_010 padding_px-y_000 width_box" data-bd-a-color="#d9d9d9"
                        data-bg-color="#ffffff" data-xy="1-800: flex_ft width_box padding_px-y_010">
                        <form id="inactive_member_how_to_convert_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="inactive_member_how_to_convert">
                            <div class="flex_fl_yc padding_px-l_000 padding_px-y_005" data-bd-a-color="#d9d9d9"
                                data-xy="1-800: padding_px-l_010 padding_px-y_005 border_px-u_001 width_box">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888" 
                                    type="radio" name="group_required" value="1"
                                    id="crm_member_management_change_member_level_first_one"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($inactive_member_how_to_convert == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_change_member_level_first_one">로그인 후 본인인증단계 없이 일반회원으로
                                    전환</label>
                            </div>
                            <div class="flex_fl_yc_wrap padding_px-l_000" data-xy="1-800: border_px-u_001 padding_px-l_010"
                                data-bd-a-color="#d9d9d9">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                         type="radio" name="group_required" value="2"
                                        id="crm_member_management_change_member_level_second_one"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '2') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_second_one">회원정보에 등록되어 있는 정보 입력 후
                                        일반회원으로 전환</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="3"
                                        id="crm_member_management_change_member_level_second_two_1"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '3') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_second_two_1">휴대폰번호</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="4"
                                        id="crm_member_management_change_member_level_second_two_2"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '4') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_second_two_2">이메일</label>
                                </div>
                            </div>
                            <div class="flex_fl_yc_wrap padding_px-l_000" data-xy="1-800: padding_px-l_010">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required" value="5"
                                        id="crm_member_management_change_member_level_third_one"
                                            data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '5') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_third_one">본인인증 이후 일반회원으로 전환</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="6"
                                        id="crm_member_management_change_member_level_third_two_1"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '6') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_third_two_1">등록된 휴대폰으로 인증번호
                                        SMS수신</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="7"
                                        id="crm_member_management_change_member_level_third_two_2"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '7') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_third_two_2">등록된 이메일로 인증번호 수신</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="8"
                                        id="crm_member_management_change_member_level_third_two_3"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '8') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_third_two_3">아이핀 본인인증</label>
                                </div>
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required" value="9"
                                        id="crm_member_management_change_member_level_third_two_4"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_how_to_convert == '9') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_change_member_level_third_two_4">휴대폰 본인인증</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="flex_yc min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">회원등급 초기화</div>
                    <div class="flex_ft border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box flex_ft padding_px-y_010">
                        <?php
                        // 설정 값 불러오기
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'inactive_member_reset_membership_level' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $inactive_member_reset_level = $result[0]['group_required'];
                        ?>
                        <form id="inactive_member_reset_membership_level_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="inactive_member_reset_membership_level">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" value="1"
                                    id="crm_member_management_dormant_member_reset_on"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($inactive_member_reset_level == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_dormant_member_reset_on">휴면회원 해제시 기본회원으로 등급 변경</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" value="0"
                                    id="crm_member_management_dormant_member_reset_off"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($inactive_member_reset_level == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_dormant_member_reset_off">사용안함</label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="flex_yc min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">구독회원 휴면전환</div>
                    <div class="flex_ft border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box flex_ft padding_px-y_010">
                            <?php
                        // 설정 값 불러오기
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'inactive_member_subscription_member_dormancy_conve' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);
                        

                        $inactive_member_subscription_member_dormancy_conve = $result[0]['group_required'];
                        ?>
                        <form id="inactive_member_subscription_member_dormancy_conve_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="inactive_member_subscription_member_dormancy_conve">
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required" value="1"
                                    id="crm_member_management_dormant_member_subscribe_reset_on"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($inactive_member_subscription_member_dormancy_conve == '1') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_dormant_member_subscribe_reset_on">휴면회원 해제시 잔여기간 소진</label>
                                    <?php echo ($inactive_member_subscription_member_dormancy_conve == '1') ? 'checked' : ''; ?>
                            </div>
                            <div class="flex_fl_yc padding_px-x_000 padding_px-y_005" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="0"
                                    id="crm_member_management_dormant_member_subscribe_reset_off"
                                    data-xy="1-800: width_px_016 height_px_016"
                                    <?php echo ($inactive_member_subscription_member_dormancy_conve == '0') ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_management_dormant_member_subscribe_reset_off">사용안함</label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="flex_yc min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">마일리지 소멸 설정</div>
                    <div class="flex_ft border_px-u_001 padding_px-x_010 padding_px-y_000 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: width_box flex_ft padding_px-y_010">
                        <?php
                        // 설정 값 불러오기
                        $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'inactive_member_mileage_expiration_settings' AND is_status = 1";
                        $binding = binding_sql(1, $query, []);
                        $result = egb_sql($binding);

                        $inactive_member_mileage_expiration_settings = $result[0]['group_required'];
                        ?>
                        <form id="inactive_member_mileage_expiration_settings_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type="hidden" name="group_code" value="inactive_member_mileage_expiration_settings">
                            <div class="flex_ft">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="1"
                                        id="crm_member_management_dormant_member_mileage_reset_on"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_mileage_expiration_settings == '1') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_dormant_member_mileage_reset_on">휴면회원 해제시 유효기간이 지난 마일리지
                                        소멸</label>
                                </div>
                                <div class="font_px_012" data-color="#888888">마일리지의 유효기간은 지급 당시의 회원 > 마일리지/예치금관리 > 마일리지 기본
                                    설정을 따르며, 마일리지 소멸 시 자동안내(sms,이메일)는 발송되지 않습니다.</div>
                            </div>
                            <div class="flex_ft">
                                <div class="flex_fl_yc padding_px-x_000 padding_px-y_005"
                                    data-xy="1-800: width_box flex_xc_yc">
                                    <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                        type="radio" name="group_required" value="0"
                                        id="crm_member_management_dormant_member_mileage_reset_off"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo ($inactive_member_mileage_expiration_settings == '0') ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_management_dormant_member_mileage_reset_off">휴면회원 전환 시 보유 마일리지
                                        초기화</label>
                                </div>
                                <div class="font_px_012 padding_px-u_005" data-color="#888888">해당설정 시 휴면회원의 마일리지 처리방침에 대한 별도
                                    안내를 이용약관 및 공지사항
                                    등을 통해 사전에 고지할 것을 권장합니다.</div>
                            </div>
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

    .crm_member_management_4_bg {
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