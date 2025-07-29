<form id="company_check1_form_input" action="<?php echo DOMAIN. '/?post=business_authenticity_verification_form_input'; ?>" method="post"enctype="multipart/form-data"></form>
<form id="company_check2_form_input" action="<?php echo DOMAIN. '/?post=corporation_authenticity_verification_form_input'; ?>" method="post" enctype="multipart/form-data"></form>

<section class="position1 width_box height_box padding_px-y_050">
    <div class="width_px_620 margin_x_auto letterm_spacing_030" data-xy="1-620: width_box">
        <div class="padding_px-x_010" data-xy="1-620: padding_px-x_020">
            <div class="flex_xc_yc font_px_024 flv6" data-color="#202020">회원가입</div>
                <div class="step2">
                    <div class="flex_xs1_yc width_px_450 margin_x_auto padding_px-y_050"
                        data-xy="1-450: width_box flex_xs3_yc font_px_014, 451-800: flex_xs3_yc font_px_014">
                        <div class="stepselect" data-color="#888888">1.약관동의</div>
                        <div class="flex_xc_yc width_px_015 height_px_015">
                            <svg fill="#888888" id="magicoon-Bold" height="100%" viewBox="0 0 512 512" width="100%"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="chevron-right-Bold">
                                    <path id="chevron-right-Bold-2"
                                        d="m377.75 271.083-192 192a21.331 21.331 0 1 1 -30.167-30.166l176.917-176.917-176.917-176.917a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                        data-name="chevron-right-Bold" />
                                </g>
                            </svg>
                        </div>
                        <div class="stepselect stepcolor" data-color="#888888">2.정보입력</div>
                        <div class="flex_xc_yc width_px_015 height_px_015">
                            <svg fill="#888888" id="magicoon-Bold" height="100%" viewBox="0 0 512 512" width="100%"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="chevron-right-Bold">
                                    <path id="chevron-right-Bold-2"
                                        d="m377.75 271.083-192 192a21.331 21.331 0 1 1 -30.167-30.166l176.917-176.917-176.917-176.917a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                        data-name="chevron-right-Bold" />
                                </g>
                            </svg>
                        </div>
                        <div class="stepselect" data-color="#888888">3.가입완료</div>
                    </div>
                    <div class="font_px_020 flv6 padding_px-u_025 border_px-u_003" data-color="#202020"
                        data-bd-a-color="#202020">회원유형</div>
                    <div class="font_px_013" data-bd-a-color="#ededed" data-color="#202020">
                        <div>
                            <?php
                            //쇼핑몰 회원 구분
                            // 옵션 그룹 조회
                            $tree = egb_option_flat('shopping_mall_user_type');

                            // 옵션 그룹 정보 조회
                            $query = "SELECT group_required, group_title, group_code FROM egb_option_group WHERE group_code = 'shopping_mall_user_type' AND is_status = 1";
                            $binding = binding_sql(1, $query, []);
                            $result = egb_sql($binding);

                            $display_class = 'display_none';
                            $required = false;
                            $group_title = '쇼핑몰 회원 구분'; // 기본값

                            if(isset($result[0])) {
                                if($result[0]['group_required'] == 0) {
                                    $display_class = 'display_none'; // 미사용
                                } else {
                                    $display_class = ''; // 사용 또는 필수
                                    if($result[0]['group_required'] == 2) {
                                        $required = true; // 필수
                                    }
                                }
                                $group_title = $result[0]['group_title'];
                            }
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo $display_class; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc width_px_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-y_010 del-signup_bgcolor"><span
                                        class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        data-bg-color="#ff5555"></span><?php echo $group_title; ?></div>
                                <div class="flex_fl_yc_wrap padding_px-x_025 padding_px-y_015"
                                    data-xy="1-620: padding_px-x_000 padding_px-y_010">
                                    <?php
                                    if (!empty($tree)) {
                                        $name = $result[0]['group_code'];
                                        echo "<div class='flex_yc_wrap'>";
                                        foreach ($tree as $option) {
                                            ?>
                                            <div class="flex_yc padding_px-r_025">
                                                <input class="pointer width_px_012 height_px_012"
                                                    id="<?php echo $name; ?>_<?php echo $option['uniq_id']; ?>" 
                                                    name="<?php echo $name; ?>" 
                                                    type="radio" 
                                                    data-signup-text="쇼핑몰 회원 구분"
                                                    value="<?php echo $option['uniq_id']; ?>"
                                                    <?php echo $required ? 'required' : ''; ?>>
                                                <label class="pointer padding_px-l_005" 
                                                    for="<?php echo $name; ?>_<?php echo $option['uniq_id']; ?>">
                                                    <?php echo $option['label']; ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                                <script nonce="<?php echo NONCE; ?>">
                                document.addEventListener('DOMContentLoaded', function() {
                                    const radios = document.querySelectorAll('input[name="shopping_mall_user_type"]');
                                    const businessTypeBox = document.getElementById('business_user_type_box');
                                    const individualBox = document.getElementById('individual_info_box');
                                    const corporateBox = document.getElementById('corporate_info_box');
                                
                                    radios.forEach(radio => {
                                        const lbl = document.querySelector(`label[for="${radio.id}"]`);
                                        if (!lbl) return;
                                    
                                        radio.addEventListener('change', function() {
                                            if (lbl.textContent.trim() == '기업회원' && radio.checked) {
                                                businessTypeBox.classList.remove('display_none');
                                            } else {
                                                businessTypeBox.classList.add('display_none');
                                                individualBox.classList.add('display_none');
                                                corporateBox.classList.add('display_none');
                                                
                                                // Reset business type radio buttons
                                                const businessTypeRadios = document.querySelectorAll('input[name="shopping_mall_user_type_business"]');
                                                businessTypeRadios.forEach(btn => btn.checked = false);
                                            }
                                        });
                                    });
                                });
                                </script>
                            </div>
                        <div>
                            <?php
                            // 옵션 그룹 조회
                            $tree = egb_option_flat('shopping_mall_user_type_business');

                            // 옵션 그룹 정보 조회
                            $query   = "SELECT group_required, group_title, group_code
                                        FROM egb_option_group
                                        WHERE group_code = 'shopping_mall_user_type_business'
                                          AND is_status = 1";
                            $binding = binding_sql(1, $query, []);
                            $result  = egb_sql($binding);

                            $display_class = 'display_none';
                            $required      = false;
                            $group_title   = '사업자 구분';

                            if (isset($result[0])) {
                                if ($result[0]['group_required'] == 0) {
                                    $display_class = 'display_none'; // 미사용
                                } else {
                                    $display_class = 'display_none'; // 사용 또는 필수
                                    if ($result[0]['group_required'] == 2) {
                                        $required = false; // 필수
                                    }
                                }
                                $group_title = $result[0]['group_title'];
                            }
                            ?>    
                            <div id="business_user_type_box"
                                 class="flex_fl_yc border_px-u_001 <?php echo $display_class; ?>"
                                 data-bd-a-color="#f3f3f3"
                                 data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc width_px_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                     data-xy="1-620: width_box padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                          data-bg-color="#ff5555"></span>
                                    <?php echo $group_title; ?>
                                </div>
                                <div class="flex_fl_yc_wrap padding_px-x_025 padding_px-y_015"
                                     data-xy="1-620: padding_px-x_000 padding_px-y_010">
                                    <?php
                                    if (!empty($tree)) {
                                        foreach ($tree as $option) {
                                            ?>
                                            <div class="flex_yc padding_px-r_025">
                                                <input
                                                    class="pointer width_px_012 height_px_012"
                                                    id="<?php echo $result[0]['group_code']; ?>_<?php echo $option['uniq_id']; ?>"
                                                    name="<?php echo $result[0]['group_code']; ?>"
                                                    type="radio"
                                                    data-signup-text="사업자 구분"
                                                    value="<?php echo $option['uniq_id']; ?>"
                                                    <?php echo $required ? 'required' : ''; ?>
                                                >
                                                <label class="pointer padding_px-l_005"
                                                       for="<?php echo $result[0]['group_code']; ?>_<?php echo $option['uniq_id']; ?>">
                                                    <?php echo $option['label']; ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 개인사업자 섹션 (ID 부여)
                            $option_group_query = "SELECT * FROM egb_option_group
                                                   WHERE group_code = 'user_company_name'
                                                     AND deleted_at IS NULL
                                                   LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled  = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div id="individual_info_box" class="display_none">
                                <div class="flex_ft border_px-u_001" data-bd-a-color="#f3f3f3">
                                    <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled || $option_required == 0) ? 'display_none' : ''; ?>"
                                         data-bd-a-color="#f3f3f3"
                                         data-xy="1-620: flex_ft border_px-u_000">
                                        <div class="flex_fl_yc width_px_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                             data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                            <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                                  <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>
                                            사업자명
                                        </div>
                                        <input
                                            class="width_px_400 height_px_035 margin_px-l_025 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 font_px_015"
                                            type="text"
                                            name="<?php echo $option_group[0]['group_code']; ?>"
                                            <?php echo $option_required == 2 ? 'required' : ''; ?>
                                            data-bd-a-color="#dbdbdb"
                                            data-signup-text="사업자명"
                                            data-xy="1-620: width_box del-margin_px-l_000 font_px_012"
                                        >
                                    </div>
                                    <div class="flex_fl_yc <?php echo (!$option_enabled || $option_required == 0) ? 'display_none' : ''; ?>"
                                         data-xy="1-620: flex_ft border_px-u_000">
                                        <div class="flex_fl_yc width_px_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                             data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                            <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                                  <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>
                                            사업자번호
                                        </div>
                                        <div class="flex_fl_yc">
                                            <input
                                                class="width_px_070 height_px_035 margin_px-l_025 fontstyle1 font_px_015 border_px-a_001 border_bre-a_004 padding_px-x_010"
                                                type="text"
                                                name="user_company_registration_number1"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>
                                                data-bd-a-color="#dbdbdb"
                                                data-signup-text="사업자번호"
                                                data-xy="1-620: width_box margin_px-l_000 font_px_012"
                                            >
                                            <div class="padding_px-x_010" data-xy="1-620: padding_px-x_005">-</div>
                                            <input
                                                class="width_px_050 height_px_035 fontstyle1 font_px_015 border_px-a_001 border_bre-a_004 padding_px-x_010"
                                                type="text"
                                                name="user_company_registration_number2"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>
                                                data-bd-a-color="#dbdbdb"
                                                data-signup-text="사업자번호"
                                                data-xy="1-620: width_box font_px_012"
                                            >
                                            <div class="padding_px-x_010" data-xy="1-620: padding_px-x_005">-</div>
                                            <input
                                                class="width_px_105 height_px_035 fontstyle1 font_px_015 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                                type="text"
                                                name="user_company_registration_number3"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>
                                                data-bd-a-color="#dbdbdb"
                                                data-signup-text="사업자번호"
                                                data-xy="1-620: width_box font_px_012"
                                            >
                                            <div id="company_check1"
                                                 class="pointer check flex_xc_yc margin_px-l_010 width_px_115 height_px_035 fontstyle1 font_px_011 border_px-a_001 border_bre-a_004"
                                                 data-color="#ffffff"
                                                 data-bg-color="#202020"
                                                 data-bd-a-color="#202020"
                                                 data-xy="1-620: width_box">
                                                확인
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 법인사업자 섹션 (ID 부여)
                            $option_group_query = "SELECT * FROM egb_option_group
                                                   WHERE group_code = 'user_company_name2'
                                                     AND deleted_at IS NULL
                                                   LIMIT 1";
                            $option_group    = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled  = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div id="corporate_info_box" class="display_none">
                                <div class="flex_ft border_px-u_001" data-bd-a-color="#f3f3f3">
                                    <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled || $option_required == 0) ? 'display_none' : ''; ?>"
                                         data-bd-a-color="#f3f3f3"
                                         data-xy="1-620: flex_ft border_px-u_000">
                                        <div class="flex_fl_yc width_px_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                             data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                            <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                                  <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>
                                            법인명
                                        </div>
                                        <input
                                            class="width_px_400 height_px_035 margin_px-l_025 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 font_px_015"
                                            type="text"
                                            name="<?php echo $option_group[0]['group_code']; ?>"
                                            <?php echo $option_required == 2 ? 'required' : ''; ?>
                                            data-bd-a-color="#dbdbdb"
                                            data-signup-text="법인명"
                                            data-xy="1-620: width_box del-margin_px-l_000 font_px_012"
                                        >
                                    </div>
                                    <div class="flex_fl_yc <?php echo (!$option_enabled || $option_required == 0) ? 'display_none' : ''; ?>"
                                         data-xy="1-620: flex_ft border_px-u_000">
                                        <div class="flex_fl_yc width_px_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                             data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                            <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                                  <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>
                                            사업자번호
                                        </div>
                                        <div class="flex_fl_yc">
                                            <input
                                                class="width_px_070 height_px_035 margin_px-l_025 fontstyle1 font_px_015 border_px-a_001 border_bre-a_004 padding_px-x_010"
                                                type="text"
                                                name="user_company_registration_number4"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>
                                                data-bd-a-color="#dbdbdb"
                                                data-signup-text="사업자번호"
                                                data-xy="1-620: width_box margin_px-l_000 font_px_012"
                                            >
                                            <div class="padding_px-x_010" data-xy="1-620: padding_px-x_005">-</div>
                                            <input
                                                class="width_px_050 height_px_035 fontstyle1 font_px_015 border_px-a_001 border_bre-a_004 padding_px-x_010"
                                                type="text"
                                                name="user_company_registration_number5"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>
                                                data-bd-a-color="#dbdbdb"
                                                data-signup-text="사업자번호"
                                                data-xy="1-620: width_box font_px_012"
                                            >
                                            <div class="padding_px-x_010" data-xy="1-620: padding_px-x_005">-</div>
                                            <input
                                                class="width_px_105 height_px_035 fontstyle1 font_px_015 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                                type="text"
                                                name="user_company_registration_number6"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>
                                                data-bd-a-color="#dbdbdb"
                                                data-signup-text="사업자번호"
                                                data-xy="1-620: width_box font_px_012"
                                            >
                                            <div id="company_check2"
                                                 class="pointer check flex_xc_yc margin_px-l_010 width_px_115 height_px_035 fontstyle1 font_px_011 border_px-a_001 border_bre-a_004"
                                                 data-color="#ffffff"
                                                 data-bg-color="#202020"
                                                 data-bd-a-color="#202020"
                                                 data-xy="1-620: width_box">
                                                확인
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script nonce="<?php echo NONCE; ?>">
                        document.addEventListener('DOMContentLoaded', function() {
                            const radios         = document.querySelectorAll('input[name="shopping_mall_user_type_business"]');
                            const individualBox  = document.getElementById('individual_info_box');
                            const corporateBox   = document.getElementById('corporate_info_box');
                        
                            radios.forEach(function(radio) {
                                const lbl = document.querySelector('label[for="' + radio.id + '"]');
                                if (!lbl) return;
                            
                                // 라벨이 '개인사업자'면 individualBox 토글
                                if (lbl.textContent.trim() == '개인사업자') {
                                    radio.addEventListener('change', function() {
                                        if (radio.checked) {
                                            individualBox.classList.remove('display_none');
                                            corporateBox.classList.add('display_none');
                                        }
                                    });
                                    if (radio.checked) {
                                        individualBox.classList.remove('display_none');
                                        corporateBox.classList.add('display_none');
                                    }
                                }
                            
                                // 라벨이 '법인사업자'면 corporateBox 토글
                                if (lbl.textContent.trim() == '법인사업자') {
                                    radio.addEventListener('change', function() {
                                        if (radio.checked) {
                                            corporateBox.classList.remove('display_none');
                                            individualBox.classList.add('display_none');
                                        }
                                    });
                                    if (radio.checked) {
                                        corporateBox.classList.remove('display_none');
                                        individualBox.classList.add('display_none');
                                    }
                                }
                            });
                        });
                        </script>

                        <input type="hidden" name="user_company_registration_number" value="">

                        <script nonce="<?php echo NONCE; ?>">
                        // 회사 확인 버튼 클릭 이벤트 리스너
                        document.getElementById("company_check1").addEventListener("click", function(event) {
                        
                            // 클릭된 버튼 참조
                            const busunessCheckButton = document.getElementById("company_check1");
                        
                            // 클릭 상태 확인
                            if (busunessCheckButton.getAttribute("data-checked") == "true") {
                                alert("이미 확인되었습니다.");
                                return;
                            }
                        
                        	egbAjaxDataHook('company_check1_form_input', function (formData) {
                        		// 사업자 등록 번호 가져오기
                        		const part1 = document.querySelector('input[name="user_company_registration_number1"]').value;
                        		const part2 = document.querySelector('input[name="user_company_registration_number2"]').value;
                        		const part3 = document.querySelector('input[name="user_company_registration_number3"]').value;
                            
                        		// 사업자 번호 문자열로 연결
                        		const businessNumber = part1 + part2 + part3;
                            
                                // 사업자명 가져오기
                                const businessName = document.querySelector('input[name="user_company_name"]').value;
                            
                                formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>'); // CSRF 토큰 추가
                        		formData.append('b_no[]', [businessNumber]); // 사업자 번호 추가
                                formData.append('b_nm', businessName); // 사업자명 추가
                            
                        	});
                        });

                        // 법인 확인 버튼 클릭 이벤트 리스너
                        document.getElementById("company_check2").addEventListener("click", function(event) {
                            // 클릭된 버튼 참조
                            const corporationCheckButton = document.getElementById("company_check2");
                        
                            // 클릭 상태 확인
                            if (corporationCheckButton.getAttribute("data-checked") == "true") {
                                alert("이미 확인되었습니다.");
                                return;
                            }
                        
                        	egbAjaxDataHook('company_check2_form_input', function (formData) {
                        		// 법인 등록 번호 가져오기
                        		const part4 = document.querySelector('input[name="user_company_registration_number4"]').value;
                        		const part5 = document.querySelector('input[name="user_company_registration_number5"]').value;
                        		const part6 = document.querySelector('input[name="user_company_registration_number6"]').value;
                            
                        		// 법인 번호 문자열로 연결
                        		const corporationNumber = part4 + part5 + part6;

                                // 법인명 가져오기
                                const corporationName = document.querySelector('input[name="user_company_name2"]').value;

                                formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>'); // CSRF 토큰 추가
                        		formData.append('b_no[]', [corporationNumber]); // 법인 번호 추가
                                formData.append('b_nm', corporationName); // 법인명 추가
                            
                        	});
                        });
                        </script>
                        
                        <div>
                            <?php
                            // 옵션 그룹 조회
                            $tree = egb_option_flat('community_user_grade');

                            // 옵션 그룹 정보 조회 
                            $query = "SELECT group_required, group_title, group_code FROM egb_option_group WHERE group_code = 'community_user_grade' AND is_status = 1";
                            $binding = binding_sql(1, $query, []);
                            $result = egb_sql($binding);

                            $display_class = 'display_none';
                            $required = false;
                            $group_title = '커뮤니티 회원 등급'; // 기본값

                            if(isset($result[0])) {
                                if($result[0]['group_required'] == 0) {
                                    $display_class = 'display_none'; // 미사용
                                } else {
                                    $display_class = ''; // 사용 또는 필수
                                    if($result[0]['group_required'] == 2) {
                                        $required = true; // 필수
                                    }
                                }
                                $group_title = $result[0]['group_title'];
                            }
                            ?>

                            <div class="flex_fl_yc border_px-u_001 <?php echo $display_class; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_015 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $required ? 'data-bg-color="#ff5555"' : ''; ?>></span><?php echo $group_title; ?>
                                </div>
                                <div class="flex_fl_yc_wrap padding_px-x_025 padding_px-y_015" 
                                    data-xy="1-620: padding_px-x_000 padding_px-y_010">
                                    <?php
                                    if (!empty($tree)) {
                                        foreach ($tree as $option) {
                                            ?>
                                            <div class="flex_yc padding_px-r_025">
                                                <input class="pointer width_px_012 height_px_012"
                                                    id="<?php echo $result[0]['group_code']; ?>_<?php echo $option['uniq_id']; ?>" 
                                                    name="<?php echo $result[0]['group_code']; ?>" 
                                                    type="radio" 
                                                    data-signup-text="커뮤니티 회원 등급"
                                                    value="<?php echo $option['uniq_id']; ?>"
                                                    <?php echo $required ? 'required' : ''; ?>>
                                                <label class="pointer padding_px-l_005" 
                                                    for="<?php echo $result[0]['group_code']; ?>_<?php echo $option['uniq_id']; ?>">
                                                    <?php echo $option['label']; ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_mentor_id' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 2;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;
                            ?>
                            <div id="mentor_id_box" class="flex_fl_yc border_px-u_001 display_none <?php echo !$option_enabled ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>멘토아이디
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="멘토아이디" 
                                        placeholder="멘토아이디를 입력해주세요." <?php echo $option_required ? '' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">멘토아이디를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>

                        <script nonce="<?php echo NONCE; ?>">
                        document.addEventListener('DOMContentLoaded', function() {
                            const radios    = document.querySelectorAll('input[name="community_user_grade"]');
                            const mentorBox = document.getElementById('mentor_id_box');
                        
                            radios.forEach(function(radio) {
                                const lbl = document.querySelector('label[for="' + radio.id + '"]');
                                if (!lbl) return;
                            
                                // 라벨이 '멘티'인 경우
                                if (lbl.textContent.trim() == '멘티') {
                                    radio.addEventListener('change', function() {
                                        if (radio.checked) {
                                            mentorBox.classList.remove('display_none');
                                        }
                                    });
                                    if (radio.checked) {
                                        mentorBox.classList.remove('display_none');
                                    }
                                } 
                                // 그 외 옵션을 선택했을 때는 숨김
                                else {
                                    radio.addEventListener('change', function() {
                                        if (radio.checked) {
                                            mentorBox.classList.add('display_none');
                                        }
                                    });
                                }
                            });
                        });
                        </script>

                        <div class="flex_ft font_px_012 padding_px-y_020" data-color="#898989" data-xy="1-620: font_px_010">
                            <div>구독제 회원 유형을 선택하신 후 결제가 이루어지지 않으면 일반회원으로 전환됩니다.</div>
                            <div>회원가입 완료 후 선택하신 유형에 맞는 구독료를 결제하시고 승인을 기다려주세요.</div>
                        </div>
                        <div class="width_px_450 margin_x_auto flex_xc border_bre-a_100 font_px_012 padding_px-y_008 pointer"
                            data-bg-color="#15376b" data-xy="1-620: width_box" data-color="#ffffff">
                            <span data-color="#ffffff">이젠오토&nbsp;</span><span class="flv6" data-color="#ffffff">커뮤니티
                                회원등급</span><span data-color="#ffffff">&nbsp;상세 안내</span>
                        </div>
                        <div class="font_px_020 flv6 padding_px-t_050 padding_px-u_025 border_px-u_003" data-color="#202020"
                            data-bd-a-color="#202020">
                            기본정보
                        </div>
                        
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_id' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 2;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>아이디
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_035 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="아이디" 
                                        placeholder="아이디" <?php echo $option_required ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012 margin_px-l_000">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">영문, 숫자를 포함한 6자 이상의 아이디를
                                        입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_password' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 2;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>비밀번호
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="password" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="비밀번호" 
                                        placeholder="비밀번호" <?php echo $option_required ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">영문, 숫자를 포함한 8자 이상의 비밀번호를
                                        입력해주세요.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_password_check' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 2;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>비밀번호 확인
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="password" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="비밀번호 확인" 
                                        placeholder="비밀번호 확인" <?php echo $option_required ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">비밀번호를 한번 더 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_name' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 2;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>이름
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="이름"
                                        placeholder="이름" <?php echo $option_required ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">이름을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_nick_name' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 0;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;
                            $is_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] == 2;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $is_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>별명
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="별명"
                                        placeholder="별명" <?php echo $is_required ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">별명을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 우편번호 옵션 그룹 설정 불러오기
                            $zipcode_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_zipcode' AND deleted_at IS NULL LIMIT 1";
                            $zipcode_group = egb_sql(binding_sql(1, $zipcode_query));
                            $zipcode_required = isset($zipcode_group[0]['group_required']) && $zipcode_group[0]['group_required'] == 2;
                            $zipcode_enabled = isset($zipcode_group[0]['group_required']) && $zipcode_group[0]['group_required'] >= 1;

                            // 기본주소 옵션 그룹 설정 불러오기
                            $address_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_address' AND deleted_at IS NULL LIMIT 1";
                            $address_group = egb_sql(binding_sql(1, $address_query));
                            $address_required = isset($address_group[0]['group_required']) && $address_group[0]['group_required'] == 2;
                            $address_enabled = isset($address_group[0]['group_required']) && $address_group[0]['group_required'] >= 1;

                            // 상세주소 옵션 그룹 설정 불러오기
                            $address_detail_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_address_detail' AND deleted_at IS NULL LIMIT 1";
                            $address_detail_group = egb_sql(binding_sql(1, $address_detail_query));
                            $address_detail_required = isset($address_detail_group[0]['group_required']) && $address_detail_group[0]['group_required'] == 2;
                            $address_detail_enabled = isset($address_detail_group[0]['group_required']) && $address_detail_group[0]['group_required'] >= 1;
                            ?>
                            <div class="flex_fl_yc height_box border_px-u_001 height_px_155 <?php echo (!$zipcode_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft height_box border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $zipcode_required ? 'data-bg-color="#ff5555"' : ''; ?>></span>주소
                                </div>
                                <div class="padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <div class="flex_fl_yc width_box">
                                        <input id="user_address1" type="text" name="<?php echo $zipcode_group[0]['group_code']; ?>"
                                            class="width_px_270 margin_px-r_010 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                            data-bd-a-color="#dbdbdb" data-signup-text="우편번호" data-bg-color="#eeeeee" placeholder="우편번호" <?php echo $zipcode_required ? 'required' : ''; ?>
                                            value="" disabled data-xy="1-620: width_box font_px_012">
                                        <input id="user_address1_1" type="hidden" data-signup-text="우편번호" name="<?php echo $zipcode_group[0]['group_code']; ?>" value="">
                                        <div class="flex_xc_yc width_px_120 height_px_040 border_bre-a_004 border_px-a_001 font_px_014 pointer check"
                                            data-bg-color="#202020" data-bd-a-color="#202020" data-xy="1-620: font_px_012"
                                            data-color="#ffffff">
                                            <span id="address_check" data-color="#ffffff">주소찾기</span>
                                        </div>
                                    </div>
                                    <input id="user_address2" type="text" 
                                        class="margin_px-y_010 width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" data-bg-color="#eeeeee" data-signup-text="기본주소" placeholder="기본주소" <?php echo $address_required ? 'required' : ''; ?> disabled
                                        value="" data-xy="1-620: width_box font_px_012">
                                    <input id="user_address2_1" type="hidden" data-signup-text="기본주소" name="<?php echo $address_group[0]['group_code']; ?>" value="">
                                    <input id="user_address3" type="text" name="<?php echo $address_detail_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="상세주소"
                                        placeholder="상세주소" <?php echo $address_detail_required ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                </div>
                            </div>
                        </div>

                        
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'phone_number1' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] >= 1;

                            // 지역번호 옵션 가져오기
                            $phone_options = egb_option_flat('phone_number');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo (!$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>휴대전화
                                </div>
                                <div class="flex_yc padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <select type="text" name="<?php echo $option_group[0]['group_code']; ?>1" 
                                        class="width_px_115 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="휴대전화"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?> data-xy="1-620: width_box font_px_012">
                                        <?php foreach($phone_options as $option): ?>
                                        <option value="<?php echo htmlspecialchars($option['label']); ?>"><?php echo htmlspecialchars($option['label']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="flex_xc width_px_028 padding_px-x_000"
                                        data-xy="1-620: width_px_020 padding_px-x_010">-</div>
                                    <input type="number" data-signup-text="휴대전화" name="<?php echo $option_group[0]['group_code']; ?>2" 
                                        class="width_px_115 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" <?php echo $option_required == 2 ? 'required' : ''; ?> 
                                        data-xy="1-620: width_box font_px_012"
                                        maxlength="4" 
                                        pattern="[0-9]{4}">
                                    <div class="flex_xc width_px_027 padding_px-x_000"
                                        data-xy="1-620: width_px_020 padding_px-x_010">-</div>
                                    <input type="number" data-signup-text="휴대전화" name="<?php echo $option_group[0]['group_code']; ?>3" 
                                        class="width_px_115 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" <?php echo $option_required == 2 ? 'required' : ''; ?> 
                                        data-xy="1-620: width_box font_px_012"
                                        maxlength="4"
                                        pattern="[0-9]{4}">
                                </div>
                            </div>
                        </div>

                        
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'phone_number2' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;

                            // 지역번호 옵션 가져오기
                            $phone_options = egb_option_flat('phone_number');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>기타 연락처
                                </div>
                                <div class="flex_yc padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <select type="text" name="<?php echo $option_group[0]['group_code']; ?>1" 
                                        class="width_px_115 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="기타 연락처"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?> data-xy="1-620: width_box font_px_012">
                                        <?php foreach($phone_options as $option): ?>
                                        <option value="<?php echo htmlspecialchars($option['label']); ?>"><?php echo htmlspecialchars($option['label']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="flex_xc width_px_028 padding_px-x_000"
                                        data-xy="1-620: width_px_020 padding_px-x_010">-</div>
                                    <input type="number" name="<?php echo $option_group[0]['group_code']; ?>2" 
                                        class="width_px_115 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="기타 연락처"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?> 
                                        data-xy="1-620: width_box font_px_012"
                                        maxlength="4"
                                        pattern="[0-9]{4}">
                                    <div class="flex_xc width_px_027 padding_px-x_000"
                                        data-xy="1-620: width_px_020 padding_px-x_010">-</div>
                                    <input type="number" name="<?php echo $option_group[0]['group_code']; ?>3" 
                                        class="width_px_115 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="기타 연락처"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?> 
                                        data-xy="1-620: width_box font_px_012"
                                        maxlength="4"
                                        pattern="[0-9]{4}">
                                </div>
                            </div>
                        </div>
                        
                        <div>            
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_email1' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;

                            // 이메일 옵션 가져오기
                            $email_options = egb_option_flat('user_email2');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>이메일
                                </div>
                                <div class="flex_yc padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <div class="" data-xy="1-620: width_box">
                                        <input type="text" name="<?php echo $option_group[0]['group_code']; ?>1" 
                                            class="width_px_185 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                            data-bd-a-color="#dbdbdb" 
                                            data-signup-text="이메일"
                                            placeholder="이메일" <?php echo $option_required == 2 ? 'required' : ''; ?>
                                            data-xy="1-620: width_box font_px_012">
                                    </div>
                                    <div class="padding_px-x_008 min_width_030 flex_xc" data-xy="1-620: min_width_025 padding_px-x_002">@</div>
                                    <div class="position1 emailbox_container" data-xy="1-620: width_box">
                                        <select name="<?php echo $option_group[0]['group_code']; ?>2" 
                                            class="width_px_185 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 emailbox"
                                            data-bd-a-color="#dbdbdb" 
                                            data-signup-text="이메일"
                                            <?php echo $option_required == 2 ? 'required' : ''; ?> data-xy="1-620: width_box font_px_012">
                                            <option value="선택해주세요." hidden selected disabled>선택해주세요.</option>
                                            <option value="email_custom_value">직접입력</option>
                                            <?php foreach($email_options as $option): ?>
                                            <option value="<?php echo htmlspecialchars($option['label']); ?>"><?php echo htmlspecialchars($option['label']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="text" name="<?php echo $option_group[0]['group_code']; ?>3" 
                                            class="width_px_185 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 position2 email_custom_input"
                                            data-bd-a-color="#dbdbdb" 
                                            data-signup-text="이메일"
                                            placeholder="직접입력" data-top="0%" data-left="0%"
                                            style="display:none; box-sizing: border-box;"
                                            data-xy="1-620: width_box font_px_012">
                                        <span class="email_custom_close">&times;</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_gender' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <?php
                            // 성별 옵션 가져오기
                            $tree = egb_option_flat('user_gender');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>성별
                                </div>
                                <div class="flex_fl_yc padding_px-x_025 padding_px-y_015"
                                    data-xy="1-620: padding_px-x_000 padding_px-y_010">
                                    <?php
                                    if (!empty($tree)) {
                                        foreach ($tree as $option) {
                                    ?>
                                        <div class="flex_yc padding_px-r_025">
                                            <input class="pointer width_px_012 height_px_012"
                                                id="<?php echo $option_group[0]['group_code']; ?>_<?php echo $option['uniq_id']; ?>"
                                                name="<?php echo $option_group[0]['group_code']; ?>"
                                                type="radio"
                                                data-signup-text="성별"
                                                value="<?php echo $option['label']; ?>"
                                                <?php echo $option_required == 2 ? 'required' : ''; ?>>
                                            <label class="pointer padding_px-l_005"
                                                for="<?php echo $option_group[0]['group_code']; ?>_<?php echo $option['uniq_id']; ?>">
                                                <?php echo $option['label']; ?>
                                            </label>
                                        </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="font_px_020 flv6 padding_px-t_050 padding_px-u_025 border_px-u_003" data-color="#202020"
                            data-bd-a-color="#202020">
                            추가정보
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_homepage' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>홈페이지
                                </div>
                                <div class="flex_yc padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <div class="" data-xy="1-620: width_box">
                                        <input type="text" name="<?php echo $option_group[0]['group_code']; ?>"
                                            class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                            data-bd-a-color="#dbdbdb" 
                                            data-signup-text="홈페이지"
                                            placeholder="홈페이지를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                            data-xy="1-620: width_box font_px_012">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_registration_purpose' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>가입목적
                                </div>
                                <div class="flex_yc padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <div class="" data-xy="1-620: width_box">
                                        <input type="text" name="<?php echo $option_group[0]['group_code']; ?>"
                                            class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                            data-bd-a-color="#dbdbdb" 
                                            data-signup-text="가입목적"
                                            placeholder="가입목적을 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                            data-xy="1-620: width_box font_px_012">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_funnel_source' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>유입경로
                                </div>
                                <div class="flex_yc padding_px-l_025" data-xy="1-620: padding_px-l_000">
                                    <div class="" data-xy="1-620: width_box">
                                        <input type="text" name="<?php echo $option_group[0]['group_code']; ?>"
                                            class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                            data-bd-a-color="#dbdbdb" 
                                            data-signup-text="유입경로"
                                            placeholder="유입경로를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                            data-xy="1-620: width_box font_px_012">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_birthday' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;

                            // 년도, 월, 일 옵션 그룹 조회
                            $year_query = "SELECT * FROM egb_option_group WHERE group_code = 'year' AND deleted_at IS NULL LIMIT 1";
                            $month_query = "SELECT * FROM egb_option_group WHERE group_code = 'month' AND deleted_at IS NULL LIMIT 1";
                            $day_query = "SELECT * FROM egb_option_group WHERE group_code = 'day' AND deleted_at IS NULL LIMIT 1";

                            $year_group = egb_sql(binding_sql(1, $year_query));
                            $month_group = egb_sql(binding_sql(1, $month_query));
                            $day_group = egb_sql(binding_sql(1, $day_query));

                            // 각 옵션 조회
                            $year_options = egb_option_flat('year');
                            $month_options = egb_option_flat('month');
                            $day_options = egb_option_flat('day');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>생일
                                </div>
                                <div class="flex_fl_yc">
                                    <select name="user_birth_day1" 
                                        class="width_px_109 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 margin_px-l_025 birth_year"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="생일"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box margin_px-l_000 font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php
                                        foreach($year_options as $option) {
                                            echo '<option value="'.$option['label'].'">'.$option['label'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div>년</div>
                                    <select name="user_birth_day2"
                                        class="width_px_109 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 margin_px-l_015 birth_month"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="생일"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box margin_px-l_010 font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php
                                        foreach($month_options as $option) {
                                            echo '<option value="'.$option['label'].'">'.$option['label'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div>월</div>
                                    <select name="user_birth_day3"
                                        class="width_px_109 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 margin_px-l_015 birth_day"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="생일"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box margin_px-l_010 font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php
                                        foreach($day_options as $option) {
                                            echo '<option value="'.$option['label'].'">'.$option['label'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div>일</div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_custom_day' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;

                            $year_options = egb_option_flat('year');
                            $month_options = egb_option_flat('month'); 
                            $day_options = egb_option_flat('day');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>기념일
                                </div>
                                <div class="flex_fl_yc">
                                    <select name="user_custom_day1" 
                                        class="width_px_109 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 margin_px-l_025 anniversary_year"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="기념일"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box margin_px-l_000 font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php
                                        foreach($year_options as $option) {
                                            echo '<option value="'.$option['label'].'">'.$option['label'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div>년</div>
                                    <select name="user_custom_day2"
                                        class="width_px_109 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 margin_px-l_015 anniversary_month"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="기념일"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box margin_px-l_010 font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php
                                        foreach($month_options as $option) {
                                            echo '<option value="'.$option['label'].'">'.$option['label'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div>월</div>
                                    <select name="user_custom_day3"
                                        class="width_px_109 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015 margin_px-l_015 anniversary_day"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="기념일"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box margin_px-l_010 font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php
                                        foreach($day_options as $option) {
                                            echo '<option value="'.$option['label'].'">'.$option['label'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div>일</div>
                                </div>
                            </div>
                        </div>
                        
                        <div>      
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_bank_alias' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>계좌별칭
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="계좌별칭"
                                        placeholder="계좌별칭을 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">계좌별칭을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_bank_account' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>계좌번호
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="계좌번호"
                                        placeholder="계좌번호를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">계좌번호를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_bank_holder' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>예금주
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="예금주"
                                        placeholder="예금주를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">예금주를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_job' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>직업
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="직업"
                                        placeholder="직업을 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">직업을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_company_name3' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>회사명
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="회사명"
                                        placeholder="회사명을 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">회사명을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_department' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>부서
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="부서"
                                        placeholder="부서를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">부서를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_position' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>직책
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="직책"
                                        placeholder="직책을 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">직책을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_work_phone' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>직장 전화
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="tel" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="직장 전화"
                                        placeholder="직장 전화번호를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">직장 전화번호를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_work_fax' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>직장 팩스
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="tel" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="직장 팩스"
                                        placeholder="직장 팩스번호를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">직장 팩스번호를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_work_address' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>직장 주소
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="직장 주소"
                                        placeholder="직장 주소를 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">직장 주소를 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_activity_area' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>활동지역
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <input type="text" name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="활동지역"
                                        placeholder="활동지역을 입력해주세요." <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">활동지역을 입력해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_car_cc' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;

                            // 자동차 옵션 가져오기
                            $car_cc_options = egb_option_flat('user_car_cc');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>자동차
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <select name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="자동차"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                        <option value="0" selected>없음</option>
                                        <?php foreach($car_cc_options as $option): ?>
                                        <option value="<?php echo htmlspecialchars($option['uniq_id']); ?>"><?php echo htmlspecialchars($option['label']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">자동차를 선택해주세요.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            // 옵션 그룹 설정 불러오기
                            $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_region' AND deleted_at IS NULL LIMIT 1";
                            $option_group = egb_sql(binding_sql(1, $option_group_query));
                            $option_required = isset($option_group[0]['group_required']) ? $option_group[0]['group_required'] : 0;
                            $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] == 1;

                            // 지역 옵션 가져오기
                            $region_options = egb_option_flat('user_region');
                            ?>
                            <div class="flex_fl_yc border_px-u_001 <?php echo ($option_required == 0 || !$option_enabled) ? 'display_none' : ''; ?>" data-bd-a-color="#f3f3f3"
                                data-xy="1-620: flex_ft border_px-u_000">
                                <div class="flex_fl_yc height_box min_width_160 padding_px-l_015 padding_px-y_025 font_px_014 flv6 signup_bgcolor"
                                    data-xy="1-620: width_box padding_px-l_000 padding_px-y_010 del-signup_bgcolor">
                                    <span class="width_px_003 height_px_003 border_bre-a_003 margin_px-r_010"
                                        <?php echo $option_required == 2 ? 'data-bg-color="#ff5555"' : ''; ?>></span>지역
                                </div>
                                <div class="flex_ft padding_px-t_005 padding_px-l_025"
                                    data-xy="1-620: padding_px-t_005 padding_px-l_000">
                                    <select name="<?php echo $option_group[0]['group_code']; ?>" id="signup_<?php echo $option_group[0]['group_code']; ?>"
                                        class="width_px_400 height_px_040 font_px_015 fontstyle1 border_px-a_001 border_bre-a_004 padding_px-x_015"
                                        data-bd-a-color="#dbdbdb" 
                                        data-signup-text="지역"
                                        <?php echo $option_required == 2 ? 'required' : ''; ?>
                                        data-xy="1-620: width_box font_px_012">
                                        <option value="0" selected>없음</option>
                                        <?php foreach($region_options as $option): ?>
                                        <option value="<?php echo htmlspecialchars($option['uniq_id']); ?>"><?php echo htmlspecialchars($option['label']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-y_002 font_px_012" data-color="#828C94">지역을 선택해주세요.</div>
                                </div>
                            </div>
                        </div>
			            <form id="signup_input" class="step2_button" action="<?php echo DOMAIN.'/?post=signup_input'; ?>" method="post" enctype="multipart/form-data">
			            	<div class="flex_xc width_box padding_px-t_030 padding_px-u_015 font_px_016">
			            		<div class="width_box padding_px-r_005">
			            			<div class="flex_xc_yc width_box border_px-a_001 border_bre-a_005 padding_px-y_015 pointer prevstep1"
			            				data-bd-a-color="#d9d9d9" data-color="#202020">이전으로</div>
			            		</div>
			            		<div id="signup_complete_link" class="width_box padding_px-l_005">
			            			<div class="flex_xc_yc width_box border_px-a_001 border_bre-a_005 padding_px-y_015 pointer submit_check"
			            				data-bd-a-color="#202020" data-bg-color="#202020" data-color="#ffffff">회원가입</div>
			            		</div>
			            	</div>
			            </form>                    
                    </div>
                <div class="flex_xc_yc font_px_015">
                    <div class="padding_px-r_010" data-color="#202020">이미 아이디가 있으신가요?</div>
                    <div class="flv6" style="text-decoration: underline;"><a class="pointer"
                            href="<?php echo DOMAIN . '/page/login'; ?>">로그인</a></div>
                </div>
            </div>
        </div>
    </div>

<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    select {
        box-sizing: border-box;
        background-color: transparent;
    }

    .signup_bgcolor {
        background-color: #f3f3f3;
    }

    .cancelsignup:hover {
        border-color: #202020;
    }

    p {
        margin-bottom: 10px;
    }

    .stepcolor {
        color: #202020;
        font-weight: 600;
    }

    input {
        all: unset;
        box-sizing: border-box;
    }

    .check:hover {
        background-color: #15376b;
    }

    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"] {
        outline: none;
    }

    select {
        outline: none;
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

    input[type="text"]:focus,
    input[type="password"]:focus {
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
        width: 12px;
        height: 12px;
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
        width: 8px;
        height: 8px;
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
    }

    .blink {
        animation: blink-animation 0.5s step-end infinite alternate;
    }

    @keyframes blink-animation {
        50% {
            outline: 2px solid #ff5555;
        }

        100% {
            outline: 2px solid transparent;
        }
    }
</style>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js" nonce="<?php echo NONCE; ?>"></script>
<script nonce="<?php echo NONCE; ?>">
    // address_check 요소에 클릭 이벤트 추가
    document.getElementById('address_check').addEventListener('click', function() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색 결과 항목을 클릭했을 때 실행할 코드를 작성하는 부분입니다.
                
                // 주소의 타입에 따라 도로명주소와 지번주소를 사용할 수 있습니다.
                var roadAddr = data.roadAddress; // 도로명 주소
                var jibunAddr = data.jibunAddress; // 지번 주소

                // 우편번호를 user_address1에 보이도록 하고, 실제 값을 히든 필드에 넣음
                document.getElementById("user_address1").value = data.zonecode;
                document.getElementById("user_address1_1").value = data.zonecode;

                // 기본주소를 user_address2에 보이도록 하고, 실제 값을 히든 필드에 넣음
                var address = roadAddr ? roadAddr : jibunAddr;
                document.getElementById("user_address2").value = address;
                document.getElementById("user_address2_1").value = address;

                // 상세주소 입력 필드는 사용자가 직접 입력하므로 여기서는 설정하지 않음
                
                // disabled 속성은 그대로 유지
            }
        }).open();
    });
</script>

<script nonce="<?php echo NONCE; ?>">
document.querySelector('.submit_check')?.addEventListener('click', function(event) {
    event.preventDefault();
    
    // 필수 입력값 체크
    const requiredElements = document.querySelectorAll('[required]');
    
    // 필수값이 있는 경우에만 체크
    if (requiredElements?.length) {
        for (const element of requiredElements) {
            if (!element) continue;

            // select나 radio 체크
            if (element.type === 'radio') {
                const radioGroup = document.querySelectorAll(`input[name="${element.name}"]`);
                if (!radioGroup?.length) continue;

                let isChecked = false;
                for (const radio of radioGroup) {
                    if (radio?.checked) {
                        isChecked = true;
                        break;
                    }
                }
                if (!isChecked) {
                    const labelText = element.getAttribute('data-signup-text') || element.name;
                    alert(`${labelText}을(를) 선택해주세요.`);
                    element.focus();
                    return;
                }
                continue;
            }

            if (element.tagName === 'SELECT') {
                if (!element.value) {
                    const labelText = element.getAttribute('data-signup-text') || element.name;
                    alert(`${labelText}을(를) 선택해주세요.`);
                    element.focus();
                    return;
                }
                continue;
            }

            // 일반 입력필드 체크
            if (!element.value?.trim()) {
                const labelText = element.getAttribute('data-signup-text') || element.placeholder || element.name;
                alert(`${labelText}을(를) 입력해주세요.`);
                element.focus();
                return;
            }
        }
    }

    // 필수값 체크 통과 또는 필수값이 없는 경우 폼 제출 진행
    egbAjaxDataHook('signup_input', function(formData) {
        if (!formData) return;

        formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');
        
        // 쇼핑몰 회원 구분 값 가져오기
        const shoppingMallUserType = document.querySelector('input[name="shopping_mall_user_type"]:checked');
        if (shoppingMallUserType) {
            formData.append('shopping_mall_user_type', shoppingMallUserType.value);
            
            const label = document.querySelector(`label[for="${shoppingMallUserType.id}"]`);
            const shoppingMallUserTypeLabel = label?.textContent?.trim();

            if (shoppingMallUserTypeLabel === '기업회원') {
                // 사업자 구분 값 가져오기
                const businessType = document.querySelector('input[name="shopping_mall_user_type_business"]:checked');
                if (businessType) {
                    formData.append('shopping_mall_user_type_business', businessType.value);
                    
                    const businessLabel = document.querySelector(`label[for="${businessType.id}"]`);
                    const businessTypeLabel = businessLabel?.textContent?.trim();

                    if (businessTypeLabel === '개인사업자') {
                        const companyNum1 = document.querySelector('input[name="user_company_registration_number1"]')?.value || '';
                        const companyNum2 = document.querySelector('input[name="user_company_registration_number2"]')?.value || '';
                        const companyNum3 = document.querySelector('input[name="user_company_registration_number3"]')?.value || '';
                        
                        const companyName = document.querySelector('input[name="user_company_name"]')?.value;
                        if (companyName) {
                            formData.append('user_company_name', companyName);
                        }
                        
                        const registrationNumber = companyNum1 + companyNum2 + companyNum3;
                        formData.append('user_company_registration_number', registrationNumber);
                    }
                    
                    if (businessTypeLabel === '법인사업자') {
                        const companyNum4 = document.querySelector('input[name="user_company_registration_number4"]')?.value || '';
                        const companyNum5 = document.querySelector('input[name="user_company_registration_number5"]')?.value || '';
                        const companyNum6 = document.querySelector('input[name="user_company_registration_number6"]')?.value || '';
                        
                        const registrationNumber = companyNum4 + companyNum5 + companyNum6;
                        formData.append('user_company_registration_number', registrationNumber);
                        
                        const companyName2 = document.querySelector('input[name="user_company_name2"]')?.value;
                        if (companyName2) {
                            formData.append('user_company_name2', companyName2);
                        }
                    }
                }
            }
        }

        // 커뮤니티 회원등급 값 가져오기
        const communityUserGrade = document.querySelector('input[name="community_user_grade"]:checked');
        if (communityUserGrade) {
            formData.append('community_user_grade', communityUserGrade.value);
            
            const gradeLabel = document.querySelector(`label[for="${communityUserGrade.id}"]`);
            const communityUserGradeLabel = gradeLabel?.textContent?.trim();

            if (communityUserGradeLabel === '멘티') {
                const userMentorId = document.querySelector('input[name="user_mentor_id"]')?.value;
                if (userMentorId) {
                    formData.append('user_mentor_id', userMentorId);
                }
            }
        }

        // 필수 입력 항목
        const userId = document.getElementById('signup_user_id')?.value;
        if (userId) {
            formData.append('user_id', userId);
        }

        const userPassword = document.getElementById('signup_user_password')?.value;
        if (userPassword) {
            formData.append('user_password', userPassword);
        }

        const userPasswordCheck = document.getElementById('signup_user_password_check')?.value;
        if (userPasswordCheck) {
            formData.append('user_password_check', userPasswordCheck);
        }

        const userName = document.getElementById('signup_user_name')?.value;
        if (userName) {
            formData.append('user_name', userName);
        }

        const userNickName = document.getElementById('signup_user_nick_name')?.value;
        if (userNickName) {
            formData.append('user_nick_name', userNickName);
        }

        const userZipcode = document.getElementById('user_address1_1')?.value;
        if (userZipcode) {
            formData.append('user_zipcode', userZipcode);
        }

        const userAddress = document.getElementById('user_address2_1')?.value;
        if (userAddress) {
            formData.append('user_address', userAddress);
        }

        const userAddressDetail = document.getElementById('user_address3')?.value;
        if (userAddressDetail) {
            formData.append('user_address_detail', userAddressDetail);
        }

        // 전화번호 1
        const phone1 = document.querySelector('select[name="phone_number11"]')?.value || '';
        const phone2 = document.querySelector('input[name="phone_number12"]')?.value || '';
        const phone3 = document.querySelector('input[name="phone_number13"]')?.value || '';
        if (phone2 && phone3) {
            formData.append('phone_number1', phone1 + phone2 + phone3);
        } else {
            formData.append('phone_number1', '');
        }

        // 전화번호 2
        const phone4 = document.querySelector('select[name="phone_number21"]')?.value || '';
        const phone5 = document.querySelector('input[name="phone_number22"]')?.value || '';
        const phone6 = document.querySelector('input[name="phone_number23"]')?.value || '';
        if (phone5 && phone6) {
            formData.append('phone_number2', phone4 + phone5 + phone6);
        } else {
            formData.append('phone_number2', '');
        }

        // 이메일
        const email1 = document.querySelector('input[name="user_email11"]')?.value || '';
        const emailSelect = document.querySelector('select[name="user_email12"]');
        const email2 = emailSelect?.value || '선택해주세요.';
        if (email2 && email2 !== '선택해주세요.') {
            formData.append('user_email', email1 + '@' + email2);
        } else {
            formData.append('user_email', '');
        }

        // 성별
        const userGender = document.querySelector('input[name="user_gender"]:checked');
        formData.append('user_gender', userGender?.value || '');

        // 기타 정보
        const userHomepage = document.querySelector('input[name="user_homepage"]')?.value;
        if (userHomepage) {
            formData.append('user_homepage', userHomepage);
        }

        const userRegistrationPurpose = document.querySelector('input[name="user_registration_purpose"]')?.value;
        if (userRegistrationPurpose) {
            formData.append('user_registration_purpose', userRegistrationPurpose);
        }

        const userFunnelSource = document.querySelector('input[name="user_funnel_source"]')?.value;
        if (userFunnelSource) {
            formData.append('user_funnel_source', userFunnelSource);
        }

        // 생년월일
        const birthYear = document.querySelector('select[name="user_birth_day1"]')?.value || '';
        const birthMonth = document.querySelector('select[name="user_birth_day2"]')?.value || '';
        const birthDay = document.querySelector('select[name="user_birth_day3"]')?.value || '';
        if (birthYear && birthMonth && birthDay) {
            formData.append('user_birthday', birthYear + '-' + birthMonth + '-' + birthDay);
        } else {
            formData.append('user_birthday', '');
        }

        // 기념일
        const customYear = document.querySelector('select[name="user_custom_day1"]')?.value || '';
        const customMonth = document.querySelector('select[name="user_custom_day2"]')?.value || '';
        const customDay = document.querySelector('select[name="user_custom_day3"]')?.value || '';
        if (customYear && customMonth && customDay) {
            formData.append('user_custom_day', customYear + '-' + customMonth + '-' + customDay);
        } else {
            formData.append('user_custom_day', '');
        }

        // 은행 정보
        const userBankAlias = document.querySelector('input[name="user_bank_alias"]')?.value;
        if (userBankAlias) {
            formData.append('user_bank_alias', userBankAlias);
        }

        const userBankAccount = document.querySelector('input[name="user_bank_account"]')?.value;
        if (userBankAccount) {
            formData.append('user_bank_account', userBankAccount);
        }

        const userBankHolder = document.querySelector('input[name="user_bank_holder"]')?.value;
        if (userBankHolder) {
            formData.append('user_bank_holder', userBankHolder);
        }

        // 직장 정보
        const userJob = document.querySelector('input[name="user_job"]')?.value;
        if (userJob) {
            formData.append('user_job', userJob);
        }

        const userCompanyName = document.querySelector('input[name="user_company_name3"]')?.value;
        if (userCompanyName) {
            formData.append('user_company_name3', userCompanyName);
        }

        const userDepartment = document.querySelector('input[name="user_department"]')?.value;
        if (userDepartment) {
            formData.append('user_department', userDepartment);
        }

        const userPosition = document.querySelector('input[name="user_position"]')?.value;
        if (userPosition) {
            formData.append('user_position', userPosition);
        }

        const userWorkPhone = document.querySelector('input[name="user_work_phone"]')?.value;
        if (userWorkPhone) {
            formData.append('user_work_phone', userWorkPhone);
        }

        const userWorkFax = document.querySelector('input[name="user_work_fax"]')?.value;
        if (userWorkFax) {
            formData.append('user_work_fax', userWorkFax);
        }

        const userWorkAddress = document.querySelector('input[name="user_work_address"]')?.value;
        if (userWorkAddress) {
            formData.append('user_work_address', userWorkAddress);
        }

        // 활동 정보
        const userActivityArea = document.querySelector('input[name="user_activity_area"]')?.value;
        if (userActivityArea) {
            formData.append('user_activity_area', userActivityArea);
        }

        const userCarCC = document.querySelector('select[name="user_car_cc"]')?.value;
        if (userCarCC && userCarCC !== '0') {
            formData.append('user_car_cc', userCarCC);
        }

        const userRegion = document.querySelector('select[name="user_region"]')?.value;
        if (userRegion && userRegion !== '0') {
            formData.append('user_region', userRegion);
        }
    });
});
</script>