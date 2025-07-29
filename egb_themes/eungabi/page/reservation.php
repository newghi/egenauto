


<?php 

$store_uniq_id = egb('store');
$current_month = egb('month');
if (empty($current_month)) {
    $current_month = date('m');
}

    $current_year = egb('year');
    if (empty($current_year)) {
        $current_year = date('Y');
    }

    $prev_month = $current_month - 1;
    $next_month = $current_month + 1;
    $prev_year = $current_year;
    $next_year = $current_year;
    if ($prev_month == 0) {
        $prev_month = 12;
        $prev_year--;
    }

    if ($next_month == 13) {
        $next_month = 1;
        $next_year++;
    }

    $today = date('d');
    $this_month = date('m');
    $this_year = date('Y');

    // 스토어 스케줄 조회
    $sql = "SELECT store_schedule, store_name FROM egb_store WHERE uniq_id = :uniq_id";
    $params = [':uniq_id' => $store_uniq_id];
    $binding = binding_sql(1, $sql, $params);
    $result = egb_sql($binding);

    $schedule = [];
    $holidays = [];
    if (!empty($result[0]['store_schedule'])) {
        $schedule = json_decode($result[0]['store_schedule'], true);
        if (isset($schedule['holidays'])) {
            $holidays = $schedule['holidays'];
        }
    }

    // 휴일 날짜와 이름을 저장할 배열
    $holiday_dates = [];
    $holiday_names = [];
    foreach ($holidays as $holiday) {
        $holiday_dates[] = $holiday['date'];
        $holiday_names[$holiday['date']] = $holiday['holiday_name'];
    }

    // Get selected date from URL parameters
    $selected_day = egb('day');
    $selected_month = egb('month');
    $selected_year = egb('year');

    ?>
    <div class="display_off" data-bd-a-color="#d9d9d9" data-bg-color="#eeeeee" data-color="#cccccc"></div>
    <section class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
        <div class="padding_px-y_025 padding_px-x_010">
            <div class="padding_px-u_040 font_px_024 flv6 font_style_center">예약하기</div>
        </div>
        <div class="padding_px-x_010 padding_px-t_010 flex_xs1_yc">
            <div>
                <div class="flex_xc_yc">
                    <div class="padding_px-t_004">
                        <a href="/page/reservation/?store=<?php echo $store_uniq_id; ?>&month=<?php echo str_pad($prev_month, 2, '0', STR_PAD_LEFT); ?>&year=<?php echo $prev_year; ?>">
                            <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/leftarrow.svg'; ?>" class="pointer width_px_015 height_px_015">
                        </a>
                    </div>
                    <div class="font_px_024 flv6 padding_px-x_025" data-xy="1-600: font_px_018, 601-1000: font_px_021">
                        <span id="reservation_year"><?php echo $current_year; ?></span><span>.</span><span id="reservation_month"><?php echo str_pad($current_month, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="padding_px-t_004">
                        <a href="/page/reservation/?store=<?php echo $store_uniq_id; ?>&month=<?php echo str_pad($next_month, 2, '0', STR_PAD_LEFT); ?>&year=<?php echo $next_year; ?>">
                            <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/rightarrow.svg'; ?>" class="pointer width_px_015 height_px_015">
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="padding_px-x_010 padding_px-u_025 flex_xc_yc font_px_016" data-xy="1-600: font_px_014">
                    <div class="flex_yc">
                        <div class="width_px_018 height_px_018 border_bre-a_020" style="background-color: #15376b;" data-xy="1-600: width_px_016 height_px_016"></div>
                        <div class="padding_px-l_005" data-color="#000000">예약일 선택</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="padding_px-x_010 padding_px-y_035 font_px_016" data-xy="1-600: font_px_014">
            <div class="grid_xx border_px-y_001" data-xx="14.3% 14.3% 14.3% 14.3% 14.3% 14.3% 14.3%" data-color="#212529" data-bd-a-color="#cccccc" data-bg-color="#f4f4f4">
                <div class="flex_xc padding_px-y_013 border_px-x_001" data-color="#ff0000" data-bd-a-color="#dddddd">일</div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd">월</div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd">화</div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd">수</div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd">목</div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd">금</div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-color="#2C7BE3" data-bd-a-color="#dddddd">토</div>
            </div>
            <div class="grid_xx gridmenu" data-xx="14.3% 14.3% 14.3% 14.3% 14.3% 14.3% 14.3%" data-color="#212529">
                <?php
                $days_in_month = date('t', strtotime("$current_year-$current_month-01"));
                $first_day_of_month = date('w', strtotime("$current_year-$current_month-01"));

                // 첫 번째 날 이전의 빈 박스들을 생성합니다.
                for ($i = 0; $i < $first_day_of_month; $i++) {
                    $border_class = $i == 0 ? "border_px-x_001" : "border_px-r_001";
                    echo '<div class="grid_item width_box ' . $border_class . ' border_px-u_001" data-bd-a-color="#dddddd"></div>';
                }

                // 각 날짜에 대한 박스를 생성
                for ($day = 1; $day <= $days_in_month; $day++) {
                    $date_string = sprintf("%04d-%02d-%02d", $current_year, $current_month, $day);
                    $timestamp = strtotime($date_string);
                    $day_of_week = date('w', $timestamp);
                    $day_name = ['일', '월', '화', '수', '목', '금', '토'][$day_of_week];
                    $is_past = $current_year < $this_year ||
                        ($current_year == $this_year && $current_month < $this_month) ||
                        ($current_year == $this_year && $current_month == $this_month && $day < $today);
                    $is_holiday = in_array($date_string, $holiday_dates);
                    $is_today = ($current_year == $this_year && $current_month == $this_month && $day == $today);
                    $is_selected = $is_today; // 오늘 날짜를 기본 선택으로 설정
                    // 해당 요일의 영업 상태 확인
                    $day_schedule = isset($schedule[$day_name]) ? $schedule[$day_name] : null;
                    $is_closed = !$day_schedule || $day_schedule['status'] == 0;
                    $classes = "flex_xc_yc font_style_center padding_px-y_018";
                    $style = "";
                    if ($is_holiday || $is_closed) {
                        $classes .= " close_day";
                    } else if (!$is_past) {
                        $classes .= " pointer";
                    }
                    if ($is_past || $is_holiday || $is_closed) {
                        $classes .= " o_4";
                    }
                    if ($is_today) {
                        $classes .= " today_click border_bre-a_030";
                    }
                    if ($is_selected) {
                        $classes .= " selected";
                    }
                    if ($day_of_week == 0 || $is_holiday) {
                        if (!$style) {
                            $style .= 'background-color: #ffcccc; color: #ff0000;';
                        }
                    } elseif ($day_of_week == 6) {
                        if (!$style) {
                            $style .= 'color: #2C7BE3;';
                        }
                    } elseif (!$style) {
                        $style .= 'color: #212529;';
                    }
                    $display_day = $is_holiday ? $holiday_names[$date_string] : str_pad($day, 2, '0', STR_PAD_LEFT);
                    echo '<div class="width_box grid_item border_px-u_001 border_px-r_001" data-bd-a-color="#dddddd" style="' . $style . '">';
                    
                    // 비활성화된 날짜는 div로, 활성화된 날짜는 form으로
                    if ($is_closed || $is_past) {
                        echo '<div class="flex_xc_yc reservation_form">';
                        echo '<div class="egb_submit reservation_day_' . $day . ' ' . $classes . '" data-day="' . $day . '" data-month="' . $current_month . '" data-year="' . $current_year . '">' . $display_day . '</div>';
                        echo '</div>';
                    } else {
                        echo '<form action="/?post=egb_get_store_schedule_time_input" method="post" class="flex_xc_yc reservation_form">';
                        echo '<input type="hidden" name="uniq_id" value="' . $store_uniq_id . '">';
                        echo '<input type="hidden" name="year" value="' . $current_year . '">';
                        echo '<input type="hidden" name="month" value="' . $current_month . '">';
                        echo '<input type="hidden" name="day" value="' . $day . '">';
                        echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
                        echo '<div class="egb_submit reservation_day_' . $day . ' ' . $classes . '" data-day="' . $day . '" data-month="' . $current_month . '" data-year="' . $current_year . '">' . $display_day . '</div>';
                        echo '</form>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>
    <section class="position1 width_box">
        <div class="width_px_1220 margin_x_auto flex_xr font_px_015 padding_px-u_020" data-xy="1-1220: width_box"
            data-color="#000000">
            <div class="flex_fl_yc padding_px-r_010">
                <div class="border_px-a_001 border_bre-a_003 padding_px-x_003" data-bd-a-color="#d9d9d9"
                    data-color="#0000ff">국</div>
                <div class="padding_px-l_005">국산차</div>
            </div>
            <div class="flex_fl_yc padding_px-r_010">
                <div class="border_px-a_001 border_bre-a_003 padding_px-x_003" data-bd-a-color="#d9d9d9"
                    data-color="#00ff00">수</div>
                <div class="padding_px-l_005">수입차</div>
            </div>
            <div class="flex_fl_yc">
                <div class="border_px-a_001 border_bre-a_003 padding_px-x_003" data-bd-a-color="#d9d9d9"
                    data-color="#ff0000">타</div>
                <div class="padding_px-l_005">타이어</div>
            </div>
        </div>
    <?php
    $target_date = $current_year.'-'.$current_month.'-'.$today;
    $current_date = date('Y-m-d');
    
    $selected_date = $current_year.'-'.$current_month.'-'.$selected_day;
    // selected_date가 유효한 날짜 형식인지 확인
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selected_date)) {
        $selected_date = $current_date;
    }

    // 오늘이 휴일인지 체크
    $is_today_holiday = in_array($current_date, $holiday_dates);
    
    // 오늘의 요일 구하기
    $today_day_name = date('w');
    $days = ['일', '월', '화', '수', '목', '금', '토']; // Define $days array here
    $today_day_schedule = isset($schedule[$days[$today_day_name]]) ? $schedule[$days[$today_day_name]] : null;
    $is_today_closed = !$today_day_schedule || $today_day_schedule['status'] == 0;

    if ($target_date == $current_date) {
        if ($is_today_holiday || $is_today_closed) {
            $today_no = 'display_off';
            $today_no_reservation = '';
        } else {
            $today_no = '';
            $today_no_reservation = '';
        }
    } else {
        $today_no = 'display_off';
        $today_no_reservation = '';
    }

    ?>
        <div id="reservation_no_box" class="flex_xc padding_px-u_040 <?php echo $today_no; ?>">
            <div class="width_px_500 margin_x_auto padding_px-y_020 border_px-a_001 border_bre-a_005 font_px_016 font_style_center"
                data-bd-a-color="#aaaaaa" data-color="#888888">
                <div class="font_px_022 flv6" data-color="#000000">
                    <?php if ($is_today_holiday): ?>
                        휴일입니다
                    <?php elseif ($is_today_closed): ?>
                        휴무일입니다
                    <?php else: ?>
                        당일 예약 불가
                    <?php endif; ?>
                </div>
                <div class="padding_px-y_005">
                    <?php if ($is_today_holiday || $is_today_closed): ?>
                        오늘은 영업하지 않습니다.
                    <?php else: ?>
                        당일 온라인 예약은 제공하지 않습니다.
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($is_today_holiday || $is_today_closed): ?>
                        다른 날짜를 선택해 주세요.
                    <?php else: ?>
                        당일 예약은 해당 지점에 직접 문의해 주세요.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="position1 width_box">
        <div class="width_px_1220 margin_x_auto padding_px-y_030" data-xy="1-1220: width_box">
            <div class="fontstyle2 flex_fl_yc font_px_018 padding_px-u_010">
                <div class="flv6 padding_px-r_005"><?php echo $result[0]['store_name']; ?></div>
                <div class="flex_fl padding_px-r_005">
                    <svg height="14px" viewBox="0 -10 511.98685 511" width="14px" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0"
                            fill="#ffc107" />
                    </svg>
                </div>
                <div class="padding_px-r_005">5.0</div>
                <div class="font_px_016 margin_px-r_005 border_px-a_001 border_bre-a_003 padding_px-x_003"
                    data-bd-a-color="#d9d9d9" data-color="#0000ff">국</div>
                <div class="font_px_016 border_px-a_001 border_bre-a_003 padding_px-x_003" data-bd-a-color="#d9d9d9"
                    data-color="#00ff00">수</div>
            </div>
            <div class="flex_fl_xs1 width_box padding_px-a_020 border_px-a_001 border_bre-a_012 " data-bd-a-color="#d9d9d9"
                style="box-shadow: 0 0 10px 0 #0000001a;" data-xy="1-1250: flex_ft">
                <div class="flex_fl_yc" data-xy="1-600: flex_ft">
                    <div class="">
                        <img class="width_px_190 height_px_130 border_bre-a_008" data-xy="1-600: width_box height_box"
                            src="<?php echo DOMAIN . THEMES_PATH . '/img/repairshop/1.webp'; ?>" style="object-fit: cover;">
                    </div>
                    <div class="flex_ft_xs1 height_px_130 font_px_014 padding_px-y_015 padding_px-x_010"
                        data-color="#555555">
                        <div class="flex_ft">
                            <span>경기 안산시 단원구 산단로 325</span>
                            <span>리드스마트스퀘어 3층 353호</span>
                        </div>
                        <div class="">070-4694-0059</div>
                        <div class="flex_fl_yc font_px_012" data-color="#909090">
                            <span>평균답변시간&nbsp;</span>
                            <span data-color="#000000">9시간</span>
                            <span>｜</span>
                            <span>후기 470</span>
                            <span>｜</span>
                            <span>추천 31</span>
                        </div>
                    </div>
                </div>

                
        <?php

        // 오늘 날짜의 요일을 구합니다
        $day_of_week = date('w'); // 0: 일, 1: 월, ..., 6: 토
        $days = ['일', '월', '화', '수', '목', '금', '토']; // Define $days array here
        $reservation_day = $days[$day_of_week];

        // 스케줄 데이터를 가져옵니다
        $schedule_query = "SELECT store_schedule FROM egb_store WHERE uniq_id = :store_uniq_id";
        $schedule_params = [':store_uniq_id' => $store_uniq_id];
        $schedule_binding = binding_sql(1, $schedule_query, $schedule_params);
        $schedule_result = egb_sql($schedule_binding);

        $schedule = [];
        if (isset($schedule_result[0]['store_schedule'])) {
            $schedule = json_decode($schedule_result[0]['store_schedule'], true);
        }

        // 오늘 요일의 스케줄 정보를 가져옵니다
        $today_schedule = isset($schedule[$reservation_day]) ? $schedule[$reservation_day] : null;

        // 오늘이 휴일인지 체크
        $today_date = date('Y-m-d');
        $is_holiday = in_array($today_date, $holiday_dates);

        // 총 예약 가능 차량 대수와 현재 가능한 차량 대수를 계산합니다
        $total_car_count = 0;
        $total_available_car_count = 0;

        if (!$is_holiday && $today_schedule && $today_schedule['status'] == 1) {
            foreach ($today_schedule['slots'] as $slot) {
                if ($slot['status'] == 1) {
                    $total_car_count += $slot['count'];
                    
                    // 해당 시간대의 예약된 차량 수를 조회 (신청, 확정 상태 포함)
                    $reservation_count_query = "
                        SELECT COUNT(*) as cnt 
                        FROM egb_reservation 
                        WHERE reservation_store_uniq_id = :store_uniq_id
                        AND YEAR(reservation_date) = :year
                        AND MONTH(reservation_date) = :month  
                        AND DAY(reservation_date) = :day
                        AND HOUR(reservation_time) = :hour
                        AND reservation_status IN (1, 2, 3) -- 1: 신청, 2: 확정, 3: 완료
                        AND deleted_at IS NULL
                    ";
                    
                    $hour = explode(':', $slot['time'])[0];
                    $reservation_count_params = [
                        ':store_uniq_id' => $store_uniq_id,
                        ':year' => $current_year,
                        ':month' => $current_month,
                        ':day' => $today,
                        ':hour' => $hour
                    ];

                    $reservation_count_binding = binding_sql(1, $reservation_count_query, $reservation_count_params);
                    $reservation_count_result = egb_sql($reservation_count_binding);
                    $reserved_count = $reservation_count_result[0]['cnt'];

                    // 실제 가능한 차량 수 계산 (전체 - 예약된 수)
                    $available_count = max(0, $slot['count'] - $reserved_count);
                    $total_available_car_count += $available_count;
                }
            }
        }

        ?>

        <div id="change_time_box" class="flex_ft <?php echo $today_no_reservation; ?>">
            <div class="flex_xr_yc fontstyle2">예약 가능 대수&nbsp;:&nbsp;<span id="reservation_car_count" data-color="#ff0000"><?php echo $total_available_car_count; ?></span>&nbsp;/&nbsp;<span id="reservation_total_car_count"><?php echo $total_car_count; ?></span></div>
            <div id="change_time" class="width_px_750 flex_fl_wrap" data-xy="1-1250: flex_wrap width_box">
        <?php

        if (!$is_holiday && $today_schedule && $today_schedule['status'] == 1) {
            foreach ($today_schedule['slots'] as $slot) {
                if ($slot['status'] == 1) { // status가 1인 경우만 표시
                    $time_parts = explode(':', $slot['time']);
                    $hour = $time_parts[0];

                    // 해당 시간대의 예약된 차량 수를 조회 (신청, 확정 상태 포함)
                    $reservation_count_query = "
                        SELECT COUNT(*) as cnt 
                        FROM egb_reservation 
                        WHERE reservation_store_uniq_id = :store_uniq_id
                        AND YEAR(reservation_date) = :year
                        AND MONTH(reservation_date) = :month
                        AND DAY(reservation_date) = :day
                        AND HOUR(reservation_time) = :hour
                        AND reservation_status IN (1, 2, 3) -- 1: 신청, 2: 확정, 3: 완료
                        AND deleted_at IS NULL
                    ";
                    
                    $reservation_count_params = [
                        ':store_uniq_id' => $store_uniq_id,
                        ':year' => $current_year,
                        ':month' => $current_month,
                        ':day' => $today,
                        ':hour' => $hour
                    ];

                    $reservation_count_binding = binding_sql(1, $reservation_count_query, $reservation_count_params);
                    $reservation_count_result = egb_sql($reservation_count_binding);
                    $reserved_count = $reservation_count_result[0]['cnt'];

                    // 실제 가능한 차량 수 계산 (전체 - 예약된 수)
                    $available_count = max(0, $slot['count'] - $reserved_count);

                    if ($available_count <= 0) {
                        // 예약 가능 수량이 0인 경우 마감으로 표시
                        ?>
                        <div class="padding_px-a_005">
                            <div class="width_px_140 flex_xc border_px-a_001 border_bre-a_005 padding_px-y_010"
                                data-bd-a-color="#d9d9d9" data-bg-color="#eeeeee" data-xy="1-600: width_px_125"
                                data-color="#cccccc">
                                <?php echo $hour; ?>시(마감)
                            </div>
                        </div>
                        <?php
                    } else {
                        // 예약 가능한 경우
                        ?>
                        <div class="padding_px-a_005">
                            <div class="width_px_140 position1 flex_xc border_px-a_001 border_bre-a_005 padding_px-y_010 pointer reservation_hover"
                                data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-600: width_px_125"
                                data-color="#000000">
                                <div class="reservation_hover_1">
                                    <?php echo $hour; ?>시<span class="color-ff0000">(<?php echo $available_count; ?>대)</span>
                                </div>
                                <div class="position2 flex_xc_yc width_box height_box border_bre-a_005 o_0 reservation_hover_2 top-0per bg-color-15376b color-ffffff">예약하기</div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        } else {
            if ($is_holiday) {
                echo '<div>오늘은 휴일입니다.</div>';
            } else if (!$today_schedule || $today_schedule['status'] == 0) {
                echo '<div>오늘은 휴무일입니다.</div>';
            } else {
                echo '<div>해당 요일에 예약 가능한 데이터가 없습니다.</div>';
            }
        }

        ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    <section class="position1 width_box z-index_2" data-bg-color="#ffffff">
        <div class="padding_px-y_015" 
            data-xy="1-1000: padding_px-y_010">
            <div class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
                <div class="padding_px-x_010">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <form id="reservation_form" class="egb_no_submit" method="POST" action="<?php echo DOMAIN . '/page/reservation_form'; ?>">
                            <input type="hidden" name="selected_date" id="selected_date" value="<?php echo $selected_date; ?>">
                            <input type="hidden" name="selected_times" id="selected_times" value="">
                            <input type="hidden" name="store" value="<?php echo $store_uniq_id; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button type="submit" id="reservation_button" class="width_box border_bre-a_006 flex_xc padding_px-y_024 line_height_100 pointer" data-color="#ffffff" data-bg-color="#15376b" data-xy="1-1000: padding_px-y_015" disabled>
                                예약하기
                            </button>
                        </form>
                    <?php } else { ?>
                        <a href="/page/login" class="width_box border_bre-a_006 flex_xc padding_px-y_024 line_height_100 pointer" data-color="#ffffff" data-bg-color="#15376b" data-xy="1-1000: padding_px-y_015">
                            로그인 후 예약하기
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <style>
        .reservationclose {
            display: none;
        }

        .reservationclose_1 {
            padding-bottom: 60px;
        }

        .reservation_hover:hover .reservation_hover_1 {
            opacity: 0;
            transition: 0.3s;
        }

        .reservation_hover:hover .reservation_hover_2 {
            opacity: 1;
            transition: 0.3s;
        }
    </style>

    <style>
    .selected {
        background-color: #15376b !important;
        color: #ffffff !important;
        border-radius: 50px;
        margin: auto;
        padding-left: 9px;
        padding-right: 9px;
        padding-top: 5px;
        padding-bottom: 6px;
    }

    .time_selected {
        background-color: #15376b !important;
        color: #ffffff !important;
    }

    .close_day {}

    .time-slot {
        padding: 10px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
    }

    .time-slot:hover {
        background-color: #f5f5f5;
    }

    .time-slot.sold-out {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* 예약 버튼 비활성화 스타일 */
    #reservation_button:disabled {
        background-color: #cccccc !important;
        color: #888888 !important;
        cursor: not-allowed !important;
        border: 1px solid #bbbbbb !important;
    }

    </style>
    <script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    const reservationDays = document.querySelectorAll('.egb_submit');
    const selectedDateInput = document.getElementById('selected_date');
    const selectedTimesInput = document.getElementById('selected_times');
    const reservationButton = document.getElementById('reservation_button');

    // 필수 요소들이 존재하는지 확인 (로그인 상태에서만 필요)
    if (!selectedDateInput || !selectedTimesInput || !reservationButton) {
        return;
    }

    reservationDays.forEach(day => {
        day.addEventListener('click', function(e) {
            // 비활성화된 날짜는 클릭 무시
            if (this.closest('form') === null) {
                return;
            }
            
            // 기존 selected 클래스 제거
            const previousSelected = document.querySelector('.selected');
            if (previousSelected) {
                previousSelected.classList.remove('selected');
            }

            this.classList.add('selected');

            // 날짜 저장 (null 체크 추가)
            const year = this.dataset.year;
            const month = this.dataset.month.padStart(2, '0');
            const dayValue = this.dataset.day.padStart(2, '0');
            
            if (selectedDateInput) {
                selectedDateInput.value = `${year}-${month}-${dayValue}`;
            }

            // 시간 초기화
            resetTimeSelection();
            updateReservationButton();
        });
    });
});

    </script>
<script nonce="<?php echo NONCE; ?>">
let selectedTimes = []; // 전역

function updateReservationButton() {
    const button = document.getElementById('reservation_button');
    const selectedTimesInput = document.getElementById('selected_times');
    
    // 요소가 존재하지 않으면 함수 종료 (로그인 상태에서만 필요)
    if (!button || !selectedTimesInput) {
        return;
    }
    
    if (selectedTimes.length > 0) {
        selectedTimes.sort((a, b) => a - b);
        const timeText = selectedTimes.length > 1 ? 
            `${String(selectedTimes[0]).padStart(2,'0')}시 ~ ${String(selectedTimes[selectedTimes.length-1]).padStart(2,'0')}시 ` : 
            `${String(selectedTimes[0]).padStart(2,'0')}시 `;
        button.textContent = timeText + '예약하기';
        selectedTimesInput.value = selectedTimes.join(',');
        button.disabled = false;
    } else {
        button.textContent = '예약하기';
        selectedTimesInput.value = '';
        button.disabled = true;
    }
}

// ✅ 전역 함수로 등록
window.resetTimeSelection = function () {
    selectedTimes = [];
    const list = document.querySelectorAll('#change_time .time_selected');
    console.log('초기화 대상 개수:', list.length);
    list.forEach(el => el.classList.remove('time_selected'));
    
    // updateReservationButton 함수가 존재하는지 확인
    if (typeof updateReservationButton === 'function') {
        updateReservationButton();
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const changeTimeBox = document.getElementById('change_time');
    if (!changeTimeBox) return;

    changeTimeBox.addEventListener('click', function (e) {
        const slot = e.target.closest('.reservation_hover');
        if (!slot || !changeTimeBox.contains(slot)) return;

        const hourText = slot.querySelector('.reservation_hover_1')?.textContent.trim();
        const hourMatch = hourText?.match(/^(\d{1,2})시/);
        const hour = hourMatch ? parseInt(hourMatch[1]) : NaN;

        if (isNaN(hour)) return;

        const isSelected = slot.classList.contains('time_selected');

        if (isSelected) {
            if (
                selectedTimes.length === 1 ||
                hour === selectedTimes[0] ||
                hour === selectedTimes[selectedTimes.length - 1]
            ) {
                selectedTimes = selectedTimes.filter(t => t !== hour);
                slot.classList.remove('time_selected');
            } else {
                alert('중간 시간은 해제할 수 없습니다.');
            }
        } else {
            if (
                selectedTimes.length === 0 ||
                hour === Math.min(...selectedTimes) - 1 ||
                hour === Math.max(...selectedTimes) + 1
            ) {
                selectedTimes.push(hour);
                selectedTimes.sort((a, b) => a - b);
                slot.classList.add('time_selected');
            } else {
                alert('연속된 시간만 선택할 수 있습니다.');
            }
        }
        updateReservationButton();
    });
});
</script>
