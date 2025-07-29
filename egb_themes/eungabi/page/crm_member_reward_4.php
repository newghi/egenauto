    <?php
// 관리자 권한 체크
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] != 1) {
    echo "<script nonce='" . NONCE . "'>window.location.href = '" . DOMAIN . "/page/login';</script>";
    exit;
}

// 검색 조건 설정
$community_user_grade = egb('community_user_grade');
$user_id = egb('user_id');
$crm_member_reward_viewing_period = egb('crm_member_reward_viewing_period');
$crm_member_reward_year_1 = egb('crm_member_reward_year_1');
$crm_member_reward_month_1 = egb('crm_member_reward_month_1');
$crm_member_reward_day_1 = egb('crm_member_reward_day_1');
$crm_member_reward_year_2 = egb('crm_member_reward_year_2');
$crm_member_reward_month_2 = egb('crm_member_reward_month_2');
$crm_member_reward_day_2 = egb('crm_member_reward_day_2');

// 기간검색 기본값 설정 
if(empty($crm_member_reward_viewing_period)) {
    $crm_member_reward_viewing_period = 'all';
}

// 기본값 설정
if($crm_member_reward_viewing_period == 'period_search') {
    // 기간검색일 경우에도 기본값 설정
    $crm_member_reward_year_1 = !empty($crm_member_reward_year_1) ? $crm_member_reward_year_1 : date('Y');
    $crm_member_reward_month_1 = !empty($crm_member_reward_month_1) ? $crm_member_reward_month_1 : date('m');
    $crm_member_reward_day_1 = !empty($crm_member_reward_day_1) ? $crm_member_reward_day_1 : date('d');
    $crm_member_reward_year_2 = !empty($crm_member_reward_year_2) ? $crm_member_reward_year_2 : date('Y');
    $crm_member_reward_month_2 = !empty($crm_member_reward_month_2) ? $crm_member_reward_month_2 : date('m');
    $crm_member_reward_day_2 = !empty($crm_member_reward_day_2) ? $crm_member_reward_day_2 : date('d');
}

$view_count = egb('view_count');
$view_count = !empty($view_count) ? (int)$view_count : 30;

// 쿼리 작성
$query = "
    SELECT u.*, m.* 
FROM egb_user u
LEFT JOIN egb_mileage m ON u.uniq_id = m.mileage_target_uniq_id
WHERE m.mileage_target_uniq_id IS NOT NULL
";

$params = [];

// 등급 검색 조건
if (!empty($community_user_grade) && $community_user_grade != '전체') {
    $query .= " AND u.community_user_grade = :community_user_grade";
    $params[':community_user_grade'] = $community_user_grade;
}

// 아이디 검색 조건
if (!empty($user_id)) {
    $query .= " AND u.user_id = :user_id";
    $params[':user_id'] = $user_id;
}

// 조회기간 검색 조건
if ($crm_member_reward_viewing_period == 'today') {
    $created_at_start = date('Y-m-d');
    $created_at_end = date('Y-m-d');
    $query .= " AND DATE(m.created_at) BETWEEN :created_at_start AND :created_at_end";
    $params[':created_at_start'] = $created_at_start;
    $params[':created_at_end'] = $created_at_end;
} else if ($crm_member_reward_viewing_period == '3days') {
    $created_at_start = date('Y-m-d', strtotime('-2 days')); 
    $created_at_end = date('Y-m-d');
    $query .= " AND DATE(m.created_at) BETWEEN :created_at_start AND :created_at_end";
    $params[':created_at_start'] = $created_at_start;
    $params[':created_at_end'] = $created_at_end;
} else if ($crm_member_reward_viewing_period == '7days') {
    $created_at_start = date('Y-m-d', strtotime('-6 days'));
    $created_at_end = date('Y-m-d');
    $query .= " AND DATE(m.created_at) BETWEEN :created_at_start AND :created_at_end";
    $params[':created_at_start'] = $created_at_start;
    $params[':created_at_end'] = $created_at_end;
} else if ($crm_member_reward_viewing_period == 'period_search' && !empty($crm_member_reward_year_1) && !empty($crm_member_reward_month_1) && !empty($crm_member_reward_day_1) && !empty($crm_member_reward_year_2) && !empty($crm_member_reward_month_2) && !empty($crm_member_reward_day_2)) {
    $created_at_start = $crm_member_reward_year_1 . '-' . str_pad($crm_member_reward_month_1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($crm_member_reward_day_1, 2, '0', STR_PAD_LEFT);
    $created_at_end = $crm_member_reward_year_2 . '-' . str_pad($crm_member_reward_month_2, 2, '0', STR_PAD_LEFT) . '-' . str_pad($crm_member_reward_day_2, 2, '0', STR_PAD_LEFT);
    $query .= " AND DATE(m.created_at) BETWEEN :created_at_start AND :created_at_end";
    $params[':created_at_start'] = $created_at_start;
    $params[':created_at_end'] = $created_at_end;
}

// 정렬 설정
$query .= " ORDER BY m.created_at DESC";

// 정렬 및 페이지당 보기 설정
$current_page = egb('list');
$current_page = (int)$current_page;
if($current_page < 1) {
    $current_page = 1;
}
$offset = ($current_page - 1) * $view_count;
$query .= " LIMIT :offset, :view_count";
$params[':offset'] = $offset;
$params[':view_count'] = $view_count;


// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$results = egb_sql($binding);

$positive_mileage = 0;
$negative_mileage = 0;

if(!empty($results[0])) {
    foreach($results[0] as $row) {
        if($row['mileage_type'] == '1') {
            $positive_mileage += (int)$row['mileage_amount'];
        } else if($row['mileage_type'] == '0') {
            $negative_mileage += (int)$row['mileage_amount']; 
        }
    }
}
$total_mileage = $positive_mileage - $negative_mileage;

// 전체 이벤트 수 계산
$totalCountQuery = "
    SELECT COUNT(*) as record_total_count 
    FROM egb_user u
    LEFT JOIN egb_mileage m ON u.uniq_id = m.mileage_target_uniq_id
    WHERE m.mileage_target_uniq_id IS NOT NULL
";
$totalCountBinding = binding_sql(1, $totalCountQuery, []);
$totalCountResult = egb_sql($totalCountBinding);
$total_count = $totalCountResult[0]['record_total_count'] ?? 0;

// 검색된 이벤트 수 계산
$search_count = !empty($results[0]) ? count($results[0]) : 0;

$total_pages = ceil($total_count / $view_count);
$num_links = 5;

?>
<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_reward_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">마일리지조회</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>리워드</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">마일리지관리</div>
                    </div>
                </div>
            </div>
            <div class="flex_ft width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9"
                data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">등급</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'community_user_grade' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('community_user_grade');

                        // 선택된 값 가져오기
                        $selected_rank = egb('community_user_grade');
                        ?>
                        <select class="width_px_200 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" name="community_user_grade" id="community_user_grade" data-xy="1-800: width_box font_px_012">
                            <option value="전체" <?php echo $selected_rank == '전체' ? 'selected' : ''; ?>>전체</option>
                            <?php
                            if (!empty($tree)) {
                                foreach($tree as $option) {
                            ?>
                                <option value="<?php echo $option['uniq_id']; ?>" <?php echo $selected_rank == $option['uniq_id'] ? 'selected' : ''; ?>><?php echo $option['label']; ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">아이디</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_id" id="auto_reward_log_user_id" value="<?php echo $user_id; ?>" data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                    <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: padding_px-y_032 padding_px-l_010 border_px-u_001">
                        조회기간</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-1200: flex_ft border_px-u_000 del-height_px_055, 1201-1500: flex_ft border_px-u_001 del-height_px_055">
                        <div class="flex_fl_yc min_width_310 width_px_310 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_viewing_period" value="today"
                                id="crm_member_reward_viewing_period_today" data-xy="1-800: width_px_016 height_px_016" <?php echo $crm_member_reward_viewing_period == 'today' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020"
                                for="crm_member_reward_viewing_period_today"
                                data-xy="1-800: padding_px-r_010">오늘</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_viewing_period" value="3days"
                                id="crm_member_reward_viewing_period_3day" data-xy="1-800: width_px_016 height_px_016" <?php echo $crm_member_reward_viewing_period == '3days' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_reward_viewing_period_3day"
                                data-xy="1-800: padding_px-r_010">3일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_viewing_period" value="7days"
                                id="crm_member_reward_viewing_period_7day" data-xy="1-800: width_px_016 height_px_016" <?php echo $crm_member_reward_viewing_period == '7days' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_reward_viewing_period_7day"
                                data-xy="1-800: padding_px-r_010">7일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_reward_viewing_period" value="period_search"
                                id="crm_member_reward_viewing_period_period_search"
                                    data-xy="1-800: width_px_016 height_px_016" <?php echo $crm_member_reward_viewing_period == 'period_search' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020"
                                for="crm_member_reward_viewing_period_period_search"
                                data-xy="1-800: padding_px-r_000">기간검색</label>
                        </div>
                        <div class="flex_fl_yc width_box height_box" data-bg-color="#ffffff" data-xy="1-1200: flex_ft">
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $tree_year = egb_option_flat('year');
                                    $tree_month = egb_option_flat('month');
                                    $tree_day = egb_option_flat('day');
                                    ?>
                                    <select id="crm_member_reward_year_1" name="crm_member_reward_year_1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_year_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">선택</option>
                                        <?php foreach($tree_year as $year): ?>
                                        <option value="<?php echo $year['label']; ?>" <?php echo egb('crm_member_reward_year_1') == $year['label'] ? 'selected' : ''; ?>><?php echo $year['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_month_1" name="crm_member_reward_month_1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_month_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">선택</option>
                                        <?php foreach($tree_month as $month): ?>
                                        <option value="<?php echo $month['label']; ?>" <?php echo egb('crm_member_reward_month_1') == $month['label'] ? 'selected' : ''; ?>><?php echo $month['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_day_1" name="crm_member_reward_day_1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_day_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">선택</option>
                                        <?php foreach($tree_day as $day): ?>
                                        <option value="<?php echo $day['label']; ?>" <?php echo egb('crm_member_reward_day_1') == $day['label'] ? 'selected' : ''; ?>><?php echo $day['label']; ?></option>
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
                                    <select id="crm_member_reward_year_2" name="crm_member_reward_year_2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_year_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">선택</option>
                                        <?php foreach($tree_year as $year): ?>
                                        <option value="<?php echo $year['label']; ?>" <?php echo egb('crm_member_reward_year_2') == $year['label'] ? 'selected' : ''; ?>><?php echo $year['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_month_2" name="crm_member_reward_month_2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_month_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">선택</option>
                                        <?php foreach($tree_month as $month): ?>
                                        <option value="<?php echo $month['label']; ?>" <?php echo egb('crm_member_reward_month_2') == $month['label'] ? 'selected' : ''; ?>><?php echo $month['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="crm_member_reward_day_2" name="crm_member_reward_day_2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_reward_day_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">선택</option>
                                        <?php foreach($tree_day as $day): ?>
                                        <option value="<?php echo $day['label']; ?>" <?php echo egb('crm_member_reward_day_2') == $day['label'] ? 'selected' : ''; ?>><?php echo $day['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script nonce="<?php echo NONCE; ?>">
            document.addEventListener('DOMContentLoaded', function() {
                // 조회기간 라디오 버튼 요소들 가져오기
                const updatedAtRadios = document.querySelectorAll('input[name="crm_member_reward_viewing_period"]');
                
                // 페이지 로드시 선택된 라디오 버튼 확인
                const selectedRadio = document.querySelector('input[name="crm_member_reward_viewing_period"]:checked');
                if(selectedRadio) {
                    handleDateSelection(selectedRadio.value);
                }
                
                // 라디오 버튼 변경 이벤트 리스너
                updatedAtRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        handleDateSelection(this.value);
                    });
                });

                // 날짜 선택 처리 함수
                function handleDateSelection(value) {
                    // 날짜 입력 필드 요소들
                    const year1 = document.getElementById('crm_member_reward_year_1');
                    const month1 = document.getElementById('crm_member_reward_month_1');
                    const day1 = document.getElementById('crm_member_reward_day_1');
                    const year2 = document.getElementById('crm_member_reward_year_2');
                    const month2 = document.getElementById('crm_member_reward_month_2');
                    const day2 = document.getElementById('crm_member_reward_day_2');
                    
                    // 모든 날짜 필드 초기화 및 비활성화
                    [year1, month1, day1, year2, month2, day2].forEach(el => {
                        if(value !== 'period_search') {
                            el.value = '';
                        }
                        el.disabled = value !== 'period_search';
                    });
                    
                    // 선택된 기간에 따라 날짜 설정
                    if(value === 'today') {
                        const today = new Date();
                        setDates(today, today);
                    } else if(value === '3days') {
                        const end = new Date();
                        const start = new Date();
                        start.setDate(start.getDate() - 2);
                        setDates(start, end);
                    } else if(value === '7days') {
                        const end = new Date();
                        const start = new Date();
                        start.setDate(start.getDate() - 6);
                        setDates(start, end);
                    } else if(value === 'period_search' && !year1.value) {
                        // 기간검색이고 날짜가 비어있을 때만 오늘 날짜로 기본값 설정
                        const today = new Date();
                        setDates(today, today);
                    }
                }

                // 날짜 설정 함수
                function setDates(start, end) {
                    const year1 = document.getElementById('crm_member_reward_year_1');
                    const month1 = document.getElementById('crm_member_reward_month_1');
                    const day1 = document.getElementById('crm_member_reward_day_1');
                    const year2 = document.getElementById('crm_member_reward_year_2');
                    const month2 = document.getElementById('crm_member_reward_month_2');
                    const day2 = document.getElementById('crm_member_reward_day_2');

                    // 시작일과 종료일 설정
                    year1.value = start.getFullYear();
                    month1.value = String(start.getMonth() + 1).padStart(2,'0');
                    day1.value = String(start.getDate()).padStart(2,'0');
                    year2.value = end.getFullYear();
                    month2.value = String(end.getMonth() + 1).padStart(2,'0');
                    day2.value = String(end.getDate()).padStart(2,'0');

                    // change 이벤트 발생
                    [year1, month1, day1, year2, month2, day2].forEach(el => {
                        el.dispatchEvent(new Event('change'));
                    });
                }
            });
            </script>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span id="egen_search">검색하기</span>
                </div>
            </div>
<div class="font_px_020 flv6 padding_px-y_020">조회기간 내 마일리지 내역 통계</div>
<div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
    <div class="width_box padding_px-y_015 flex_xc font_px_016 flv6 border_px-u_001" data-bg-color="#efefef"
        data-bd-a-color="#d9d9d9">가용마일리지</div>
    <div class="flex_fl width_box height_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
        <div class="flex_fl_yc width_box font_style_center" data-xy="1-800: flex_ft">
            <div class="width_box flex_ft border_px-r_001 border_px-u_000" data-bd-a-color="#d9d9d9"
                data-xy="1-800: border_px-r_000 border_px-u_001">
                <div class="padding_px-y_015 border_px-u_001 flv6" data-bg-color="#efefef"
                    data-bd-a-color="#d9d9d9">지급</div>
                <div id="pay1" class="padding_px-y_015"><?php echo $positive_mileage; ?></div>
            </div>
            <div class="width_box flex_ft border_px-r_001 border_px-u_000" data-bd-a-color="#d9d9d9"
                data-xy="1-800: border_px-r_000 border_px-u_001">
                <div class="padding_px-y_015 border_px-u_001 flv6" data-bg-color="#efefef"
                    data-bd-a-color="#d9d9d9">차감</div>
                <div id="pay2" class="padding_px-y_015"><?php echo $negative_mileage; ?></div>
            </div>
            <div class="width_box flex_ft" data-bd-a-color="#d9d9d9">
                <div class="padding_px-y_015 border_px-u_001 flv6" data-bg-color="#efefef"
                    data-bd-a-color="#d9d9d9">합계</div>
                <div id="pay_sum" class="padding_px-y_015"><?php echo $total_mileage; ?></div>
            </div>
        </div>
    </div>
</div>
            <div class="font_px_020 flv6 padding_px-y_020">마일리지 조회결과</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;회원수&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $total_count; ?></span>명&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span
                                class="flv6" data-color="#15376b"><?php echo $search_count; ?></span>명
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
<div class="padding_px-r_010 padding_px-t_000" data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
    <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
            name="view_count" id="view_count" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
        <option value="30" <?php echo ($view_count == 30) ? 'selected' : ''; ?>>30개씩 보기</option>
        <option value="20" <?php echo ($view_count == 20) ? 'selected' : ''; ?>>20개씩 보기</option>
        <option value="10" <?php echo ($view_count == 10) ? 'selected' : ''; ?>>10개씩 보기</option>
    </select>
</div>

                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 9% 9% 10% 10% 10% 10% 8% 19% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_reward_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_reward_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">일자</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">시간</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">지급</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">차감</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">잔액</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">처리자</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">내용</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
<?php
// 결과를 출력합니다.
if ($results && isset($results[0])) {
    foreach ($results[0] as $row) {
        // 마일리지 잔액 계산
        $mileage_before = $row['mileage_before_balance'] ?? 0;
        $mileage_amount = $row['mileage_amount'] ?? 0; 
        $mileage_type = $row['mileage_type'] ?? '0';
        $mileage_after = $row['mileage_after_balance'] ?? 0;

        // 지급/차감 금액 표시
        $reward = $mileage_type == '1' ? number_format($mileage_amount) : '-';
        $deduction = $mileage_type == '0' ? number_format($mileage_amount) : '-';

        // created_at이 null인 경우 현재 시간을 사용
        $created_at = !empty($row['created_at']) ? $row['created_at'] : date('Y-m-d H:i:s');

        echo '
        <div class="grid_xx border_px-u_001" data-xx="5% 5% 9% 9% 10% 10% 10% 10% 8% 19% 5%" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
            <label for="crm_searching_member_reward_' . ($row['no'] ?? '') . '" class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" id="crm_searching_member_reward_' . ($row['no'] ?? '') . '" data-bd-a-color="#d9d9d9">
            </label>
            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . ($row['no'] ?? '') . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . date('Y-m-d', strtotime($created_at)) . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . date('H:i:s', strtotime($created_at)) . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . ($row['user_id'] ?? '') . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . $reward . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . $deduction . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . number_format($mileage_after) . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . ($row['created_by'] ?? '') . '</div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">' . ($row['mileage_reason'] ?? '') . '</div>
            <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
        </div>
        ';
    }
} else {
    echo '<div class="flex_xc padding_px-y_015">검색된 결과가 없습니다.</div>';
}
?>

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
?>
<style>
    .crm_member_reward_color {
        background-color: #15376b;
    }

    .crm_member_reward_2_bg {
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