<?php
// GET 파라미터 받기
$crm_member_check_four_shopingmall = isset($_GET['crm_member_check_four_shopingmall']) ? $_GET['crm_member_check_four_shopingmall'] : '전체';
$crm_member_check_four_payment_company = isset($_GET['crm_member_check_four_payment_company']) ? $_GET['crm_member_check_four_payment_company'] : '전체';
$crm_member_check_four_payment_method = isset($_GET['crm_member_check_four_payment_method']) ? $_GET['crm_member_check_four_payment_method'] : '전체';
$crm_member_check_four_order_status = isset($_GET['crm_member_check_four_order_status']) ? $_GET['crm_member_check_four_order_status'] : '전체';
$crm_member_check_four_process_status = isset($_GET['crm_member_check_four_process_status']) ? $_GET['crm_member_check_four_process_status'] : '전체';

// 기간 필터
$period = isset($_GET['period']) ? $_GET['period'] : 'all';
$start_year = isset($_GET['start_year']) ? $_GET['start_year'] : '';
$start_month = isset($_GET['start_month']) ? $_GET['start_month'] : '';
$start_day = isset($_GET['start_day']) ? $_GET['start_day'] : '';
$end_year = isset($_GET['end_year']) ? $_GET['end_year'] : '';
$end_month = isset($_GET['end_month']) ? $_GET['end_month'] : '';
$end_day = isset($_GET['end_day']) ? $_GET['end_day'] : '';

// 페이지네이션 설정
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 20;
$offset = ($current_page - 1) * $items_per_page;

// 기본 쿼리 - 회원별 주문 합계 조회
$query = "SELECT 
            o.order_user_id,
            u.user_name,
            u.user_email,
            u.user_phone,
            COUNT(o.uniq_id) as order_count,
            SUM(o.order_total_price) as total_amount
          FROM auto_order o
          LEFT JOIN auto_user u ON o.order_user_id = u.uniq_id 
          WHERE o.is_status = 1";

$params = [];

// 필터 조건 추가
if ($crm_member_check_four_shopingmall !== '전체') {
    $query .= " AND o.shopingmall_id = :shopingmall_id";
    $params[':shopingmall_id'] = $crm_member_check_four_shopingmall;
}

if ($crm_member_check_four_payment_company !== '전체') {
    $query .= " AND o.payment_company_id = :payment_company_id";
    $params[':payment_company_id'] = $crm_member_check_four_payment_company;
}

if ($crm_member_check_four_payment_method !== '전체') {
    $query .= " AND o.payment_method_id = :payment_method_id";
    $params[':payment_method_id'] = $crm_member_check_four_payment_method;
}

if ($crm_member_check_four_order_status !== '전체') {
    $query .= " AND o.order_status_id = :order_status_id";
    $params[':order_status_id'] = $crm_member_check_four_order_status;
}

if ($crm_member_check_four_process_status !== '전체') {
    $query .= " AND o.process_status_id = :process_status_id";
    $params[':process_status_id'] = $crm_member_check_four_process_status;
}

// 기간 필터 적용
if ($period !== 'all') {
    switch($period) {
        case 'today':
            $query .= " AND DATE(o.order_date) = CURDATE()";
            break;
        case '3days':
            $query .= " AND o.order_date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
            break;
        case 'custom':
            if ($start_year && $start_month && $start_day) {
                $start_date = sprintf('%04d-%02d-%02d', $start_year, $start_month, $start_day);
                $query .= " AND o.order_date >= :start_date";
                $params[':start_date'] = $start_date;
            }
            if ($end_year && $end_month && $end_day) {
                $end_date = sprintf('%04d-%02d-%02d', $end_year, $end_month, $end_day);
                $query .= " AND o.order_date <= :end_date";
                $params[':end_date'] = $end_date;
            }
            break;
    }
}

// GROUP BY로 회원별 집계 및 정렬
$query .= " GROUP BY o.order_user_id
           ORDER BY total_amount DESC 
           LIMIT :offset, :items_per_page";

$params[':offset'] = $offset;
$params[':items_per_page'] = $items_per_page;

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$sql_results = egb_sql($binding);

// 전체 레코드 수 조회를 위한 카운트 쿼리
$count_query = "SELECT COUNT(DISTINCT o.order_user_id) as total_count 
                FROM auto_order o 
                WHERE o.is_status = 1";
$count_binding = binding_sql(0, $count_query, []);
$count_result = egb_sql($count_binding);
$totalCount = isset($count_result[0]) && isset($count_result[0][0]) ? $count_result[0][0]['total_count'] : 0;

// 필터링된 레코드 수 조회
$filtered_count_query = str_replace("SELECT COUNT(DISTINCT o.order_user_id)", "SELECT COUNT(DISTINCT o.order_user_id)", $count_query);
$filtered_count_binding = binding_sql(0, $filtered_count_query, $params);
$filtered_count_result = egb_sql($filtered_count_binding);
$filteredCount = isset($filtered_count_result[0]) && isset($filtered_count_result[0][0]) ? $filtered_count_result[0][0]['total_count'] : 0;

// 총 페이지 수 계산
$total_pages = ceil($totalCount / $items_per_page);
?>


<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_check_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">상위매출회원조회</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원조회</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">상위매출회원조회</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
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
                        <?php
                        // 쇼핑몰 조회
                        $query = "SELECT * FROM auto_shopingmall 
                                WHERE deleted_at IS NULL 
                                ORDER BY display_order ASC";
                        $binding = binding_sql(0, $query, []);
                        $sql_result = egb_sql($binding);

                        // 쇼핑몰 구분 값 가져오기
                        $selected_shop = isset($_GET['order_mall_type']) ? $_GET['order_mall_type'] : '전체';
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_mall_type" value="전체"
                                id="crm_member_check_four_shopingmall_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_shop === '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_check_four_shopingmall_all">전체</label>
                        </div>
                        <?php foreach($sql_result[0] as $shop): ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_mall_type"
                                id="crm_member_check_four_shopingmall_<?php echo $shop['uniq_id']; ?>" value="<?php echo $shop['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_shop === $shop['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_check_four_shopingmall_<?php echo $shop['uniq_id']; ?>"><?php echo $shop['shop_name']; ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 1</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 회원구분1 값 가져오기
                        $selected_member_class_one = isset($_GET['order_user_type1']) ? $_GET['order_user_type1'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type1" id="crm_member_check_four_memberclass_one_all"
                            data-xy="1-800: width_px_016 height_px_016" value="전체"
                            <?php echo $selected_member_class_one === '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_four_memberclass_one_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type1" id="crm_member_check_four_memberclass_one_yes"
                            data-xy="1-800: width_px_016 height_px_016" value="회원"
                            <?php echo $selected_member_class_one === '회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_four_memberclass_one_yes">회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type1" id="crm_member_check_four_memberclass_one_no"
                            data-xy="1-800: width_px_016 height_px_016" value="비회원"
                            <?php echo $selected_member_class_one === '비회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005" for="crm_member_check_four_memberclass_one_no">비회원</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 2</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <?php
                        // 회원구분2 값 가져오기
                        $selected_member_class_two = isset($_GET['order_user_type2']) ? $_GET['order_user_type2'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type2" id="crm_member_check_four_memberclass_two_all"
                            data-xy="1-800: width_px_016 height_px_016" value="전체"
                            <?php echo $selected_member_class_two === '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_four_memberclass_two_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type2" id="crm_member_check_four_memberclass_two_yes"
                            data-xy="1-800: width_px_016 height_px_016" value="개인회원"
                            <?php echo $selected_member_class_two === '개인회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_four_memberclass_two_yes">개인회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type2" id="crm_member_check_four_memberclass_two_no"
                            data-xy="1-800: width_px_016 height_px_016" value="사업자"
                            <?php echo $selected_member_class_two === '사업자' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005" for="crm_member_check_four_memberclass_two_no">사업자</label>
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
                            name="payment_company" id="crm_member_check_four_payment_company_all" value=""
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo empty($selected_company) ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_four_payment_company_all">전체</label>
                        
                        <?php
                        if($payment_companies[0]) {
                            foreach($payment_companies[0] as $company) {
                                ?>
                                <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                                    name="payment_company" id="crm_member_check_four_payment_company_<?php echo $company['uniq_id']; ?>" 
                                    value="<?php echo $company['uniq_id']; ?>"
                                    data-xy="1-800: width_px_016 height_px_016" 
                                    <?php echo $selected_company === $company['uniq_id'] ? 'checked' : ''; ?>>
                                <label class="padding_px-l_005 padding_px-r_010"
                                    for="crm_member_check_four_payment_company_<?php echo $company['uniq_id']; ?>"><?php echo $company['payment_company_name']; ?></label>
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
                                type="radio" name="payment_method" id="crm_member_check_four_payment_method_all" value=""
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo empty($selected_method) ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_check_four_payment_method_all">전체</label>
                        </div>

                        <?php
                        // 결제수단 목록 출력
                        if($payment_methods[0]) {
                            foreach($payment_methods[0] as $method) {
                                ?>
                                <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                        type="radio" name="payment_method" 
                                        id="crm_member_check_four_payment_method_<?php echo $method['uniq_id']; ?>"
                                        value="<?php echo $method['uniq_id']; ?>"
                                        data-xy="1-800: width_px_016 height_px_016"
                                        <?php echo $selected_method === $method['uniq_id'] ? 'checked' : ''; ?>>
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_check_four_payment_method_<?php echo $method['uniq_id']; ?>"><?php echo $method['payment_method_name']; ?></label>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001" data-bg-color="#ffffff"
                    data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 height_box padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 border_px-u_000, 801-1200: padding_px-y_070 padding_px-l_010 border_px-u_000, 1201-1500: padding_px-y_032 padding_px-l_010 border_px-u_001">
                        주문기간</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-1200: flex_ft border_px-u_000 del-height_px_055, 1201-1500: flex_ft border_px-u_001 del-height_px_055">
                        <div class="flex_fl_yc min_width_375 width_px_375 padding_px-u_000"
                            data-xy="1-1500: width_box padding_px-u_008">
                            <?php
                            $period = isset($_GET['period']) ? $_GET['period'] : '';
                            $has_date_params = isset($_GET['order_date_year1']) || isset($_GET['order_date_year2']);
                            if($has_date_params && !$period) {
                                $period = 'custom';
                            }
                            ?>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_all" value="all"
                                data-xy="1-800: width_px_016 height_px_016" 
                                <?php echo $period === '' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_all"
                                data-xy="1-800: padding_px-r_010">전체</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_today" value="today"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period === 'today' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_today"
                                data-xy="1-800: padding_px-r_010">오늘</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_3day" value="3day"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period === '3day' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_3day"
                                data-xy="1-800: padding_px-r_010">3일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_7day" value="7day"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period === '7day' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_7day"
                                data-xy="1-800: padding_px-r_010">7일</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="period" id="period_custom" value="custom"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $period === 'custom' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_020" for="period_custom"
                                data-xy="1-800: padding_px-r_000">기간검색</label>
                        </div>
                        <div class="flex_fl_yc width_box height_box" data-bg-color="#ffffff" data-xy="1-1200: flex_ft">
                            <div class="flex_fl_yc" data-xy="1-1200: width_box">
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_year" name="start_year"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065"
                                        <?php echo $period !== 'custom' && $period !== '' ? 'disabled' : ''; ?>>
                                        <option value="">선택</option>
                                        <?php
                                        $start_year = isset($_GET['order_date_year1']) ? $_GET['order_date_year1'] : '';
                                        $current_year = date('Y');
                                        for($year = $current_year; $year >= $current_year - 5; $year--) {
                                            echo '<option value="'.$year.'" '.($start_year == $year ? 'selected' : '').'>'.$year.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_month" name="start_month"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060"
                                        <?php echo $period !== 'custom' && $period !== '' ? 'disabled' : ''; ?>>
                                        <option value="">선택</option>
                                        <?php 
                                        $start_month = isset($_GET['order_date_month1']) ? $_GET['order_date_month1'] : '';
                                        for($i=1; $i<=12; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($start_month == $i ? 'selected' : ''); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_day" name="start_day"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012"
                                        <?php echo $period !== 'custom' && $period !== '' ? 'disabled' : ''; ?>>
                                        <option value="">선택</option>
                                        <?php
                                        $start_day = isset($_GET['order_date_day1']) ? $_GET['order_date_day1'] : '';
                                        if($start_year && $start_month) {
                                            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $start_month, $start_year);
                                            for($i=1; $i<=$days_in_month; $i++) {
                                                echo '<option value="'.$i.'" '.($start_day == $i ? 'selected' : '').'>'.$i.'</option>';
                                            }
                                        }
                                        ?>
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
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065"
                                        <?php echo $period !== 'custom' && $period !== '' ? 'disabled' : ''; ?>>
                                        <option value="">선택</option>
                                        <?php
                                        $end_year = isset($_GET['order_date_year2']) ? $_GET['order_date_year2'] : '';
                                        $current_year = date('Y');
                                        for($year = $current_year; $year >= $current_year - 5; $year--) {
                                            echo '<option value="'.$year.'" '.($end_year == $year ? 'selected' : '').'>'.$year.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">년</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="end_month" name="end_month"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060"
                                        <?php echo $period !== 'custom' && $period !== '' ? 'disabled' : ''; ?>>
                                        <option value="">선택</option>
                                        <?php
                                        $end_month = isset($_GET['order_date_month2']) ? $_GET['order_date_month2'] : '';
                                        for($i=1; $i<=12; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($end_month == $i ? 'selected' : ''); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="end_day" name="end_day"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012"
                                        <?php echo $period !== 'custom' && $period !== '' ? 'disabled' : ''; ?>>
                                        <option value="">선택</option>
                                        <?php
                                        $end_day = isset($_GET['order_date_day2']) ? $_GET['order_date_day2'] : '';
                                        if($end_year && $end_month) {
                                            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $end_month, $end_year);
                                            for($i=1; $i<=$days_in_month; $i++) {
                                                echo '<option value="'.$i.'" '.($end_day == $i ? 'selected' : '').'>'.$i.'</option>';
                                            }
                                        }
                                        ?>
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

                        const periodRadios = document.querySelectorAll('input[name="period"]');
                        const today = new Date();
                        today.setHours(0,0,0,0);

                        function setDateRange(startDate, endDate) {
                            if(startDate) {
                                dateSelects.start.year.value = startDate.getFullYear();
                                dateSelects.start.month.value = startDate.getMonth() + 1;
                                updateDays(dateSelects.start.day, startDate.getFullYear(), startDate.getMonth() + 1);
                                dateSelects.start.day.value = startDate.getDate();
                            }

                            if(endDate) {
                                dateSelects.end.year.value = endDate.getFullYear();
                                dateSelects.end.month.value = endDate.getMonth() + 1;
                                updateDays(dateSelects.end.day, endDate.getFullYear(), endDate.getMonth() + 1);
                                dateSelects.end.day.value = endDate.getDate();
                            }
                        }

                        function updateDays(daySelect, year, month) {
                            if(!year || !month) return;
                            
                            const daysInMonth = new Date(year, month, 0).getDate();
                            daySelect.innerHTML = '<option value="">선택</option>';
                            
                            for (let day = 1; day <= daysInMonth; day++) {
                                const option = document.createElement('option');
                                option.value = day;
                                option.textContent = day;
                                daySelect.appendChild(option);
                            }
                        }

                        function toggleDateSelects(disabled) {
                            ['start', 'end'].forEach(type => {
                                Object.values(dateSelects[type]).forEach(select => {
                                    select.disabled = disabled;
                                });
                            });
                        }

                        periodRadios.forEach(radio => {
                            radio.addEventListener('change', function() {
                                const value = this.value;
                                
                                switch(value) {
                                    case 'today':
                                        setDateRange(today, today);
                                        toggleDateSelects(true);
                                        break;
                                    case '3day':
                                        const threeDaysAgo = new Date(today);
                                        threeDaysAgo.setDate(today.getDate() - 2);
                                        setDateRange(threeDaysAgo, today);
                                        toggleDateSelects(true);
                                        break;
                                    case '7day':
                                        const sevenDaysAgo = new Date(today);
                                        sevenDaysAgo.setDate(today.getDate() - 6);
                                        setDateRange(sevenDaysAgo, today);
                                        toggleDateSelects(true);
                                        break;
                                    case 'custom':
                                        toggleDateSelects(false);
                                        break;
                                    case 'all':
                                        ['start', 'end'].forEach(type => {
                                            Object.values(dateSelects[type]).forEach(select => {
                                                select.value = '';
                                            });
                                        });
                                        toggleDateSelects(true);
                                        break;
                                }
                            });
                        });

                        // 월 변경시 일자 업데이트
                        ['start', 'end'].forEach(type => {
                            dateSelects[type].year.addEventListener('change', function() {
                                const month = dateSelects[type].month.value;
                                if (month) {
                                    updateDays(dateSelects[type].day, this.value, month);
                                }
                                if(document.getElementById('period_custom').checked) {
                                    checkAndSetPeriodRadio();
                                }
                            });

                            dateSelects[type].month.addEventListener('change', function() {
                                const year = dateSelects[type].year.value;
                                if (year) {
                                    updateDays(dateSelects[type].day, year, this.value);
                                }
                                if(document.getElementById('period_custom').checked) {
                                    checkAndSetPeriodRadio();
                                }
                            });

                            dateSelects[type].day.addEventListener('change', function() {
                                if(document.getElementById('period_custom').checked) {
                                    checkAndSetPeriodRadio();
                                }
                            });
                        });

                        function checkAndSetPeriodRadio() {
                            if (!dateSelects.start.year.value || !dateSelects.start.month.value || !dateSelects.start.day.value ||
                                !dateSelects.end.year.value || !dateSelects.end.month.value || !dateSelects.end.day.value) {
                                return;
                            }

                            const startDate = new Date(
                                dateSelects.start.year.value,
                                dateSelects.start.month.value - 1,
                                dateSelects.start.day.value
                            );
                            const endDate = new Date(
                                dateSelects.end.year.value,
                                dateSelects.end.month.value - 1,
                                dateSelects.end.day.value
                            );

                            const todayStr = today.toDateString();
                            const startStr = startDate.toDateString();
                            const endStr = endDate.toDateString();
                            
                            if (startStr === todayStr && endStr === todayStr) {
                                document.getElementById('period_today').checked = true;
                                toggleDateSelects(true);
                            } else {
                                const diffDays = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24));
                                if (diffDays === 2 && endStr === todayStr) {
                                    document.getElementById('period_3day').checked = true;
                                    toggleDateSelects(true);
                                } else if (diffDays === 6 && endStr === todayStr) {
                                    document.getElementById('period_7day').checked = true;
                                    toggleDateSelects(true);
                                }
                            }
                        }

                        // URL 파라미터에 따른 초기 상태 설정
                        const urlParams = new URLSearchParams(window.location.search);
                        const period = urlParams.get('period');
                        
                        if (period) {
                            const periodRadio = document.getElementById('period_' + period);
                            if (periodRadio) {
                                periodRadio.checked = true;
                                periodRadio.dispatchEvent(new Event('change'));
                            }
                        } else if (dateSelects.start.year.value && dateSelects.end.year.value) {
                            document.getElementById('period_custom').checked = true;
                            toggleDateSelects(false);
                            checkAndSetPeriodRadio();
                        }
                    });
                </script>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 del-height_px_084, 801-1220: padding_px-y_018 padding_px-l_010 height_px_084">
                        주문상태</div>
                    <div class="flex_xs1_yc border_px-u_001 padding_px-x_010 padding_px-y_018 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-1220: flex_ft">
                        <div class="flex_fl_yc padding_px-t_000" data-xy="1-1220: padding_px-t_010">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_order_status" id="crm_member_check_four_order_status_cancel" value="취소"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['crm_member_check_four_order_status']) && $_GET['crm_member_check_four_order_status'] == '취소' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_order_status_cancel"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">취소</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_order_status" id="crm_member_check_four_order_status_exchange" value="교환"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['crm_member_check_four_order_status']) && $_GET['crm_member_check_four_order_status'] == '교환' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_order_status_exchange"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">교환</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_order_status" id="crm_member_check_four_order_status_return" value="반품"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['crm_member_check_four_order_status']) && $_GET['crm_member_check_four_order_status'] == '반품' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_order_status_return"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">반품</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_order_status" id="crm_member_check_four_order_status_refund" value="환불"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['crm_member_check_four_order_status']) && $_GET['crm_member_check_four_order_status'] == '환불' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_order_status_refund"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">환불</label>
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box border_px-u_000, 801-912: padding_px-y_020 padding_px-l_010 height_box border_px-u_000">
                        처리상태</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-912: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 del-height_px_055">
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_all" value=""
                                data-xy="1-800: width_px_016 height_px_016" checked>
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_all">전체</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_pending" value="입금대기"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_pending">입금대기</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_paid" value="결제완료"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_paid">결제완료</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_ready" value="상품준비중"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_ready">상품준비중</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_shipping" value="배송중"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_shipping">배송중</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_delivered" value="배송완료"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_delivered">배송완료</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_confirmed" value="구매확정"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005 padding_px-r_010" for="crm_member_check_four_process_status_confirmed">구매확정</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_check_four_process_status" id="crm_member_check_four_process_status_failed" value="결제실패"
                                data-xy="1-800: width_px_016 height_px_016">
                            <label class="padding_px-l_005" for="crm_member_check_four_process_status_failed">결제실패</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span id="egen_search">검색하기</span>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">상위매출회원조회 결과</div>
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
                                <div id="user_excel_download" class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">EXCEL</div>
                            </div>
                            <div class="flex_xc padding_px-l_005">
                                <div id="user_all_excel_download" class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">ALL EXCEL</div>
                            </div>
                        </div>
                    </div>
                    <div class="padding_px-r_010 padding_px-t_000"
                        data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                        <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                            name="egen_search_view_count" id="egen_search_view_count" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                            <option value="30">30개씩 보기</option>
                            <option value="20">20개씩 보기</option>
                            <option value="10">10개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_check_four_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" name=""
                                    id="crm_searching_member_check_four_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">최근주문일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이름</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">구매처</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">결제수단</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">주문 금액</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원등급</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">총주문건수</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <?php if(isset($members) && count($members) > 0) { 
                            foreach($members as $index => $member) { ?>
                        <div class="grid_xx border_px-u_001" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <label for="crm_searching_member_check_four_<?php echo $index+1; ?>"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" name=""
                                    id="crm_searching_member_check_four_<?php echo $index+1; ?>" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $index+1; ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['recent_order_date']; ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['name']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['id']; ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['purchase_site']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['payment_method']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo number_format($member['order_amount']); ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['member_level']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $member['total_orders']; ?>건</div>
                            <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                        </div>
                        <?php } 
                        } ?>
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

    .crm_member_check_4_bg {
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
        // 검색 버튼 클릭 이벤트 
        document.getElementById('egen_search').addEventListener('click', function(e) {
            e.preventDefault();

            // 각 필드 값을 가져옵니다
            const order_number = document.querySelector('input[name="order_number"]')?.value.trim() || '';
            const order_user_id = document.querySelector('input[name="order_user_id"]')?.value.trim() || '';
            const order_user_name = document.querySelector('input[name="order_user_name"]')?.value.trim() || '';
            const order_user_type1 = document.querySelector('input[name="order_user_type1"]:checked')?.value || '전체';
            const order_user_type2 = document.querySelector('input[name="order_user_type2"]:checked')?.value || '전체';
            const order_mall_type = document.querySelector('input[name="order_mall_type"]:checked')?.value || '전체';
            const payment_company = document.querySelector('input[name="payment_company"]:checked')?.value || '';
            const payment_method = document.querySelector('input[name="payment_method"]:checked')?.value || '';
            const viewCount = document.getElementById('egen_search_view_count')?.value || '30';
            const order_status = document.querySelector('input[name="crm_member_check_four_order_status"]:checked')?.value || '';
            const process_status = document.querySelector('input[name="crm_member_check_four_process_status"]:checked')?.value || '';

            // 날짜 값을 가져옵니다
            const start_year = document.getElementById('start_year')?.value || '';
            const start_month = document.getElementById('start_month')?.value || '';
            const start_day = document.getElementById('start_day')?.value || '';
            const end_year = document.getElementById('end_year')?.value || '';
            const end_month = document.getElementById('end_month')?.value || '';
            const end_day = document.getElementById('end_day')?.value || '';

            // URL 쿼리 스트링을 생성합니다
            const queryParams = new URLSearchParams(window.location.search);

            // 기존 파라미터 유지하면서 새로운 값 설정
            queryParams.set('order_number', order_number);
            queryParams.set('order_user_id', order_user_id); 
            queryParams.set('order_user_name', order_user_name);
            queryParams.set('order_user_type1', order_user_type1);
            queryParams.set('order_user_type2', order_user_type2);
            queryParams.set('order_mall_type', order_mall_type);
            queryParams.set('payment_company', payment_company);
            queryParams.set('payment_method', payment_method);
            queryParams.set('egen_search_view_count', viewCount);
            queryParams.set('crm_member_check_four_order_status', order_status);
            queryParams.set('crm_member_check_four_process_status', process_status);

            // 날짜 파라미터 설정
            queryParams.set('order_date_year1', start_year);
            queryParams.set('order_date_month1', start_month); 
            queryParams.set('order_date_day1', start_day);
            queryParams.set('order_date_year2', end_year);
            queryParams.set('order_date_month2', end_month);
            queryParams.set('order_date_day2', end_day);

            // 빈 값인 파라미터 제거
            for (const [key, value] of queryParams.entries()) {
                if (!value || value === '전체') {
                    queryParams.delete(key);
                }
            }

            // 페이지를 필터링된 URL로 새로고침합니다
            window.location.href = '/page/crm_member_check_4/?' + queryParams.toString();
        });

        // egen_search_view_count 선택 시 자동 새로고침
        document.getElementById('egen_search_view_count').addEventListener('change', function() {
            const queryParams = new URLSearchParams(window.location.search);
            queryParams.set('egen_search_view_count', this.value);
            
            // 현재 스크롤 위치 저장
            const scrollPosition = window.scrollY;
            queryParams.set('scrollTo', scrollPosition);
            
            window.location.href = '/page/crm_member_check_4/?' + queryParams.toString();
        });

        // 초기 로드 시 egen_search_view_count 값 설정
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

        // 전체 체크박스 이벤트
        document.getElementById('crm_searching_member_check_four_all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[id^="crm_searching_member_check_four_"]');
            checkboxes.forEach(checkbox => {
                if(checkbox.id !== 'crm_searching_member_check_four_all') {
                    checkbox.checked = this.checked;
                }
            });
        });

        // URL 파라미터로 입력 필드 초기화
        const initializeFields = () => {
            const params = new URLSearchParams(window.location.search);
            
            // 각 필드 초기화
            if(params.get('order_number')) {
                document.querySelector('input[name="order_number"]').value = params.get('order_number');
            }
            if(params.get('order_user_id')) {
                document.querySelector('input[name="order_user_id"]').value = params.get('order_user_id');
            }
            if(params.get('order_user_name')) {
                document.querySelector('input[name="order_user_name"]').value = params.get('order_user_name');
            }
            if(params.get('order_user_type1')) {
                document.querySelector(`input[name="order_user_type1"][value="${params.get('order_user_type1')}"]`).checked = true;
            }
            if(params.get('order_user_type2')) {
                document.querySelector(`input[name="order_user_type2"][value="${params.get('order_user_type2')}"]`).checked = true;
            }
            if(params.get('order_mall_type')) {
                document.querySelector(`input[name="order_mall_type"][value="${params.get('order_mall_type')}"]`).checked = true;
            }
            if(params.get('payment_company')) {
                document.querySelector(`input[name="payment_company"][value="${params.get('payment_company')}"]`).checked = true;
            }
            if(params.get('payment_method')) {
                document.querySelector(`input[name="payment_method"][value="${params.get('payment_method')}"]`).checked = true;
            }
            if(params.get('crm_member_check_four_order_status')) {
                document.querySelector(`input[name="crm_member_check_four_order_status"][value="${params.get('crm_member_check_four_order_status')}"]`).checked = true;
            }
            if(params.get('crm_member_check_four_process_status')) {
                document.querySelector(`input[name="crm_member_check_four_process_status"][value="${params.get('crm_member_check_four_process_status')}"]`).checked = true;
            }

            // 날짜 필드 초기화
            if(params.get('order_date_year1')) {
                document.getElementById('start_year').value = params.get('order_date_year1');
            }
            if(params.get('order_date_month1')) {
                document.getElementById('start_month').value = params.get('order_date_month1');
            }
            if(params.get('order_date_day1')) {
                document.getElementById('start_day').value = params.get('order_date_day1');
            }
            if(params.get('order_date_year2')) {
                document.getElementById('end_year').value = params.get('order_date_year2');
            }
            if(params.get('order_date_month2')) {
                document.getElementById('end_month').value = params.get('order_date_month2');
            }
            if(params.get('order_date_day2')) {
                document.getElementById('end_day').value = params.get('order_date_day2');
            }
        };

        // 페이지 로드 시 필드 초기화 실행
        initializeFields();
    });
</script>
