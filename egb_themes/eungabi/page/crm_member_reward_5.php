<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_reward_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">멘티 마일리지 소멸</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>리워드</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">멘티마일리지 소멸</div>
                    </div>
                </div>
            </div>
            <div class="flex_ft width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9"
                data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">소멸 방법</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_extinction" id="crm_member_reward_extinction_manual"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010" for="crm_member_reward_extinction_manual">수동 소멸
                            처리</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_extinction" id="crm_member_reward_extinction_auto"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005" for="crm_member_reward_extinction_auto">자동 소멸 처리</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: padding_px-y_032 padding_px-l_010 border_px-u_001">
                        소멸 대상 기간</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-1200: flex_ft border_px-u_000 del-height_px_055, 1201-1500: flex_ft border_px-u_001 del-height_px_055">
                        <div class="flex_fl_yc min_width_310 width_px_310 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_orderday" id="crm_member_reward_orderday_today"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_reward_orderday_today"
                                data-xy="1-800: padding_px-r_010">오늘</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_orderday" id="crm_member_reward_orderday_3day"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_reward_orderday_3day"
                                data-xy="1-800: padding_px-r_010">3일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_orderday" id="crm_member_reward_orderday_7day"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_reward_orderday_7day"
                                data-xy="1-800: padding_px-r_010">7일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_orderday"
                                id="crm_member_reward_orderday_period_search"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_020"
                                for="crm_member_reward_orderday_period_search"
                                data-xy="1-800: padding_px-r_000">기간검색</label>
                        </div>
                        <div class="flex_fl_yc width_box height_box" data-bg-color="#ffffff" data-xy="1-1200: flex_ft">
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_year_1" name=""
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_year_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="선택" selected hidden disabled>선택</option>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_month_1" name=""
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_month_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="선택" selected hidden disabled>선택</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_day_1" name=""
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_day_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="선택" selected hidden disabled>선택</option>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                            <div class="padding_px-x_010 padding_px-y_000"
                                data-xy="1-800: flex_xc padding_px-x_000 padding_px-y_010, 801-1200: flex_xc padding_px-x_000 padding_px-y_005">
                                ~</div>
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_year_2" name=""
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_year_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="선택" selected hidden disabled>선택</option>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_month_2" name=""
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_month_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="선택" selected hidden disabled>선택</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_day_2" name=""
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_day_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="선택" selected hidden disabled>선택</option>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script nonce="<?php echo NONCE; ?>">
                    document.addEventListener('DOMContentLoaded', function () {
                        const today = new Date();

                        // 라디오 버튼과 기간 선택 요소
                        const radioButtons = document.querySelectorAll('input[name="crm_member_reward_orderday"]');
                        const yearSelects = [
                            document.getElementById('crm_member_reward_year_1'),
                            document.getElementById('crm_member_reward_year_2'),
                        ];
                        const monthSelects = [
                            document.getElementById('crm_member_reward_month_1'),
                            document.getElementById('crm_member_reward_month_2'),
                        ];
                        const daySelects = [
                            document.getElementById('crm_member_reward_day_1'),
                            document.getElementById('crm_member_reward_day_2'),
                        ];

                        radioButtons.forEach(radio => {
                            radio.addEventListener('change', function () {
                                const value = this.id;

                                // 초기화
                                yearSelects.forEach(select => select.selectedIndex = 0);
                                monthSelects.forEach(select => select.selectedIndex = 0);
                                daySelects.forEach(select => {
                                    select.selectedIndex = 0;
                                    select.disabled = true; // 비활성화
                                });

                                let date1 = new Date(today); // 첫 번째 그룹의 날짜
                                let date2 = new Date(today); // 두 번째 그룹의 날짜

                                if (value === 'crm_member_reward_orderday_today') {
                                    setDate(date1, date2, yearSelects, monthSelects, daySelects);
                                } else if (value === 'crm_member_reward_orderday_3day') {
                                    date1.setDate(today.getDate() - 3); // 첫 번째 그룹은 3일 전
                                    setDate(date1, date2, yearSelects, monthSelects, daySelects);
                                } else if (value === 'crm_member_reward_orderday_7day') {
                                    date1.setDate(today.getDate() - 7); // 첫 번째 그룹은 7일 전
                                    setDate(date1, date2, yearSelects, monthSelects, daySelects);
                                }
                            });
                        });

                        // 월이 변경될 때 일자를 자동으로 업데이트
                        monthSelects.forEach((monthSelect, index) => {
                            monthSelect.addEventListener('change', function () {
                                const year = yearSelects[index].value;
                                const month = monthSelect.value;
                                const daySelect = daySelects[index];

                                // 일자 선택 초기화 및 활성화
                                daySelect.selectedIndex = 0;
                                daySelect.disabled = false; // 활성화

                                // 가능한 일 수 계산
                                const daysInMonth = new Date(year, month, 0).getDate();
                                // 기존 옵션 삭제
                                daySelect.innerHTML = '<option value="선택" selected hidden disabled>선택</option>';

                                for (let day = 1; day <= daysInMonth; day++) {
                                    const option = document.createElement('option');
                                    option.value = day;
                                    option.textContent = day;
                                    daySelect.appendChild(option);
                                }
                            });
                        });

                        function setDate(date1, date2, yearSelects, monthSelects, daySelects) {
                            // 첫 번째 그룹의 날짜 설정
                            yearSelects[0].value = date1.getFullYear();
                            monthSelects[0].value = date1.getMonth() + 1; // 0-11 범위를 1-12로 변환
                            monthSelects[0].dispatchEvent(new Event('change')); // 월 변경 이벤트 트리거
                            daySelects[0].value = date1.getDate();

                            // 두 번째 그룹의 날짜 설정 (오늘 날짜로 고정)
                            yearSelects[1].value = date2.getFullYear();
                            monthSelects[1].value = date2.getMonth() + 1; // 0-11 범위를 1-12로 변환
                            monthSelects[1].dispatchEvent(new Event('change')); // 월 변경 이벤트 트리거
                            daySelects[1].value = date2.getDate();
                        }
                    });
                </script>
                <div class="flex_fl_yc width_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-912: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box border_px-u_000, 801-912: padding_px-y_018 padding_px-l_010 border_px-u_000">
                        쇼핑몰 구분</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-912: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 border_px-u_000 del-height_px_055">
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_shopingmall" id="crm_member_reward_shopingmall_all"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_shopingmall_all">전체</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_shopingmall"
                                id="crm_member_reward_shopingmall_egenautomall"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_shopingmall_egenautomall">이젠오토몰</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_shopingmall"
                                id="crm_member_reward_shopingmall_egenmall" data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_shopingmall_egenmall">이젠몰</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_shopingmall"
                                id="crm_member_reward_shopingmall_coupang" data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_shopingmall_coupang">쿠팡</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_shopingmall"
                                id="crm_member_reward_shopingmall_smartstore"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_shopingmall_smartstore">스마트스토어</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_shopingmall"
                                id="crm_member_reward_shopingmall_11st" data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_shopingmall_11st">11번가</label>
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 1</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_memberclass_one" id="crm_member_reward_memberclass_one_all"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_reward_memberclass_one_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_memberclass_one" id="crm_member_reward_memberclass_one_yes"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_reward_memberclass_one_yes">회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_memberclass_one" id="crm_member_reward_memberclass_one_no"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005" for="crm_member_reward_memberclass_one_no">비회원</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 2</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_memberclass_two" id="crm_member_reward_memberclass_two_all"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_reward_memberclass_two_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_memberclass_two" id="crm_member_reward_memberclass_two_yes"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_reward_memberclass_two_yes">개인회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_reward_memberclass_two" id="crm_member_reward_memberclass_two_no"
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005" for="crm_member_reward_memberclass_two_no">사업자</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-968: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box border_px-u_000, 801-968: padding_px-y_018 padding_px-l_010 height_box border_px-u_000">
                        커뮤니티 등급</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-968: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 border_px-u_000 del-height_px_055">
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_communitylevel"
                                id="crm_member_reward_communitylevel_all" data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_communitylevel_all">전체</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_communitylevel"
                                id="crm_member_reward_communitylevel_normal"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_communitylevel_normal">일반회원</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_communitylevel"
                                id="crm_member_reward_communitylevel_mentee"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_communitylevel_mentee">멘티</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_communitylevel"
                                id="crm_member_reward_communitylevel_mento" data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_communitylevel_mento">멘토</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_communitylevel"
                                id="crm_member_reward_communitylevel_partner"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_communitylevel_partner">파트너</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_communitylevel"
                                id="crm_member_reward_communitylevel_franchise"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_reward_communitylevel_franchise">가맹점</label>
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">소멸 대상 기준 금액</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <select class="width_px_200 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="" id="" data-xy="1-800: width_box font_px_012">
                            <option value="전체" hidden selected disabled>전체</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">검색일 안내</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <div>
                            <select class="width_px_200 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="" id=""
                                data-xy="1-800: width_box font_px_012">
                                <option value="아이디디" hidden selected disabled>아이디</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="width_px_020"></div>
                        <div class="" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <input class="width_px_200 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="" id=""
                                data-xy="1-800: width_box font_px_012">
                        </div>
                    </div>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">소멸대상 멘티 마일리지 통계</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl width_box height_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="flex_fl_yc width_box font_style_center" data-xy="1-800: flex_ft">
                        <div class="width_box flex_ft border_px-r_001 border_px-u_000" data-bd-a-color="#d9d9d9"
                            data-xy="1-800: border_px-r_000 border_px-u_001">
                            <div class="padding_px-y_015 border_px-u_001 flv6" data-bg-color="#efefef"
                                data-bd-a-color="#d9d9d9">적립금 소멸 대상 회원수</div>
                            <div class="padding_px-y_015">0</div>
                        </div>
                        <div class="width_box flex_ft border_px-r_001 border_px-u_000" data-bd-a-color="#d9d9d9"
                            data-xy="1-800: border_px-r_000 border_px-u_001">
                            <div class="padding_px-y_015 border_px-u_001 flv6" data-bg-color="#efefef"
                                data-bd-a-color="#d9d9d9">사용가능 적립금 합계</div>
                            <div class="padding_px-y_015">0</div>
                        </div>
                        <div class="width_box flex_ft" data-bd-a-color="#d9d9d9">
                            <div class="padding_px-y_015 border_px-u_001 flv6" data-bg-color="#efefef"
                                data-bd-a-color="#d9d9d9">소멸대상 적립금 합계</div>
                            <div class="padding_px-y_015">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span>검색하기</span>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">소멸대상 적립금 조회 결과</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;<span class="flv6"
                                data-color="#15376b">523</span>건&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                data-color="#15376b">3</span>명
                        </div>
                        <div class="flex_fl_yc padding_px-t_000" data-xy="1-800: padding_px-t_010">
                            <div class="flex_xc padding_px-l_005">
                                <div class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">SMS</div>
                            </div>
                            <div class="flex_xc padding_px-l_005">
                                <div class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">EXCEL</div>
                            </div>
                        </div>
                    </div>
                    <div class="padding_px-r_010 padding_px-t_000"
                        data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                        <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                            name="" id="" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                            <option value="30개씩 보기">30개씩 보기</option>
                            <option value="30개씩 보기">20개씩 보기</option>
                            <option value="30개씩 보기">10개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 18% 18% 18% 18% 18%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_reward_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_reward_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원등급</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">사용가능적립금
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">소멸대상적립금
                            </div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">소멸 후 사용가능 적립금</div>
                        </div>
                        <div class="grid_xx border_px-u_001" data-xx="5% 5% 18% 18% 18% 18% 18%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <label for="crm_searching_member_reward_1"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_reward_1" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">1</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                        </div>
                        <div class="grid_xx border_px-u_001" data-xx="5% 5% 18% 18% 18% 18% 18%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <label for="crm_searching_member_reward_2"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_reward_2" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">2</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">2</div>
                        </div>
                        <div class="grid_xx border_px-u_001" data-xx="5% 5% 18% 18% 18% 18% 18%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <label for="crm_searching_member_reward_3"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_reward_3" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">3</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">0</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">3</div>
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
    .crm_member_reward_color {
        background-color: #15376b;
    }

    .crm_member_reward_3_bg {
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

    // 연도를 채우는 함수
    function populateYears(selectElement) {
        const currentYear = new Date().getFullYear(); // 현재 연도
        for (let year = 1920; year <= currentYear; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            selectElement.appendChild(option);
        }
    }

    // 월과 연도 선택에 따라 일수를 갱신하는 함수
    function updateDays(yearSelect, monthSelect, daySelect) {
        const selectedYear = parseInt(yearSelect.value);
        const selectedMonth = parseInt(monthSelect.value);
        const daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

        daySelect.innerHTML = ''; // 기존 일 옵션 초기화
        for (let day = 1; day <= daysInMonth; day++) {
            const option = document.createElement('option');
            option.value = day;
            option.textContent = day;
            daySelect.appendChild(option);
        }
    }

    // 그룹 관리 배열
    const dateGroups = [];

    const groupCount = 2; // 그룹의 수 (필요한 그룹 수만큼 설정)
    for (let i = 1; i <= groupCount; i++) {
        dateGroups.push({
            year: document.querySelector(`.crm_member_reward_year_${i}`),
            month: document.querySelector(`.crm_member_reward_month_${i}`),
            day: document.querySelector(`.crm_member_reward_day_${i}`)
        });
    }

    // 각 그룹에 대해 연도 채우기 및 이벤트 리스너 추가
    dateGroups.forEach(group => {
        populateYears(group.year);

        group.month.addEventListener('change', () => updateDays(group.year, group.month, group.day));
        group.year.addEventListener('change', () => updateDays(group.year, group.month, group.day));

        // 초기 실행 시 기본 일 갱신
        updateDays(group.year, group.month, group.day);
    });


</script>