<div class="display_off" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9" data-hover-bg-color="#ff0000aa" data-hover-color="#ffffff">클래스 생성</div>



<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
    <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_reservation_sub_menu.php'; ?>
    <div class="position1 flex_ft width_box height_box padding_px-a_020" data-bg-color="#e6e6e5">
        <div class="flex_xs1_yc padding_px-u_020"
            data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
            <div class="font_px_020 flv6">휴일설정</div>
            <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                    data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                    <div>관리자 페이지</div>
                    <div>></div>
                    <div>설정</div>
                    <div>></div>
                    <div class="flv6" data-color="#000000">휴일설정</div>
                </div>
            </div>
        </div>
        <div class="padding_px-t_020 padding_px-u_010 font_px_018 flv6">휴일등록</div>
        <div class="border_px-a_002 font_px_014" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
            <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">휴일날짜</div>
                <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                    <input id="holiday_date" class="padding_px-x_015 padding_px-y_008 font_px_014 border_px-a_001"
                        data-bd-a-color="#888888" type="date" name="holiday_date" data-xy="1-800: width_box font_px_012">
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
                        <div id="holiday_submit" class="width_px_050 padding_px-y_010 pointer font_style_center" data-bg-color="#202020"
                            data-color="#ffffff" data-hover-bg-color="#15376b">등록</div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="padding_px-t_020 padding_px-u_010 font_px_018 flv6">휴일수정</div>
            <div class="border_px-a_002 font_px_014" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">휴일날짜</div>
                    <div class="border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input id="holiday_date_edit" class="padding_px-x_015 padding_px-y_008 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="date" name="holiday_date_edit" data-xy="1-800: width_box font_px_012">
                    </div>
                </div>
                <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">휴일명</div>
                    <div class="flex_fl border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <input id="holiday_name_edit" class="padding_px-x_015 padding_px-y_008 font_px_014 border_px-a_001"
                            data-bd-a-color="#888888" type="text" name="holiday_name_edit" data-xy="1-800: width_box font_px_012">
                        <div class="padding_px-x_010 font_px_012" data-xy="1-800: font_px_010">
                            <div id="holiday_submit_edit" class="width_px_050 padding_px-y_010 pointer font_style_center" data-bg-color="#202020"
                                data-color="#ffffff" data-hover-bg-color="#15376b">수정</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="padding_px-t_020 padding_px-u_010 font_px_018 flv6">휴일목록</div>
        <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
            data-xy="1-800: font_px_014">
            <div class="scrolls width_box overflow_hidden">
                <div class="holiday_list_box flex_ft border_px-a_001 min_width_600 bd-a-color-d9d9d9">
                    <div class="grid_xx border_px-u_001 flv6 bd-a-color-d9d9d9" data-xx="10% 40% 40% 10%"
                        data-bg-color="#efefef">
                        <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">No</div>
                        <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">휴일일자</div>
                        <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" >휴일명</div>
                        <div class="flex_xc padding_px-y_015 bd-a-color-d9d9d9">삭제</div>
                    </div>
<?php

$query_select = "SELECT no, reservation_holiday_uniq_id, reservation_holiday_date, reservation_holiday_name FROM auto_reservation_holiday ORDER BY no DESC";
$binding_select = binding_sql(0, $query_select);
$sql_select = egb_sql($binding_select);

// 결과 확인 및 HTML 출력
if (isset($sql_select[0])) {
    foreach ($sql_select[0] as $item) {
        echo '
            <div class="holiday_list holiday_id_'.htmlspecialchars($item['reservation_holiday_uniq_id']).' grid_xx border_px-u_001 pointer bd-a-color-d9d9d9 bg-color-ffffff" data-xx="10% 40% 40% 10%">
                <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">' . htmlspecialchars($item['no']) . '</div>
                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">' . htmlspecialchars($item['reservation_holiday_date']) . '</div>
                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">' . htmlspecialchars($item['reservation_holiday_name']) . '</div>
                <div class="flex_xc padding_px-y_015 pointer delete_holiday bd-a-color-d9d9d9 hover-bg-color-ff0000aa hover-color-ffffff" data-id="' . htmlspecialchars($item['no']) . '">삭제</div>
            </div>
        ';
    }
} else {
    echo "<div class='holiday_list'>등록된 휴일이 없습니다.</div>";
}

?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    .no-scroll {
        overflow: hidden;
    }

    .reservation_user_details_box_open:hover *:not(.notcolor) {
        background-color: #f2f2f2;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .user_details_box {
        transform: translateX(400px);
        transition: 0.4s;
    }

    .user_details_box_view {
        transform: translateX(0px);
        transition: 0.4s;
    }

    .excel_down_hover:hover {
        color: #ffffff;
        background-color: #15376b;
        transition: 0.3s;
    }

    .reservation_change_click {
        user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;/
    }

    .reservation_change_clicked {
        background-color: #15376b;
        color: #ffffff;
        font-weight: 600;
        transition: 0.2s;
    }

    .full {
        height: 90vh;
    }

    .crm_member_reservation_color {
        background-color: #15376b;
    }

    .crm_member_reservation_holiday_bg {
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

    textarea {
        outline: none;
        resize: none;
        font-family: fontstyle1;
    }

    textarea:focus {
        outline: none;
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

    select:focus:not(.nothover) {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
    }

    input[type="checkbox"]:checked,
    {
    display: block;
    width: 20px;
    height: 20px;
    border: 1px solid #202020;
    border-radius: 4px;
    background: url('<?php echo $background_url; ?>') no-repeat 0 0px / cover;
    }


    input[type="text"]:focus:not(.nothover),
    input[type="password"]:focus:not(.nothover),
    input[type="date"]:focus:not(.nothover) {
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
<?php jquery(); ?>
<script nonce="<?php echo NONCE; ?>">
$(document).ready(function () {
	
    // 오늘 날짜를 구하여 YYYY-MM-DD 형식으로 변환
    const today = new Date().toISOString().split('T')[0];
    
    // 내일 날짜를 구하여 min 속성으로 설정 (당일과 이전 날짜를 선택 불가)
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate());
    const minDate = tomorrow.toISOString().split('T')[0];

    // 당일 및 이전 날짜 선택 불가
    $('#holiday_date, #holiday_date_edit').attr('min', minDate);
	
    // 휴일 등록 처리
    $('#holiday_submit').on('click', function () {
        const holidayDate = $('#holiday_date').val();
        const holidayName = $('#holiday_name').val();

        $.ajax({
            url: '<?php echo DOMAIN . "/?post=reservation_holiday_input"; ?>',
            method: 'POST',
            data: {
                holiday_date: holidayDate,
                holiday_name: holidayName
            },
            success: function (response) {
                const result = JSON.parse(response);
                if (result.success) {
                    $('.holiday_list').remove();
                    result.data.forEach(function(item) {
                        const holidayRecord = `
                            <div class="holiday_list holiday_id_${item.reservation_holiday_uniq_id} grid_xx border_px-u_001 pointer bd-a-color-d9d9d9" data-xx="10% 40% 40% 10%" data-bg-color="#ffffff" data-id="${item.reservation_holiday_uniq_id}">
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${item.no}</div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${item.reservation_holiday_date}</div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${item.reservation_holiday_name}</div>
                                <div class="flex_xc padding_px-y_015 pointer delete_holiday bd-a-color-d9d9d9" data-hover-bg-color="#ff0000aa" data-hover-color="#ffffff" data-id="${item.no}">삭제</div>
                            </div>
                        `;
                        $('.holiday_list_box').append(holidayRecord);
                    });
                    $('#holiday_date').val("");
                    $('#holiday_name').val("");
                    alert("휴일이 성공적으로 등록되었습니다.");
                } else {
                    switch (result.errorCode) {
                        case 1:
                            alert("휴일 날짜를 입력하세요.");
                            break;
                        case 2:
                            alert("휴일 이름을 입력하세요.");
                            break;
                        case 3:
                            alert("등록 중 오류가 발생했습니다.");
                            break;
                        case 4:
                            alert("목록을 불러오는 중 오류가 발생했습니다.");
                            break;
                        case 5:
                            alert("이미 같은 날짜의 휴일이 존재합니다.");
                            break;
                        default:
                            alert("알 수 없는 오류가 발생했습니다.");
                    }
                }
            },
            error: function () {
                alert("서버와의 통신 중 오류가 발생했습니다.");
            }
        });
    });

    // 휴일 목록 아이템 클릭 이벤트
    $(document).on('click', '.holiday_list', function () {
        $('.holiday_list').removeClass('active');
        $(this).addClass('active');

        const holidayDate = $(this).find('.flex_xc').eq(0).text().trim();
        const holidayName = $(this).find('.flex_xc').eq(1).text().trim();

        $('#holiday_date_edit').val(holidayDate);
        $('#holiday_name_edit').val(holidayName);
    });

    // 휴일 수정 처리
    $('#holiday_submit_edit').on('click', function () {
        const holidayDateEdit = $('#holiday_date_edit').val();
        const holidayNameEdit = $('#holiday_name_edit').val();
        
        // `holiday_id_` 접두어를 제거하고 실제 ID 값만 사용
        const holidayId = $('.holiday_list.active').attr('class').split(' ').find(cls => cls.startsWith('holiday_id_')).replace('holiday_id_', '');

        $.ajax({
            url: '<?php echo DOMAIN . "/?post=reservation_holiday_edit_input"; ?>',
            method: 'POST',
            data: {
                holiday_date_edit: holidayDateEdit,
                holiday_name_edit: holidayNameEdit,
                holiday_id: holidayId
            },
            success: function (response) {
                const result = JSON.parse(response);
                if (result.success) {
                    const activeId = holidayId; // 현재 active 상태의 ID 저장

                    $('.holiday_list').remove();
                    result.data.forEach(function(item) {
                        const holidayRecord = `
                            <div class="holiday_list holiday_id_${item.reservation_holiday_uniq_id} grid_xx border_px-u_001 pointer bd-a-color-d9d9d9 bg-color-ffffff" data-xx="10% 40% 40% 10%" data-id="${item.reservation_holiday_uniq_id}">
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${item.no}</div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${item.reservation_holiday_date}</div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${item.reservation_holiday_name}</div>
                                <div class="flex_xc padding_px-y_015 pointer delete_holiday bd-a-color-d9d9d9 hover-bg-color-ff0000aa hover-color-ffffff" data-id="${item.no}">삭제</div>
                            </div>
                        `;
                        $('.holiday_list_box').append(holidayRecord);
                    });

                    // 목록 갱신 후 저장된 ID에 대해 active 클래스 추가
                    $(`.holiday_list_box .holiday_id_${activeId}`).addClass('active');

                    alert("휴일이 성공적으로 수정되었습니다.");
                } else {
                    switch (result.errorCode) {
                        case 1:
                            alert("휴일 날짜를 입력하세요.");
                            break;
                        case 2:
                            alert("휴일 이름을 입력하세요.");
                            break;
                        case 3:
                            alert("수정 중 오류가 발생했습니다.");
                            break;
                        case 4:
                            alert("목록을 불러오는 중 오류가 발생했습니다.");
                            break;
                        case 5:
                            alert("이미 같은 날짜의 휴일이 존재합니다.");
                            break;
                        default:
                            alert("알 수 없는 오류가 발생했습니다.");
                    }
                }
            },
            error: function () {
                alert("서버와의 통신 중 오류가 발생했습니다.");
            }
        });
    });
});

$(document).on('click', '.delete_holiday', function () {
    // 클릭된 요소의 부모 요소인 holiday_list에 active 클래스 추가
    $(this).closest('.holiday_list').addClass('active');

    const holidayId = $('.holiday_list.active').attr('class').split(' ').find(cls => cls.startsWith('holiday_id_')).replace('holiday_id_', '');

    if (confirm("정말로 삭제하시겠습니까?")) {
        $.ajax({
            url: '<?php echo DOMAIN . "/?post=reservation_holiday_del_input"; ?>',
            method: 'POST',
            dataType: 'json', // 항상 JSON으로 받도록 설정
            data: {
                holiday_id: holidayId
            },
            success: function (response) {
                if (response.success) {
                    $(`.holiday_id_${holidayId}`).remove(); // 삭제된 항목을 화면에서 제거
                    alert("휴일이 성공적으로 삭제되었습니다.");
                } else {
                    switch (response.errorCode) {
                        case 1:
                            alert("휴일 ID가 없습니다.");
                            break;
                        case 3:
                            alert("삭제 중 오류가 발생했습니다.");
                            break;
                        case 4:
                            alert("목록을 불러오는 중 오류가 발생했습니다.");
                            break;
                        default:
                            alert("알 수 없는 오류가 발생했습니다.");
                    }
                }
            },
            error: function (xhr, status, error) {
                alert("서버와의 통신 중 오류가 발생했습니다.");
                console.log("Error:", error);
            }
        });
    }
});



</script>
