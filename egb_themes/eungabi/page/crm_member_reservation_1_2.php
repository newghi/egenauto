

<?php

$request_page = 'crm';
// 스토어 정보 조회
$store_name = '안산[산단점] 2호기';
$store_query = "
    SELECT uniq_id, store_schedule 
    FROM egb_store 
    WHERE store_name = :store_name 
    AND is_status = 1 
    LIMIT 1
";
$store_params = [':store_name' => $store_name];
$store_binding = binding_sql(1, $store_query, $store_params);
$store_result = egb_sql($store_binding);

if (empty($store_result[0])) {
    echo "<div>스토어 정보를 찾을 수 없습니다.</div>";
    return;
}

$store_uniq_id = $store_result[0]['uniq_id'];
$store_schedule = $store_result[0]['store_schedule'];

// store_schedule JSON 데이터를 PHP 배열로 변환
$schedule_data = json_decode($store_schedule, true);

// holidays 배열 가져오기
$holidays = isset($schedule_data['holidays']) ? $schedule_data['holidays'] : [];
$holiday_json = json_encode($holidays);

?>

<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
    <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_reservation_sub_menu.php'; ?>
    <div class="position1 flex_ft width_box height_box padding_px-a_020" data-bg-color="#e6e6e5">
        <div class="flex_xs1_yc padding_px-u_020"
            data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
            <div class="font_px_020 flv6">예약설정</div>
            <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                    data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                    <div>관리자 페이지</div>
                    <div>></div>
                    <div>설정</div>
                    <div>></div>
                    <div class="flv6" data-color="#000000">예약 설정</div>
                </div>
            </div>
        </div>
        <div class="border_px-a_002" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
            <?php
            $store_query = "
                SELECT store_schedule 
                FROM egb_store 
                WHERE uniq_id = :store_uniq_id
                AND is_status = 1
            ";
            
            $store_params = [':store_uniq_id' => $store_uniq_id];
            $store_binding = binding_sql(1, $store_query, $store_params);
            $store_results = egb_sql($store_binding);

            if (empty($store_results[0])) {
                echo "<div>예약 설정 데이터가 없습니다.</div>";
                return;
            }

            $schedule = json_decode($store_results[0]['store_schedule'], true);

            $days = ['월', '화', '수', '목', '금', '토', '일'];
            $day_values = ['월', '화', '수', '목', '금', '토', '일'];
            
            for($i = 0; $i < count($days); $i++) {
                $day = $days[$i];
                $day_value = $day_values[$i];
                $day_data = $schedule[$day];
                $is_holiday = $day_data['status'] ? 'checked' : '';

                echo "<details class='reservation_detail overflow_hidden' data-day='{$day_value}'>";
                echo "<summary class='flex_xs1_yc width_box height_px_056 border_px-u_001 padding_px-x_010 question'>";
                echo "<div class='flex_fl_yc'>";
                echo "<div class='font_px_050 arrow_rotate'>&blacktriangleright;</div>";
                echo "<div class='font_px_018 flv6'>{$day}요일</div>";
                echo "</div>";
                echo "<div class='flex_ft_yc'>";
                echo "<form action='" . DOMAIN . "/?post=egb_store_toggle_weekday_status_input' method='post' class='holiday_form'>";
                echo "<input type='hidden' name='csrf_token' value='" . $_SESSION['csrf_token'] . "'>";
                echo "<input type='hidden' name='uniq_id' value='{$store_uniq_id}'>";
                echo "<input type='hidden' name='request_page' value='{$request_page}'>";
                echo "<input type='hidden' name='weekday' value='{$day}'>";
                echo "<label class='switch_1' for='holiday_{$day}'>";
                echo "<input type='checkbox' class='day_status egb_submit' id='holiday_{$day}' name='holiday_status' {$is_holiday} data-day='{$day_value}'>";
                echo "<div class='reservation_on_off_slider_1 reservation_on_off_round_1'></div>";
                echo "</label>";
                echo "</form>";
                echo "<div class='font_px_010' data-color='#222222'>휴일 설정</div>";
                echo "</div>";
                echo "</summary>";

                echo "<div class='flex_fl_yc_wrap width_box border_px-t_001 padding_px-a_010 answer timeslotscontainer' data-bd-a-color='#d9d9d9' style='word-break: break-all;'>";

                foreach ($day_data['slots'] as $slot) {
                    $time_str = $slot['time'];
                    $car_count = $slot['count'];
                    $status_checked = $slot['status'] ? 'checked' : '';
                    $unique_id = 'reservation_time_' . $day . '_' . str_replace(':', '', $time_str);

                    echo "<div class='padding_px-a_010 timeslot' data-day='{$day_value}' data-time='{$time_str}'>";
                    echo "<div class='flex_fl_yc border_px-a_001 border_bre-a_005 padding_px-a_010' data-bd-a-color='#cccccc'>";
                    echo "<div class='flex_fl_yc padding_px-r_010'>";
                    echo "<div class='flex_fl_yc'>";
                    echo "<div class='width_px_050 padding_px-r_010 white-_space_nowrap'>" . substr($time_str, 0, 2) . "시</div>";
                    echo "<form action='" . DOMAIN . "/?post=egb_store_update_slot_count_input' method='post' class='count_form'>";
                    echo "<input type='hidden' name='csrf_token' value='" . $_SESSION['csrf_token'] . "'>";
                    echo "<input type='hidden' name='uniq_id' value='{$store_uniq_id}'>";
                    echo "<input type='hidden' name='request_page' value='{$request_page}'>";
                    echo "<input type='hidden' name='weekday' value='{$day}'>";
                    echo "<input type='hidden' name='time' value='{$time_str}'>";
                    echo "<input class='car_count width_px_030 border_px-u_001 font_px_014 number_change_submit' type='number' name='count' value='{$car_count}' maxlength='2' data-day='{$day_value}'>";
                    echo "</form>";
                    echo "<div>대</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<form action='" . DOMAIN . "/?post=egb_store_toggle_slot_status_input' method='post' class='status_form'>";
                    echo "<input type='hidden' name='csrf_token' value='" . $_SESSION['csrf_token'] . "'>";
                    echo "<input type='hidden' name='uniq_id' value='{$store_uniq_id}'>";
                    echo "<input type='hidden' name='request_page' value='{$request_page}'>";
                    echo "<input type='hidden' name='weekday' value='{$day}'>";
                    echo "<input type='hidden' name='time' value='{$time_str}'>";
                    echo "<label class='switch_2' for='{$unique_id}' title='활성화버튼'>";
                    echo "<input type='checkbox' class='time_status egb_submit' id='{$unique_id}' name='time_status' {$status_checked} data-day='{$day_value}' data-time='{$time_str}'>";
                    echo "<div class='reservation_on_off_slider_2 reservation_on_off_round_2'></div>";
                    echo "</label>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }

                echo "</div>";
                echo "</details>";
            }
            ?>
        </div>

        <!-- 휴일설정 섹션 추가 -->
        <div class="padding_px-t_020 padding_px-u_010 font_px_018 flv6">휴일등록&수정</div>
        <form action="<?php echo DOMAIN; ?>/?post=egb_store_add_holiday_input" method="post" id="holidayForm">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="uniq_id" value="<?php echo $store_uniq_id; ?>">
            <div class="border_px-a_002 font_px_014" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">휴일날짜</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input id="holiday_date" class="padding_px-x_015 padding_px-y_008 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="date" name="holiday_date" min="<?php echo date('Y-m-d'); ?>" data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">휴일명</div>
                    <div class="flex_fl border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input id="holiday_name" class="padding_px-x_015 padding_px-y_008 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="holiday_name" data-xy="1-800: width_box font_px_012">
                        <div class="padding_px-x_010 font_px_012" data-xy="1-800: font_px_010">
                            <button type="submit" class="width_px_050 padding_px-y_010 pointer font_style_center" data-bg-color="#202020"
                                data-color="#ffffff" data-hover-bg-color="#15376b">등록</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="padding_px-t_020 padding_px-u_010 font_px_018 flv6">휴일목록</div>
        <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
            data-xy="1-800: font_px_014">
            <div class="scrolls width_box overflow_hidden">
                <div class="holiday_list_box flex_ft border_px-a_001 min_width_600 bd-a-color-d9d9d9">
                    <div class="grid_xx border_px-u_001 flv6 bd-a-color-d9d9d9" data-xx="10% 40% 40% 10%"
                        data-bg-color="#efefef">
                        <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">No</div>
                        <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">휴일일자</div>
                        <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">휴일명</div>
                        <div class="flex_xc padding_px-y_015 bd-a-color-d9d9d9">삭제</div>
                    </div>
                    <?php
                    // 결과 확인 및 HTML 출력
                    if (isset($holidays) && !empty($holidays)) {
                        $index = 1;
                        foreach ($holidays as $holiday) {
                            echo '
                                <div class="holiday_list holiday_id_'.$index.' grid_xx border_px-u_001 pointer bd-a-color-d9d9d9 bg-color-ffffff" data-xx="10% 40% 40% 10%" data-date="' . htmlspecialchars($holiday['date']) . '" data-name="' . htmlspecialchars($holiday['holiday_name']) . '">
                                    <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">' . $index . '</div>
                                    <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">' . htmlspecialchars($holiday['date']) . '</div>
                                    <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">' . htmlspecialchars($holiday['holiday_name']) . '</div>
                                    <form action="' . DOMAIN . '/?post=egb_store_delete_holiday_input" method="post" class="delete_holiday_form">
                                        <input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">
                                        <input type="hidden" name="uniq_id" value="' . $store_uniq_id . '">
                                        <input type="hidden" name="holiday_date" value="' . htmlspecialchars($holiday['date']) . '">
                                        <div class="egb_submit flex_xc padding_px-y_015 pointer delete_holiday bd-a-color-d9d9d9 hover-bg-color-ff0000aa hover-color-ffffff width_box" data-id="' . $index . '">삭제</div>
                                    </form>
                                </div>
                            ';
                            $index++;
                        }
                    } else {
                        echo "<div class='holiday_list'>등록된 휴일이 없습니다.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="position2 width_box height_box zm-index_1 full overflow_hidden" data-bg-color="#e6e6e5"
            data-top="0%" data-left="0%"></div>
    </div>
</div>
<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    const holidayListBox = document.querySelector('.holiday_list_box');
    
    holidayListBox.addEventListener('click', function(e) {
        const holidayList = e.target.closest('.holiday_list');
        if (holidayList) {
            const date = holidayList.dataset.date;
            const name = holidayList.dataset.name;
            
            document.getElementById('holiday_date').value = date;
            document.getElementById('holiday_name').value = name;
        }
    });
});
</script>
<style>
    .full {
        height: 90vh;
    }

    .crm_member_reservation_color {
        background-color: #15376b;
    }

    .crm_member_reservation_1_bg {
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

    .reservation_detail {
        overflow: hidden;
        transition: height 300ms ease-out;
    }

    input[type="number"] {
        text-align: right;
        font-family: fontstyle1;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* 파이어폭스에서 스피너 제거 */
    input[type="number"] {
        -moz-appearance: textfield;
    }

    .switch_1 {
        display: inline-block;
        height: 26px;
        position: relative;
        width: 60px;
    }

    .switch_2 {
        display: inline-block;
        height: 20px;
        position: relative;
        width: 40px;
    }

    .switch_1 input {
        display: none;
    }

    .switch_2 input {
        display: none;
    }

    .reservation_on_off_slider_1 {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .reservation_on_off_slider_2 {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .reservation_on_off_slider_1:before {
        background-color: #fff;
        bottom: 3px;
        content: "";
        height: 20px;
        left: 2px;
        position: absolute;
        transition: .4s;
        width: 20px;
    }

    .reservation_on_off_slider_2:before {
        background-color: #fff;
        bottom: 3px;
        content: "";
        height: 14px;
        left: 2px;
        position: absolute;
        transition: .4s;
        width: 14px;
    }

    input:checked+.reservation_on_off_slider_1,
    input:checked+.reservation_on_off_slider_2 {
        background-color: #15376b;
    }

    input:checked+.reservation_on_off_slider_1:before {
        transform: translateX(36px);
    }

    input:checked+.reservation_on_off_slider_2:before {
        transform: translateX(21px);
    }

    .reservation_on_off_slider_1.reservation_on_off_round_1,
    .reservation_on_off_slider_2.reservation_on_off_round_2 {
        border-radius: 34px;
    }

    .reservation_on_off_slider_1.reservation_on_off_round_1:before,
    .reservation_on_off_slider_2.reservation_on_off_round_2:before {
        border-radius: 50%;
    }

    /* 화살표 회전 */
    .arrow_rotate {
        display: inline-block;
        transition: transform 0.5s ease-in-out;
    }
</style>