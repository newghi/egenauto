<?php
$_SESSION['admin_login'] = 1;
// 관리자 권한 체크
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] != 1) {
    echo "<script nonce='" . NONCE . "'>window.location.href = '" . DOMAIN . "/page/login';</script>";
    exit;
}

// 검색 조건 설정
$user_name = egb('user_name');
$user_id = egb('user_id');
$user_nick_name = egb('user_nick_name');
$user_email = egb('user_email');
$user_gender = egb('user_gender');
$user_birth_year1 = egb('user_birth_day1');
$user_birth_month1 = egb('user_birth_day2');
$user_birth_day1 = egb('user_birth_day3');
$user_birth_year2 = egb('user_birth_day4');
$user_birth_month2 = egb('user_birth_day5');
$user_birth_day2 = egb('user_birth_day6');
$user_shopping_mall_type = egb('user_shopping_mall_type');
$user_selfcare_history = egb('user_selfcare_history');
$user_selfrepair_visit = egb('user_selfrepair_visit');
$user_admin_consulting_history = egb('user_admin_consulting_history');
$shopping_mall_user_type = egb('shopping_mall_user_type');
$shopping_mall_user_type_business = egb('shopping_mll_user_type_business');
$community_user_grade = egb('community_user_grade');
$user_device = egb('user_device');

// 가입일 검색 조건
$created_at = egb('created_at');
$created_at_year1 = egb('created_at_year_1');
$created_at_month1 = egb('created_at_month_1');
$created_at_day1 = egb('created_at_day_1');
$created_at_year2 = egb('created_at_year_2');
$created_at_month2 = egb('created_at_month_2');
$created_at_day2 = egb('created_at_day_2');

// 수정일 검색 조건 
$updated_at = egb('updated_at');
$updated_at_year1 = egb('updated_at_year_1');
$updated_at_month1 = egb('updated_at_month_1');
$updated_at_day1 = egb('updated_at_day_1');
$updated_at_year2 = egb('updated_at_year_2');
$updated_at_month2 = egb('updated_at_month_2');
$updated_at_day2 = egb('updated_at_day_2');

// IP 검색 조건
$user_ip = egb('user_ip');

// 페이지당 보기 수 설정
$view_count = egb('egen_search_view_count');
$view_count = !empty($view_count) ? (int)$view_count : 30;

// 쿼리 작성
$query = "
SELECT * FROM egb_user 
WHERE 1=1
";

$params = [];

function buildConditions(&$params): string {
    $conditions = [];

    if (!empty($_POST['user_name'])) {
        $conditions[] = 'user_name LIKE :user_name';
        $params[':user_name'] = '%' . $_POST['user_name'] . '%';
    }

    if (!empty($_POST['user_email'])) {
        $conditions[] = 'user_email LIKE :user_email';
        $params[':user_email'] = '%' . $_POST['user_email'] . '%';
    }

    if (!empty($_POST['user_phone'])) {
        $conditions[] = 'user_phone LIKE :user_phone';
        $params[':user_phone'] = '%' . $_POST['user_phone'] . '%';
    }

    if (!empty($_POST['user_type'])) {
        $conditions[] = 'user_type = :user_type';
        $params[':user_type'] = $_POST['user_type'];
    }

    if (!empty($_POST['join_type'])) {
        $conditions[] = 'join_type = :join_type';
        $params[':join_type'] = $_POST['join_type'];
    }

    if (!empty($_POST['user_status'])) {
        $conditions[] = 'user_status = :user_status';
        $params[':user_status'] = $_POST['user_status'];
    }

    if (!empty($_POST['sdate']) && !empty($_POST['edate'])) {
        $conditions[] = 'created_at BETWEEN :sdate AND :edate';
        $params[':sdate'] = $_POST['sdate'] . ' 00:00:00';
        $params[':edate'] = $_POST['edate'] . ' 23:59:59';
    }

    return $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
}

function fetchUsers($pdo, $offset, $view_count) {
    $params = [];
    $whereClause = buildConditions($params);

    // 메인 데이터 쿼리
    $query = "SELECT * FROM egb_user {$whereClause} ORDER BY created_at DESC LIMIT :offset, :view_count";
    $stmt = $pdo->prepare($query);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->bindValue(':view_count', (int)$view_count, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 필터된 카운트
    $countQuery = "SELECT COUNT(*) FROM egb_user {$whereClause}";
    $countStmt = $pdo->prepare($countQuery);
    foreach ($params as $key => $val) {
        $countStmt->bindValue($key, $val);
    }
    $countStmt->execute();
    $filteredCount = $countStmt->fetchColumn();

    // 전체 카운트 (필터 무시)
    $totalCount = $pdo->query("SELECT COUNT(*) FROM egb_user")->fetchColumn();

    return [
        'data' => $data,
        'filteredCount' => $filteredCount,
        'totalCount' => $totalCount
    ];
}


// 쇼핑몰 타입 검색 조건
if (!empty($user_shopping_mall_type)) {
    $query .= " AND user_shopping_mall_type LIKE :user_shopping_mall_type";
    $params[':user_shopping_mall_type'] = '%' . $user_shopping_mall_type . '%';
}

// 셀케어 사용이력 검색 조건
if (!empty($user_selfcare_history)) {
    $query .= " AND user_selfcare_history LIKE :user_selfcare_history";
    $params[':user_selfcare_history'] = '%' . $user_selfcare_history . '%';
}

// 셀수리 방문 이력 검색 조건
if (!empty($user_selfrepair_visit)) {
    $query .= " AND user_selfrepair_visit LIKE :user_selfrepair_visit";
    $params[':user_selfrepair_visit'] = '%' . $user_selfrepair_visit . '%';
}

// 관리자 상담 이력 검색 조건
if (!empty($user_admin_consulting_history)) {
    $query .= " AND user_admin_consulting_history LIKE :user_admin_consulting_history";
    $params[':user_admin_consulting_history'] = '%' . $user_admin_consulting_history . '%';
}

// 쇼핑몰 타입 검색 조건
if (!empty($shopping_mall_user_type)) {
    $query .= " AND shopping_mall_user_type LIKE :shopping_mall_user_type";
    $params[':shopping_mall_user_type'] = '%' . $shopping_mall_user_type . '%';
}

// 쇼핑몰 타입 검색 조건
if (!empty($shopping_mall_user_type_business)) {
    $query .= " AND shopping_mall_user_type_business LIKE :shopping_mall_user_type_business";
    $params[':shopping_mall_user_type_business'] = '%' . $shopping_mall_user_type_business . '%';
}

// 커뮤니티 등급 검색 조건
if (!empty($community_user_grade)) {
    $query .= " AND community_user_grade LIKE :community_user_grade";
    $params[':community_user_grade'] = '%' . $community_user_grade . '%';
}

// 디바이스 검색 조건
if (!empty($user_device)) {
    $query .= " AND user_device LIKE :user_device";
    $params[':user_device'] = '%' . $user_device . '%';
}

// 가입일 기간 설정
if ($created_at == 'today') {
    $created_at_start = date('Y-m-d');
    $created_at_end = date('Y-m-d');
} else if ($created_at == '3days') {
    $created_at_start = date('Y-m-d', strtotime('-2 days'));
    $created_at_end = date('Y-m-d');
} else if ($created_at == '7days') {
    $created_at_start = date('Y-m-d', strtotime('-6 days'));
    $created_at_end = date('Y-m-d');
} else if ($created_at == 'period' && !empty($created_at_year1) && !empty($created_at_month1) && !empty($created_at_day1) && !empty($created_at_year2) && !empty($created_at_month2) && !empty($created_at_day2)) {
    $created_at_start = $created_at_year1 . '-' . str_pad($created_at_month1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($created_at_day1, 2, '0', STR_PAD_LEFT);
    $created_at_end = $created_at_year2 . '-' . str_pad($created_at_month2, 2, '0', STR_PAD_LEFT) . '-' . str_pad($created_at_day2, 2, '0', STR_PAD_LEFT);
}

// 가입일 검색 조건
if (!empty($created_at_start) && !empty($created_at_end)) {
    $query .= " AND created_at BETWEEN :created_at_start AND :created_at_end";
    $params[':created_at_start'] = $created_at_start;
    $params[':created_at_end'] = $created_at_end;
}

// 수정일 기간 설정
if ($updated_at == 'today') {
    $updated_at_start = date('Y-m-d');
    $updated_at_end = date('Y-m-d');
} else if ($updated_at == '3days') {
    $updated_at_start = date('Y-m-d', strtotime('-2 days'));
    $updated_at_end = date('Y-m-d');
} else if ($updated_at == '7days') {
    $updated_at_start = date('Y-m-d', strtotime('-6 days'));
    $updated_at_end = date('Y-m-d');
} else if ($updated_at == 'period' && !empty($updated_at_year1) && !empty($updated_at_month1) && !empty($updated_at_day1) && !empty($updated_at_year2) && !empty($updated_at_month2) && !empty($updated_at_day2)) {
    $updated_at_start = $updated_at_year1 . '-' . str_pad($updated_at_month1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($updated_at_day1, 2, '0', STR_PAD_LEFT);
    $updated_at_end = $updated_at_year2 . '-' . str_pad($updated_at_month2, 2, '0', STR_PAD_LEFT) . '-' . str_pad($updated_at_day2, 2, '0', STR_PAD_LEFT);
}

// 수정일 검색 조건
if (!empty($updated_at_start) && !empty($updated_at_end)) {
    $query .= " AND updated_at BETWEEN :updated_at_start AND :updated_at_end";
    $params[':updated_at_start'] = $updated_at_start;
    $params[':updated_at_end'] = $updated_at_end;
}

// IP 검색 조건
if (!empty($user_ip)) {
    $query .= " AND user_ip LIKE :user_ip";
    $params[':user_ip'] = '%' . $user_ip . '%';
}


// 정렬 및 페이지당 보기 설정
$current_page = egb('list');
$current_page = (int)$current_page;
if($current_page < 1) {
    $current_page = 1;
}
$offset = ($current_page - 1) * $view_count;
$query .= " ORDER BY created_at DESC LIMIT :offset, :view_count";
$params[':offset'] = $offset;
$params[':view_count'] = $view_count;

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$results = egb_sql($binding);

// 전체 회원수와 필터링된 회원수 계산
$totalCountQuery = "
    SELECT record_total_count 
    FROM egb_record_count 
    WHERE record_table_name = :table_name 
    LIMIT 1
";
$totalCountParams = [
    ':table_name' => 'egb_user'
];
$totalCountBinding = binding_sql(1, $totalCountQuery, $totalCountParams);
$totalCountResult = egb_sql($totalCountBinding);
$totalCount = $totalCountResult[0]['record_total_count'];


$filteredCount = !empty($results[0]) ? count($results[0]) : 0;

$total_pages = ceil($totalCount / $view_count);
$num_links = 5;

?>

<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_check_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">회원정보조회</div>
                <div class="flex_xc" data-xy="1-800: flex_xr">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원조회</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">회원정보조회</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">이름</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_name" value="<?php echo $user_name; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">아이디</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_id" value="<?php echo $user_id; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">별명</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_nick_name" value="<?php echo $user_nick_name; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">이메일</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_email" value="<?php echo $user_email; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">성별</div>
                    <div class="flex_fl_yc padding_px-x_025 padding_px-y_015 border_px-u_001 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-620: padding_px-x_000 padding_px-y_010">
                        <div class="flex_yc padding_px-r_025">
                            <input class="pointer width_px_012 height_px_012"
                                id="user_gender_all"
                                name="user_gender" 
                                type="radio"
                                value="전체"
                                <?php echo empty($user_gender) || $user_gender === '전체' ? 'checked' : ''; ?>>
                            <label class="pointer padding_px-l_005"
                                for="user_gender_all">전체</label>
                        </div>
                        <?php
                        // 성별 옵션 가져오기
                        $tree = egb_option_flat('user_gender');
                        if (!empty($tree)) {
                            foreach ($tree as $option) {
                        ?>
                            <div class="flex_yc padding_px-r_025">
                                <input class="pointer width_px_012 height_px_012"
                                    id="user_gender_<?php echo $option['uniq_id']; ?>"
                                    name="user_gender"
                                    type="radio"
                                    value="<?php echo $option['label']; ?>"
                                    <?php echo $user_gender === $option['label'] ? 'checked' : ''; ?>>
                                <label class="pointer padding_px-l_005"
                                    for="user_gender_<?php echo $option['uniq_id']; ?>">
                                    <?php echo $option['label']; ?>
                                </label>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-1200: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">연령</div>
                    <div class="flex_fl_yc border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_ft">
                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                            <div class="flex_fl_yc" data-xy="1-800: width_box">
                                <select id="user_birth_day1" name="user_birth_day1"
                                    class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_year_1"
                                    data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                    <option value="" selected hidden disabled>선택</option>
                                    <?php
                                    $year_options = egb_option_flat('year');
                                    foreach($year_options as $option) {
                                        $selected = $user_birth_year1 === $option['label'] ? 'selected' : '';
                                        echo '<option value="'.$option['label'].'" '.$selected.'>'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="padding_px-l_005 padding_px-r_015"
                                    data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: width_box">
                                <select id="user_birth_day2" name="user_birth_day2"
                                    class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_month_1"
                                    data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                    <option value="" selected hidden disabled>선택</option>
                                    <?php
                                    $month_options = egb_option_flat('month');
                                    foreach($month_options as $option) {
                                        $selected = $user_birth_month1 === $option['label'] ? 'selected' : '';
                                        echo '<option value="'.$option['label'].'" '.$selected.'>'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="padding_px-l_005 padding_px-r_015"
                                    data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: width_box">
                                <select id="user_birth_day3" name="user_birth_day3"
                                    class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_day_1"
                                    data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                    <option value="" selected hidden disabled>선택</option>
                                    <?php
                                    $day_options = egb_option_flat('day');
                                    foreach($day_options as $option) {
                                        $selected = $user_birth_day1 === $option['label'] ? 'selected' : '';
                                        echo '<option value="'.$option['label'].'" '.$selected.'>'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="padding_px-l_005">일</div>
                            </div>
                        </div>
                        <div class="padding_px-x_010 padding_px-y_000"
                            data-xy="1-800: flex_xc padding_px-x_000 padding_px-y_010">~</div>
                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                            <div class="flex_fl_yc" data-xy="1-800: width_box">
                                <select id="user_birth_day4" name="user_birth_day4"
                                    class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_year_2"
                                    data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                    <option value="" selected hidden disabled>선택</option>
                                    <?php
                                    foreach($year_options as $option) {
                                        $selected = $user_birth_year2 === $option['label'] ? 'selected' : '';
                                        echo '<option value="'.$option['label'].'" '.$selected.'>'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="padding_px-l_005 padding_px-r_015"
                                    data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: width_box">
                                <select id="user_birth_day5" name="user_birth_day5"
                                    class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_month_2"
                                    data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                    <option value="" selected hidden disabled>선택</option>
                                    <?php
                                    foreach($month_options as $option) {
                                        $selected = $user_birth_month2 === $option['label'] ? 'selected' : '';
                                        echo '<option value="'.$option['label'].'" '.$selected.'>'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="padding_px-l_005 padding_px-r_015"
                                    data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                            </div>
                            <div class="flex_fl_yc" data-xy="1-800: width_box">
                                <select id="user_birth_day6" name="user_birth_day6"
                                    class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_day_2"
                                    data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                    <option value="" selected hidden disabled>선택</option>
                                    <?php
                                    foreach($day_options as $option) {
                                        $selected = $user_birth_day2 === $option['label'] ? 'selected' : '';
                                        echo '<option value="'.$option['label'].'" '.$selected.'>'.$option['label'].'</option>';
                                    }
                                    ?>
                                </select>
                                <div class="padding_px-l_005">일</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex_fl_yc width_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-912: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box border_px-u_000">쇼핑몰 구분</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-912: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 border_px-u_000 del-height_px_055">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_shopping_mall_type' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('user_shopping_mall_type');
                        
                        // 선택된 값 가져오기
                        $selected_shop = egb('user_shopping_mall_type');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_shopping_mall_type" value="전체"
                                id="user_shopping_mall_type_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_shop == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_shopping_mall_type_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_shopping_mall_type"
                                id="user_shopping_mall_type_<?php echo $option['uniq_id']; ?>" 
                                value="<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_shop == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_shopping_mall_type_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">셀케어 사용이력</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_selfcare_history' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('user_selfcare_history');
                        
                        // 선택된 값 가져오기
                        $selected_selfcare = egb('user_selfcare_history');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_selfcare_history" value="전체"
                                id="user_selfcare_history_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_selfcare == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_selfcare_history_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_selfcare_history"
                                id="user_selfcare_history_<?php echo $option['uniq_id']; ?>" 
                                value="<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_selfcare == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_selfcare_history_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">셀프정비소 방문이력</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_selfrepair_visit' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('user_selfrepair_visit');
                        
                        // 선택된 값 가져오기
                        $selected_selfrepair = egb('user_selfrepair_visit');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_selfrepair_visit" value="전체"
                                id="user_selfrepair_visit_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_selfrepair == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_selfrepair_visit_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_selfrepair_visit"
                                id="user_selfrepair_visit_<?php echo $option['uniq_id']; ?>" 
                                value="<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_selfrepair == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_selfrepair_visit_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">관리자 상담이력</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_admin_consulting_history' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('user_admin_consulting_history');
                        
                        // 선택된 값 가져오기
                        $selected_consulting = egb('user_admin_consulting_history');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_admin_consulting_history" value="전체"
                                id="user_admin_consulting_history_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_consulting == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_admin_consulting_history_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="user_admin_consulting_history"
                                id="user_admin_consulting_history_<?php echo $option['uniq_id']; ?>" 
                                value="<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_consulting == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_admin_consulting_history_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 1</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'shopping_mall_user_type' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('shopping_mall_user_type');
                        
                        // 선택된 값 가져오기
                        $selected_type1 = egb('shopping_mall_user_type');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="shopping_mall_user_type" value="전체"
                                id="shopping_mall_user_type_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_type1 == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="shopping_mall_user_type_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="shopping_mall_user_type"
                                id="shopping_mall_user_type_<?php echo $option['uniq_id']; ?>" 
                                value="<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_type1 == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="shopping_mall_user_type_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 2</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'shopping_mall_user_type_business' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('shopping_mall_user_type_business');
                        
                        // 선택된 값 가져오기
                        $selected_type2 = egb('shopping_mall_user_type_business');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="shopping_mall_user_type_business" value="전체"
                                id="shopping_mall_user_type_business_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_type2 == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="shopping_mall_user_type_business_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="shopping_mall_user_type_business"
                                id="shopping_mall_user_type_business_<?php echo $option['uniq_id']; ?>" 
                                value="<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_type2 == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="shopping_mall_user_type_business_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft border_px-u_001, 801-968: flex_fl_yc border_px-u_001" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6" data-bd-a-color="#d9d9d9" data-bg-color="#efefef" data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box border_px-u_000, 801-968: padding_px-y_018 padding_px-l_010 height_box border_px-u_000">커뮤니티 등급</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-968: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 border_px-u_000 del-height_px_055">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'community_user_grade' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('community_user_grade');

                        // 선택된 값 가져오기
                        $selected_level = egb('community_user_grade');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="community_user_grade" id="community_user_grade_all" value="전체"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_level == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="community_user_grade_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="community_user_grade" value="<?php echo $option['uniq_id']; ?>" 
                                id="community_user_grade_<?php echo $option['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_level == $option['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="community_user_grade_<?php echo $option['uniq_id']; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">디바이스</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 옵션 그룹 설정 불러오기
                        $option_group_query = "SELECT * FROM egb_option_group WHERE group_code = 'user_device' AND deleted_at IS NULL LIMIT 1";
                        $option_group = egb_sql(binding_sql(1, $option_group_query));
                        $option_required = isset($option_group[0]['group_required']) && $option_group[0]['group_required'] === 1;
                        $option_enabled = isset($option_group[0]['is_status']) && $option_group[0]['is_status'] === 1;

                        // 옵션 가져오기
                        $tree = egb_option_flat('user_device');

                        // 선택된 값 가져오기
                        $selected_device = egb('user_device');
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                name="user_device" id="crm_member_check_device_all" value="전체"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_device == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_device_all">전체</label>
                        </div>
                        <?php
                        if (!empty($tree)) {
                            foreach($tree as $option) {
                                $id = 'crm_member_check_device_' . strtolower($option['label']);
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                name="user_device" id="<?php echo $id; ?>" value="<?php echo $option['label']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_device == $option['label'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="<?php echo $id; ?>"><?php echo $option['label']; ?></label>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: border_px-u_001 padding_px-y_032 padding_px-l_010">
                        가입일</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: flex_ft border_px-u_000 del-height_px_055, 801-1200: border_px-u_000 flex_ft del-height_px_055, 1201-1500: border_px-u_001 flex_ft del-height_px_055">
                        <div class="flex_fl_yc min_width_375 width_px_375 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="created_at" value="all"
                                id="created_at_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo empty(egb('created_at')) || egb('created_at') == 'all' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="created_at_all"
                                data-xy="1-800: padding_px-r_010">전체</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="created_at" value="today"
                                id="created_at_today" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('created_at') == 'today' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="created_at_today"
                                data-xy="1-800: padding_px-r_010">오늘</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="created_at" value="3days"
                                id="created_at_3day" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('created_at') == '3days' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="created_at_3day"
                                data-xy="1-800: padding_px-r_010">3일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="created_at" value="7days"
                                id="created_at_7day" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('created_at') == '7days' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="created_at_7day"
                                data-xy="1-800: padding_px-r_010">7일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="created_at" value="period"
                                id="created_at_period_search"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('created_at') == 'period' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020"
                                for="created_at_period_search"
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
                                    <select id="created_at_year_1" name="created_at_year_1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 created_at_year_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">선택</option>
                                        <?php foreach($tree_year as $year): ?>
                                        <option value="<?php echo $year['label']; ?>" <?php echo egb('created_at_year_1') == $year['label'] ? 'selected' : ''; ?>><?php echo $year['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="created_at_month_1" name="created_at_month_1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 created_at_month_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">선택</option>
                                        <?php foreach($tree_month as $month): ?>
                                        <option value="<?php echo $month['label']; ?>" <?php echo egb('created_at_month_1') == $month['label'] ? 'selected' : ''; ?>><?php echo $month['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="created_at_day_1" name="created_at_day_1"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 created_at_day_1"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">선택</option>
                                        <?php foreach($tree_day as $day): ?>
                                        <option value="<?php echo $day['label']; ?>" <?php echo egb('created_at_day_1') == $day['label'] ? 'selected' : ''; ?>><?php echo $day['label']; ?></option>
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
                                    <select id="created_at_year_2" name="created_at_year_2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 created_at_year_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">선택</option>
                                        <?php foreach($tree_year as $year): ?>
                                        <option value="<?php echo $year['label']; ?>" <?php echo egb('created_at_year_2') == $year['label'] ? 'selected' : ''; ?>><?php echo $year['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="created_at_month_2" name="created_at_month_2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 created_at_month_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">선택</option>
                                        <?php foreach($tree_month as $month): ?>
                                        <option value="<?php echo $month['label']; ?>" <?php echo egb('created_at_month_2') == $month['label'] ? 'selected' : ''; ?>><?php echo $month['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="created_at_day_2" name="created_at_day_2"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 created_at_day_2"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">선택</option>
                                        <?php foreach($tree_day as $day): ?>
                                        <option value="<?php echo $day['label']; ?>" <?php echo egb('created_at_day_2') == $day['label'] ? 'selected' : ''; ?>><?php echo $day['label']; ?></option>
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
                    // 가입일 라디오 버튼 이벤트 리스너
                    const createdAtRadios = document.querySelectorAll('input[name="created_at"]');
                    
                    // 페이지 로드시 선택된 라디오 버튼에 대한 날짜 설정
                    const selectedRadio = document.querySelector('input[name="created_at"]:checked');
                    if(selectedRadio) {
                        handleDateSelection(selectedRadio.value);
                    }
                    
                    createdAtRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            handleDateSelection(this.value);
                        });
                    });

                    function handleDateSelection(value) {
                        const year1 = document.getElementById('created_at_year_1');
                        const month1 = document.getElementById('created_at_month_1'); 
                        const day1 = document.getElementById('created_at_day_1');
                        const year2 = document.getElementById('created_at_year_2');
                        const month2 = document.getElementById('created_at_month_2');
                        const day2 = document.getElementById('created_at_day_2');

                        // 모든 날짜 필드 초기화 및 비활성화 설정
                        [year1, month1, day1, year2, month2, day2].forEach(el => {
                            el.value = '';
                            el.disabled = value !== 'period';
                        });

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
                        }
                    }

                    function setDates(startDate, endDate) {
                        const year1 = document.getElementById('created_at_year_1');
                        const month1 = document.getElementById('created_at_month_1');
                        const day1 = document.getElementById('created_at_day_1');
                        const year2 = document.getElementById('created_at_year_2');
                        const month2 = document.getElementById('created_at_month_2');
                        const day2 = document.getElementById('created_at_day_2');

                        year1.value = startDate.getFullYear();
                        month1.value = String(startDate.getMonth() + 1).padStart(2,'0');
                        day1.value = String(startDate.getDate()).padStart(2,'0');
                        year2.value = endDate.getFullYear();
                        month2.value = String(endDate.getMonth() + 1).padStart(2,'0');
                        day2.value = String(endDate.getDate()).padStart(2,'0');

                        // 값 변경 이벤트 트리거
                        [year1, month1, day1, year2, month2, day2].forEach(el => {
                            el.dispatchEvent(new Event('change'));
                        });
                    }
                });
                </script>
                <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: border_px-u_001 padding_px-y_032 padding_px-l_010">
                        접속일</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-1200: flex_ft border_px-u_000 del-height_px_055, 1201-1500: flex_ft border_px-u_001 del-height_px_055">
                        <div class="flex_fl_yc min_width_375 width_px_375 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_updateday" value="전체" 
                                id="crm_member_check_updateday_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo !egb('crm_member_check_updateday') || egb('crm_member_check_updateday') == '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_check_updateday_all"
                                data-xy="1-800: padding_px-r_010">전체</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_updateday" value="today"
                                id="crm_member_check_updateday_today" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('crm_member_check_updateday') == 'today' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_check_updateday_today"
                                data-xy="1-800: padding_px-r_010">오늘</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_updateday" value="3days"
                                id="crm_member_check_updateday_3day" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('crm_member_check_updateday') == '3days' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_check_updateday_3day"
                                data-xy="1-800: padding_px-r_010">3일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_updateday" value="7days"
                                id="crm_member_check_updateday_7day" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('crm_member_check_updateday') == '7days' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="crm_member_check_updateday_7day"
                                data-xy="1-800: padding_px-r_010">7일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_updateday" value="period"
                                id="crm_member_check_updateday_period_search" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo egb('crm_member_check_updateday') == 'period' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020"
                                for="crm_member_check_updateday_period_search"
                                data-xy="1-800: padding_px-r_000">기간검색</label>
                        </div>
                        <div class="flex_fl_yc width_box height_box" data-bg-color="#ffffff" data-xy="1-1200: flex_ft">
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <?php
                                    $tree_year = egb_option_flat('year');
                                    $selected_year1 = egb('crm_member_check_year1_5');
                                    ?>
                                    <select id="crm_member_check_year1_5" name="crm_member_check_year1_5"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_year_7"
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
                                    $selected_month1 = egb('crm_member_check_month1_5');
                                    ?>
                                    <select id="crm_member_check_month1_5" name="crm_member_check_month1_5"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_month_7"
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
                                    $selected_day1 = egb('crm_member_check_day1_5');
                                    ?>
                                    <select id="crm_member_check_day1_5" name="crm_member_check_day1_5"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_day_7"
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
                                    $selected_year2 = egb('crm_member_check_year1_6');
                                    ?>
                                    <select id="crm_member_check_year1_6" name="crm_member_check_year1_6"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_year_8"
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
                                    $selected_month2 = egb('crm_member_check_month1_6');
                                    ?>
                                    <select id="crm_member_check_month1_6" name="crm_member_check_month1_6"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_month_8"
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
                                    $selected_day2 = egb('crm_member_check_day1_6');
                                    ?>
                                    <select id="crm_member_check_day1_6" name="crm_member_check_day1_6"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001 crm_member_check_day_8"
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
                    // 접속일 라디오 버튼 이벤트 리스너
                    const updatedAtRadios = document.querySelectorAll('input[name="crm_member_check_updateday"]');
                    
                    // 페이지 로드시 선택된 라디오 버튼에 대한 날짜 설정
                    const selectedRadio = document.querySelector('input[name="crm_member_check_updateday"]:checked');
                    if(selectedRadio) {
                        handleDateSelection(selectedRadio.value);
                    }
                    
                    updatedAtRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            handleDateSelection(this.value);
                        });
                    });

                    function handleDateSelection(value) {
                        const year1 = document.getElementById('crm_member_check_year1_5');
                        const month1 = document.getElementById('crm_member_check_month1_5'); 
                        const day1 = document.getElementById('crm_member_check_day1_5');
                        const year2 = document.getElementById('crm_member_check_year1_6');
                        const month2 = document.getElementById('crm_member_check_month1_6');
                        const day2 = document.getElementById('crm_member_check_day1_6');

                        // 모든 날짜 필드 초기화 및 비활성화 설정
                        [year1, month1, day1, year2, month2, day2].forEach(el => {
                            el.value = '';
                            el.disabled = value !== 'period';
                        });

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
                        }
                    }

                    function setDates(startDate, endDate) {
                        const year1 = document.getElementById('crm_member_check_year1_5');
                        const month1 = document.getElementById('crm_member_check_month1_5');
                        const day1 = document.getElementById('crm_member_check_day1_5');
                        const year2 = document.getElementById('crm_member_check_year1_6');
                        const month2 = document.getElementById('crm_member_check_month1_6');
                        const day2 = document.getElementById('crm_member_check_day1_6');

                        year1.value = startDate.getFullYear();
                        month1.value = String(startDate.getMonth() + 1).padStart(2,'0');
                        day1.value = String(startDate.getDate()).padStart(2,'0');
                        year2.value = endDate.getFullYear();
                        month2.value = String(endDate.getMonth() + 1).padStart(2,'0');
                        day2.value = String(endDate.getDate()).padStart(2,'0');

                        // 값 변경 이벤트 트리거
                        [year1, month1, day1, year2, month2, day2].forEach(el => {
                            el.dispatchEvent(new Event('change'));
                        });
                    }
                });
                </script>
                
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">접속 IP</div>
                    <div class="flex_fl_yc border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_ft">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_ip" value="<?php echo $user_ip; ?>"
                            data-xy="1-800: width_box font_px_012">
                        <div class="padding_px-l_020 padding_px-t_000 font_px_012" data-color="#bbbbbb"
                            data-xy="1-800: padding_px-l_005 padding_px-t_005">예&rpar; 123.123.123.123</div>
                    </div>
                </div>
                
            </div>
            <!-- <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span id="egen_search" data-color="#ffffff">검색하기</span>
                </div>
            </div>
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
}); -->
<!-- 검색 버튼 및 결과 영역 -->
 
<div class="flex_xc padding_px-t_010 padding_px-u_020">
  <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
       data-xy="1-800: font_px_016"
       data-bd-a-color="#d9d9d9"
       data-bg-color="#333333"
       data-color="#ffffff">
    <span id="egen_search" data-color="#ffffff">검색하기</span>
  </div>
</div>
            <div class="font_px_020 flv6 padding_px-y_020">회원정보조회 결과</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;회원수&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $totalCount; ?></span>명&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span
                                class="flv6" data-color="#15376b"><?php echo $filteredCount; ?></span>명
                        </div>
                        <div class="flex_fl_yc padding_px-t_000" data-xy="1-800: padding_px-t_010">
                            <div class="flex_xc padding_px-l_005">
                                <div class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">SMS</div>
                            </div>
                            <div class="flex_xc padding_px-l_005">
                                <div id="user_excel_download"
                                    class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">EXCEL</div>
                            </div>
                            <div class="flex_xc padding_px-l_005">
                                <div id="user_all_excel_download"
                                    class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">ALL EXCEL</div>
                            </div>
                        </div>
                    </div>
                    <div class="padding_px-r_010 padding_px-t_000"
                        data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                        <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                            name="egen_search_view_count" id="egen_search_view_count" data-bd-a-color="#888888"
                            data-xy="1-800: font_px_012">
                            <option value="30" <?php echo $view_count == 30 ? 'selected' : ''; ?>>30개씩 보기</option>
                            <option value="20" <?php echo $view_count == 20 ? 'selected' : ''; ?>>20개씩 보기</option>
                            <option value="10" <?php echo $view_count == 10 ? 'selected' : ''; ?>>10개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_check_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_check_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">가입일
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이름</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">연락처1
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원구분
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">쇼핑몰 등급
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">성별
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">커뮤니티 등급
                            </div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                    </div>
                </div>
            </div>
<!-- 결과 표시 영역 -->
<div id="search_result" class="padding_px-u_020"></div>

<script nonce="<?php echo NONCE; ?>">
document.getElementById('egen_search').addEventListener('click', function () {
    const formData = new FormData();
    document.querySelectorAll('input[user_name], select[user_name]').forEach(el => {
        if (el.type === 'radio' && !el.checked) return;
        if (el.value !== '') formData.append(el.name, el.value);
    });

     // ✅ user_name 필드 수집!
    const nameInput = document.querySelector('input[name="user_name"]');
    if (nameInput && nameInput.value.trim() !== '') {
        formData.append('user_name', nameInput.value.trim());
    }
    
    fetch('/egb_api/crm_member_search_input.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('search_result').innerHTML = html;
    })
    .catch(err => {
        console.error('검색 오류', err);
        document.getElementById('search_result').innerHTML = '<div>검색 실패</div>';
    });
});
</script>


</script>
            <div id="member_list_result"></div>
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
    .crm_member_check_color {
        background-color: #15376b;
    }

    .crm_member_check_1_bg {
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
        outline: unset;
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