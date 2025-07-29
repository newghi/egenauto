<?php

$event_keyword = egb('event_keyword');
$event_status = egb('event_status');
$event_type = egb('event_type');
$date_search_type = egb('date_search_type');
$date_search_year1 = egb('date_search_year1');
$date_search_month1 = egb('date_search_month1');
$date_search_day1 = egb('date_search_day1');
$date_search_year2 = egb('date_search_year2');
$date_search_month2 = egb('date_search_month2');
$date_search_day2 = egb('date_search_day2');

$view_count = egb('view_count');
$view_count = !empty($view_count) ? (int)$view_count : 30;

// 시작일과 종료일 설정
$start_date = null;
$end_date = null;

if ($date_search_type != '전체' && $date_search_year1 && $date_search_month1 && $date_search_day1 && 
    $date_search_year2 && $date_search_month2 && $date_search_day2) {
    $start_date = $date_search_year1 . '-' . $date_search_month1 . '-' . $date_search_day1;
    $end_date = $date_search_year2 . '-' . $date_search_month2 . '-' . $date_search_day2;
}

// 이벤트 조회 쿼리 생성
$query = "SELECT * FROM egb_event WHERE is_status = 1 AND event_category = '회원정보'";
$params = [];

// 검색어 필터링
if (!empty($event_keyword)) {
    $keyword = '%' . $event_keyword . '%';
    $query .= " AND (event_title LIKE :keyword1 OR event_description LIKE :keyword2)";
    $params[':keyword1'] = $keyword;
    $params[':keyword2'] = $keyword; 
}

// 진행상태 필터링
if (!empty($event_status) && $event_status !== 'all') {
    $query .= " AND event_status = :event_status";
    $params[':event_status'] = $event_status;
}

// 이벤트 유형 필터링
if (!empty($event_type) && $event_type !== 'all') {
    $query .= " AND event_type = :event_type";
    $params[':event_type'] = $event_type;
}

// 기간 검색 필터링
if ($start_date && $end_date) {
    $query .= " AND created_at BETWEEN :start_date AND :end_date";
    $params[':start_date'] = $start_date . ' 00:00:00';
    $params[':end_date'] = $end_date . ' 23:59:59';
}

// 정렬 조건 및 페이지 처리
$query .= " ORDER BY created_at DESC";

$current_page = (int)egb('list');
if ($current_page < 1) {
    $current_page = 1;
}
$offset = ($current_page - 1) * $view_count;
$query .= " LIMIT :offset, :view_count";
$params[':offset'] = (int)$offset;
$params[':view_count'] = (int)$view_count;

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$events = egb_sql($binding);

// 전체 이벤트 수 계산
$totalCountQuery = "
    SELECT COUNT(*) as record_total_count 
    FROM egb_event 
    WHERE is_status = 1 
    AND event_category = '회원정보'
";
$totalCountBinding = binding_sql(1, $totalCountQuery, []);
$totalCountResult = egb_sql($totalCountBinding);
$total_count = $totalCountResult[0]['record_total_count'] ?? 0;

// 검색된 이벤트 수 계산
$search_count = !empty($events[0]) ? count($events[0]) : 0;

$total_pages = ceil($total_count / $view_count);
$num_links = 5;
?>


<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_event_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020 "
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">회원정보이벤트</div>
                <div class="flex_xc" data-xy="1-800: flex_xr">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>이벤트</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">회원정보이벤트</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">검색어</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="event_keyword" id="event_keyword" 
                            placeholder="이벤트명 또는 키워드를 입력하세요"
                            value="<?php echo isset($event_keyword) ? htmlspecialchars($event_keyword) : ''; ?>" 
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">진행상태</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 진행상태 옵션 정의
                        $event_statuses = array(
                            'all' => '전체',
                            '0' => '대기',
                            '1' => '진행중',
                            '2' => '종료'
                        );

                        foreach($event_statuses as $value => $label) {
                            $checked = ($event_status == $value) ? ' checked' : '';
                            echo '<input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                    name="event_status" id="event_status_' . ($value == 'all' ? 'all' : $value) . '" value="' . $value . '"' . $checked . '
                                    data-xy="1-800: width_px_016 height_px_016">';
                            echo '<label class="padding_px-l_005 ' . (end($event_statuses) === $label ? '' : 'padding_px-r_010') . '"
                                    for="event_status_' . ($value == 'all' ? 'all' : $value) . '">' . $label . '</label>';
                        }
                        ?>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">이벤트 유형</div>
                        <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio" 
                                name="event_type" id="event_type_all" value="all" checked
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" 
                                for="event_type_all">전체</label>

                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                name="event_type" id="event_type_member_info" value="회원정보수정"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="event_type_member_info">회원정보수정</label>

                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                name="event_type" id="event_type_lifetime" value="평생회원"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005"
                                for="event_type_lifetime">평생회원</label>
                        </div>
                </div>
                    <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: border_px-u_001 padding_px-y_032 padding_px-l_010">
                        기간 검색</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-1200: flex_ft border_px-u_000 del-height_px_055, 1201-1500: flex_ft border_px-u_001 del-height_px_055">
                        <div class="flex_fl_yc min_width_375 width_px_375 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="date_search_type" value="전체" 
                                id="date_search_type_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo !isset($date_search_type) || $date_search_type == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="date_search_type_all"
                                data-xy="1-800: padding_px-r_010">전체</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="date_search_type" value="등록일"
                                id="date_search_type_created" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo isset($date_search_type) && $date_search_type == '등록일' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="date_search_type_created"
                                data-xy="1-800: padding_px-r_010">등록일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="date_search_type" value="시작일"
                                id="date_search_type_start" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo isset($date_search_type) && $date_search_type == '시작일' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="date_search_type_start"
                                data-xy="1-800: padding_px-r_010">시작일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="date_search_type" value="종료일"
                                id="date_search_type_end" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo isset($date_search_type) && $date_search_type == '종료일' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="date_search_type_end"
                                data-xy="1-800: padding_px-r_010">종료일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="date_search_type" value="period"
                                id="date_search_type_period" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo isset($date_search_type) && $date_search_type == 'period' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="date_search_type_period"
                                data-xy="1-800: padding_px-r_000">기간검색</label>
                        </div>
                        <div class="flex_fl_yc width_box height_box" data-bg-color="#ffffff" data-xy="1-1200: flex_ft">
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $tree_year = egb_option_flat('year');
                                    $selected_year1 = egb('date_search_year1');
                                    ?>
                                    <select id="date_search_year1" name="date_search_year1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 date_search_year_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">년도</option>
                                        <?php foreach($tree_year as $year): ?>
                                            <option value="<?php echo $year['label']; ?>" <?php echo $selected_year1 == $year['label'] ? 'selected' : ''; ?>><?php echo $year['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $tree_month = egb_option_flat('month');
                                    $selected_month1 = egb('date_search_month1');
                                    ?>
                                    <select id="date_search_month1" name="date_search_month1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 date_search_month_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">월</option>
                                        <?php foreach($tree_month as $month): ?>
                                            <option value="<?php echo $month['label']; ?>" <?php echo $selected_month1 == $month['label'] ? 'selected' : ''; ?>><?php echo $month['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $tree_day = egb_option_flat('day');
                                    $selected_day1 = egb('date_search_day1');
                                    ?>
                                    <select id="date_search_day1" name="date_search_day1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 date_search_day_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">일</option>
                                        <?php foreach($tree_day as $day): ?>
                                            <option value="<?php echo $day['label']; ?>" <?php echo $selected_day1 == $day['label'] ? 'selected' : ''; ?>><?php echo $day['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                            <div class="padding_px-x_010 padding_px-y_000"
                                data-xy="1-800: flex_xc padding_px-x_000 padding_px-y_010, 801-1200: flex_xc padding_px-x_000 padding_px-y_005">
                                ~</div>
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $selected_year2 = egb('date_search_year2');
                                    ?>
                                    <select id="date_search_year2" name="date_search_year2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 date_search_year_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">년도</option>
                                        <?php foreach($tree_year as $year): ?>
                                            <option value="<?php echo $year['label']; ?>" <?php echo $selected_year2 == $year['label'] ? 'selected' : ''; ?>><?php echo $year['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $selected_month2 = egb('date_search_month2');
                                    ?>
                                    <select id="date_search_month2" name="date_search_month2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 date_search_month_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">월</option>
                                        <?php foreach($tree_month as $month): ?>
                                            <option value="<?php echo $month['label']; ?>" <?php echo $selected_month2 == $month['label'] ? 'selected' : ''; ?>><?php echo $month['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $selected_day2 = egb('date_search_day2');
                                    ?>
                                    <select id="date_search_day2" name="date_search_day2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 date_search_day_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">일</option>
                                        <?php foreach($tree_day as $day): ?>
                                            <option value="<?php echo $day['label']; ?>" <?php echo $selected_day2 == $day['label'] ? 'selected' : ''; ?>><?php echo $day['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script nonce="<?php echo NONCE; ?>">
                document.addEventListener('DOMContentLoaded', function() {
                    const dateSearchRadios = document.querySelectorAll('input[name="date_search_type"]');
                    
                    const selectedRadio = document.querySelector('input[name="date_search_type"]:checked');
                    if(selectedRadio) {
                        handleDateSelection(selectedRadio.value);
                    }
                    
                    dateSearchRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            handleDateSelection(this.value);
                        });
                    });

                    function handleDateSelection(value) {
                        const year1 = document.getElementById('date_search_year1');
                        const month1 = document.getElementById('date_search_month1');
                        const day1 = document.getElementById('date_search_day1');
                        const year2 = document.getElementById('date_search_year2');
                        const month2 = document.getElementById('date_search_month2');
                        const day2 = document.getElementById('date_search_day2');

                        [year1, month1, day1, year2, month2, day2].forEach(el => {
                            el.value = '';
                            el.disabled = value === '전체';
                        });

                        if(value !== '전체' && value !== 'period') {
                            const today = new Date();
                            setDates(today, today);
                        }
                    }

                    function setDates(startDate, endDate) {
                        const year1 = document.getElementById('date_search_year1');
                        const month1 = document.getElementById('date_search_month1');
                        const day1 = document.getElementById('date_search_day1');
                        const year2 = document.getElementById('date_search_year2');
                        const month2 = document.getElementById('date_search_month2');
                        const day2 = document.getElementById('date_search_day2');

                        year1.value = startDate.getFullYear();
                        month1.value = String(startDate.getMonth() + 1).padStart(2,'0');
                        day1.value = String(startDate.getDate()).padStart(2,'0');
                        year2.value = endDate.getFullYear();
                        month2.value = String(endDate.getMonth() + 1).padStart(2,'0');
                        day2.value = String(endDate.getDate()).padStart(2,'0');

                        [year1, month1, day1, year2, month2, day2].forEach(el => {
                            el.dispatchEvent(new Event('change'));
                        });
                    }
                });
                </script>
            </div>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span id="egen_search">검색하기</span>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">검색 결과</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;이벤트&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $total_count; ?></span>건&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $search_count; ?></span>건
                        </div>
                    </div>
                    <div class="flex_fl_yc">
                        <div class="padding_px-r_010 padding_px-t_000"
                            data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                            <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                                name="view_count" id="view_count" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                                <option value="30" <?php echo $view_count == 30 ? 'selected' : ''; ?>>30개씩 보기</option>
                                <option value="20" <?php echo $view_count == 20 ? 'selected' : ''; ?>>20개씩 보기</option>
                                <option value="10" <?php echo $view_count == 10 ? 'selected' : ''; ?>>10개씩 보기</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 15% 12% 10% 15% 9% 15% 9% 5%" 
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_event_all" 
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" name=""
                                    id="crm_searching_member_event_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이벤트명</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이벤트유형</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">진행상태</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">진행기간</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등록자</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등록일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">참여내역관리</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <?php if(!empty($events[0])): ?>
                            <?php foreach($events[0] as $result): ?>
                            <div class="grid_xx border_px-u_001" data-xx="5% 5% 15% 12% 10% 15% 9% 15% 9% 5%" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                                <label for="crm_searching_member_event_<?php echo isset($result['no']) ? htmlspecialchars($result['no']) : ''; ?>"
                                    class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                    <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" name=""
                                        id="crm_searching_member_event_<?php echo isset($result['no']) ? htmlspecialchars($result['no']) : ''; ?>" data-bd-a-color="#d9d9d9">
                                </label>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo isset($result['no']) ? htmlspecialchars($result['no']) : ''; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo isset($result['event_title']) ? htmlspecialchars($result['event_title']) : ''; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo isset($result['event_type']) ? htmlspecialchars($result['event_type']) : ''; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo isset($result['event_status']) ? htmlspecialchars($result['event_status']) : ''; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php 
                                    $start_date = isset($result['event_start_date']) ? date('Y.m.d', strtotime($result['event_start_date'])) : '1970.01.01';
                                    $end_date = isset($result['event_end_date']) ? date('Y.m.d', strtotime($result['event_end_date'])) : '1970.01.01';
                                    echo htmlspecialchars($start_date . '~' . $end_date);
                                ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo isset($result['created_by']) ? htmlspecialchars($result['created_by']) : ''; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo isset($result['created_at']) ? date('Y.m.d', strtotime($result['created_at'])) : '1970.01.01'; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff" onclick="location.href='/page/crm_member_event_participation/<?php echo isset($result['uniq_id']) ? htmlspecialchars($result['uniq_id']) : ''; ?>'">보기</div>
                                <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff" onclick="location.href='/page/crm_member_event_detail/<?php echo isset($result['uniq_id']) ? htmlspecialchars($result['uniq_id']) : ''; ?>'">보기</div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="flex_xc_yc padding_px-y_030 font_px_016">검색 결과가 없습니다.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="padding_px-u_060"></div>
            <div class="flex_xc_yc width_box font_px_015 padding_px-u_030" data-xy="1-700: font_px_010"
                data-color="#666666">
                <?php

                $paginationm = max(1, $current_page - 1); // 이전 페이지 번호 (1보다 작아지지 않도록)
                $paginationp = min($total_pages, $current_page + 1); // 다음 페이지 번호 (마지막 페이지를 초과하지 않도록)
                
                function addOrUpdateUrlParam($url, $paramName, $paramValue)
                {
                    $url_data = parse_url($url);

                    // 쿼리 문자열이 존재하는 경우 쿼리 문자열을 배열로 변환
                    $params = [];
                    if (isset($url_data['query'])) {
                        parse_str($url_data['query'], $params);
                    }

                    // 'list' 파라미터를 업데이트
                    $params[$paramName] = $paramValue;

                    // 새로운 쿼리 문자열 생성
                    $url_data['query'] = http_build_query($params);

                    // 경로가 슬래시로 끝나는지 확인하고 조합
                    $path = $url_data['path'];
                    if (substr($path, -1) !== '/') {
                        $path .= '/';
                    }

                    // 새로운 URL 조합
                    return (isset($url_data['scheme']) ? $url_data['scheme'] . '://' : '') .
                        (isset($url_data['host']) ? $url_data['host'] : '') .
                        $path . '?' . $url_data['query'];
                }

                // 이전 페이지 버튼
                echo '<a class="padding_px-y_010 padding_px-x_005 pointer" href="' . addOrUpdateUrlParam(URL, 'list', $paginationm) . '">';
                echo '<div class="pointer border_px-a_001 width_px_040 height_px_040 flex_xc_yc hovernumber" data-bd-a-color="#ffffff" data-xy="1-700: height_px_030 width_px_030">＜</div>';
                echo '</a>';

                if (isset($filteredCount)) {
                    $start = max(1, min($current_page - floor($num_links / 2), $total_pages - $num_links + 1));
                    $end = min($start + $num_links - 1, $total_pages);

                    // 페이지 링크 표시
                    for ($i = $start; $i <= $end; $i++) {
                        $choicenumber = ($current_page == $i) ? 'choicenumber' : '';
                        echo '<a class="padding_px-y_010 padding_px-x_005 pointer" href="' . addOrUpdateUrlParam(URL, 'list', $i) . '">';
                        echo '<div class="pointer border_px-a_001 width_px_040 height_px_040 flex_xc_yc hovernumber ' . $choicenumber . '" data-bd-a-color="#ffffff" data-xy="1-700: height_px_030 width_px_030">';
                        echo $i;
                        echo '</div>';
                        echo '</a>';
                    }
                }

                // 다음 페이지 버튼
                echo '<a class="padding_px-y_010 padding_px-x_005 pointer" href="' . addOrUpdateUrlParam(URL, 'list', $paginationp) . '">';
                echo '<div class="pointer border_px-a_001 width_px_040 height_px_040 flex_xc_yc hovernumber" data-bd-a-color="#ffffff" data-xy="1-700: height_px_030 width_px_030">＞</div>';
                echo '</a>';
                ?>
            </div>
        </div>
    </div>
</section>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?><style>
    .crm_member_event_color {
        background-color: #15376b;
    }

    .crm_member_event_1_bg {
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
document.getElementById('egen_search').addEventListener('click', function() {
    const params = new URLSearchParams();
    document.querySelectorAll('input[name], select[name]').forEach(el => {
        if (el.type === 'radio' && !el.checked) return;
        if (el.value !== '') params.append(el.name, el.value);
    });
    // 반드시 경로 끝에 '/' 하나만 남기고 '?' 붙이기
    let path = window.location.pathname;
    if (!path.endsWith('/')) path += '/';
    window.location.href = path + '?' + params.toString();
});
</script>
