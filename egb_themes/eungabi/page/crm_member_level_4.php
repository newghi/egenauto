<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php';  ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_level_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">회원등급 노출이름 변경</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">등급관리</div>
                    </div>
                </div>
            </div>
            <form id="grade_name_form" action="<?php echo DOMAIN . '/?post=egb_grade_name_edit_form_input'; ?>" method="post">
                <input type="hidden" name="csrf_token" value=" <?php echo $_SESSION['csrf_token']; ?>">
                <div class="flex_ft width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                    <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                        <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: padding_px-y_010 padding_px-l_010">노출이름</div>
                        <div class="flex_fl_yc border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="grade_name" id="grade_name_input" data-xy="1-800: width_box font_px_012">
                            <input type="hidden" name="uniq_id" id="grade_uniq_id">
                            <div class="padding_px-l_010 flex_xc_yc font_px_012">
                                <div class="egb_submit padding_px-x_010 padding_px-y_005 white-_space_nowrap" data-color="#ffffff"
                                    data-bg-color="#202020">
                                    수정
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="font_px_020 flv6 padding_px-y_020">회원등급 쿠폰 혜택 설정</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl width_box height_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="flex_ft_xc height_auto min_width_180 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: height_px_040 padding_px-y_010 padding_px-l_010">
                        <span>쿠폰 혜택 지급 시</span>
                        <span>쿠폰 발급 시점 설정</span>
                    </div>
                    <form id="coupon_issuance_form" action="<?php echo DOMAIN . '/?post=egb_group_option_setting_update_form_input'; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value=" <?php echo $_SESSION['csrf_token']; ?>"> 
                        <input type="hidden" name="group_code" value="community_coupon_issuance_timing">
                        <div class="flex_ft width_box" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                            data-xy="1-800: width_box">
            <?php
                // 옵션 그룹 정보 조회
                $query = "SELECT group_required, group_title, group_code, group_description FROM egb_option_group WHERE group_code = 'community_coupon_issuance_timing' AND is_status = 1";
                $binding = binding_sql(1, $query, []);
                $result = egb_sql($binding);

                $group_required = $result[0]['group_required'];
            ?>
                            <div class="flex_fl_yc padding_px-x_010 padding_px-y_009 border_px-u_001"
                                data-bd-a-color="#d9d9d9" data-xy="1-1450: width_box flex_ft_xc">
                                <div class="flex_fl_yc" data-xy="1-800: flex_ft">
                                    <div class="flex_fl_yc" data-xy="1-800: flex_xc_yc">
                                        <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required"
                                            id="crm_member_level_community_coupon_setting_one1"
                                            value="1"
                                            <?php echo $group_required == '1' ? 'checked' : ''; ?>
                                            data-xy="1-800: width_px_016 height_px_016">
                                        <label class="padding_px-l_005 padding_px-r_010"
                                            for="crm_member_level_community_coupon_setting_one1">회원등급 평가 완료 시 발급</label>
                                    </div>
                                    <div class="flex_fl_yc padding_px-t_000" data-xy="1-800: flex_xc_yc padding_px-t_005">
                                        <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required"
                                            id="crm_member_level_community_coupon_setting_one2"
                                            value="2"
                                            <?php echo $group_required == '2' ? 'checked' : ''; ?>
                                            data-xy="1-800: width_px_016 height_px_016">
                                        <label class="padding_px-l_005 padding_px-r_010"
                                            for="crm_member_level_community_coupon_setting_one2">등급 변경 시에만 발급</label>
                                    </div>
                                </div>
                                <div class="flex_fl_yc font_px_012" data-xy="1-1450: padding_px-t_005" data-color="#888888">
                                    '회원등급 평가 완료 시 발급' 설정 시 수동 발급은 [회원등급
                                    수동평가] 버튼 클릭 시, 자동 발급은 등급 평가일에 쿠폰이 발급됩니다.
                                </div>
                            </div>
                            <div class="flex_fl_yc padding_px-x_010 padding_px-y_009 border_px-u_001"
                                data-bd-a-color="#d9d9d9" data-xy="1-800: width_box flex_xc_yc">
                                <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                    type="radio" name="group_required"
                                    id="crm_member_level_community_coupon_setting_two1"
                                    value="3"
                                    <?php echo $group_required == '3' ? 'checked' : ''; ?>
                                    data-xy="1-800: width_px_016 height_px_016">
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_level_community_coupon_setting_two1">회원등급을 직접 수정 시 발급</label>
                            </div>
                            <div class="flex_fl_yc padding_px-x_010 padding_px-y_009 border_px-u_001"
                                data-bd-a-color="#d9d9d9" data-xy="1-1450: width_box flex_ft_xc">
                                <div class="flex_fl_yc" data-xy="1-800: flex_ft">
                                    <div class="flex_fl_yc" data-xy="1-800: flex_xc_yc">
                                        <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required"
                                            id="crm_member_level_community_coupon_setting_three1"
                                            value="4"
                                            <?php echo $group_required == '4' ? 'checked' : ''; ?>
                                            data-xy="1-800: width_px_016 height_px_016">
                                        <label class="padding_px-l_005 padding_px-r_010"
                                            for="crm_member_level_community_coupon_setting_three1">회원 액셀 업로드로 회원등급을 업데이트 시
                                            발급</label>
                                    </div>
                                    <div class="flex_fl_yc padding_px-t_000" data-xy="1-800: flex_xc_yc padding_px-t_005">
                                        <input class="width_px_018 height_px_018 border_px-a_001 radio_submit" data-bd-a-color="#888888"
                                            type="radio" name="group_required"
                                            id="crm_member_level_community_coupon_setting_three2"
                                            value="5"
                                            <?php echo $group_required == '5' ? 'checked' : ''; ?>
                                            data-xy="1-800: width_px_016 height_px_016">
                                        <label class="padding_px-l_005 padding_px-r_010"
                                            for="crm_member_level_community_coupon_setting_three2">등급 변경 시에만 발급</label>
                                    </div>
                                </div>
                                <div class="flex_fl_yc font_px_012" data-xy="1-1450: padding_px-t_005" data-color="#888888">
                                    '등급 변경 시에만 발급' 체크를 하면, 해당 이벤트 발생 시 회원등급이 변경된 회원들에게만 쿠폰이 발급됩니다.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">회원등급 리스트</div>
            <?php
            // 옵션 그룹 조회
            $tree = egb_option_flat('community_user_grade');

            // 옵션 그룹 정보 조회 
            $query = "SELECT group_required, group_title, group_code FROM egb_option_group WHERE group_code = 'community_user_grade' AND is_status = 1";
            $binding = binding_sql(1, $query, []);
            $result = egb_sql($binding);

            $total_count = count($tree);
            ?>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $total_count; ?></span>건&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $total_count; ?></span>명
                        </div>
                        <div class="flex_fl_yc padding_px-t_000" data-xy="1-800: padding_px-t_010">
                            <div class="flex_xc padding_px-l_005">
                                <div id="send_sms" class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">SMS</div>
                            </div>
                            <div class="flex_xc padding_px-l_005">
                                <div id="download_excel" class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">EXCEL</div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 16% 8% 18% 22% 12% 9% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_level_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" name="check_all"
                                    id="crm_searching_member_level_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원등급명</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원수</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등급혜택</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이용결제수단</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등록일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등록자</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <div id="member_levels_list">
                        <?php if(!empty($tree)): ?>
                            <?php foreach($tree as $index => $level): ?>
                                <?php
                                $level_data = json_decode($level['option_data'], true);
                                ?>
                            <div class="grid_xx border_px-u_001 member-level-row pointer" data-xx="5% 5% 16% 8% 18% 22% 12% 9% 5%"
                                data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-level-id="<?php echo $level['uniq_id']; ?>" data-grade-name="<?php echo $level['label']; ?>">
                                <label for="crm_searching_member_level_<?php echo $level['uniq_id']; ?>"
                                    class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                    <input class="border_px-a_001 width_px_020 height_px_020 member-level-checkbox" type="checkbox" name="member_level[]"
                                        id="crm_searching_member_level_<?php echo $level['uniq_id']; ?>" value="<?php echo $level['uniq_id']; ?>" data-grade-name="<?php echo $level['label']; ?>" data-bd-a-color="#d9d9d9">
                                </label>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $index + 1; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $level['label']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $level_data['user_count']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $level_data['benefit_data']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                                    <?php 
                                    if(!empty($level_data['payment_methods'])) {
                                        $payment_methods = json_decode($level_data['payment_methods'], true);
                                        if(is_array($payment_methods)) {
                                            $method_names = [];
                                            $query = "SELECT payment_method_name FROM auto_payment_method WHERE uniq_id IN ('" . implode("','", $payment_methods) . "') AND is_status = 1 AND deleted_at IS NULL";
                                            $binding = binding_sql(0, $query);
                                            $result = egb_sql($binding);
                                            foreach($result[0] as $method) {
                                                $method_names[] = $method['payment_method_name'];
                                            }
                                            echo implode('/', $method_names);
                                        }
                                    } else {
                                        echo '없음';
                                    }
                                    ?>
                                </div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo date('Y-m-d', strtotime($level['created_at'])); ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $level['created_by']; ?></div>
                                <div class="flex_xc padding_px-y_015 pointer view-details" data-level-id="<?php echo $level['uniq_id']; ?>" data-bd-a-color="#d9d9d9"
                                    data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="flex_xc_yc padding_px-y_020">등록된 회원등급이 없습니다.</div>
                        <?php endif; ?>
                        </div>
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

    .crm_member_level_4_bg {
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

<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    // 체크박스 클릭 이벤트 리스너 추가
    document.querySelectorAll('.member-level-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // 체크된 경우 해당 등급명과 유니크아이디를 input에 설정
                document.getElementById('grade_name_input').value = this.getAttribute('data-grade-name');
                document.getElementById('grade_uniq_id').value = this.value;
                
                // 다른 체크박스들은 해제
                document.querySelectorAll('.member-level-checkbox').forEach(function(otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
            } else {
                // 체크 해제된 경우 input 값들을 비움
                document.getElementById('grade_name_input').value = '';
                document.getElementById('grade_uniq_id').value = '';
            }
        });
    });

    // 행 클릭 이벤트 리스너 추가
    document.querySelectorAll('.member-level-row').forEach(function(row) {
        row.addEventListener('click', function(e) {
            // 체크박스나 '보기' 버튼 클릭 시에는 이벤트 처리하지 않음
            if (e.target.type === 'checkbox' || e.target.classList.contains('view-details')) {
                return;
            }
            
            // 해당 행의 체크박스 찾기
            const checkbox = this.querySelector('.member-level-checkbox');
            // 체크박스 상태 토글
            checkbox.checked = !checkbox.checked;
            // change 이벤트 발생시키기
            const event = new Event('change');
            checkbox.dispatchEvent(event);
        });
    });

    // hover 효과 처리
    document.querySelectorAll('[data-hover-bg-color]').forEach(function(element) {
        element.addEventListener('mouseenter', function() {
            this.style.backgroundColor = this.getAttribute('data-hover-bg-color');
            if(this.hasAttribute('data-hover-color')) {
                this.style.color = this.getAttribute('data-hover-color');
            }
        });

        element.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            if(this.hasAttribute('data-hover-color')) {
                this.style.color = '';
            }
        });
    });
});
</script>