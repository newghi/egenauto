<form id="manual_form_input" class="position1" action="<?php echo DOMAIN . '/?post=manual_form_input'; ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
<section class="position3 width_box height_px_080 border_px-u_001 z-index_2"
        data-bg-color="#ffffff" data-bd-a-color="#dddddd" data-top="0">
        <div class="width_px_1220 margin_x_auto position1 height_px_080 padding_px-a_010" data-xy="1-1220: width_box">
            <div class="flex_xs1_yc" data-color="#2F3438">
                <div class="flex_fl_yc font_px_018 flv6">
                    <div class="font_px_025 pointer">
                        <a href="<?php echo DOMAIN; ?>"><img class="width_px_160 height_px_060"
                                src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>"></a>
                    </div>
                </div>
                <div id="manual_write_header" class="flex_fr_yc font_px_014" style="white-space: nowrap;">
                    <div id="manual_submit_button"
                        class="padding_px-x_040 flex_xc_yc height_px_040 border_bre-a_004 pointer buttonselect egb_submit"
                        data-bg-color="#15376b" data-color="#ffffff">
                        올리기
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="width_box height_px_080"></div>

    <section class="position1 width_box">
        <div class="width_px_800 margin_x_auto padding_px-t_050" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="border_px-a_001 border_bre-a_005 padding_px-a_020" data-bd-a-color="#dfdfdf"
                    style="box-shadow: 0px 0px 5px 0.5px #00000050">
                    <div class="flex_xs1_yc">
                        <div class="flex_fl_yc">
                            <div class="flex_xc_yc width_px_025 height_px_025 border_bre-a_030" data-bg-color="#15376b">
                                <div class="width_px_015 height_px_015">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0"
                                        y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g transform="matrix(1,0,0,-1,0,24)">
                                            <path
                                                d="M2 6a1 1 0 0 1 1-1h18a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1zm19 5H3a1 1 0 0 0 0 2h18a1 1 0 0 0 0-2zm-9 6H3a1 1 0 0 0 0 2h9a1 1 0 0 0 0-2z"
                                                fill="#ffffff" opacity="1" data-original="#000000" class=""></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: flex_ft">
                                <span class="font_px_016 flv6 padding_px-l_015 padding_px-r_010"
                                    data-xy="1-800: font_px_014 padding_px-l_010 padding_px-r_000">정비 매뉴얼 작성 가이드</span>
                                <span class="font_px_012 padding_px-l_000" data-color="#888888"
                                    data-xy="1-800: font_px_010 padding_px-l_010">원활한 셀프 정비 매뉴얼 작성을위해 꼭 읽어주세요!</span>
                            </div>
                        </div>
                        <div class="width_px_015 height_px_015 pointer rotate openguide">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g
                                    transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                    <path
                                        d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                        data-name="chevron-right-Bold" fill="#888888" opacity="1"
                                        data-original="#000000" class=""></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="flex_ft padding_px-x_010 font_px_014 guidebox overflow_hidden"
                        data-xy="1-800: font_px_012">
                        <div class="padding_px-t_020"></div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>아래 필수 정보 입력란에서 모든 항목을 채워주세요.</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>목록에서 보여질 대표 이미지를 업로드해주세요.</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>작업 과정을 기록한 사진이나 영상 파일을 업로드 해주세요</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>각 사진과 영상 아래에 해당 과정에 대한설명을 글로 적어주세요.</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>정비 방법과 필요한 도구, 부품 정보, 셀프정비소 정보 등을 명확하게
                                기재해주세요.</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>타인의 지식재산권을 침해하지 않도록 주의해 주세요. 사용한 자료는 출처를
                                명시해주세요.</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>작성하신 매뉴얼은 이젠오토 홈에 노출 될 수 있습니다.</span>
                        </div>
                        <div class="flex_fl_yc padding_px-u_010">
                            <span class="flv6">·&nbsp;&nbsp;</span><span>여러분의 소중한 경험을 공유하여 많은 분들이 도움을 받을 수 있도록
                                해주세요.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box">
        <div class="width_px_800 margin_x_auto padding_px-t_020" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="border_px-a_001 border_bre-a_005 padding_px-a_020" data-bd-a-color="#dfdfdf"
                    style="box-shadow: 0px 0px 5px 0.5px #00000050">
                    <div class="flex_xs1_yc">
                        <div class="flex_fl_yc">
                            <div class="flex_xc_yc width_px_025 height_px_025 border_bre-a_030" data-bg-color="#15376b">
                                <div class="width_px_015 height_px_015">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="#ffffff"
                                        width="100%" height="100%">
                                        <g>
                                            <g>
                                                <path d="M498.125,92.38l-78.505-78.506c-18.496-18.497-48.436-18.5-66.935,0C339.518,27.043,50.046,316.516,44.525,322.035
            c-2.182,2.182-3.725,4.918-4.46,7.915L0.502,491.068c-3.036,12.368,8.186,23.44,20.431,20.432
            c8.361-2.053,153.718-37.747,161.117-39.564c2.996-0.735,5.734-2.278,7.915-4.46c5.816-5.816,293.677-293.677,308.161-308.161
            C516.622,140.818,516.627,110.879,498.125,92.38z M39.957,472.043l1.612-6.562l4.951,4.951L39.957,472.043z M84.874,461.014
            l-33.887-33.887l14.736-60.009l79.16,79.16L84.874,461.014z M178.022,431.647l-97.668-97.668L332.559,81.773l97.668,97.668
            L178.022,431.647z M474.24,135.429l-19.508,19.507l-97.667-97.668l19.507-19.507c5.294-5.293,13.867-5.298,19.163,0l78.506,78.507
            C479.536,121.563,479.536,130.132,474.24,135.429z" />
                                            </g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </svg>

                                </div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: flex_ft">
                                <span class="font_px_016 flv6 padding_px-l_015 padding_px-r_010"
                                    data-xy="1-800: font_px_014 padding_px-l_010 padding_px-r_000">정비 매뉴얼 작성 가이드</span>
                                <span class="font_px_012 padding_px-l_000" data-color="#888888"
                                    data-xy="1-800: font_px_010 padding_px-l_010">원활한 셀프 정비 매뉴얼 작성을위해 꼭 읽어주세요!</span>
                            </div>
                        </div>
                        <div class="width_px_015 height_px_015 pointer rotate openguide">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g
                                    transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                    <path
                                        d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                        data-name="chevron-right-Bold" fill="#888888" opacity="1"
                                        data-original="#000000" class=""></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="flex_ft padding_px-x_010 font_px_016 guidebox overflow_hidden" data-xy="1-800: font_px_012">
                        <div class="padding_px-t_020"></div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015" data-xy="1-800: flex_ft padding_px-y_010 del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">정비 카테고리</div>
                            <div>
                                <select name="manual_category"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                     
                                    // 옵션 가져오기
                                    $options = egb_option_flat('manual_category');
                                    
                                    foreach($options as $option) {
                                        echo '<option value="'.$option['uniq_id'].'">'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015" data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">작업 인원</div>
                            <div class="flex_fl_yc">
                                <?php
                                // 옵션 가져오기 
                                $options = egb_option_flat('manual_worker');
                                
                                foreach($options as $index => $option):
                                    $id = "work_head_count_" . ($index + 1);
                                ?>
                                <input id="<?php echo $id; ?>" name="manual_worker" value="<?php echo $option['label']; ?>"
                                    type="radio" class="width_px_014 height_px_014 border_px-a_001"
                                    data-bd-a-color="#000000" <?php echo $index === 0 ? 'required' : ''; ?>>
                                <label class="padding_px-l_003 padding_px-r_015" for="<?php echo $id; ?>"><?php echo $option['label']; ?></label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">셀프정비소
                            </div>
                            <div class="flex_fl_yc">
                                <input type="text" name="manual_self_repair_shop"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    placeholder="셀프정비소를 입력해주세요." data-xy="1-800: width_box font_px_012" required>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">작업기간</div>
                            <div class="flex_fl_yc">
                                <input type="number" name="auto_manual_board_work_date1" id="work_date1"
                                    class="width_px_145 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005 margin_px-r_010"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                <select name="auto_manual_board_work_date2" id="work_date2"
                                    class="width_px_145 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <option value="시간">시간</option>
                                    <option value="일">일</option>
                                    <option value="개월">개월</option>
                                    <option value="년">년</option>
                                </select>
                                <input type="hidden" name="manual_worker_time" id="manual_worker_time">
                                <script nonce="<?php echo NONCE; ?>">
                                    document.getElementById('work_date1').addEventListener('change', combineWorkTime);
                                    document.getElementById('work_date2').addEventListener('change', combineWorkTime);
                                    
                                    function combineWorkTime() {
                                        const date1 = document.getElementById('work_date1').value;
                                        const date2 = document.getElementById('work_date2').value;
                                        if(date1 && date2) {
                                            document.getElementById('manual_worker_time').value = date1 + date2;
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="flex_fl padding_px-y_015" data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">예산</div>
                            <div class="flex_ft">
                                <div class="flex_fl_yc padding_px-u_010" data-xy="1-800: flex_ft">
                                    <div class="width_px_060 padding_px-u_000" data-xy="1-800:  padding_px-u_010">부품
                                    </div>
                                    <div class="budget">
                                        <input name="manual_worker_budget_part" id="parts" type="number"
                                            class="width_px_240 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                            data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                            style="text-align: right;" data-xy="1-800: width_box font_px_012" required>
                                    </div>
                                </div>
                                <div class="flex_fl_yc padding_px-u_010" data-xy="1-800: flex_ft">
                                    <div class="width_px_060 padding_px-u_000" data-xy="1-800:  padding_px-u_010">소모품
                                    </div>
                                    <div class="budget">
                                        <input name="manual_worker_budget_consumable" id="supplies" type="number"
                                            class="width_px_240 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                            data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                            style="text-align: right;" data-xy="1-800: width_box font_px_012" required>
                                    </div>
                                </div>
                                <div class="flex_fl_yc padding_px-u_010" data-xy="1-800: flex_ft">
                                    <div class="width_px_060 padding_px-u_000" data-xy="1-800:  padding_px-u_010">총예산
                                    </div>
                                    <div class="budget">
                                        <input name="auto_manual_board_budget3" id="total" disabled type="number"
                                            class="width_px_240 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                            data-bd-a-color="#888888" data-bg-color="#e5e5e5" data-color="#000000"
                                            style="text-align: right;" data-xy="1-800: width_box font_px_012">
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="flex_fl_yc height_px_050 padding_px-y_015" data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">작업유형</div>
                            <div class="flex_fl_yc">
                                <?php
                                // 작업유형 옵션 가져오기
                                $tree = egb_option_flat('manual_worker_type');
                                if (!empty($tree)) {
                                    foreach ($tree as $option) {
                                        ?>
                                        <input id="worker_type_<?php echo $option['uniq_id']; ?>" 
                                            name="manual_worker_type" 
                                            value="<?php echo $option['uniq_id']; ?>" 
                                            type="radio"
                                            class="width_px_014 height_px_014 border_px-a_001" 
                                            data-bd-a-color="#000000" 
                                            <?php echo ($option['label'] === '국산') ? 'checked' : ''; ?> 
                                            required>
                                        <label class="padding_px-l_003 padding_px-r_015" 
                                            for="worker_type_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">제조사</div>
                            <div>
                                <select name="manual_worker_brand" id="domestic_maker"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005 domestic_car"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                    // 국산 제조사 옵션 가져오기
                                    $tree = egb_option_flat('manual_brand_domestic');
                                    if (!empty($tree)) {
                                        foreach ($tree as $option) {
                                            echo '<option value="' . $option['uniq_id'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <select name="manual_worker_brand" id="import_maker"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005 display_none import_car"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" disabled>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                    // 수입 제조사 옵션 가져오기  
                                    $tree = egb_option_flat('manual_brand_import');
                                    if (!empty($tree)) {
                                        foreach ($tree as $option) {
                                            echo '<option value="' . $option['uniq_id'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">차종</div>
                            <div>
                                <select name="auto_manual_board_car_model"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                    // 차종 목록 가져오기
                                    $tree = egb_option_flat('manual_car_model');
                                    if (!empty($tree)) {
                                        foreach ($tree as $option) {
                                            echo '<option value="' . $option['uniq_id'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">외형</div>
                            <div>
                                <select name="auto_manual_board_car_type"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                    // 차량 외형 목록 가져오기
                                    $options = egb_option_flat('manual_car_exterior');
                                    
                                    if (!empty($options)) {
                                        foreach ($options as $option) {
                                            echo '<option value="' . $option['uniq_id'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">모델명</div>
                            <div class="flex_fl_yc">
                                <input type="text" name="manual_car_model_name"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    placeholder="모델명을 입력해주세요." data-xy="1-800: width_box font_px_012" required>

                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">유종</div>
                            <div>
                                <select name="auto_manual_board_car_oil_type"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                    // 유종 목록 가져오기
                                    $options = egb_option_flat('manual_car_fuel');
                                    
                                    if (!empty($options)) {
                                        foreach ($options as $option) {
                                            echo '<option value="' . $option['uniq_id'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex_fl_yc height_px_050 padding_px-y_015"
                            data-xy="1-800: flex_ft del-height_px_050">
                            <div class="width_px_140 flv6 padding_px-u_000" data-xy="1-800: padding_px-u_010">연식</div>
                            <div>
                                <select name="auto_manual_board_car_model_year"
                                    class="width_px_300 padding_px-x_010 padding_px-y_008 fontstyle1 font_px_015 border_px-a_001 border_bre-a_005 yearcar"
                                    data-bd-a-color="#888888" data-bg-color="#ffffff" data-color="#000000"
                                    data-xy="1-800: width_box font_px_012" required>
                                    <option value="" disabled selected hidden>선택</option>
                                    <?php
                                    // 연식 목록 가져오기
                                    $options = egb_option_flat('manual_car_year');
                                    
                                    if (!empty($options)) {
                                        foreach ($options as $option) {
                                            echo '<option value="' . $option['uniq_id'] . '">' . $option['label'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box">
        <div class="width_px_800 margin_x_auto padding_px-t_020" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="flex_ft_xc_yc border_bre-a_005 width_box min_height_500 height_box font_px_016 font_style_center"
                    data-bg-color="#e5e5e5" data-xy="1-800: font_px_013 min_height_200">
                    <!--<div class="flex_ft_yc font_px_018 flv6" data-xy="1-800: font_px_015">
                        <div>드래그 앤 드롭이나 추가하기 버튼으로</div>
                        <div>커버 사진을 업로드해주세요.</div>
                    </div>
                    <div class="flex_ft_yc padding_px-y_020" data-color="#888888">
                        <div>*권장 사이즈</div>
                        <div>모바일: 1920 x 1920, 최소: 1400 x 1400(1:1비율)</div>
                        <div>PC: 1920 x 1080, 최소: 1400 x 787(16:9비율)</div>
                    </div>-->
                    <div class="flex_ft_xc_yc manual_img_box width_box min_height_500 border_bre-a_005 overflow_hidden"
                        data-xy="1-800: min_height_200">
                        <input type="file" name="images[]" multiple accept="image/*" class="img_files display_none">
                        <img class="manual_img width_px_025 height_px_025 "
                            src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                        <div class="padding_px-t_010">
                            <div class="manual_contents_img_upload_button filechoice border_bre-a_005 padding_px-y_015 padding_px-x_025 flv6 pointer"
                                data-bg-color="#15376b" data-color="#ffffff">썸네일 이미지 등록</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box">
        <div class="width_px_800 margin_x_auto padding_px-t_020" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="manual_content border_bre-a_005 width_box height_px_500 flex_ft_yc font_px_016"
                    data-bg-color="#ffffff">
                    <div class="position1 width_box flex_ft_yc font_px_018 flv6 border_px-u_001 budget2"
                        data-bd-a-color="#dddddd">
                        <input type="text" name="titles[]"
                            class="manual_content_title padding_px-x_025 padding_px-y_015 font_px_025 flv6 width_box nothover"
                            maxlength="80" placeholder="제목을 입력해주세요." data-color="#000000" data-xy="1-800: font_px_018">
                    </div>
                    <div class="width_box flex_ft_yc font_px_018 flv6 padding_px-t_015">
                        <div id="egbeditor2" class="manual_content_content padding_px-x_025 padding_px-y_015 width_box"
                            name="contents[]"></div>
                        <!--
                        <div id="egbeditor2" name="contents[]"
                            class="manual_content_content height_px_400 padding_px-x_025 padding_px-y_015 font_px_015 width_box nothover"
                            data-color="#000000" placeholder="내용을 입력해주세요" data-xy="1-800: font_px_012"></div>
                    -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="padding_px-u_100"></section>
</form>
<style>
    .egbeditor2_click {
        outline: none;
    }
</style>

<?php egbeditor2(); ?>

<script nonce="<?php echo NONCE; ?>">
document.addEventListener("DOMContentLoaded", function () {

    function setUpUploadButton(uploadButton) {
        if (uploadButton.dataset.initialized) return;
        uploadButton.dataset.initialized = true;

        const fileInput = document.createElement("input");
        fileInput.type = "file";
        fileInput.accept = "image/*";

        uploadButton.addEventListener("click", () => fileInput.click());

        fileInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                uploadButton.fileInput = fileInput;
                handleFileUpload(file, uploadButton, !uploadButton.file && !uploadButton.dataset.replaced && !uploadButton.dataset.dragged);
            }
        });

        setUpDragAndDrop(uploadButton.closest(".manual_img_box"), uploadButton);

        const imgElement = uploadButton.closest(".manual_img_box").querySelector(".manual_img");
        imgElement.onclick = () => uploadButton.click();
    }

    function handleFileUpload(file, uploadButton, isNewUpload) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imgBox = uploadButton.closest(".manual_img_box");
            imgBox.classList.remove("height_px_420");
            const dataUrl = e.target.result;
            const imgElement = imgBox.querySelector(".manual_img");
            imgElement.src = dataUrl;
            imgElement.style.width = "100%";
            imgElement.style.height = "auto";

            imgElement.onclick = () => uploadButton.click();

            Array.from(imgBox.children).forEach(child => {
                if (!child.classList.contains("manual_img")) {
                    child.style.display = "none";
                }
            });

            uploadButton.file = file;
        };
        reader.readAsDataURL(file);
    }

    function setUpDragAndDrop(dropArea, uploadButton) {
        if (dropArea.dataset.initialized) return;
        dropArea.dataset.initialized = true;

        dropArea.addEventListener("dragenter", e => {
            e.preventDefault();
            dropArea.classList.add("drag-over");
        });

        dropArea.addEventListener("dragover", e => {
            e.preventDefault();
            dropArea.classList.add("drag-over");
        });

        dropArea.addEventListener("dragleave", e => {
            e.preventDefault();
            dropArea.classList.remove("drag-over");
        });

        dropArea.addEventListener("drop", e => {
            e.preventDefault();
            dropArea.classList.remove("drag-over");
            const file = e.dataTransfer.files[0];
            if (file && !uploadButton.dataset.dragged) {
                uploadButton.dataset.dragged = true;
                handleFileUpload(file, uploadButton, !uploadButton.file && !uploadButton.dataset.replaced);
                delete uploadButton.dataset.dragged;
            }
        });
    }

    const uploadButton = document.querySelector(".manual_contents_img_upload_button");
    setUpUploadButton(uploadButton);

    document.getElementById("manual_submit_button").addEventListener("click", function () {
        const firstTitleInput = document.querySelector('.manual_content_title[name="titles[]"]');
        const firstContentInput = document.querySelector('.manual_content_content[name="contents[]"]');
        const firstContentValue = firstContentInput ? firstContentInput.innerHTML.trim() : '';

        // ✅ 유효성 검사: 제목
        if (!firstTitleInput || !firstTitleInput.value.trim()) {
            alert("제목을 입력해주세요.");
            firstTitleInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstTitleInput.focus();
            return;
        }

        // ✅ 유효성 검사: 내용
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = firstContentValue;
        const textContent = tempDiv.textContent.trim();
        if (!textContent) {
            alert("내용을 입력해주세요.");
            firstContentInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstContentInput.focus();
            return;
        }

        egbAjaxDataHook('manual_form_input', function (formData) {
            const uploadButton = document.querySelector(".manual_contents_img_upload_button");
            const firstFile = uploadButton ? uploadButton.file : null;

            const category = document.querySelector('[name="manual_category"]');
            const manual_worker = document.querySelector('[name="manual_worker"]');
            const manual_self_repair_shop = document.querySelector('[name="manual_self_repair_shop"]');
            const manual_worker_time = document.querySelector('[name="manual_worker_time"]');
            const manual_worker_budget_part = document.querySelector('[name="manual_worker_budget_part"]');
            const manual_worker_budget_consumable = document.querySelector('[name="manual_worker_budget_consumable"]');
            const manual_worker_type = document.querySelector('[name="manual_worker_type"]:checked');
            const manual_worker_brand = document.querySelector('[name="manual_worker_brand"]');
            const auto_manual_board_car_model = document.querySelector('[name="auto_manual_board_car_model"]');
            const auto_manual_board_car_type = document.querySelector('[name="auto_manual_board_car_type"]');
            const manual_car_model_name = document.querySelector('[name="manual_car_model_name"]');
            const auto_manual_board_car_oil_type = document.querySelector('[name="auto_manual_board_car_oil_type"]');
            const auto_manual_board_car_model_year = document.querySelector('[name="auto_manual_board_car_model_year"]');

            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

            formData.append('titles', firstTitleInput.value);
            formData.append('contents', firstContentValue);
            formData.append('images', firstFile);
            formData.append('manual_category', category.value);
            formData.append('manual_worker', manual_worker.value);
            formData.append('manual_worker_type', manual_worker_type.value);
            formData.append('manual_self_repair_shop', manual_self_repair_shop.value);
            formData.append('manual_worker_time', manual_worker_time.value);
            formData.append('manual_worker_budget_part', manual_worker_budget_part.value);
            formData.append('manual_worker_budget_consumable', manual_worker_budget_consumable.value);
            formData.append('manual_worker_brand', manual_worker_brand.value);
            formData.append('auto_manual_board_car_model', auto_manual_board_car_model.value);
            formData.append('auto_manual_board_car_type', auto_manual_board_car_type.value);
            formData.append('manual_car_model_name', manual_car_model_name.value);
            formData.append('auto_manual_board_car_oil_type', auto_manual_board_car_oil_type.value);
            formData.append('auto_manual_board_car_model_year', auto_manual_board_car_model_year.value);
        });
    });
});
</script>

<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    .dashborder {
        border: 1px dashed #e6e6e6;
    }

    .filechoice:hover {
        background-color: #09addb;
    }

    ::placeholder {
        color: #c2c8cc;
    }

    .drag-over {
        background-color: #d0e6f7;
        /* 밝은 블루 색상으로 드래그 가능 상태를 강조 */
        border: 2px dashed #0275d8;
        /* 테두리를 점선으로 표시하여 드래그 대상임을 나타냄 */
        transition: background-color 0.3s ease-in-out, border 0.3s ease-in-out;
        /* 부드러운 전환 효과 추가 */
    }

    .instargram_img_box.drag-over {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
        /* 파란색 그림자로 드래그 가능 영역 강조 */
        transform: scale(1.05);
        /* 약간 확대하여 사용자가 드래그 중임을 강조 */
    }
</style>
<style>
    .rotate {
        transform: rotate(180deg);
        transition: 0.5s;
    }

    .rotate.reverse {
        transform: rotate(0deg);
        /* 반대 방향 회전 */
    }

    .guidebox {
        max-height: 9999px;
        /* 처음에 보이도록 */
        transition: max-height 0.5s ease-out;
    }

    select {
        box-sizing: border-box;
        background-color: transparent;
        outline: none;
    }

    input,
    textarea {
        all: unset;
        box-sizing: border-box;
    }

    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"],
    textarea {
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
        width: 15px;
        height: 15px;
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

    .budget {
        position: relative;
    }

    .budget input {
        padding-right: 40px;
        /* 만 원이 보일 공간을 만듦 */
    }

    .budget:after {
        content: '만 원';
        /* "만 원"을 input 필드 끝에 추가 */
        position: absolute;
        right: 10px;
        /* input 끝에서 조금 띄워서 위치 설정 */
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #888888;
        pointer-events: none;
        /* "만 원" 텍스트가 선택되지 않도록 설정 */
    }

    .budget2 input {
        padding-right: 65px;
        /* 만 원이 보일 공간을 만듦 */
    }

    :root {
        --char-count: '0 / 80';
        /* 초기 값 설정 */
    }

    .budget2:after {
        content: var(--char-count);
        /* CSS 변수 사용 */
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #888888;
        pointer-events: none;
    }
    </style>
    <script nonce="<?php echo NONCE; ?>">
    // 가이드 박스 토글 기능
    (function() {
        document.querySelectorAll('.openguide').forEach(function (button, index) {
            var guidebox = document.querySelectorAll('.guidebox')[index];
            var rotateIcon = document.querySelectorAll('.rotate')[index];
            var isGuideboxVisible = true;

            button.addEventListener('click', function () {
                if (isGuideboxVisible) {
                    guidebox.style.maxHeight = '0';  // 높이 0으로 설정 (접기)
                    rotateIcon.classList.add('reverse');  // 아이콘 반대 방향 회전
                } else {
                    guidebox.style.maxHeight = guidebox.scrollHeight + "px";  // 높이 설정 (펼치기)
                    rotateIcon.classList.remove('reverse');  // 원래 방향 회전
                }
                isGuideboxVisible = !isGuideboxVisible;  // 상태 반전
            });
        });
    })();
    </script>

    <script nonce="<?php echo NONCE; ?>">
    // 국산/수입 차량 선택에 따른 제조사 선택 UI 토글
    (function() {
        document.querySelectorAll('input[name="manual_worker_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const domesticSelect = document.getElementById('domestic_maker');
                const importSelect = document.getElementById('import_maker');
                
                if (this.value === document.querySelector('input[name="manual_worker_type"]').value) {
                    // 국산차 선택 시
                    domesticSelect.classList.remove('display_none');
                    domesticSelect.disabled = false;
                    importSelect.classList.add('display_none'); 
                    importSelect.disabled = true;
                } else {
                    // 수입차 선택 시
                    importSelect.classList.remove('display_none');
                    importSelect.disabled = false;
                    domesticSelect.classList.add('display_none');
                    domesticSelect.disabled = true;
                }
            });
        });
    })();
    </script>

    <script nonce="<?php echo NONCE; ?>">
    // 예산 계산 기능
    (function() {
        const partsInput = document.getElementById('parts');
        const suppliesInput = document.getElementById('supplies');
        const totalBudgetInput = document.getElementById('total');

        function updateTotalBudget() {
            const partsValue = parseFloat(partsInput.value) || 0;
            const suppliesValue = parseFloat(suppliesInput.value) || 0;
            totalBudgetInput.value = partsValue + suppliesValue;
        }

        partsInput.addEventListener('input', updateTotalBudget);
        suppliesInput.addEventListener('input', updateTotalBudget);
    })();
    </script>

    <script nonce="<?php echo NONCE; ?>">
    // 문자 수 카운터 기능
    (function() {
        document.addEventListener("DOMContentLoaded", () => {
            const input = document.querySelector('.budget2 input');
            
            if (input) {
                input.addEventListener('input', () => {
                    const maxLength = 80;
                    const currentLength = input.value.length;
                    document.documentElement.style.setProperty(
                        '--char-count',
                        `'${currentLength} / ${maxLength}'`
                    );
                });
            }
        });
    })();
    </script>