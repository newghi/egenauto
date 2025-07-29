<?php


?>
<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_check_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020 "
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">주문현황조회</div>
                <div class="flex_xc" data-xy="1-800: flex_xr">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원조회</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">주문현황조회</div>
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
                                id="user_shopping_mall_type_all" data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_shop === '전체' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_shopping_mall_type_all">전체</label>
                        </div>
                        <?php foreach($sql_result[0] as $shop): ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_mall_type"
                                id="user_shopping_mall_type_<?php echo $shop['uniq_id']; ?>" value="<?php echo $shop['uniq_id']; ?>"
                                data-xy="1-800: width_px_016 height_px_016"
                                <?php echo $selected_shop === $shop['uniq_id'] ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="user_shopping_mall_type_<?php echo $shop['uniq_id']; ?>"><?php echo $shop['shop_name']; ?></label>
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
                        $selected_type1 = isset($_GET['order_user_type1']) ? $_GET['order_user_type1'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type1" id="crm_member_check_memberclass_one_all" value="전체"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type1 == '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_one_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type1" id="crm_member_check_memberclass_one_yes" value="회원"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type1 == '회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_one_yes">회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type1" id="crm_member_check_memberclass_one_no" value="비회원"
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
                        $selected_type2 = isset($_GET['order_user_type2']) ? $_GET['order_user_type2'] : '전체';
                        ?>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type2" id="crm_member_check_memberclass_two_all" value="전체"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type2 == '전체' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_two_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type2" id="crm_member_check_memberclass_two_yes" value="개인회원"
                            data-xy="1-800: width_px_016 height_px_016"
                            <?php echo $selected_type2 == '개인회원' ? 'checked' : ''; ?>>
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_check_memberclass_two_yes">개인회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="order_user_type2" id="crm_member_check_memberclass_two_no" value="사업자"
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
                        // 결제수단 목록 출력
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
                            data-bd-a-color="#888888" type="text" name="order_user_name" id="order_user_name" 
                            value="<?php echo isset($_GET['order_user_name']) ? $_GET['order_user_name'] : ''; ?>"
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
                            data-bd-a-color="#888888" type="text" name="order_user_id" id="order_user_id"
                            value="<?php echo isset($_GET['order_user_id']) ? $_GET['order_user_id'] : ''; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">주문번호</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="order_number" id="order_number"
                            value="<?php echo isset($_GET['order_number']) ? $_GET['order_number'] : ''; ?>"
                            data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl_yc width_box height_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-1200: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
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
                            $period = isset($_GET['period']) ? $_GET['period'] : 'all';
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
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">선택</option>
                                        <?php
                                        $start_month = isset($_GET['order_date_month1']) ? $_GET['order_date_month1'] : '';
                                        for($month = 1; $month <= 12; $month++) {
                                            echo '<option value="'.$month.'" '.($start_month == $month ? 'selected' : '').'>'.$month.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="start_day" name="start_day"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">선택</option>
                                        <?php
                                        $start_day = isset($_GET['order_date_day1']) ? $_GET['order_date_day1'] : '';
                                        for($day = 1; $day <= 31; $day++) {
                                            echo '<option value="'.$day.'" '.($start_day == $day ? 'selected' : '').'>'.$day.'</option>';
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
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_065">
                                        <option value="">선택</option>
                                        <?php
                                        $end_year = isset($_GET['order_date_year2']) ? $_GET['order_date_year2'] : '';
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
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012 min_width_060">
                                        <option value="">선택</option>
                                        <?php
                                        $end_month = isset($_GET['order_date_month2']) ? $_GET['order_date_month2'] : '';
                                        for($month = 1; $month <= 12; $month++) {
                                            echo '<option value="'.$month.'" '.($end_month == $month ? 'selected' : '').'>'.$month.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="padding_px-l_005 padding_px-r_015"
                                        data-xy="1-800: padding_px-l_005 padding_px-r_010">월</div>
                                </div>
                                <div class="flex_fl_yc" data-xy="1-800: width_box">
                                    <select id="end_day" name="end_day"
                                        class="width_px_080 padding_px-y_008 padding_px-x_005 font_px_014 border_px-a_001"
                                        data-bd-a-color="#888888" data-xy="1-800: width_box font_px_012">
                                        <option value="">선택</option>
                                        <?php
                                        $end_day = isset($_GET['order_date_day2']) ? $_GET['order_date_day2'] : '';
                                        for($day = 1; $day <= 31; $day++) {
                                            echo '<option value="'.$day.'" '.($end_day == $day ? 'selected' : '').'>'.$day.'</option>';
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
                    document.addEventListener('DOMContentLoaded', function () {
                        const today = new Date();
                        const periodRadios = document.querySelectorAll('input[name="period"]');
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

                        function setDateRange(startDate, endDate) {
                            // 시작일 설정
                            dateSelects.start.year.value = startDate.getFullYear();
                            dateSelects.start.month.value = startDate.getMonth() + 1;
                            updateDays(dateSelects.start.day, startDate.getFullYear(), startDate.getMonth() + 1);
                            dateSelects.start.day.value = startDate.getDate();

                            // 종료일 설정
                            dateSelects.end.year.value = endDate.getFullYear();
                            dateSelects.end.month.value = endDate.getMonth() + 1;
                            updateDays(dateSelects.end.day, endDate.getFullYear(), endDate.getMonth() + 1);
                            dateSelects.end.day.value = endDate.getDate();
                        }

                        function updateDays(daySelect, year, month) {
                            const daysInMonth = new Date(year, month, 0).getDate();
                            const currentValue = daySelect.value;
                            daySelect.innerHTML = '<option value="">선택</option>';
                            
                            for (let day = 1; day <= daysInMonth; day++) {
                                const option = document.createElement('option');
                                option.value = day;
                                option.textContent = day;
                                if(currentValue == day) {
                                    option.selected = true;
                                }
                                daySelect.appendChild(option);
                            }
                        }

                        function toggleDateSelects(disabled) {
                            Object.values(dateSelects).forEach(group => {
                                Object.values(group).forEach(select => {
                                    select.disabled = disabled;
                                });
                            });
                        }

                        // 날짜가 이미 설정되어 있다면 해당하는 라디오 버튼 선택
                        function checkAndSetPeriodRadio() {
                            const startYear = dateSelects.start.year.value;
                            const startMonth = dateSelects.start.month.value;
                            const startDay = dateSelects.start.day.value;
                            const endYear = dateSelects.end.year.value;
                            const endMonth = dateSelects.end.month.value;
                            const endDay = dateSelects.end.day.value;

                            if (!startYear || !startMonth || !startDay || !endYear || !endMonth || !endDay) {
                                document.getElementById('period_custom').checked = true;
                                return;
                            }

                            const startDate = new Date(startYear, startMonth - 1, startDay);
                            const endDate = new Date(endYear, endMonth - 1, endDay);
                            const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                            
                            const diffDays = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24));
                            
                            if (startDate.getTime() === todayStart.getTime() && endDate.getTime() === todayStart.getTime()) {
                                document.getElementById('period_today').checked = true;
                            } else if (diffDays === 2 && endDate.getTime() === todayStart.getTime()) {
                                document.getElementById('period_3day').checked = true;
                            } else if (diffDays === 6 && endDate.getTime() === todayStart.getTime()) {
                                document.getElementById('period_7day').checked = true;
                            } else {
                                document.getElementById('period_custom').checked = true;
                            }
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
                                    default:
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
                            });

                            dateSelects[type].month.addEventListener('change', function() {
                                const year = dateSelects[type].year.value;
                                if (year) {
                                    updateDays(dateSelects[type].day, year, this.value);
                                }
                            });
                        });

                        // 초기 상태 설정
                        checkAndSetPeriodRadio();
                        const selectedPeriod = document.querySelector('input[name="period"]:checked');
                        if (selectedPeriod && selectedPeriod.value !== 'custom') {
                            toggleDateSelects(true);
                        }
                    });
                </script>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">구매금액</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_ft del-height_px_055">
                        <div class="" data-xy="1-800: width_box">
                            <select class="width_px_160 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" name="price_type" id="price_type"
                                data-xy="1-800: width_box font_px_012">
                                <option value="total" <?php echo isset($_GET['price_type']) && $_GET['price_type'] == 'total' ? 'selected' : ''; ?>>총 주문금액</option>
                                <option value="actual" <?php echo isset($_GET['price_type']) && $_GET['price_type'] == 'actual' ? 'selected' : ''; ?>>총 실결제금액</option>
                            </select>
                        </div>
                        <div class="width_px_020 height_px_010"></div>
                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="number" name="min_price" id="min_price"
                                data-xy="1-800: width_box font_px_012" value="<?php echo isset($_GET['min_price']) ? $_GET['min_price'] : ''; ?>">
                            <div class="width_px_020 flex_xc" data-xy="1-800: min_width_020">-</div>
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="number" name="max_price" id="max_price"
                                data-xy="1-800: width_box font_px_012" value="<?php echo isset($_GET['max_price']) ? $_GET['max_price'] : ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">구매건수</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: flex_ft del-height_px_055">
                        <div data-xy="1-800: width_box">
                            <select class="width_px_160 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" name="order_count_type" id="order_count_type"
                                data-xy="1-800: width_box font_px_012">
                                <option value="total" <?php echo isset($_GET['order_count_type']) && $_GET['order_count_type'] == 'total' ? 'selected' : ''; ?>>총 주문건수</option>
                                <option value="actual" <?php echo isset($_GET['order_count_type']) && $_GET['order_count_type'] == 'actual' ? 'selected' : ''; ?>>총 실주문건수</option>
                            </select>
                        </div>
                        <div class="width_px_020 height_px_010"></div>
                        <div class="flex_fl_yc" data-xy="1-800: width_box">
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="number" name="min_count" id="min_count"
                                data-xy="1-800: width_box font_px_012" value="<?php echo isset($_GET['min_count']) ? $_GET['min_count'] : ''; ?>">
                            <div class="width_px_020 flex_xc" data-xy="1-800: min_width_020">-</div>
                            <input class="width_px_100 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" type="number" name="max_count" id="max_count"
                                data-xy="1-800: width_box font_px_012" value="<?php echo isset($_GET['max_count']) ? $_GET['max_count'] : ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">상품 카테고리</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <div>
                            <select class="width_px_190 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" name="category_level_1" id="category_level_1"
                                data-xy="1-800: width_box font_px_012">
                                <option value="" hidden selected disabled>대분류</option>
                                <?php
                                $level1_query = "SELECT * FROM auto_product_category WHERE category_level = 1 AND deleted_at IS NULL ORDER BY display_order ASC, category_name ASC";
                                $level1_categories = egb_sql(binding_sql(0, $level1_query));
                                
                                if(isset($level1_categories[0])) {
                                    foreach($level1_categories[0] as $category) {
                                        $selected = isset($_GET['category_level_1']) && $_GET['category_level_1'] == $category['uniq_id'] ? 'selected' : '';
                                        echo '<option value="'.$category['uniq_id'].'" '.$selected.'>'.$category['category_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="width_px_020"></div>
                        <div>
                            <select class="width_px_190 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" name="category_level_2" id="category_level_2"
                                data-xy="1-800: width_box font_px_012">
                                <option value="" hidden selected disabled>중분류</option>
                                <?php
                                $level2_query = "SELECT * FROM auto_product_category WHERE category_level = 2 AND deleted_at IS NULL ORDER BY display_order ASC, category_name ASC";
                                $level2_categories = egb_sql(binding_sql(0, $level2_query));
                                
                                if(isset($level2_categories[0])) {
                                    foreach($level2_categories[0] as $category) {
                                        $selected = isset($_GET['category_level_2']) && $_GET['category_level_2'] == $category['uniq_id'] ? 'selected' : '';
                                        echo '<option value="'.$category['uniq_id'].'" '.$selected.'>'.$category['category_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="width_px_020"></div>
                        <div>
                            <select class="width_px_190 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                data-bd-a-color="#888888" name="category_level_3" id="category_level_3"
                                data-xy="1-800: width_box font_px_012">
                                <option value="" hidden selected disabled>소분류</option>
                                <?php
                                $level3_query = "SELECT * FROM auto_product_category WHERE category_level = 3 AND deleted_at IS NULL ORDER BY display_order ASC, category_name ASC";
                                $level3_categories = egb_sql(binding_sql(0, $level3_query));
                                
                                if(isset($level3_categories[0])) {
                                    foreach($level3_categories[0] as $category) {
                                        $selected = isset($_GET['category_level_3']) && $_GET['category_level_3'] == $category['uniq_id'] ? 'selected' : '';
                                        echo '<option value="'.$category['uniq_id'].'" '.$selected.'>'.$category['category_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
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
                            data-bd-a-color="#888888" type="text" name="order_keyword" id="order_keyword" data-xy="1-800: width_box font_px_012"
                            value="<?php echo isset($_GET['order_keyword']) ? $_GET['order_keyword'] : ''; ?>">
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">상품코드</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input class="width_px_400 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="order_product_code" id="order_product_code" data-xy="1-800: width_box font_px_012"
                            value="<?php echo isset($_GET['order_product_code']) ? $_GET['order_product_code'] : ''; ?>">
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 del-height_px_084, 801-1220: padding_px-y_018 padding_px-l_010 height_px_084">
                        주문상태</div>
                    <div class="flex_xs1_yc border_px-u_001 padding_px-x_010 padding_px-y_018 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-1220: flex_ft">
                        <div class="flex_fl_yc padding_px-t_000" data-xy="1-1220: padding_px-t_010">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_status" id="order_status_cancel" value="취소"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_status']) && $_GET['order_status'] == '취소' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_status_cancel"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">취소</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_status" id="order_status_exchange" value="교환"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_status']) && $_GET['order_status'] == '교환' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_status_exchange"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">교환</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_status" id="order_status_return" value="반품"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_status']) && $_GET['order_status'] == '반품' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_status_return"
                                data-xy="1-800: padding_px-l_005 padding_px-r_015">반품</label>
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_status" id="order_status_refund" value="환불"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_status']) && $_GET['order_status'] == '환불' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_status_refund"
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
                                type="radio" name="order_process_status" id="order_process_status_all" value=""
                                data-xy="1-800: width_px_016 height_px_016" <?php echo !isset($_GET['order_process_status']) || $_GET['order_process_status'] == '' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_all">전체</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_pending" value="입금대기"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '입금대기' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_pending">입금대기</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_paid" value="결제완료"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '결제완료' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_paid">결제완료</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_ready" value="상품준비중"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '상품준비중' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_ready">상품준비중</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_shipping" value="배송중"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '배송중' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_shipping">배송중</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_delivered" value="배송완료"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '배송완료' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_delivered">배송완료</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_confirmed" value="구매확정"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '구매확정' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010" for="order_process_status_confirmed">구매확정</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="order_process_status" id="order_process_status_failed" value="결제실패"
                                data-xy="1-800: width_px_016 height_px_016" <?php echo isset($_GET['order_process_status']) && $_GET['order_process_status'] == '결제실패' ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005" for="order_process_status_failed">결제실패</label>
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
            <div class="font_px_020 flv6 padding_px-y_020">주문현황조회 결과</div>
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
                            <label for="crm_searching_member_check_two_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_check_two_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">최근주문일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이름</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">구매처</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">결제수단</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">주문 금액</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원등급</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">총 주문 건수
                            </div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <?php
                        if ($sql_results[0] && count($sql_results[0]) > 0) {
                            $i = 1;
                            foreach ($sql_results[0] as $row) {
                        ?>
                        <div class="grid_xx border_px-u_001" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <label for="crm_searching_member_check_two_<?php echo $i; ?>"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="checkbox" name=""
                                    id="crm_searching_member_check_two_<?php echo $i; ?>" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $i; ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['order_date']; ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['name']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['user_id']; ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['store']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['payment_method']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo number_format($row['order_amount']); ?>
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['member_level']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $row['total_orders']; ?>건</div>
                            <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                        </div>
                        <?php
                                $i++;
                            }
                        } else {
                            echo "검색 결과가 없습니다.";
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
    .crm_member_check_color {
        background-color: #15376b;
    }

    .crm_member_check_2_bg {
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
            year: document.querySelector(`.crm_member_check_two_year_${i}`),
            month: document.querySelector(`.crm_member_check_two_month_${i}`),
            day: document.querySelector(`.crm_member_check_two_day_${i}`)
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
        // 필터링 폼의 submit 버튼 클릭 시
        document.getElementById('egen_search').addEventListener('click', function (e) {
            e.preventDefault(); // 폼 기본 제출 동작 방지

            // 각 필드 값을 가져옵니다
            const order_number = document.querySelector('input[name="order_number"]')?.value || '';
            const order_user_id = document.querySelector('input[name="order_user_id"]')?.value || '';
            const order_user_name = document.querySelector('input[name="order_user_name"]')?.value || '';
            const order_user_type1 = document.querySelector('input[name="order_user_type1"]:checked')?.value || '전체';
            const order_user_type2 = document.querySelector('input[name="order_user_type2"]:checked')?.value || '전체';
            const order_mall_type = document.querySelector('input[name="order_mall_type"]:checked')?.value || '전체';
            const order_payment_company = document.querySelector('input[name="payment_company"]:checked')?.value || '';
            const order_payment_method = document.querySelector('input[name="payment_method"]:checked')?.value || '';
            const order_status = document.querySelector('input[name="order_status"]:checked')?.value || '';
            const order_process_status = document.querySelector('input[name="order_process_status"]:checked')?.value || '';
            const order_product_code = document.querySelector('input[name="order_product_code"]')?.value || '';
            const order_category1 = document.querySelector('input[name="order_category1"]:checked')?.value || '';
            const order_category2 = document.querySelector('input[name="order_category2"]:checked')?.value || '';
            const order_keyword = document.querySelector('input[name="order_keyword"]')?.value || '';
            const order_cancel_request = document.querySelector('input[name="order_cancel_request"]:checked')?.value || '';
            const order_refund_request = document.querySelector('input[name="order_refund_request"]:checked')?.value || '';
            const order_return_request = document.querySelector('input[name="order_return_request"]:checked')?.value || '';
            const order_exchange_request = document.querySelector('input[name="order_exchange_request"]:checked')?.value || '';
            const viewCount = document.getElementById('egen_search_view_count')?.value || '30';

            // 구매금액 필드 값 가져오기
            const price_type = document.getElementById('price_type')?.value || '';
            const min_price = document.getElementById('min_price')?.value || '';
            const max_price = document.getElementById('max_price')?.value || '';

            // 구매건수 필드 값 가져오기  
            const order_count_type = document.getElementById('order_count_type')?.value || '';
            const min_count = document.getElementById('min_count')?.value || '';
            const max_count = document.getElementById('max_count')?.value || '';

            // 카테고리 필드 값 가져오기
            const category_level_1 = document.getElementById('category_level_1')?.value || '';
            const category_level_2 = document.getElementById('category_level_2')?.value || '';
            const category_level_3 = document.getElementById('category_level_3')?.value || '';

            // URL 쿼리 스트링을 생성합니다
            let queryParams = new URLSearchParams();

            // 필요한 필드만 추가
            if (order_number) queryParams.append('order_number', order_number);
            if (order_user_id) queryParams.append('order_user_id', order_user_id);
            if (order_user_name) queryParams.append('order_user_name', order_user_name);
            if (order_user_type1 !== '전체') queryParams.append('order_user_type1', order_user_type1);
            if (order_user_type2 !== '전체') queryParams.append('order_user_type2', order_user_type2);
            if (order_mall_type !== '전체') queryParams.append('order_mall_type', order_mall_type);
            if (order_payment_company) queryParams.append('payment_company', order_payment_company);
            if (order_payment_method) queryParams.append('payment_method', order_payment_method);
            if (order_status) queryParams.append('order_status', order_status);
            if (order_process_status) queryParams.append('order_process_status', order_process_status);
            if (order_product_code) queryParams.append('order_product_code', order_product_code);
            if (order_category1) queryParams.append('order_category1', order_category1);
            if (order_category2) queryParams.append('order_category2', order_category2);
            if (order_keyword) queryParams.append('order_keyword', order_keyword);
            if (order_cancel_request !== '전체') queryParams.append('order_cancel_request', order_cancel_request);
            if (order_refund_request !== '전체') queryParams.append('order_refund_request', order_refund_request);
            if (order_return_request !== '전체') queryParams.append('order_return_request', order_return_request);
            if (order_exchange_request !== '전체') queryParams.append('order_exchange_request', order_exchange_request);
            if (viewCount) queryParams.append('egen_search_view_count', viewCount);

            // 구매금액 파라미터 추가
            if (price_type) queryParams.append('price_type', price_type);
            if (min_price) queryParams.append('min_price', min_price);
            if (max_price) queryParams.append('max_price', max_price);

            // 구매건수 파라미터 추가
            if (order_count_type) queryParams.append('order_count_type', order_count_type);
            if (min_count) queryParams.append('min_count', min_count);
            if (max_count) queryParams.append('max_count', max_count);

            // 카테고리 파라미터 추가
            if (category_level_1) queryParams.append('category_level_1', category_level_1);
            if (category_level_2) queryParams.append('category_level_2', category_level_2);
            if (category_level_3) queryParams.append('category_level_3', category_level_3);

            // 주문일자 필터 추가
            const order_date_year1 = document.getElementById('start_year')?.value || '';
            const order_date_month1 = document.getElementById('start_month')?.value || '';
            const order_date_day1 = document.getElementById('start_day')?.value || '';
            const order_date_year2 = document.getElementById('end_year')?.value || '';
            const order_date_month2 = document.getElementById('end_month')?.value || '';
            const order_date_day2 = document.getElementById('end_day')?.value || '';

            if (order_date_year1 !== '선택' && order_date_month1 !== '선택' && order_date_day1 !== '선택') {
                queryParams.append('order_date_year1', order_date_year1);
                queryParams.append('order_date_month1', order_date_month1); 
                queryParams.append('order_date_day1', order_date_day1);
            }
            if (order_date_year2 !== '선택' && order_date_month2 !== '선택' && order_date_day2 !== '선택') {
                queryParams.append('order_date_year2', order_date_year2);
                queryParams.append('order_date_month2', order_date_month2);
                queryParams.append('order_date_day2', order_date_day2);
            }

            // 페이지를 필터링된 URL로 새로고침합니다
            window.location.href = '/page/crm_member_check_2/?' + queryParams.toString();
        });

        // egen_search_view_count 선택 시 자동 새로고침
        document.getElementById('egen_search_view_count').addEventListener('change', function() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('egen_search_view_count', this.value);
            
            // 현재 스크롤 위치 저장
            const scrollPosition = window.scrollY;
            urlParams.set('scrollTo', scrollPosition);
            
            window.location.href = '/page/crm_member_check_2/?' + urlParams.toString();
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
    });
</script>
