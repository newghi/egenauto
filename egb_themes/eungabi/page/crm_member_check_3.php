<?php
// GET 요청으로 필터 값을 받습니다. 값이 없으면 빈 문자열로 초기화합니다.
$reservation_platform = isset($_GET['reservation_platform']) ? $_GET['reservation_platform'] : '';
$user_type1 = isset($_GET['user_type1']) ? $_GET['user_type1'] : '';
$user_type2 = isset($_GET['user_type2']) ? $_GET['user_type2'] : '';
$payment_company = isset($_GET['payment_company']) ? $_GET['payment_company'] : '';
$payment_method = isset($_GET['payment_method']) ? $_GET['payment_method'] : '';
$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$reservation_code = isset($_GET['reservation_code']) ? $_GET['reservation_code'] : '';
$reservation_status = isset($_GET['reservation_status']) ? $_GET['reservation_status'] : '';
$search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';

// 예약일자 범위 필터링
$reservation_date_year1 = isset($_GET['reservation_date_year1']) ? $_GET['reservation_date_year1'] : '';
$reservation_date_month1 = isset($_GET['reservation_date_month1']) ? $_GET['reservation_date_month1'] : '';
$reservation_date_day1 = isset($_GET['reservation_date_day1']) ? $_GET['reservation_date_day1'] : '';
$reservation_date_year2 = isset($_GET['reservation_date_year2']) ? $_GET['reservation_date_year2'] : '';
$reservation_date_month2 = isset($_GET['reservation_date_month2']) ? $_GET['reservation_date_month2'] : '';
$reservation_date_day2 = isset($_GET['reservation_date_day2']) ? $_GET['reservation_date_day2'] : '';

// 사용금액 필터
$amount_type = isset($_GET['amount_type']) ? $_GET['amount_type'] : '';
$min_amount = isset($_GET['min_amount']) ? $_GET['min_amount'] : '';
$max_amount = isset($_GET['max_amount']) ? $_GET['max_amount'] : '';

// 예약건수 필터
$reservation_count_type = isset($_GET['reservation_count_type']) ? $_GET['reservation_count_type'] : '';
$min_count = isset($_GET['min_count']) ? $_GET['min_count'] : '';
$max_count = isset($_GET['max_count']) ? $_GET['max_count'] : '';

// 페이지네이션 설정
$current_page = isset($_GET['list']) ? (int) $_GET['list'] : 1;
$view_count = isset($_GET['egen_search_view_count']) ? (int) $_GET['egen_search_view_count'] : 30;
$offset = ($current_page - 1) * $view_count;

// 기본 쿼리 생성
$query = "SELECT * FROM auto_reservation_status WHERE is_status = 1";
$params = [];

// 필터 조건 추가
if ($reservation_platform) {
    $query .= " AND reservation_platform = :reservation_platform";
    $params[':reservation_platform'] = $reservation_platform;
}

if ($user_type1) {
    $query .= " AND user_type1 = :user_type1";
    $params[':user_type1'] = $user_type1;
}

if ($user_type2) {
    $query .= " AND user_type2 = :user_type2";
    $params[':user_type2'] = $user_type2;
}

if ($payment_company) {
    $query .= " AND payment_company = :payment_company";
    $params[':payment_company'] = $payment_company;
}

if ($payment_method) {
    $query .= " AND payment_method = :payment_method";
    $params[':payment_method'] = $payment_method;
}

if ($user_name) {
    $query .= " AND user_name LIKE :user_name";
    $params[':user_name'] = "%$user_name%";
}

if ($user_id) {
    $query .= " AND user_id LIKE :user_id";
    $params[':user_id'] = "%$user_id%";
}

if ($reservation_code) {
    $query .= " AND reservation_code = :reservation_code";
    $params[':reservation_code'] = $reservation_code;
}

if ($reservation_status && $reservation_status != 'all') {
    $query .= " AND reservation_status = :reservation_status";
    $params[':reservation_status'] = $reservation_status;
}

if ($search_keyword) {
    $query .= " AND (user_name LIKE :search_keyword OR user_id LIKE :search_keyword OR reservation_code LIKE :search_keyword)";
    $params[':search_keyword'] = "%$search_keyword%";
}

// 예약일자 필터링
if ($reservation_date_year1 && $reservation_date_month1 && $reservation_date_day1) {
    $start_date = sprintf("%04d-%02d-%02d 00:00:00", $reservation_date_year1, $reservation_date_month1, $reservation_date_day1);
    $query .= " AND reservation_start >= :start_date";
    $params[':start_date'] = $start_date;
}

if ($reservation_date_year2 && $reservation_date_month2 && $reservation_date_day2) {
    $end_date = sprintf("%04d-%02d-%02d 23:59:59", $reservation_date_year2, $reservation_date_month2, $reservation_date_day2);
    $query .= " AND reservation_end <= :end_date";
    $params[':end_date'] = $end_date;
}

// 사용금액 필터링
if ($amount_type && $min_amount !== '') {
    $query .= " AND used_amount >= :min_amount";
    $params[':min_amount'] = $min_amount;
}

if ($amount_type && $max_amount !== '') {
    $query .= " AND used_amount <= :max_amount";
    $params[':max_amount'] = $max_amount;
}

// 예약건수 필터링
if ($reservation_count_type && $min_count !== '') {
    $query .= " AND reservation_count >= :min_count";
    $params[':min_count'] = $min_count;
}

if ($reservation_count_type && $max_count !== '') {
    $query .= " AND reservation_count <= :max_count";
    $params[':max_count'] = $max_count;
}

// 정렬 및 페이지네이션
$query .= " ORDER BY created_at DESC LIMIT :offset, :view_count";
$params[':offset'] = $offset;
$params[':view_count'] = $view_count;

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$sql_results = egb_sql($binding);

// 결과가 null이 아닌 경우에만 count() 실행
$filteredCount = 0;
if (is_array($sql_results) && isset($sql_results[0])) {
    $filteredCount = count($sql_results[0]);
}

// 총 데이터 수량 쿼리
$totalQuery = "SELECT COUNT(*) as total_count FROM auto_reservation_status WHERE is_status = 1";
$totalBinding = binding_sql(0, $totalQuery, []);
$totalResult = egb_sql($totalBinding);

$totalCount = 0;
if (is_array($totalResult) && isset($totalResult[0][0]['total_count'])) {
    $totalCount = number_format($totalResult[0][0]['total_count']);
}

$total_pages = ceil((int)str_replace(',', '', $totalCount) / $view_count);
$num_links = 5;
?>

<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_check_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020 "
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">예약현황조회</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원조회</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">예약현황조회</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">예약 플랫폼 구분</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        $selected_platform = isset($_GET['reservation_platform']) ? $_GET['reservation_platform'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="reservation_platform" id="crm_member_check_three_reservation_platform_all" value="전체"
                            data-xy="1-800: width_px_016 height_px_016" <?php echo $selected_platform == '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010" 
                            for="crm_member_check_three_reservation_platform_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="reservation_platform" id="crm_member_check_three_reservation_platform_site" value="사이트 예약"
                            data-xy="1-800: width_px_016 height_px_016" <?php echo $selected_platform == '사이트 예약' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_three_reservation_platform_site">사이트 예약</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="reservation_platform" id="crm_member_check_three_reservation_platform_naver" value="네이버 예약"
                            data-xy="1-800: width_px_016 height_px_016" <?php echo $selected_platform == '네이버 예약' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_three_reservation_platform_naver">네이버 예약</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="reservation_platform" id="crm_member_check_three_reservation_platform_kakao" value="카카오 예약"
                            data-xy="1-800: width_px_016 height_px_016" <?php echo $selected_platform == '카카오 예약' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005" for="crm_member_check_three_reservation_platform_kakao">카카오 예약</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 1</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        $selected_type1 = isset($_GET['user_type1']) ? $_GET['user_type1'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="user_type1" id="crm_member_check_memberclass_one_all" value="전체"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type1 == '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_one_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="user_type1" id="crm_member_check_memberclass_one_yes" value="회원"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type1 == '회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_one_yes">회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="user_type1" id="crm_member_check_memberclass_one_no" value="비회원"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type1 == '비회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005" for="crm_member_check_memberclass_one_no">비회원</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 2</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        $selected_type2 = isset($_GET['user_type2']) ? $_GET['user_type2'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="user_type2" id="crm_member_check_memberclass_two_all" value="전체"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type2 == '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_two_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="user_type2" id="crm_member_check_memberclass_two_yes" value="개인회원"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type2 == '개인회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_two_yes">개인회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="user_type2" id="crm_member_check_memberclass_two_no" value="사업자"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type2 == '사업자' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005" for="crm_member_check_memberclass_two_no">사업자</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">결제업체</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_fl_yc_wrap">
                        <?php
                        // 결제업체 데이터 조회
                        $query = "SELECT * FROM auto_payment_company WHERE is_status = 1 ORDER BY display_order ASC";
                        $binding = binding_sql(0, $query, []);
                        $payment_companies = egb_sql($binding);

                        $selected_company = isset($_GET['payment_company']) ? $_GET['payment_company'] : '';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="payment_company" id="payment_company_all" value=""
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_company == '' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="payment_company_all">전체</label>
                        
                        <?php
                        if($payment_companies[0]) {
                            foreach($payment_companies[0] as $company) {
                                ?>
                                <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                    name="payment_company" id="payment_company_<?php echo $company['uniq_id']; ?>" 
                                    value="<?php echo $company['uniq_id']; ?>"
                                    data-xy="1-800: width_px_016 height_px_016" 
                                    <?php echo $selected_company == $company['uniq_id'] ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="payment_company_<?php echo $company['uniq_id']; ?>"><?php echo $company['payment_company_name']; ?></label>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="flex_fl width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-912: flex_fl border_px-u_001" data-bg-color="#ffffff"
                    data-bd-a-color="#d9d9d9">
                    <div class="flex_yc min_width_180 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-912: padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_000">
                        결제수단</div>
                    <div class="flex_fl_yc_wrap height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-800: padding_px-y_000 padding_px-x_010 border_px-u_000 del-height_px_055, 801-1000: padding_px-y_000 padding_px-x_010 border_px-u_001 del-height_px_055">
                        <?php
                        // 결제수단 데이터 조회
                        $query = "SELECT * FROM auto_payment_method WHERE is_status = 1 ORDER BY display_order ASC";
                        $binding = binding_sql(0, $query, []);
                        $payment_methods = egb_sql($binding);

                        $selected_method = isset($_GET['payment_method']) ? $_GET['payment_method'] : '';
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="payment_method" id="payment_method_all" value=""
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_method == '' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="payment_method_all">전체</label>
                        </div>

                        <?php
                        if($payment_methods[0]) {
                            foreach($payment_methods[0] as $method) {
                                ?>
                                <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                        type="radio" name="payment_method" 
                                        id="payment_method_<?php echo $method['uniq_id']; ?>"
                                        value="<?php echo $method['uniq_id']; ?>"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo $selected_method == $method['uniq_id'] ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="payment_method_<?php echo $method['uniq_id']; ?>"><?php echo $method['payment_method_name']; ?></label>
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
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">이름</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="user_name" id="user_name" 
                            value="<?php echo isset($_GET['user_name']) ? $_GET['user_name'] : ''; ?>"
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
                            data-bd-a-color="#888888" type="text" name="user_id" id="user_id"
                            value="<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : ''; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">예약번호</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="reservation_code" id="reservation_code"
                            value="<?php echo isset($_GET['reservation_code']) ? $_GET['reservation_code'] : ''; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: padding_px-y_032 padding_px-l_010 border_px-u_001">
                        예약기간</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-1200: flex_ft border_px-u_000 del-height_px_055, 1201-1500: flex_ft border_px-u_001 del-height_px_055">
                        <div class="flex_fl_yc min_width_375 width_px_375 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <?php
                            $period = isset($_GET['period']) ? $_GET['period'] : 'all';
                            $today = date('Y-m-d');
                            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
                            
                            if($start_date && $end_date) {
                                list($start_year, $start_month, $start_day) = explode('-', $start_date);
                                list($end_year, $end_month, $end_day) = explode('-', $end_date);
                            } else {
                                $start_year = $end_year = date('Y');
                                $start_month = $end_month = date('m');
                                $start_day = $end_day = date('d');
                            }
                            ?>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_all" value="all"
                                data-xy="1-800: width_px_016 height_px_016" 
                                <?php echo $period == 'all' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_all"
                                data-xy="1-800: padding_px-r_010">전체</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_today" value="today"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period == 'today' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_today"
                                data-xy="1-800: padding_px-r_010">오늘</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_3day" value="3day"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period == '3day' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_3day"
                                data-xy="1-800: padding_px-r_010">3일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_7day" value="7day"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period == '7day' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_7day"
                                data-xy="1-800: padding_px-r_010">7일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_custom" value="custom"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period == 'custom' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_custom"
                                data-xy="1-800: padding_px-r_000">기간검색</label>
                        </div>
                        <div class="flex_fl_yc width_box height_box" data-bg-color="#ffffff" data-xy="1-1200: flex_ft">
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_year" name="start_year"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php 
                                        $current_year = date('Y');
                                        for($year = $current_year - 5; $year <= $current_year + 5; $year++): 
                                        ?>
                                        <option value="<?php echo $year; ?>" <?php echo $start_year == $year ? 'selected' : ''; ?>><?php echo $year; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_month" name="start_month"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo $start_month == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_day" name="start_day"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php 
                                        $days_in_month = date('t', strtotime($start_year.'-'.$start_month.'-01'));
                                        for($i=1; $i<=$days_in_month; $i++): 
                                        ?>
                                        <option value="<?php echo $i; ?>" <?php echo $start_day == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                            <div class="padding_px-x_010 padding_px-y_000"
                                data-xy="1-800: flex_xc padding_px-x_000 padding_px-y_010, 801-1200: flex_xc padding_px-x_000 padding_px-y_005">
                                ~</div>
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="end_year" name="end_year"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php 
                                        for($year = $current_year - 5; $year <= $current_year + 5; $year++): 
                                        ?>
                                        <option value="<?php echo $year; ?>" <?php echo $end_year == $year ? 'selected' : ''; ?>><?php echo $year; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="end_month" name="end_month"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo $end_month == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="end_day" name="end_day"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="" selected hidden disabled>선택</option>
                                        <?php 
                                        $days_in_month = date('t', strtotime($end_year.'-'.$end_month.'-01'));
                                        for($i=1; $i<=$days_in_month; $i++): 
                                        ?>
                                        <option value="<?php echo $i; ?>" <?php echo $end_day == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005">일</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script nonce="<?php echo NONCE; ?>">
                    document.addEventListener('DOMContentLoaded', function() {
                        const dateSelects = {
                            start: {
                                year: document.getElementById('start_year'),
                                month: document.getElementById('start_month'),
                                day: document.getElementById('start_day')
                            },
                            end: {
                                year: document.getElementById('end_year'),
                                month: document.getElementById('end_month'),
                                day: document.getElementById('end_day')
                            }
                        };

                        // 날짜 선택 활성화/비활성화 함수
                        function toggleDateSelects(disabled) {
                            ['start', 'end'].forEach(type => {
                                dateSelects[type].year.disabled = disabled;
                                dateSelects[type].month.disabled = disabled;
                                dateSelects[type].day.disabled = disabled;
                            });
                        }

                        // 날짜 설정 함수
                        function setDateRange(days) {
                            const today = new Date();
                            const startDate = new Date(today);
                            if(days > 0) {
                                startDate.setDate(today.getDate() - days);
                            }
                            
                            ['start', 'end'].forEach(type => {
                                const date = type === 'start' ? startDate : today;
                                dateSelects[type].year.value = date.getFullYear();
                                dateSelects[type].month.value = date.getMonth() + 1;
                                dateSelects[type].day.value = date.getDate();
                            });
                            
                            toggleDateSelects(true);
                        }

                        // 라디오 버튼 이벤트 리스너
                        document.querySelectorAll('input[name="period"]').forEach(radio => {
                            radio.addEventListener('change', function() {
                                switch(this.value) {
                                    case 'custom':
                                        toggleDateSelects(false);
                                        break;
                                    case 'today':
                                        setDateRange(0);
                                        break;
                                    case '3day':
                                        setDateRange(3);
                                        break;
                                    case '7day':
                                        setDateRange(7);
                                        break;
                                    case 'all':
                                        toggleDateSelects(true);
                                        // 전체 선택시 날짜 초기화
                                        ['start', 'end'].forEach(type => {
                                            dateSelects[type].year.value = '';
                                            dateSelects[type].month.value = '';
                                            dateSelects[type].day.value = '';
                                        });
                                        break;
                                }
                            });
                        });

                        // 초기 상태 설정
                        const selectedPeriod = document.querySelector('input[name="period"]:checked');
                        if (selectedPeriod) {
                            if (selectedPeriod.value === 'custom') {
                                toggleDateSelects(false);
                            } else if (selectedPeriod.value === 'today') {
                                setDateRange(0);
                            } else if (selectedPeriod.value === '3day') {
                                setDateRange(3);
                            } else if (selectedPeriod.value === '7day') {
                                setDateRange(7);
                            } else if (selectedPeriod.value === 'all') {
                                toggleDateSelects(true);
                                // 전체 선택시 날짜 초기화
                                ['start', 'end'].forEach(type => {
                                    dateSelects[type].year.value = '';
                                    dateSelects[type].month.value = '';
                                    dateSelects[type].day.value = '';
                                });
                            }
                        }
                    });
                </script>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">사용금액</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_ft del-height_px_055">
                        <div class="" data-xy="1-800: width_box">
                            <select class="width_px_160 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="amount_type" id="amount_type"
                                data-xy="1-800: width_box font_px_012">
                                <option value="총 주문금액" <?php echo isset($_GET['amount_type']) && $_GET['amount_type'] == '총 주문금액' ? 'selected' : ''; ?>>총 주문금액</option>
                                <option value="총 실결제금액" <?php echo isset($_GET['amount_type']) && $_GET['amount_type'] == '총 실결제금액' ? 'selected' : ''; ?>>총 실결제금액</option>
                            </select>
                        </div>
                        <div class="width_px_020 height_px_010"></div>
                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="min_amount" id="min_amount"
                                value="<?php echo isset($_GET['min_amount']) ? $_GET['min_amount'] : ''; ?>"
                                data-xy="1-800: width_box font_px_012">
                            <div class="width_px_020 flex_xc" data-xy="1-800: min_width_020">-</div>
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="max_amount" id="max_amount"
                                value="<?php echo isset($_GET['max_amount']) ? $_GET['max_amount'] : ''; ?>"
                                data-xy="1-800: width_box font_px_012">
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">예약건수</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_ft del-height_px_055">
                        <div data-xy="1-800: width_box">
                            <select class="width_px_160 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="reservation_count_type" id="reservation_count_type"
                                data-xy="1-800: width_box font_px_012">
                                <option value="총 주문건수" <?php echo isset($_GET['reservation_count_type']) && $_GET['reservation_count_type'] == '총 주문건수' ? 'selected' : ''; ?>>총 주문건수</option>
                                <option value="총 실주문건수" <?php echo isset($_GET['reservation_count_type']) && $_GET['reservation_count_type'] == '총 실주문건수' ? 'selected' : ''; ?>>총 실주문건수</option>
                            </select>
                        </div>
                        <div class="width_px_020 height_px_010"></div>
                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="min_count" id="min_count"
                                value="<?php echo isset($_GET['min_count']) ? $_GET['min_count'] : ''; ?>"
                                data-xy="1-800: width_box font_px_012">
                            <div class="width_px_020 flex_xc" data-xy="1-800: min_width_020">-</div>
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="text" name="max_count" id="max_count"
                                value="<?php echo isset($_GET['max_count']) ? $_GET['max_count'] : ''; ?>"
                                data-xy="1-800: width_box font_px_012">
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">검색어</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="search_keyword" id="search_keyword" 
                            value="<?php echo isset($_GET['search_keyword']) ? $_GET['search_keyword'] : ''; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_000 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box">주문상태</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_000 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-912: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 del-height_px_055">
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="reservation_status" value="all"
                                id="reservation_status_all"
                                <?php echo (!isset($_GET['reservation_status']) || $_GET['reservation_status'] == 'all') ? 'checked' : ''; ?>
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="reservation_status_all">전체</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="reservation_status" value="예약완료"
                                id="reservation_status_completed"
                                <?php echo (isset($_GET['reservation_status']) && $_GET['reservation_status'] == '예약완료') ? 'checked' : ''; ?>
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="reservation_status_completed">예약완료</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="reservation_status" value="방문완료"
                                id="reservation_status_visited"
                                <?php echo (isset($_GET['reservation_status']) && $_GET['reservation_status'] == '방문완료') ? 'checked' : ''; ?>
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="reservation_status_visited">방문완료</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="reservation_status" value="예약취소"
                                id="reservation_status_cancelled"
                                <?php echo (isset($_GET['reservation_status']) && $_GET['reservation_status'] == '예약취소') ? 'checked' : ''; ?>
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="reservation_status_cancelled">예약취소</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="reservation_status" value="노쇼"
                                id="reservation_status_noshow"
                                <?php echo (isset($_GET['reservation_status']) && $_GET['reservation_status'] == '노쇼') ? 'checked' : ''; ?>
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="reservation_status_noshow">노쇼</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div id="egen_search" class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span>검색하기</span>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">예약현황조회 결과</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;회원수&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $totalCount; ?></span>명&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $filteredCount; ?></span>명
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
                            name="egen_search_view_count" id="egen_search_view_count" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                            <option value="30" <?php echo $view_count == 30 ? 'selected' : ''; ?>>30개씩 보기</option>
                            <option value="20" <?php echo $view_count == 20 ? 'selected' : ''; ?>>20개씩 보기</option>
                            <option value="10" <?php echo $view_count == 10 ? 'selected' : ''; ?>>10개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden" style="user-select: none;">
                    <div class="flex_ft border_px-a_001 min_width_1300 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6 bd-a-color-d9d9d9 bg-color-efefef xx-5per-5per-11per-11per-11per-11per-11per-12per-6per-6per-6per-5per" data-xx="5% 5% 11% 11% 11% 11% 11% 12% 6% 6% 6% 5%" data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_check_three_all" class="flex_xc border_px-r_001 padding_px-y_015 pointer bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020 bd-a-color-d9d9d9" dat="" type="checkbox" name="" id="crm_searching_member_check_three_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">최근예약일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">이름</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">연락처1</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">예약처</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">회원등급</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">누적 결제금액
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">예약</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">취소</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">노쇼</div>
                            <div class="flex_xc padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <?php if(isset($sql_results[0]) && is_array($sql_results[0])): ?>
                            <?php foreach($sql_results[0] as $index => $result): ?>
                            <div class="grid_xx border_px-u_001" data-xx="5% 5% 11% 11% 11% 11% 11% 12% 6% 6% 6% 5%"
                                data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                                <label for="crm_searching_member_check_three_<?php echo $index + 1; ?>"
                                    class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                    <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                        id="crm_searching_member_check_three_<?php echo $index + 1; ?>" data-bd-a-color="#d9d9d9">
                                </label>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $index + 1; ?>
                                </div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['order_date']; ?>
                                </div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['order_user_name']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['order_user_phone']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['order_mall_type']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['order_user_type1']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo number_format($result['total_amount']); ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['order_count']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['cancel_count']; ?></div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $result['noshow_count']; ?></div>
                                <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
    .crm_member_check_color {
        background-color: #15376b;
    }

    .crm_member_check_3_bg {
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
            year: document.querySelector(`.crm_member_check_three_year_${i}`),
            month: document.querySelector(`.crm_member_check_three_month_${i}`),
            day: document.querySelector(`.crm_member_check_three_day_${i}`)
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
<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function () {
    // 필터링 폼 submit 버튼 클릭 이벤트 
    document.getElementById('egen_search').addEventListener('click', function (e) {
        e.preventDefault(); // 기본 제출 동작 방지

        // 필드값 가져오기
        const reservation_platform = document.querySelector('input[name="reservation_platform"]:checked')?.value || '';
        const user_type1 = document.querySelector('input[name="user_type1"]:checked')?.value || '';
        const user_type2 = document.querySelector('input[name="user_type2"]:checked')?.value || '';
        const payment_company = document.querySelector('input[name="payment_company"]:checked')?.value || '';
        const payment_method = document.querySelector('input[name="payment_method"]:checked')?.value || '';
        const user_name = document.querySelector('input[name="user_name"]')?.value || '';
        const user_id = document.querySelector('input[name="user_id"]')?.value || '';
        const reservation_code = document.querySelector('input[name="reservation_code"]')?.value || '';
        const reservation_status = document.querySelector('input[name="reservation_status"]:checked')?.value || 'all';
        const search_keyword = document.querySelector('input[name="search_keyword"]')?.value || '';
        const viewCount = document.getElementById('egen_search_view_count')?.value || '30';

        // 사용금액 필드값
        const amount_type = document.getElementById('amount_type')?.value || '';
        const min_amount = document.getElementById('min_amount')?.value || '';
        const max_amount = document.getElementById('max_amount')?.value || '';

        // 예약건수 필드값
        const reservation_count_type = document.getElementById('reservation_count_type')?.value || '';
        const min_count = document.getElementById('min_count')?.value || '';
        const max_count = document.getElementById('max_count')?.value || '';

        // URL 쿼리스트링 생성
        let queryParams = new URLSearchParams();

        // 필드값 추가
        if (reservation_platform) queryParams.append('reservation_platform', reservation_platform);
        if (user_type1) queryParams.append('user_type1', user_type1);
        if (user_type2) queryParams.append('user_type2', user_type2);
        if (payment_company) queryParams.append('payment_company', payment_company);
        if (payment_method) queryParams.append('payment_method', payment_method);
        if (user_name) queryParams.append('user_name', user_name);
        if (user_id) queryParams.append('user_id', user_id);
        if (reservation_code) queryParams.append('reservation_code', reservation_code);
        if (reservation_status) queryParams.append('reservation_status', reservation_status);
        if (search_keyword) queryParams.append('search_keyword', search_keyword);
        if (viewCount) queryParams.append('egen_search_view_count', viewCount);

        // 사용금액 파라미터
        if (amount_type) queryParams.append('amount_type', amount_type);
        if (min_amount) queryParams.append('min_amount', min_amount);
        if (max_amount) queryParams.append('max_amount', max_amount);

        // 예약건수 파라미터
        if (reservation_count_type) queryParams.append('reservation_count_type', reservation_count_type);
        if (min_count) queryParams.append('min_count', min_count);
        if (max_count) queryParams.append('max_count', max_count);

        // 예약기간 처리
        const period = document.querySelector('input[name="period"]:checked')?.value;
        if (period) {
            queryParams.append('period', period);
            
            // period 값에 따라 날짜 설정
            const today = new Date();
            let startDate, endDate;
            
            switch(period) {
                case 'today':
                    startDate = endDate = today;
                    break;
                case '3day':
                    endDate = today;
                    startDate = new Date(today);
                    startDate.setDate(today.getDate() - 2);
                    break;
                case '7day':
                    endDate = today;
                    startDate = new Date(today);
                    startDate.setDate(today.getDate() - 6);
                    break;
                case 'all':
                    // 전체 선택시 날짜 파라미터 추가하지 않음
                    break;
            }

            if (period !== 'all') {
                queryParams.append('start_date', startDate.toISOString().split('T')[0]);
                queryParams.append('end_date', endDate.toISOString().split('T')[0]);
            }
        } else {
            // 직접 선택한 날짜 처리
            const reservation_date_year1 = document.querySelector('.crm_member_check_three_year_1')?.value;
            const reservation_date_month1 = document.querySelector('.crm_member_check_three_month_1')?.value;
            const reservation_date_day1 = document.querySelector('.crm_member_check_three_day_1')?.value;
            const reservation_date_year2 = document.querySelector('.crm_member_check_three_year_2')?.value;
            const reservation_date_month2 = document.querySelector('.crm_member_check_three_month_2')?.value;
            const reservation_date_day2 = document.querySelector('.crm_member_check_three_day_2')?.value;

            if (reservation_date_year1 && reservation_date_month1 && reservation_date_day1) {
                queryParams.append('reservation_date_year1', reservation_date_year1);
                queryParams.append('reservation_date_month1', reservation_date_month1);
                queryParams.append('reservation_date_day1', reservation_date_day1);
            }
            if (reservation_date_year2 && reservation_date_month2 && reservation_date_day2) {
                queryParams.append('reservation_date_year2', reservation_date_year2);
                queryParams.append('reservation_date_month2', reservation_date_month2);
                queryParams.append('reservation_date_day2', reservation_date_day2);
            }
        }

        // URL로 페이지 새로고침
        window.location.href = '/page/crm_member_check_3/?' + queryParams.toString();
    });

    // 보기 개수 변경시 자동 새로고침
    document.getElementById('egen_search_view_count').addEventListener('change', function() {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('egen_search_view_count', this.value);
        
        // 스크롤 위치 저장
        const scrollPosition = window.scrollY;
        urlParams.set('scrollTo', scrollPosition);
        
        window.location.href = '/page/crm_member_check_3/?' + urlParams.toString();
    });

    // 초기 보기 개수 설정
    const urlParams = new URLSearchParams(window.location.search);
    const viewCount = urlParams.get('egen_search_view_count');
    if (viewCount) {
        document.getElementById('egen_search_view_count').value = viewCount;
    }

    // 스크롤 위치 복원
    const scrollTo = urlParams.get('scrollTo');
    if (scrollTo) {
        window.scrollTo(0, parseInt(scrollTo));
    }

    // 기간 라디오 버튼 변경 이벤트 처리
    document.querySelectorAll('input[name="period"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const dateInputs = document.querySelectorAll('.crm_member_check_three_year_1, .crm_member_check_three_month_1, .crm_member_check_three_day_1, .crm_member_check_three_year_2, .crm_member_check_three_month_2, .crm_member_check_three_day_2');
            dateInputs.forEach(input => {
                input.disabled = this.value !== 'all';
            });
        });
    });
});
</script>
