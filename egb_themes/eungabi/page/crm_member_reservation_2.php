
<?php

// 예약 데이터를 가져오는 쿼리 (기본 10개씩)
$query = "
SELECT 
    r.uniq_id,
    r.reservation_user_uniq_id,
    r.reservation_status AS status,
    r.reservation_date,
    r.reservation_time,
    r.reservation_applied_at,
    r.reservation_confirmed_at,
    r.reservation_canceled_at,
    r.reservation_no_show_at,
    r.reservation_completed_at,
    r.reservation_data,
    r.reservation_store_uniq_id,
    r.reservation_group_uniq_id,
    u.user_name,
    u.user_phone1 as user_phone,
    u.user_email,
    s.store_name
FROM egb_reservation r
LEFT JOIN egb_user u ON r.reservation_user_uniq_id = u.uniq_id
LEFT JOIN egb_store s ON r.reservation_store_uniq_id = s.uniq_id
WHERE r.is_status = 1
ORDER BY r.created_at DESC
LIMIT 10";

$binding = binding_sql(0, $query);
$result = egb_sql($binding);

// 그룹 단위로 첫 번째 레코드만 남기기
$filtered = [];
$seenGroups = [];

foreach ($result[0] as $row) {
    $gid = $row['reservation_group_uniq_id'];

    // 그룹ID가 비어있지 않을 때만 중복 체크
    if ($gid !== null && $gid !== '') {
        if (isset($seenGroups[$gid])) {
            continue;
        }
        $seenGroups[$gid] = true;
    }

    $filtered[] = $row;
}

$reservations = $filtered;

?>
<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
    <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_reservation_sub_menu.php'; ?>
    <div class="position1 flex_ft width_box height_box padding_px-a_020 no_color_change" data-bg-color="#e6e6e5">
        <div class="flex_xs1_yc padding_px-u_020"
            data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
            <div class="flex_fl_yc font_px_020 flv6">
                <div class="padding_px-r_010">예약현황확인</div>
                <div class="flex_fl_yc padding_px-x_010 padding_px-y_006 border_px-a_001 font_px_014 pointer refresh_hover_button no_color_change"
                    data-bd-a-color="#888888" data-color="#888888">
                    <div class="width_px_016 height_px_016">
                        <svg fill="#888888" id="Capa_1" enable-background="new 0 0 512.449 512.449" height="100%"
                            viewBox="0 0 512.449 512.449" width="100%" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="m152.083 286.805c7.109-8.155 1.318-20.888-9.501-20.888h-32.392c-.211-3.205-.329-6.435-.329-9.692 0-80.706 65.658-146.364 146.363-146.364 38.784 0 74.087 15.168 100.304 39.877l45.676-53.435c-39.984-36.577-91.44-56.612-145.98-56.612-57.838 0-112.214 22.524-153.112 63.421-40.897 40.898-63.421 95.274-63.421 153.112 0 3.243.081 6.473.222 9.692h-27.284c-10.819 0-16.611 12.733-9.501 20.888l61.549 70.6 12.928 14.829 46.416-53.242z" />
                                <path
                                    d="m509.321 245.614-45.907-52.658-28.57-32.771-40.791 46.789-33.686 38.64c-7.109 8.155-1.318 20.888 9.501 20.888h32.354c-5.293 75.928-68.748 136.086-145.997 136.086-33.721 0-64.811-11.469-89.586-30.703l-45.679 53.439c38.267 30.731 85.479 47.434 135.266 47.434 57.838 0 112.214-22.523 153.112-63.421 38.466-38.466 60.672-88.856 63.177-142.834h27.306c10.818-.001 16.609-12.734 9.5-20.889z" />
                            </g>
                        </svg>
                    </div>
                    <div class="padding_px-l_008">동기화</div>
                </div>
            </div>
            <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000 no_color_change" data-color="#888888"
                    data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                    <div>관리자 페이지</div>
                    <div>></div>
                    <div>설정</div>
                    <div>></div>
                    <div class="flv6" data-color="#000000">예약현황확인</div>
                </div>
            </div>
        </div>
        
        <div class="padding_px-a_005 border_px-a_002 font_px_014" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
            <div class="flex_fl_wrap padding_px-u_010">
                <div class="padding_px-a_005">
                    <select class="padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014 filter-input"
                        data-bd-a-color="#888888" name="reservation_date_type" id="reservation_date_type">
                        <option value="use_date">이용일</option>
                        <option value="request_date">신청일</option>
                    </select>
                </div>
                <div class="padding_px-a_005">
                    <select class="padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014 filter-input"
                        data-bd-a-color="#888888" name="reservation_period" id="reservation_period">
                        <option value="daily">일간</option>
                        <option value="weekly">7일</option>
                        <option value="monthly">한달</option>
                        <option value="all" selected>전체</option>
                        <option value="custom">직접선택</option>
                    </select>
                </div>
                <div class="flex_fl padding_px-a_005" data-xy="1-400: xx-50per~50per grid_xx width_box del-flex_fl">
                    <div class="padding_px-r_010" data-xy="1-400: padding_px-r_005">
                        <input class="padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014 filter-input"
                            data-bd-a-color="#888888" type="date" name="reservation_start_date" id="reservation_start_date"
                            data-xy="1-400: padding_px-x_008 padding_px-y_008">
                    </div>
                    <div class="padding_px-l_000" data-xy="1-400: padding_px-l_005">
                        <input class="padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014 filter-input"
                            data-bd-a-color="#888888" type="date" name="reservation_end_date" id="reservation_end_date"
                            data-xy="1-400: padding_px-x_008 padding_px-y_008">
                    </div>
                </div>
                <div class="padding_px-a_005">
                    <div class="position1 width_px_300 flex_fl border_px-a_001 fake_input_div" data-bd-a-color="#888888"
                        data-xy="1-400: width_box">
                        <div class="">
                            <select
                                class="width_px_120 padding_px-l_005 padding_px-y_008 border_px-a_000 font_px_014 nothover fake_input filter-input"
                                name="search_type" id="search_type" data-xy="1-400: width_px_080">
                                <option value="reserver_name">예약자명</option>
                                <option value="reserver_phone">예약자 전화번호</option>
                                <option value="reservation_id">예약번호</option>
                            </select>
                        </div>
                        <div class="">
                            <input
                                class="width_px_160 padding_px-x_015 padding_px-y_008 border_px-a_000 font_px_014 nothover fake_input filter-input"
                                type="text" name="search_keyword" id="search_keyword" data-xy="1-400: width_px_100">
                        </div>
                        <div id="search_submit" class="position2 width_px_020 height_box" data-top="0%"
                            data-right="5%">
                        </div>
                    </div>
                </div>

                <form id="reservation_search_form_input" action="/?post=reservation_search_form_input" method="post" class="padding_px-x_005 flex_xc_yc pointer">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="flex_xc_yc pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 62.993 62.993" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path d="M62.58 60.594 41.313 39.329c3.712-4.18 5.988-9.66 5.988-15.677C47.301 10.61 36.692.001 23.651.001 10.609.001 0 10.61 0 23.652c0 13.041 10.609 23.65 23.651 23.65 6.016 0 11.497-2.276 15.677-5.988l21.265 21.267a1.403 1.403 0 0 0 1.987 0c.55-.551.55-1.438 0-1.987zM23.651 44.492c-11.492 0-20.841-9.348-20.841-20.84S12.159 2.811 23.651 2.811c11.491 0 20.84 9.349 20.84 20.841 0 5.241-1.958 10.023-5.163 13.689a21.416 21.416 0 0 1-1.987 1.987c-3.666 3.206-8.449 5.164-13.69 5.164z" style="" fill="#828c94" opacity="1" data-defult=""></path>
                            </g>
                        </svg>
                        <div class="padding_px-l_005">검색</div>
                    </div>
                </form>
            </div>

            <div class="flex_xs1 padding_px-x_005 padding_px-u_015" data-xy="1-500: flex_ft">
                <div class="flex_fl">
                    <div class="padding_px-r_010">
                        <select class="padding_px-x_015 padding_px-y_008 border_px-a_000 nothover filter-input" name="reservation_status"
                            id="reservation_status">
                            <option value="" hidden disabled>예약상태</option>
                            <option value="all">전체</option>
                            <option value="1">신청</option>
                            <option value="2">확정</option>
                            <option value="3">완료</option>
                            <option value="4">노쇼</option>
                            <option value="0">취소</option>
                        </select>
                    </div>
                    
                    <?php
                    // 스토어 목록 조회
                    $sql = "SELECT uniq_id, store_name FROM egb_store WHERE is_status = 1 ORDER BY display_order ASC, store_name ASC";
                    $stores = egb_sql(binding_sql(0, $sql));
                    ?>
                    <div class="">
                        <select class="padding_px-x_015 padding_px-y_008 border_px-a_000 nothover filter-input"
                            name="store_id" id="store_id">
                            <option value="" hidden disabled>정비소 선택</option>
                            <option value="all">전체</option>
                            <?php foreach($stores[0] as $store): ?>
                            <option value="<?php echo $store['uniq_id']; ?>"><?php echo $store['store_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="padding_px-l_010">
                        <select class="padding_px-x_015 padding_px-y_008 border_px-a_000 nothover filter-input" name="per_page" id="per_page">
                            <option value="10">10개씩 보기</option>
                            <option value="20">20개씩 보기</option>
                            <option value="50">50개씩 보기</option>
                            <option value="100">100개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="flex_fl_yc padding_px-t_000" data-xy="1-500: flex_xr_yc padding_px-t_010">
                    <div class="padding_px-r_010">
                        <span>검색</span>&nbsp;<span id="total_count" class="flv6"
                            data-color="#15376b"><?php echo count($reservations); ?></span><span>건</span>
                    </div>
                    <div id="reservation_excel_download_btn" class="padding_px-x_015 padding_px-y_008 border_px-a_001 pointer excel_down_hover"
                        data-bd-a-color="#888888">
                        Excel</div>
                </div>
            </div>
        </div>
        <script nonce="<?php echo NONCE; ?>">
        document.querySelector('#reservation_excel_download_btn').addEventListener('click', function () {
            const formData = new FormData();

            formData.append('csrf_token', '<?php echo $_SESSION["csrf_token"]; ?>')

            const dateType = document.getElementById('reservation_date_type').value;
            const startDate = document.getElementById('reservation_start_date').value;
            const endDate = document.getElementById('reservation_end_date').value;
            const searchType = document.getElementById('search_type').value;
            const searchKeyword = document.getElementById('search_keyword').value;
            const status = document.getElementById('reservation_status').value;
            const storeId = document.getElementById('store_id').value;
            const perPage = document.getElementById('per_page').value;
            const totalCount = document.getElementById('total_count').textContent;
            
            formData.append('search_type', searchType);
            formData.append('search_keyword', searchKeyword);
            formData.append('reservation_date_type', dateType);
            formData.append('reservation_start_date', startDate); 
            formData.append('reservation_end_date', endDate);
            formData.append('reservation_status', status);
            formData.append('store_id', storeId);
            formData.append('per_page', perPage);
            formData.append('total_count', totalCount);

            fetch('<?php echo DOMAIN . "/?post=reservation_excel_download_form_input"; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('서버 오류');
                return response.blob();
            })
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'reservation_list.xlsx';
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url)
                egbsuccessCode({ successCode: 27 });
            })
            .catch(error => {
                egbFailureCode({ failureCode: 171 });
                console.error(error);
            });
        });
        </script>           
            <script nonce="<?php echo NONCE; ?>">
            document.addEventListener('DOMContentLoaded', function() {
                const periodSelect = document.getElementById('reservation_period');
                const startDateInput = document.getElementById('reservation_start_date');
                const endDateInput = document.getElementById('reservation_end_date');
                const dateTypeSelect = document.getElementById('reservation_date_type');

                // 날짜 범위를 업데이트하는 함수
                function updateDateRange() {
                    const today = new Date();
                    let startDate = new Date();
                    let endDate = new Date();
                    const isUseDate = dateTypeSelect.value === 'use_date';
                    const period = periodSelect.value;

                    // period가 custom이면 날짜를 변경하지 않음
                    if (period === 'custom') {
                        return;
                    }

                    switch(period) {
                        case 'daily':
                            // 오늘
                            startDate = today;
                            endDate = today;
                            break;
                        case 'weekly':
                            if (isUseDate) {
                                // 이용일: 오늘부터 7일 후까지
                                endDate.setDate(today.getDate() + 6);
                            } else {
                                // 신청일: 오늘부터 7일 전까지
                                startDate.setDate(today.getDate() - 6);
                                endDate = today;
                            }
                            break;
                        case 'monthly':
                            if (isUseDate) {
                                // 이용일: 오늘부터 30일 후까지
                                endDate.setDate(today.getDate() + 29);
                            } else {
                                // 신청일: 오늘부터 30일 전까지
                                startDate.setDate(today.getDate() - 29);
                                endDate = today;
                            }
                            break;
                        case 'all':
                            if (isUseDate) {
                                // 이용일: 오늘부터 1년 후까지
                                endDate.setFullYear(today.getFullYear() + 1);
                            } else {
                                // 신청일: 오늘부터 1년 전까지
                                startDate.setFullYear(today.getFullYear() - 1);
                                endDate = today;
                            }
                            break;
                    }

                    startDateInput.value = startDate.toISOString().split('T')[0];
                    endDateInput.value = endDate.toISOString().split('T')[0];
                }

                // 기간 선택 변경 시 날짜 업데이트
                periodSelect.addEventListener('change', updateDateRange);

                // 날짜 타입(신청일/이용일) 변경 시 날짜 업데이트
                dateTypeSelect.addEventListener('change', updateDateRange);
            });
            </script>

            <script nonce="<?php echo NONCE; ?>">
                document.getElementById('reservation_search_form_input').addEventListener('click', function() {
                    // egbAjaxDataHook을 사용하여 폼 제출
                    egbAjaxDataHook('reservation_search_form_input', function(formData) {
                        
                        const dateType = document.getElementById('reservation_date_type').value;
                        const startDate = document.getElementById('reservation_start_date').value;
                        const endDate = document.getElementById('reservation_end_date').value;
                        const searchType = document.getElementById('search_type').value;
                        const searchKeyword = document.getElementById('search_keyword').value;
                        const status = document.getElementById('reservation_status').value;
                        const storeId = document.getElementById('store_id').value;
                        const perPage = document.getElementById('per_page').value;
                        
                        formData.append('search_type', searchType);
                        formData.append('search_keyword', searchKeyword);
                        formData.append('reservation_date_type', dateType);
                        formData.append('reservation_start_date', startDate); 
                        formData.append('reservation_end_date', endDate);
                        formData.append('reservation_status', status);
                        formData.append('store_id', storeId);
                        formData.append('per_page', perPage);

                    });
                });
            </script>

            <div class="border_px-t_001" data-bd-a-color="#888888">
                <div class="width_box overflow_hidden scrolls">
                    <div id="reservation_list"
                        class="position1 flex_ft max_height_613 min_width_1940 white-_space_nowrap"
                        data-bd-a-color="#d9d9d9" style="overflow-Y:scroll; overflow-x: hidden;">
                        <div class="position4 flex_fl flv6" data-bd-a-color="#d9d9d9" data-top="0%" data-left="0%">
                            <div class="min_width_070 flex_xc_yc border_px-x_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">상태</div>
                            <div class="min_width_100 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">예약자</div>
                            <div class="min_width_180 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">전화번호</div>
                            <div class="min_width_130 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">예약번호</div>
                            <div class="min_width_250 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">이용일시</div>
                            <div class="min_width_150 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">예약</div>
                            <!--	
                            <div class="min_width_080 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">수량</div>
                            -->
                            <div class="min_width_200 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">신청일시</div>
                            <div class="min_width_200 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">확정일시</div>
                            <div class="min_width_200 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">취소일시</div>
                            <div class="min_width_200 flex_xc border_px-r_001 border_px-u_001 padding_px-y_015"
                                data-bg-color="#efefef" data-bd-a-color="#d9d9d9">완료일시</div>
                        </div>
                        <!--
                        <div class="height_px_047"></div>
                        -->
                        
                        <?php

                        $weekdays_ko = ['일', '월', '화', '수', '목', '금', '토'];

                        $grouped_reservations = [];
                        foreach ($reservations as $row) {
                            $group_id = $row['reservation_group_uniq_id'] ?? 'no_group';
                            if (!isset($grouped_reservations[$group_id])) {
                                $grouped_reservations[$group_id] = [];
                            }
                            $grouped_reservations[$group_id][] = $row;
                        }

                        foreach ($grouped_reservations as $group_id => $group_reservations) {
                            if ($group_id != 'no_group') {
                                // 그룹의 첫 번째 예약 정보 가져오기
                                $first_reservation = $group_reservations[0];
                                
                                // reservation_data에서 전화번호 추출
                                $reservation_data = json_decode($first_reservation['reservation_data'], true);
                                $user_phone = $reservation_data['user_phone_number'] ?? '';
                                
                                // 시작 시간과 종료 시간 찾기
                                $start_time = null;
                                $end_time = null;
                                foreach ($group_reservations as $reservation) {
                                    $time = new DateTime($reservation['reservation_time']);
                                    if ($start_time === null || $time < $start_time) {
                                        $start_time = $time;
                                    }
                                    $end_time_temp = clone $time;
                                    $end_time_temp->modify('+1 hour');
                                    if ($end_time === null || $end_time_temp > $end_time) {
                                        $end_time = $end_time_temp;
                                    }
                                }

                                // 시간 차이 계산
                                $duration = $start_time->diff($end_time);
                                $hours = $duration->h + ($duration->days * 24);

                                // 날짜 포맷팅
                                $reservation_date = new DateTime($first_reservation['reservation_date']);
                                $day_of_week = $reservation_date->format('w');
                                $formatted_date = $reservation_date->format('y.m.d') . '(' . $weekdays_ko[$day_of_week] . ') ' .
                                    $start_time->format('H:i') . ' ~ ' . $end_time->format('H:i') . ' (' . $hours . '시간)';

                                // 상태 설정
                                $status_text = '';
                                switch ($first_reservation['status']) {
                                    case 0: $status_text = '취소'; $status_bg_color = '#ff0000aa'; break;
                                    case 1: $status_text = '신청'; $status_bg_color = '#15376b'; break;
                                    case 2: $status_text = '확정'; $status_bg_color = '#007bff'; break;
                                    case 3: $status_text = '완료'; $status_bg_color = '#6c757d'; break;
                                    case 4: $status_text = '노쇼'; $status_bg_color = '#ff5722'; break;
                                }

                                // 신청일시 포맷팅
                                $formatted_applied_date = '';
                                if (!empty($first_reservation['reservation_applied_at'])) {
                                    $applied_date = new DateTime($first_reservation['reservation_applied_at']);
                                    $applied_day_of_week = $applied_date->format('w');
                                    $formatted_applied_date = $applied_date->format('y.m.d') . '(' . $weekdays_ko[$applied_day_of_week] . ') ' .
                                        str_replace(['AM', 'PM'], ['오전', '오후'], $applied_date->format('A h:i'));
                                }

                                // 확정/취소/완료 일시 포맷팅
                                $formatted_confirmed_date = !empty($first_reservation['reservation_confirmed_at']) ? 
                                    (new DateTime($first_reservation['reservation_confirmed_at']))->format('y.m.d') . '(' . 
                                    $weekdays_ko[(new DateTime($first_reservation['reservation_confirmed_at']))->format('w')] . ') ' .
                                    str_replace(['AM', 'PM'], ['오전', '오후'], (new DateTime($first_reservation['reservation_confirmed_at']))->format('A h:i')) : '-';
                                
                                $formatted_canceled_date = !empty($first_reservation['reservation_canceled_at']) ?
                                    (new DateTime($first_reservation['reservation_canceled_at']))->format('y.m.d') . '(' .
                                    $weekdays_ko[(new DateTime($first_reservation['reservation_canceled_at']))->format('w')] . ') ' .
                                    str_replace(['AM', 'PM'], ['오전', '오후'], (new DateTime($first_reservation['reservation_canceled_at']))->format('A h:i')) : '-';

                                $formatted_completed_date = !empty($first_reservation['reservation_completed_at']) ?
                                    (new DateTime($first_reservation['reservation_completed_at']))->format('y.m.d') . '(' .
                                    $weekdays_ko[(new DateTime($first_reservation['reservation_completed_at']))->format('w')] . ') ' .
                                    str_replace(['AM', 'PM'], ['오전', '오후'], (new DateTime($first_reservation['reservation_completed_at']))->format('A h:i')) : '-';
                                ?>

                                <form id="reservation_details_form_input_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" action="<?php echo DOMAIN . "/?post=reservation_details_form_input"; ?>" method="post" class="reservation_details_form">
                                    
                                <input type="hidden" name="reservation_group_uniq_id" value="<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                
                                
                                <div class="egb_submit flex_fl pointer reservation_user_details_box_open reservation_id_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>"
                                        data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                                        <div class="min_width_070 flex_xc_yc border_px-x_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9">
                                            <div id="list_status_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="padding_px-x_010 padding_px-y_015 border_px-a_001 border_bre-a_100 notcolor veservation_status_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>"
                                                data-bd-a-color="transparent" data-bg-color="<?php echo $status_bg_color; ?>"
                                                data-color="#ffffff">
                                                <?php echo htmlspecialchars($status_text) ?>
                                            </div>
                                        </div>
                                        <div id="list_user_name_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_100 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($first_reservation['user_name']) ?></div>
                                        <div id="list_user_phone_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_180 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($user_phone) ?></div>
                                        <div id="list_group_id_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_130 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']) ?></div>
                                        <div id="list_date_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_250 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_date) ?></div>
                                        <div id="list_store_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_150 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 equipment_type"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($first_reservation['store_name']) ?></div>
                                        <div id="list_applied_date_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_applied_date) ?></div>
                                        <div id="list_confirmed_date_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_confirmed_date) ?></div>
                                        <div id="list_canceled_date_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_canceled_date) ?></div>
                                        <div id="list_completed_date_<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_completed_date) ?></div>
                                    </div>
                            </form>

                                <?php
                        } else {
                                // 그룹이 아닌 일반 예약 처리
                                foreach ($group_reservations as $row) {
                                    $status_text = '';
                                    $status_bg_color = '';
                                    
                                    // reservation_data에서 전화번호 추출
                                    $reservation_data = json_decode($row['reservation_data'], true);
                                    $user_phone = $reservation_data['user_phone_number'] ?? '';
                                    
                                    // 예약 상태에 따른 텍스트와 배경색 설정
                                    if (!empty($row['reservation_confirmed_at'])) {
                                        $status_text = '예약확정';
                                        $status_bg_color = '#15376b';
                                    } else if (!empty($row['reservation_canceled_at'])) {
                                        $status_text = '예약취소'; 
                                        $status_bg_color = '#ff0000';
                                    } else {
                                        $status_text = '예약대기';
                                        $status_bg_color = '#888888';
                                    }

                                    // 예약 날짜/시간 포맷팅
                                    $date = new DateTime($row['reservation_date'] . ' ' . $row['reservation_time']);
                                    $formatted_date = $date->format('y.m.d') . '(' . 
                                        $weekdays_ko[$date->format('w')] . ') ' .
                                        str_replace(['AM', 'PM'], ['오전', '오후'], $date->format('A h:i'));

                                    // 신청 일시 포맷팅
                                    $applied_date = new DateTime($row['reservation_applied_at']);
                                    $formatted_applied_date = $applied_date->format('y.m.d') . '(' .
                                        $weekdays_ko[$applied_date->format('w')] . ') ' .
                                        str_replace(['AM', 'PM'], ['오전', '오후'], $applied_date->format('A h:i'));

                                    // 확정/취소/완료 일시 포맷팅
                                    $formatted_confirmed_date = !empty($row['reservation_confirmed_at']) ?
                                        (new DateTime($row['reservation_confirmed_at']))->format('y.m.d') . '(' .
                                        $weekdays_ko[(new DateTime($row['reservation_confirmed_at']))->format('w')] . ') ' .
                                        str_replace(['AM', 'PM'], ['오전', '오후'], (new DateTime($row['reservation_confirmed_at']))->format('A h:i')) : '-';

                                    $formatted_canceled_date = !empty($row['reservation_canceled_at']) ?
                                        (new DateTime($row['reservation_canceled_at']))->format('y.m.d') . '(' .
                                        $weekdays_ko[(new DateTime($row['reservation_canceled_at']))->format('w')] . ') ' .
                                        str_replace(['AM', 'PM'], ['오전', '오후'], (new DateTime($row['reservation_canceled_at']))->format('A h:i')) : '-';

                                    $formatted_completed_date = !empty($row['reservation_completed_at']) ?
                                        (new DateTime($row['reservation_completed_at']))->format('y.m.d') . '(' .
                                        $weekdays_ko[(new DateTime($row['reservation_completed_at']))->format('w')] . ') ' .
                                        str_replace(['AM', 'PM'], ['오전', '오후'], (new DateTime($row['reservation_completed_at']))->format('A h:i')) : '-';
                                    ?>

                                    <div class="flex_fl pointer reservation_user_details_box_open reservation_id_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>"
                                        data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                                        <div class="min_width_070 flex_xc_yc border_px-x_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9">
                                            <div id="list_status_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="padding_px-x_010 padding_px-y_015 border_px-a_001 border_bre-a_100 notcolor veservation_status_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>"
                                                data-bd-a-color="transparent" data-bg-color="<?php echo $status_bg_color; ?>"
                                                data-color="#ffffff">
                                                <?php echo htmlspecialchars($status_text) ?>
                                            </div>
                                        </div>
                                        <div id="list_user_name_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_100 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($row['user_name']) ?></div>
                                        <div id="list_user_phone_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_180 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($user_phone) ?></div>
                                        <div id="list_group_id_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_130 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($row['reservation_group_uniq_id']) ?></div>
                                        <div id="list_date_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_250 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_date) ?></div>
                                        <div id="list_store_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_150 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 equipment_type"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($row['store_name']) ?></div>
                                        <div id="list_applied_date_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_applied_date) ?></div>
                                        <div id="list_confirmed_date_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_confirmed_date) ?></div>
                                        <div id="list_canceled_date_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_canceled_date) ?></div>
                                        <div id="list_completed_date_<?php echo htmlspecialchars($row['reservation_group_uniq_id']); ?>" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015"
                                            data-bd-a-color="#d9d9d9"><?php echo htmlspecialchars($formatted_completed_date) ?></div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="position2 width_box full zm-index_1" data-top="0%" data-left="0%" data-bg-color="#e6e6e5"
            style="overflow: hidden;"></div>
    </div>
</div>
<form id="reservation_scroll_update_form" method="post" action="/?post=reservation_scroll_update_form_input">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>
<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    let isLoading = false;
    const reservationList = document.getElementById('reservation_list');
    
    if (reservationList) {
        reservationList.addEventListener('scroll', function() {
            if (isLoading) return;

            // 스크롤이 정확히 하단에 도달했을 때만 실행되도록 수정
            const scrolledToBottom = Math.abs(reservationList.scrollHeight - reservationList.scrollTop - reservationList.clientHeight) < 1;
            
            if (scrolledToBottom) {
                isLoading = true;
                
                // reservation_scroll_update_form 폼 전송
                egbAjaxDataHook('reservation_scroll_update_form', function(formData) {
                    const dateType = document.getElementById('reservation_date_type').value;
                    const startDate = document.getElementById('reservation_start_date').value;
                    const endDate = document.getElementById('reservation_end_date').value;
                    const searchType = document.getElementById('search_type').value;
                    const searchKeyword = document.getElementById('search_keyword').value;
                    const status = document.getElementById('reservation_status').value;
                    const storeId = document.getElementById('store_id').value;
                    const perPage = document.getElementById('per_page').value;
                    const totalCount = document.getElementById('total_count').textContent;
                    
                    formData.append('search_type', searchType);
                    formData.append('search_keyword', searchKeyword);
                    formData.append('reservation_date_type', dateType);
                    formData.append('reservation_start_date', startDate); 
                    formData.append('reservation_end_date', endDate);
                    formData.append('reservation_status', status);
                    formData.append('store_id', storeId);
                    formData.append('per_page', perPage);
                    formData.append('total_count', totalCount);
                });
                
                // 중복 요청 방지를 위해 1초 후 isLoading 초기화
                setTimeout(() => {
                    isLoading = false;
                }, 1000);
            }
        });
    }
});
</script>


<section id="reservation_details_section" class="position3 flex_xr width_box height_box z-index_10 reservation_user_details_box display_off"
    data-bg-color="#00000080" data-top="0%" data-left="0%">
    <div id="reservation_details_box" class="position1 width_px_400 padding_px-y_020 font_px_014 user_details_box display_off" data-bg-color="#ffffff">
        <div class="flex_xs1_yc padding_px-x_030">
            <div id="reservation_details_title" class="font_px_020 flv6">예약 상세정보</div>
            <div id="reservation_details_close" class="font_px_040 flv1 pointer reservation_user_details_box_close" data-color="#888888">&times;
            </div>
        </div>
        <div id="reservation_details_content" class="max_height_1100 height_box" style="overflow-Y: scroll;">
            <div class="flex_fl_yc padding_px-x_030 padding_px-t_040 padding_px-u_015">
                <div id="reservation_status_indicator" class="flex_xc_yc width_px_040 height_px_040 border_bre-a_040"
                    data-bg-color="#ff0000aa" data-color="#ffffff">-</div>
                <div class="padding_px-l_010">
                    <div id="reservation_user_name_header" class="padding_px-u_005 font_px_020 flv6">-</div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-u_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div class="flex_fl_yc padding_px-t_015 padding_px-u_010">
                    <div id="reservation_user_label" class="width_px_100" data-color="#888888">예약자</div>
                    <div id="reservation_user_name_display">-</div>
                </div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_phone_label" class="width_px_100" data-color="#888888">전화번호</div>
                    <div id="reservation_user_phone_display">-</div>
                </div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_number_label" class="width_px_100" data-color="#888888">예약번호</div>
                    <div id="reservation_number_display">-</div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-t_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_details_subtitle" class="padding_px-u_015 font_px_018">예약내역</div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_product_label" class="width_px_100" data-color="#888888">예약</div>
                    <div id="reservation_product_display" class="flv6" data-color="#15376b">-</div>
                </div>
                <div class="flex_fl padding_px-u_025">
                    <div id="reservation_datetime_label" class="width_px_100" data-color="#888888">이용일시</div>
                    <div class="flv6" data-color="#15376b">
                        <div id="reservation_datetime_display" class="padding_px-u_005">-</div>
                    </div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-t_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_user_info_subtitle" class="padding_px-u_015 font_px_018">예약자입력정보</div>
                <div class="padding_px-u_015 border_px-u_001" data-bd-a-color="#efefef">
                    <div id="reservation_car_model_label" class="padding_px-u_005" data-color="#888888">차량명</div>
                    <div id="reservation_car_model_display">-</div>
                </div>
                <div class="padding_px-t_010 padding_px-u_015 border_px-u_001" data-bd-a-color="#efefef">
                    <div id="reservation_maintenance_label" class="padding_px-u_005" data-color="#888888">DIY 작업 내용</div>
                    <div id="reservation_maintenance_display">-</div>
                </div>
                <div class="padding_px-t_010 padding_px-u_015 border_px-u_001" data-bd-a-color="#efefef">
                    <div id="reservation_estimated_time_label" class="padding_px-u_005" data-color="#888888">DIY 작업 예상시간</div>
                    <div id="reservation_estimated_time_display">-</div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-t_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_history_subtitle" class="padding_px-u_015 font_px_018">진행이력</div>
                <div id="reservation_noshow_history" class="flex_fl padding_px-u_010 display_none">
                    <div class="width_px_100" data-color="#888888">· 노쇼</div>
                    <div class="flv6">
                        <div id="reservation_noshow_date"></div>
                        <div id="reservation_noshow_admin"></div>
                    </div>
                </div>
                <div id="reservation_cancel_history" class="flex_fl padding_px-u_010 display_none">
                    <div class="width_px_100" data-color="#888888">· 취소</div>
                    <div class="flv6">
                        <div id="reservation_cancel_date"></div>
                        <div id="reservation_cancel_admin"></div>
                    </div>
                </div>
                <div id="reservation_complete_history" class="flex_fl padding_px-u_010 display_none">
                    <div class="width_px_100" data-color="#888888">· 완료</div>
                    <div class="flv6">
                        <div id="reservation_complete_date"></div>
                        <div id="reservation_complete_admin"></div>
                    </div>
                </div>
                <div id="reservation_confirm_history" class="flex_fl padding_px-u_010 display_none">
                    <div class="width_px_100" data-color="#888888">· 확정</div>
                    <div class="flv6">
                        <div id="reservation_confirm_date"></div>
                        <div id="reservation_confirm_admin"></div>
                    </div>
                </div>
                <div id="reservation_request_history" class="flex_fl padding_px-u_010 display_none">
                    <div class="width_px_100" data-color="#888888">· 신청</div>
                    <div class="flv6">
                        <div id="reservation_request_date"></div>
                    </div>
                </div>
            </div>
            <div id="reservation_cancel_reason_box" class="display_off padding_px-x_030 border_px-t_001 padding_px-t_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_cancel_reason_subtitle" class="padding_px-u_015 font_px_018">취소사유</div>
                <div class="padding_px-u_015 border_px-u_001" data-bd-a-color="#efefef">
                    <div id="reservation_cancel_reason_text" class="padding_px-u_005" data-color="#888888">-</div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-y_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_staff_memo_subtitle" class="padding_px-u_015 font_px_018">직원메모</div>
                <div class="flex_fl padding_px-u_015" data-bd-a-color="#efefef">
                    <textarea id="reservation_staff_memo" class="width_box height_px_100 padding_px-x_015 padding_px-y_008 border_px-a_001"
                        data-bd-a-color="#888888" name="reservation_internal_memo"
                        placeholder="내부직원용으로 고객에게 보이지않는 메모입니다.(최대 500자 입력가능)"></textarea>
                </div>
            </div>
            <div id="reservation_action_buttons" class="position4 flex_xc_yc padding_px-t_020 padding_px-x_030 border_px-t_001 padding_px-u_040"
                data-bottom="0%" data-left="0%" data-bg-color="#ffffff" data-bd-a-color="#efefef" data-color="#414141">
                
                <div id="reservation_change_button" class="padding_px-x_002">
                    <div class="border_px-a_001 padding_px-x_015 padding_px-y_008 pointer reservation_change_box_click"
                        data-bd-a-color="#d9d9d9">예약변경</div>
                </div>
                <div id="reservation_noshow_button" class="padding_px-x_002">
                    <div class="border_px-a_001 padding_px-x_015 padding_px-y_008 pointer reservation_noshow_box_click"
                        data-bd-a-color="#d9d9d9">노쇼</div>
                </div>
                <div id="reservation_cancel_button" class="padding_px-x_002">
                    <div class="border_px-a_001 padding_px-x_015 padding_px-y_008 pointer reservation_cancel_box_click"
                        data-bd-a-color="#d9d9d9">예약취소</div>
                </div>
                <form id="reservation_complete_form" method="post" action="/?post=reservation_complete_form_input">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input id="reservation_complete_group_uniq_id" type="hidden" name="reservation_group_uniq_id" value="">
                    <div id="reservation_complete_button" class="padding_px-x_002">
                        <div class="border_px-a_001 padding_px-x_015 padding_px-y_008 flv6 pointer" 
                            data-bg-color="#15376b" data-color="#ffffff">이용완료</div>
                    </div>
                </form>
                
                <form id="reservation_confirm_form" method="post" action="/?post=reservation_confirm_form_input">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input id="reservation_confirm_group_uniq_id" type="hidden" name="reservation_group_uniq_id" value="">
                    <div id="reservation_confirm_button" class="padding_px-x_002">
                        <div class="border_px-a_001 padding_px-x_015 padding_px-y_008 flv6 pointer" 
                            data-bg-color="#15376b" data-color="#ffffff">예약확정</div>
                    </div> 
                </form>
            </div>
        </div>
    </div>

    <script nonce="<?php echo NONCE; ?>">
        document.getElementById('reservation_complete_button').addEventListener('click', function() {
            egbAjaxDataHook('reservation_complete_form', function(formData) {

                const reservationCompleteStaffMemo = document.getElementById('reservation_staff_memo').value;
                formData.append('reservation_staff_memo', reservationCompleteStaffMemo);

                const reservationCompleteGroupUniqId = document.getElementById('reservation_complete_group_uniq_id').value;
                formData.append('reservation_group_uniq_id', reservationCompleteGroupUniqId);
            });
        });
    </script>    
    <script nonce="<?php echo NONCE; ?>">
        document.getElementById('reservation_confirm_button').addEventListener('click', function() {
            egbAjaxDataHook('reservation_confirm_form', function(formData) {

                const reservationConfirmStaffMemo = document.getElementById('reservation_staff_memo').value;
                formData.append('reservation_staff_memo', reservationConfirmStaffMemo);

                const reservationConfirmGroupUniqId = document.getElementById('reservation_confirm_group_uniq_id').value;
                formData.append('reservation_group_uniq_id', reservationConfirmGroupUniqId);
            });
        });
    </script> 
    
    <div id="reservation_change_container" class="position1 width_px_400 padding_px-y_020 font_px_014 reservation_change_box display_off"
        data-bg-color="#ffffff">
        <div class="flex_xs1_yc padding_px-x_030">
            <div id="reservation_change_title" class="font_px_020 flv6">예약 변경</div>
            <div id="reservation_change_close" class="font_px_040 flv1 pointer reservation_change_box_close" data-color="#888888">&times;</div>
        </div>
        <div id="reservation_change_content" class="max_height_1100 height_box" style="overflow-Y: scroll;">
            <div class="flex_fl_yc padding_px-x_030 padding_px-t_040 padding_px-u_015">
                <div id="reservation_change_status" class="flex_xc_yc width_px_040 height_px_040 border_bre-a_040"
                    data-bg-color="#15376b" data-color="#ffffff">변경</div>
                <div class="padding_px-l_010">
                    <div id="reservation_change_name" class="padding_px-u_005 font_px_020 flv6">-</div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-u_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div class="flex_fl_yc padding_px-t_015 padding_px-u_010">
                    <div id="reservation_change_user_label" class="min_width_100" data-color="#888888">예약자명</div>
                    <input id="reservation_change_user_input" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014"
                        data-bd-a-color="#d9d9d9" type="text" name="reservation_user_name"
                        value="기존 예약자명" disabled data-bg-color="#efefef">
                </div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_change_phone_label" class="min_width_100" data-color="#888888">전화번호</div>
                    <input id="reservation_change_phone_input" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014"
                        data-bd-a-color="#d9d9d9" type="text" name="reservation_user_phone_number"
                        value="기존 전화번호" disabled data-bg-color="#efefef">
                </div>
            </div>
            
            <div class="padding_px-x_030 border_px-t_001 padding_px-t_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_change_details_subtitle" class="padding_px-u_015 font_px_018">예약내역</div>
                <div class="flex_fl_yc padding_px-u_010">
                    
                <div id="reservation_change_product_label" class="min_width_100" data-color="#888888">예약</div>
                    <select id="reservation_change_product_select" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014"
                        data-bd-a-color="#d9d9d9" data-color="#414141" name="reservation_user_product">
                        <?php
                        $sql = "SELECT uniq_id, store_name FROM egb_store WHERE is_status = 1 ORDER BY display_order ASC, store_name ASC";
                        $stores = egb_sql(binding_sql(0, $sql));
                        foreach($stores[0] as $store): ?>
                            <option value="<?php echo htmlspecialchars($store['uniq_id']); ?>" 
                                <?php echo ($store['uniq_id'] == $first_reservation['reservation_store_uniq_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($store['store_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <form id="reservation_change_date_form" method="post" action="/?post=reservation_change_date_form_input">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input id="reservation_change_product_hidden_input" type="hidden" name="reservation_store_uniq_id" value="<?php echo htmlspecialchars($first_reservation['reservation_store_uniq_id']); ?>">
                    <input id="reservation_change_date_hidden_input" type="hidden" name="reservation_date_day" value="<?php echo htmlspecialchars($first_reservation['reservation_date']); ?>">
                    <input id="reservation_change_group_uniq_id" type="hidden" name="reservation_group_uniq_id" value="<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>">
                </form>

                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_change_date_label" class="min_width_100" data-color="#888888">이용일</div>
                    <input id="reservation_change_date_input" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014"
                        data-bd-a-color="#d9d9d9" data-color="#414141" type="date" name="reservation_date_day" 
                        value="<?php echo htmlspecialchars($first_reservation['reservation_date']); ?>"
                        min="<?php echo date('Y-m-d'); ?>">
                </div>

                <script nonce="<?php echo NONCE; ?>">
                    document.getElementById('reservation_change_product_select').addEventListener('change', function() {
                        // 숨겨진 입력 필드 값을 업데이트 
                        document.getElementById('reservation_change_product_hidden_input').value = this.value;
                        // egbAjaxDataHook을 사용하여 폼 제출
                        egbAjaxDataHook('reservation_change_date_form', function(data) {
                            console.log('예약 상품 변경:', data);
                        });
                    });
                </script>
                <script nonce="<?php echo NONCE; ?>">
                    document.getElementById('reservation_change_date_input').addEventListener('change', function() {
                        // 숨겨진 입력 필드 값을 업데이트
                        document.getElementById('reservation_change_date_hidden_input').value = this.value;
                        // egbAjaxDataHook을 사용하여 폼 제출  
                        egbAjaxDataHook('reservation_change_date_form', function(data) {
                            console.log('예약 날짜 변경:', data);
                        });
                    });
                </script>
                
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_change_time_label" class="min_width_100" data-color="#888888">시작시간</div>
                    <select id="reservation_change_time_select" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 font_px_014"
                        data-bd-a-color="#d9d9d9" data-color="#414141" name="reservation_date_time_info_edit">
                    </select>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-t_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_change_user_info_subtitle" class="padding_px-u_015 font_px_018">예약자입력정보</div>
                <div class="padding_px-u_015" data-bd-a-color="#efefef">
                    <div id="reservation_change_car_model_label" class="min_width_100 padding_px-u_005" data-color="#888888">차량명</div>
                    <input id="reservation_change_car_model_input" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001" data-bd-a-color="#d9d9d9"
                        type="text" name="reservation_car_model_info_edit" placeholder="내용입력">
                </div>
                
                <style>
                    input[type="checkbox"] {
                        appearance: none;
                        border: 1px solid #aaaaaa;
                        border-radius: 4px;
                        position: relative;
                    }

                    input[type="checkbox"]:checked {
                        display: block;
                        width: 14px;
                        height: 14px;
                        border: 1px solid #15376b;
                        border-radius: 4px;
                        background: #15376b;
                    }

                    input[type="checkbox"]:checked::after {
                        content: '';
                        display: block;
                        width: 4px;
                        height: 8px;
                        border: solid white;
                        border-width: 0 2px 2px 0;
                        position: absolute;
                        top: 1px;
                        left: 4px;
                        transform: rotate(45deg);
                    }
                </style>
                
                <div class="padding_px-t_010 padding_px-u_015" data-bd-a-color="#efefef">
                    <div id="reservation_change_maintenance_label" class="min_width_100 padding_px-u_005" data-color="#888888">DIY 작업 내역</div>
                    <div class="padding_px-x_015 padding_px-y_008">
                        <?php
                        // 옵션 그룹 조회
                        $tree = egb_option_flat('reservation_manual_item');

                        if (!empty($tree)) {
                            $i = 1;
                            foreach ($tree as $option) {
                                ?>
                                <div class="flex_fl_yc_wrap padding_px-y_005">
                                    <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                        data-bd-a-color="#aaaaaa" 
                                        id="reservation_change_maintenance_items_<?php echo $i; ?>" 
                                        name="reservation_car_maintenance_items_info_edit[]" 
                                        type="checkbox" 
                                        value="<?php echo $option['uniq_id']; ?>"
                                        >
                                    <label class="pointer padding_px-l_005" 
                                        for="reservation_change_maintenance_items_<?php echo $i; ?>">
                                        <?php echo $option['label']; ?>
                                    </label>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="padding_px-t_010 padding_px-u_015 border_px-u_001" data-bd-a-color="#efefef">
                    <div id="reservation_change_estimated_time_label" class="min_width_100 padding_px-u_005" data-color="#888888">DIY 작업 예상시간</div>
                    <input id="reservation_change_estimated_time_input" class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001" data-bd-a-color="#d9d9d9"
                        type="number" name="reservation_estimated_time_info_edit" placeholder="내용입력">
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-y_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_change_memo_subtitle" class="padding_px-u_015 font_px_018">직원메모</div>
                <div class="flex_fl padding_px-u_015" data-bd-a-color="#efefef">
                    <textarea id="reservation_change_memo_input" class="width_box height_px_100 padding_px-x_015 padding_px-y_008 border_px-a_001"
                        data-bd-a-color="#888888" name="reservation_internal_memo_info_edit"
                        placeholder="내부직원용으로 고객에게 보이지않는 메모입니다.(최대 500자 입력가능)"></textarea>
                </div>
            </div>
            <div id="reservation_change_action_buttons" class="position4 flex_xs1_yc padding_px-t_020 padding_px-x_030 border_px-t_001 padding_px-u_040"
                data-bottom="0%" data-left="0%" data-bg-color="#ffffff" data-bd-a-color="#efefef" data-color="#414141">
                <div class="width_box padding_px-x_002">
                    <div id="reservation_change_back_button" class="flex_xc_yc width_box border_px-a_001 padding_px-y_008 pointer reservation_change_box_back_click"
                        data-bd-a-color="#d9d9d9">뒤로</div>
                </div>
                <div class="width_box padding_px-x_002">
                    <div id="reservation_change_submit_button" class="flex_xc_yc width_box border_px-a_001 padding_px-y_008 flv6 pointer"
                        data-bg-color="#15376b" data-color="#ffffff">예약변경</div>
                </div>
            </div>
        </div>
    </div>

    <form id="reservation_change_form" method="post" action="/?post=reservation_change_form_input">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input id="reservation_change_form_group_uniq_id" type="hidden" name="reservation_group_uniq_id" value="<?php echo htmlspecialchars($first_reservation['reservation_group_uniq_id']); ?>">
    </form>
    <script nonce="<?php echo NONCE; ?>">
        document.getElementById('reservation_change_submit_button').addEventListener('click', function() {
            egbAjaxDataHook('reservation_change_form', function(formData) {

                const reservationChangeFormGroupUniqId = document.getElementById('reservation_change_form_group_uniq_id').value;
                const reservationChangeProductSelect = document.getElementById('reservation_change_product_select').value;
                const reservationChangeDateInput = document.getElementById('reservation_change_date_input').value;
                const reservationChangeTimeSelect = document.getElementById('reservation_change_time_select').value;
                const reservationChangeCarModelInput = document.getElementById('reservation_change_car_model_input').value;
                const reservationChangeEstimatedTimeInput = document.getElementById('reservation_change_estimated_time_input').value;
                const reservationChangeMemoInput = document.getElementById('reservation_change_memo_input').value;
                
                // 체크된 정비 항목들만 배열로 수집
                const checkedMaintenanceItems = [];
                document.querySelectorAll('input[name="reservation_car_maintenance_items_info_edit[]"]:checked').forEach(checkbox => {
                    checkedMaintenanceItems.push(checkbox.value);
                });

                formData.append('reservation_group_uniq_id', reservationChangeFormGroupUniqId);
                formData.append('reservation_user_product', reservationChangeProductSelect);
                formData.append('reservation_date_day', reservationChangeDateInput);
                formData.append('reservation_date_time_info_edit', reservationChangeTimeSelect);
                formData.append('reservation_car_model_info_edit', reservationChangeCarModelInput);
                formData.append('reservation_estimated_time_info_edit', reservationChangeEstimatedTimeInput);
                formData.append('reservation_internal_memo_info_edit', reservationChangeMemoInput);
                
                // 체크된 정비 항목들을 JSON 문자열로 변환하여 전송
                formData.append('reservation_car_maintenance_items_info_edit', JSON.stringify(checkedMaintenanceItems));

            });
        });
    </script>
    <div id="reservation_noshow_container" class="position1 width_px_400 padding_px-y_020 font_px_014 reservation_noshow_box display_off"
        data-bg-color="#ffffff">
        <div class="flex_xs1_yc padding_px-x_030">
            <div id="reservation_noshow_title" class="font_px_020 flv6">노쇼</div>
            <div id="reservation_noshow_close" class="font_px_040 flv1 pointer reservation_noshow_box_close" data-color="#888888">&times;</div>
        </div>
        <div id="reservation_noshow_content" class="max_height_1100 height_box" style="overflow-Y: scroll;">
            <div class="flex_fl_yc padding_px-x_030 padding_px-t_040 padding_px-u_015">
                <div id="reservation_noshow_status" class="flex_xc_yc width_px_040 height_px_040 border_bre-a_040" data-bg-color="#ff5722"
                    data-color="#ffffff">노쇼</div>
                <div class="padding_px-l_010">
                    <div id="reservation_noshow_name" class="padding_px-u_005 font_px_020 flv6">-</div>
                </div>
            </div>
            <div class="padding_px-x_030 border_px-t_001 padding_px-u_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div class="flex_fl_yc padding_px-t_015 padding_px-u_010">
                    <div id="reservation_noshow_user_label" class="min_width_100" data-color="#888888">예약자</div>
                    <div id="reservation_noshow_user_display">-</div>
                </div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_noshow_number_label" class="min_width_100" data-color="#888888">예약번호</div>
                    <div id="reservation_noshow_number_display">-</div>
                </div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_noshow_product_label" class="min_width_100" data-color="#888888">예약</div>
                    <div id="reservation_noshow_product_display" data-color="#15376b">-</div>
                </div>
                <div class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_noshow_datetime_label" class="min_width_100" data-color="#888888">이용일시</div>
                    <div data-color="#15376b">
                        <div id="reservation_noshow_datetime_display">-</div>
                    </div>
                </div>
            </div>
            <form id="reservation_noshow_form" method="post" action="/?post=reservation_noshow_form_input">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input id="reservation_noshow_group_uniq_id" type="hidden" name="reservation_group_uniq_id" value="">
                <div class="padding_px-x_030 border_px-t_001 padding_px-y_015" data-bd-a-color="#efefef"
                    data-color="#414141">
                    <div id="reservation_noshow_notice_subtitle" class="padding_px-u_015 font_px_018">노쇼안내</div>
                    <div class="flex_fl padding_px-u_015" data-bd-a-color="#efefef">
                        <textarea id="reservation_noshow_notice_input" class="width_box height_px_100 padding_px-x_015 padding_px-y_008 border_px-a_001"
                            data-bd-a-color="#888888" name="reservation_noshow_memo"
                            placeholder="고객에게 안내할 노쇼 안내를 필수로 입력해주세요.(최대 500자)">-</textarea>
                    </div>
                </div>
                <div id="reservation_noshow_info" class="padding_px-x_030 border_px-t_001 padding_px-y_015 font_px_016" data-bd-a-color="#efefef"
                    data-color="#888888">노쇼 처리 시 작성된 노쇼 안내를 포함해 사용자에게 알림이 발송됩니다.</div>
                <div id="reservation_noshow_action_buttons" class="position4 flex_xs1_yc padding_px-t_020 padding_px-x_030 border_px-t_001 padding_px-u_040"
                    data-bottom="0%" data-left="0%" data-bg-color="#ffffff" data-bd-a-color="#efefef" data-color="#414141">
                    <div class="width_box padding_px-x_002">
                        <div id="reservation_noshow_back_button" class="flex_xc_yc width_box border_px-a_001 padding_px-y_008 pointer reservation_noshow_box_back_click"
                            data-bd-a-color="#d9d9d9">뒤로</div>
                    </div>
                    <div class="width_box padding_px-x_002">
                        <div id="reservation_noshow_submit_button" class="egb_submit flex_xc_yc width_box border_px-a_001 padding_px-y_008 flv6 pointer"
                            data-bg-color="#15376b" data-color="#ffffff">노쇼</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    
    <div id="reservation_cancel_container" class="position1 width_px_400 padding_px-y_020 font_px_014 reservation_cancel_box display_off"
        data-bg-color="#ffffff">
        <div id="reservation_cancel_header" class="flex_xs1_yc padding_px-x_030">
            <div id="reservation_cancel_title" class="font_px_020 flv6">예약 취소</div>
            <div id="reservation_cancel_close" class="font_px_040 flv1 pointer reservation_user_details_box_close" data-color="#888888">&times;</div>
        </div>
        <div id="reservation_cancel_content" class="max_height_1100 height_box" style="overflow-Y: scroll;">
            <div id="reservation_cancel_status_wrapper" class="flex_fl_yc padding_px-x_030 padding_px-t_040 padding_px-u_015">
                <div id="reservation_cancel_status" class="flex_xc_yc width_px_040 height_px_040 border_bre-a_040" data-bg-color="#ff0000aa"
                    data-color="#ffffff">취소</div>
                <div id="reservation_cancel_name_wrapper" class="padding_px-l_010">
                    <div id="reservation_cancel_name" class="padding_px-u_005 font_px_020 flv6">-</div>
                </div>
            </div>
            <div id="reservation_cancel_info" class="padding_px-x_030 border_px-t_001 padding_px-u_015" data-bd-a-color="#efefef"
                data-color="#414141">
                <div id="reservation_cancel_user_row" class="flex_fl_yc padding_px-t_015 padding_px-u_010">
                    <div id="reservation_cancel_user_label" class="min_width_100" data-color="#888888">예약자</div>
                    <div id="reservation_cancel_user_display">-</div>
                </div>
                <div id="reservation_cancel_number_row" class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_cancel_number_label" class="min_width_100" data-color="#888888">예약번호</div>
                    <div id="reservation_cancel_number_display">-</div>
                </div>
                <div id="reservation_cancel_product_row" class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_cancel_product_label" class="min_width_100" data-color="#888888">예약</div>
                    <div id="reservation_cancel_product_display" data-color="#15376b">-</div>
                </div>
                <div id="reservation_cancel_datetime_row" class="flex_fl_yc padding_px-u_010">
                    <div id="reservation_cancel_datetime_label" class="min_width_100" data-color="#888888">이용일시</div>
                    <div id="reservation_cancel_datetime_wrapper" data-color="#15376b">
                        <div id="reservation_cancel_datetime_display">-</div>
                    </div>
                </div>
            </div>
            <form id="reservation_cancel_form" method="post" action="/?post=reservation_cancel_form_input">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input id="reservation_cancel_group_uniq_id" type="hidden" name="reservation_group_uniq_id" value="">
                <div id="reservation_cancel_reason" class="padding_px-x_030 border_px-t_001 padding_px-y_015" data-bd-a-color="#efefef"
                    data-color="#414141">
                    <div id="reservation_cancel_reason_subtitle" class="padding_px-u_015 font_px_018">관리자 취소 사유</div>
                    <div id="reservation_cancel_reason_wrapper" class="flex_fl padding_px-u_015" data-bd-a-color="#efefef">
                        <textarea id="reservation_cancel_reason_input" class="width_box height_px_100 padding_px-x_015 padding_px-y_008 border_px-a_001"
                            data-bd-a-color="#888888" name="reservation_cancel_memo"
                            placeholder="고객에게 안내할 취소 안내를 필수로 입력해주세요.(최대 500자)">-</textarea>
                    </div>
                </div>
                <div id="reservation_cancel_notice" class="padding_px-x_030 border_px-t_001 padding_px-y_015 font_px_016" data-bd-a-color="#efefef"
                    data-color="#888888">예약 취소 시 작성된 취소 사유를 포함해 사용자에게 알림이 발송됩니다.</div>
                <div id="reservation_cancel_buttons" class="position4 flex_xs1_yc padding_px-t_020 padding_px-x_030 border_px-t_001 padding_px-u_040"
                    data-bottom="0%" data-left="0%" data-bg-color="#ffffff" data-bd-a-color="#efefef" data-color="#414141">
                    <div id="reservation_cancel_back_wrapper" class="width_box padding_px-x_002">
                        <div id="reservation_cancel_back_button" class="flex_xc_yc width_box border_px-a_001 padding_px-y_008 pointer reservation_cancel_box_back_click"
                            data-bd-a-color="#d9d9d9">
                            뒤로</div>
                    </div>
                    <div id="reservation_cancel_submit_wrapper" class="width_box padding_px-x_002">
                        <div id="reservation_cancel_submit_button"
                            class="egb_submit flex_xc_yc width_box border_px-a_001 padding_px-y_008 flv6 pointer"
                            data-bg-color="#15376b" data-color="#ffffff">예약 취소</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    const detailsSection = document.getElementById('reservation_details_section');
    const detailsBox = document.getElementById('reservation_details_box');
    const cancelContainer = document.getElementById('reservation_cancel_container');
    const noshowContainer = document.getElementById('reservation_noshow_container');
    const changeContainer = document.getElementById('reservation_change_container');

    // 애니메이션 스타일 추가
    if(detailsSection) {
        detailsSection.style.transition = 'opacity 0.3s ease';
        detailsSection.style.opacity = '0';
    }
    if(detailsBox) {
        detailsBox.style.transition = 'transform 0.3s ease';
        detailsBox.style.transform = 'translateX(100%)';
    }

    // 다른 영역 클릭시 닫기 함수
    const closeDetails = (e) => {
        // 상세보기 영역이나 컨테이너를 클릭한 경우 닫지 않음
        if(e.target.closest('#reservation_details_box') || 
           e.target.closest('#reservation_cancel_container') ||
           e.target.closest('#reservation_noshow_container') ||
           e.target.closest('#reservation_change_container') ||
           e.target.closest('.reservation_user_details_box_open')) {
            return;
        }

        if (detailsSection) {
            detailsSection.style.opacity = '0';
            if(detailsBox) detailsBox.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (detailsSection) detailsSection.classList.add('display_off');
                if (detailsBox) detailsBox.classList.add('display_off'); 
                if (cancelContainer) cancelContainer.classList.add('display_off');
                if (noshowContainer) noshowContainer.classList.add('display_off');
                if (changeContainer) changeContainer.classList.add('display_off');
            }, 300);
        }
    };

    // 상세보기 버튼 클릭 이벤트
    document.addEventListener('click', function(e) {
        if(e.target.closest('.reservation_user_details_box_open')) {
            e.preventDefault();
            e.stopPropagation();
            
            if (detailsSection) {
                detailsSection.classList.remove('display_off');
                requestAnimationFrame(() => {
                    detailsSection.style.opacity = '1';
                });
            }
            if (detailsBox) {
                detailsBox.classList.remove('display_off');
                requestAnimationFrame(() => {
                    detailsBox.style.transform = 'translateX(0)';
                });
            }
        }
    });

    // 상세보기 닫기 버튼 클릭 이벤트
    document.addEventListener('click', function(e) {
        if(e.target.closest('.reservation_user_details_box_close')) {
            e.preventDefault();
            e.stopPropagation();
            
            if (detailsSection) {
                detailsSection.style.opacity = '0';
                if(detailsBox) detailsBox.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (detailsSection) detailsSection.classList.add('display_off');
                    if (detailsBox) detailsBox.classList.add('display_off');
                    if (cancelContainer) cancelContainer.classList.add('display_off');
                    if (noshowContainer) noshowContainer.classList.add('display_off'); 
                    if (changeContainer) changeContainer.classList.add('display_off');
                }, 300);
            }
        }
    });

    // 다른 영역 클릭시 닫기
    document.addEventListener('click', closeDetails);
});
</script>

<script nonce="<?php echo NONCE; ?>">
// 취소 버튼 클릭시 취소 컨테이너 표시
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target.closest('#reservation_cancel_button')) {
            e.preventDefault();
            e.stopPropagation();
            
            const cancelContainer = document.getElementById('reservation_cancel_container');
            const detailsBox = document.getElementById('reservation_details_box');
            
            if (cancelContainer && detailsBox) {
                cancelContainer.classList.remove('display_off');
                detailsBox.classList.add('display_off');
            }
        }
    });
});
</script>

<script nonce="<?php echo NONCE; ?>">
// 취소 뒤로가기 버튼 클릭시 닫기
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target.closest('#reservation_cancel_back_button')) {
            e.preventDefault();
            e.stopPropagation();
            
            const cancelContainer = document.getElementById('reservation_cancel_container');
            const detailsBox = document.getElementById('reservation_details_box');

            if (cancelContainer && detailsBox) {
                detailsBox.classList.remove('display_off');
                cancelContainer.classList.add('display_off');
            }
        }
    });
});
</script>

<script nonce="<?php echo NONCE; ?>">
// 노쇼 버튼 클릭시 노쇼 컨테이너 표시
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target.closest('#reservation_noshow_button')) {
            e.preventDefault(); 
            e.stopPropagation();
            
            const noshowContainer = document.getElementById('reservation_noshow_container');
            const detailsBox = document.getElementById('reservation_details_box');

            if (noshowContainer && detailsBox) {
                noshowContainer.classList.remove('display_off');
                detailsBox.classList.add('display_off');
            }
        }
    });
});
</script>

<script nonce="<?php echo NONCE; ?>">
// 노쇼 뒤로가기 버튼 클릭시 닫기
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target.closest('#reservation_noshow_back_button')) {
            e.preventDefault();
            e.stopPropagation();
            
            const noshowContainer = document.getElementById('reservation_noshow_container');
            const detailsBox = document.getElementById('reservation_details_box');

            if (noshowContainer && detailsBox) {
                detailsBox.classList.remove('display_off');
                noshowContainer.classList.add('display_off');
            }
        }
    });
});
</script>

<script nonce="<?php echo NONCE; ?>">
// 변경 버튼 클릭시 변경 컨테이너 표시
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target.closest('#reservation_change_button')) {
            e.preventDefault();
            e.stopPropagation();
            
            const changeContainer = document.getElementById('reservation_change_container');
            const detailsBox = document.getElementById('reservation_details_box');

            if (changeContainer && detailsBox) {
                changeContainer.classList.remove('display_off');
                detailsBox.classList.add('display_off');
            }
        }
    });
});
</script>

<script nonce="<?php echo NONCE; ?>">
// 변경 뒤로가기 버튼 클릭시 닫기
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if(e.target.closest('#reservation_change_back_button')) {
            e.preventDefault();
            e.stopPropagation();
            
            const changeContainer = document.getElementById('reservation_change_container');
            const detailsBox = document.getElementById('reservation_details_box');

            if (changeContainer && detailsBox) {
                detailsBox.classList.remove('display_off');
                changeContainer.classList.add('display_off');
            }
        }
    });
});
</script>