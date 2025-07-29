<?php
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === 'Y'){$admin_crm = 'admin';}
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){$user_login = 'user';}

if (isset($user_login) || isset($admin_crm)){
	
}else{
	echo "<script nonce=".NONCE." type='text/javascript'>window.location.href='". DOMAIN.'/page/login'."'; </script>"; exit;
}

// POST 데이터 수신
$year = $_POST['year'] ?? null;
$month = $_POST['month'] ?? null;
$day = $_POST['day'] ?? null;
$times = $_POST['times'] ?? null; // Updated to receive 'times' parameter

if (isset($year) && isset($month) && isset($day) && isset($times)){
    $selectedTimes = json_decode($times, true); // Decode JSON to array
    if (!is_array($selectedTimes) || empty($selectedTimes)) {
        echo "<script nonce=".NONCE." type='text/javascript'>alert('시간 선택이 올바르지 않습니다.'); window.location.href='". DOMAIN.'/page/reservation'."'; </script>"; exit;
    }
}else{
	//echo "<script nonce=".NONCE." type='text/javascript'>window.location.href='". DOMAIN.'/page/reservation'."'; </script>"; exit;
}

// 사용자가 로그인되어 있고 고유 ID가 세션에 설정된 경우
if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'errorCode' => 1]); // 에러 코드 1: 세션에 user_uniq_id 없음
    exit;
}

// user_uniq_id 가져오기
$user_uniq_id = $_SESSION['user_uniq_id'];

// 사용자 정보 조회 쿼리
$query = "SELECT * FROM auto_user WHERE user_uniq_id = :user_uniq_id";
$params = [
    ':user_uniq_id' => $user_uniq_id
];

// 바인딩 및 SQL 실행
$binding = binding_sql(1, $query, $params);
$sql_result = egb_sql($binding);

// 결과 처리
if (isset($sql_result[0])) {
    $user_info = $sql_result[0];
} else {
	$user_info = '';
    echo "<script nonce=".NONCE." type='text/javascript'>window.location.href='". DOMAIN.'/page/login'."'; </script>"; exit;
}

?>

<section class="position1 width_box">
    <div class="width_px_1220 margin_x_auto">
        <div class="padding_px-x_010">
            <div class="padding_px-y_025">
                <div class="padding_px-u_040 font_px_024 flv6 border_px-u_001">예약하기</div>
            </div>
            <div class="font_style_center font_px_024 padding_px-y_015">정비예약</div>
            <form class="padding_px-t_025 padding_px-u_100 font_px_014" action="" data-color="#1c1c1c">
                <div class="grid_xx border_px-t_001 border_px-u_001" data-bd-t-color="#c9c9c9" data-bd-u-color="#d9d9d9"
                    data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">예약가맹점</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030">전주[삼천점] 2호기</div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">예약일시</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030">
                        <?php echo $year; ?>년 <?php echo $month; ?>월 <?php echo $day; ?>일 
                        <?php 
                        // Display selected times
                        $formattedTimes = array_map(function($time) {
                            return $time . '시';
                        }, $selectedTimes);
                        echo implode(', ', $formattedTimes);
                        ?>
                    </div>
					<input type="hidden" name="reservation_year" value="<?php echo $year; ?>">
					<input type="hidden" name="reservation_month" value="<?php echo $month; ?>">
					<input type="hidden" name="reservation_day" value="<?php echo $day; ?>">
					<input type="hidden" name="reservation_times" value="<?php echo htmlspecialchars(json_encode($selectedTimes), ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="50% 50%">
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">예약자성함</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_030"><?php echo $user_info['user_name']; ?></div>
						<input type="hidden" name="reservation_user_name" value="<?php echo $user_info['user_name']; ?>">
                    </div>
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">연락처</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_user_phone_number"
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9" value="<?php echo $user_info['user_phone_number1']; ?>">
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="50% 50%">
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">차량모델명</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_car_model"
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9">
                        </div>
                    </div>
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">연식</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_car_model_year" 
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9">
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="50% 50%">
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">차량번호</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_car_number" 
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9">
                        </div>
                    </div>
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">주행거리</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_car_mileage" 
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9">
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">차종선택</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030">
                        <div class="flex_yc padding_px-r_025"><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="domestic_car" name="reservation_car_type" type="radio"
                                required><label class="pointer padding_px-l_005" for="domestic_car">국산차</label></div>
                        <div class="flex_yc "><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                id="imported_car" data-bd-a-color="#aaaaaa" name="reservation_car_type" type="radio"
                                required><label class="pointer padding_px-l_005" for="imported_car">수입차</label>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">제품</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030">
                        <div class="flex_yc padding_px-r_025"><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004" id="bring"
                                data-bd-a-color="#aaaaaa" name="reservation_car_product_check" type="radio" ><label
                                class="pointer padding_px-l_005" for="bring">지참</label></div>
                        <div class="flex_yc padding_px-r_025"><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                id="not_bring" data-bd-a-color="#aaaaaa" name="reservation_car_product_check" type="radio"
                                ><label class="pointer padding_px-l_005" for="not_bring">미지참</label></div>
                        <div class="flex_yc "><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                id="partially_bring" data-bd-a-color="#aaaaaa" name="reservation_car_product_check" type="radio"
                                ><label class="pointer padding_px-l_005" for="partially_bring">일부지참</label>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">정비항목</div>
                    <div class="grid_xx padding_px-x_030 padding_px-y_030" data-xx="1fr 1fr 1fr 1fr">
                        <div class="flex_fl_yc padding_px-y_005">
                            <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="reservation_car_maintenance_items_1" name="reservation_car_maintenance_items[]" type="checkbox" value="타이어 위치교환"
                                >
                            <label class="pointer padding_px-l_005" for="reservation_car_maintenance_items_1">타이어 위치교환</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_005">
                            <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="reservation_car_maintenance_items_2" name="reservation_car_maintenance_items[]" type="checkbox" value="기타정비(상세내용기입)"
                                >
                            <label class="pointer padding_px-l_005" for="reservation_car_maintenance_items_2">기타정비(상세내용기입)</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_005">
                            <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="reservation_car_maintenance_items_3" name="reservation_car_maintenance_items[]" type="checkbox" value="디스크교환"
                                >
                            <label class="pointer padding_px-l_005" for="reservation_car_maintenance_items_3">디스크교환</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_005">
                            <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="reservation_car_maintenance_items_4" name="reservation_car_maintenance_items[]" type="checkbox" value="등속조인트"
                                >
                            <label class="pointer padding_px-l_005" for="reservation_car_maintenance_items_4">등속조인트</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_005">
                            <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="reservation_car_maintenance_items_5" name="reservation_car_maintenance_items[]" type="checkbox" value="디퍼런셜 오일"
                                >
                            <label class="pointer padding_px-l_005" for="reservation_car_maintenance_items_5">디퍼런셜 오일</label>
                        </div>
                        <div class="flex_fl_yc padding_px-y_005">
                            <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="reservation_car_maintenance_items_6" name="reservation_car_maintenance_items[]" type="checkbox" value="라이트전구교환"
                                >
                            <label class="pointer padding_px-l_005" for="reservation_car_maintenance_items_6">라이트전구교환</label>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">제목</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                        <input type="text" name="reservation_title" 
                            class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                            data-color="#1c1c1c" data-bd-a-color="#d9d9d9">
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">내용</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                        <textarea name="reservation_contents" 
                            class="width_box height_px_450 padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                            data-color="#1c1c1c" data-bd-a-color="#d9d9d9"></textarea>
                    </div>
                </div>
                <div class="font_style_center padding_px-t_015 padding_px-y_025">
                    <div data-color="#555555">예약취소는 마이페이지 예약확인/취소에서 해주세요.</div>
                    <div data-color="#15376b">당일취소는 불가하니 지점에 직접 요청해주세요.</div>
                </div>
                <div class="flex_xc">
                    <input type="submit"
                        class="check border_px-a_000 width_px_300 height_px_050 margin_x_auto font_px_017 flv6 fontstyle1 font_style_center border_bre-a_004 pointer"
                        data-color="#ffffff" value="예약하기" data-bg-color="#15376b" data-bd-a-color="#15376b">
                </div>
            </form>
        </div>
    </div>
</section>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    input {
        all: unset;
    }

    .check:hover {
        background-color: #09addb;
    }

    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"] {
        outline: none;
    }

    select {
        outline: none;
    }

    select:focus {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
    }

    input[type="checkbox"]:checked {
        display: block;
        width: 14px;
        height: 14px;
        border: 1px solid #15376b;
        border-radius: 4px;
        background: url('<?php echo $background_url; ?>') no-repeat 0 0px / cover;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    textarea:focus {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
        transition: 0.3s;
        z-index: 3;
    }

    [type="radio"] {
        appearance: none;
        border: 1px solid #aaaaaa;
        border-radius: 50%;
        position: relative;
    }

    [type="radio"]::before {
        content: '';
        display: block;
        width: 12px;
        height: 12px;
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
        border-color: #15376b;
    }

    [type="radio"]:checked::before {
        width: 8px;
        height: 8px;
        background-color: #15376b;
    }

    textarea {
        outline: none;
        font-family: fontstyle1;
        resize: none;
    }
</style>
<?php jquery(); ?>
<script nonce="<?php echo NONCE; ?>">
    $(document).ready(function () {
        console.log('Document ready. Event listeners initialized.');

        // 폼 제출 이벤트 핸들러
        $('form').on('submit', function (event) {
            event.preventDefault(); // 기본 폼 제출 동작 방지
            console.log('Form submission intercepted.');

            const formData = $(this).serialize(); // 폼 데이터를 직렬화
            console.log('Serialized Form Data:', formData);

$.ajax({
    url: '<?php echo DOMAIN . "/?post=reservation2_form_input"; ?>',
    type: 'POST',
    data: formData,
    dataType: 'json', // JSON으로 응답을 받음
    success: function (jsonResponse) {
        console.log('Parsed JSON:', jsonResponse);

        if (jsonResponse.success) {
            alert('예약이 성공적으로 완료되었습니다!');
            window.location.href = '<?php echo DOMAIN; ?>/page/reservations_complete';
        } else {
            handleError(jsonResponse.errorCode);
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.error('AJAX request failed.');
        console.error('Status:', textStatus);
        console.error('Error Thrown:', errorThrown);
        alert('서버와의 통신에 실패했습니다. 다시 시도해주세요.');
    }
});


        });

        // 에러 코드에 따른 메시지 처리
        function handleError(errorCode) {
            console.warn('Handling error with code:', errorCode);

            const errorMessages = {
                1: '세션이 만료되었습니다. 다시 로그인 해주세요.',
                2: '예약 연도를 입력해주세요.',
                3: '예약 월을 입력해주세요.',
                4: '예약 일을 입력해주세요.',
                5: '예약 시간을 입력해주세요.',
                6: '예약자 이름을 입력해주세요.',
                7: '예약자 연락처를 입력해주세요.',
                8: '차량 모델명을 입력해주세요.',
                9: '차량 연식을 입력해주세요.',
                10: '차량 번호를 입력해주세요.',
                11: '차량 주행거리를 입력해주세요.',
                12: '차량 차종을 선택해주세요.',
                13: '제품 지참 여부를 선택해주세요.',
                14: '정비 항목을 선택해주세요.',
                15: '예약 제목을 입력해주세요.',
                16: '예약 내용을 입력해주세요.',
                17: '예약 처리 중 오류가 발생했습니다.'
            };

            const message = errorMessages[errorCode] || '알 수 없는 오류가 발생했습니다.';
            console.error('Error Message:', message);
            alert(message);
        }
    });
</script>
