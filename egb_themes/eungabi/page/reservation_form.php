


<?php


if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    $user_login = 'user';
}

if (isset($user_login)) {
    $login_user_uniq_id = $_SESSION['user_uniq_id'];
} else {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/login' . "'; </script>";
    exit;
}

$store_uniq_id = egb('store');
$selected_date = egb('selected_date');
$selected_times = egb('selected_times');

// user_uniq_id 가져오기
$user_uniq_id = $_SESSION['user_uniq_id'];

// 사용자 정보 조회 쿼리
$query = "SELECT * FROM egb_user WHERE uniq_id = :user_uniq_id";
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

// 스토어 정보 조회
$store_query = "SELECT * FROM egb_store WHERE uniq_id = :store_uniq_id";
$store_params = [
    ':store_uniq_id' => $store_uniq_id
];

$store_binding = binding_sql(1, $store_query, $store_params);
$store_result = egb_sql($store_binding);

if (!isset($store_result[0])) {
    echo "<script nonce=".NONCE." type='text/javascript'>alert('존재하지 않는 매장입니다.'); history.back();</script>"; 
    exit;
}

$store_info = $store_result[0];

?>

<section class="position1 width_box">
    <div class="width_px_1220 margin_x_auto">
        <div class="padding_px-x_010">
            <div class="padding_px-y_025">
                <div class="padding_px-u_040 font_px_024 flv6 border_px-u_001">예약하기</div>
            </div>
            <div class="font_style_center font_px_024 padding_px-y_015">정비예약</div>
            <form class="padding_px-t_025 padding_px-u_100 font_px_014" method="post" enctype="multipart/form-data" action="<?php echo DOMAIN; ?>/?post=reservation_form_input" data-color="#1c1c1c">
                <div class="grid_xx border_px-t_001 border_px-u_001" data-bd-t-color="#c9c9c9" data-bd-u-color="#d9d9d9"
                    data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">예약가맹점</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030"><?php echo $store_info['store_name']; ?></div>
                    <input type="hidden" name="store_uniq_id" value="<?php echo $store_uniq_id; ?>" >
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" >
                </div>
                <?php
                // Parse selected date into year, month, day
                $date_parts = explode('-', $selected_date);
                $year = $date_parts[0];
                $month = $date_parts[1];
                $day = $date_parts[2];

                // Parse selected times
                $selectedTimes = explode(',', $selected_times);
                ?>
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
                    <input type="hidden" name="reservation_year" value="<?php echo $year; ?>" >
                    <input type="hidden" name="reservation_month" value="<?php echo $month; ?>" >
                    <input type="hidden" name="reservation_day" value="<?php echo $day; ?>" >
                    <input type="hidden" name="reservation_times" value="<?php echo htmlspecialchars(json_encode($selectedTimes), ENT_QUOTES, 'UTF-8'); ?>" >
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="50% 50%">
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">예약자성함</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_030"><?php echo $user_info['user_name']; ?></div>
						<input type="hidden" name="reservation_user_name" value="<?php echo $user_info['user_name']; ?>" >
                    </div>
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">연락처</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="tel" name="reservation_user_phone_number" required
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9" value="<?php echo $user_info['user_phone1']; ?>" 
                                placeholder="예: 010-1234-5678" pattern="[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}" maxlength="13">
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="50% 50%">
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">차량모델명</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_car_model" required
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9" placeholder="예: 아반떼, 소나타" 
                                pattern="[가-힣a-zA-Z0-9\s]+" maxlength="50">
                        </div>
                    </div>
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">연식</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <div class="flex_fl_yc width_box">
                                <input type="number" name="reservation_car_model_year" required
                                    class="flex_ft width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                    data-color="#1c1c1c" data-bd-a-color="#d9d9d9" placeholder="예: 2020" 
                                    min="1900" max="<?php echo date('Y') + 1; ?>" step="1">
                                <div class="flex_xc_yc padding_px-x_010 font_px_014 width_px_060" data-color="#666666">연식</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="50% 50%">
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">차량번호</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_car_number" required
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9" placeholder="예: 12가3456" 
                                pattern="[0-9]{2,3}[가-힣][0-9]{4}" maxlength="8">
                        </div>
                    </div>
                    <div class="grid_xx" data-xx="36% 64%">
                        <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">주행거리</div>
                        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <div class="flex_fl_yc width_box">
                                <input type="number" name="reservation_car_mileage" required
                                    class="flex_ft width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                    data-color="#1c1c1c" data-bd-a-color="#d9d9d9" placeholder="예: 50000" 
                                    min="0" max="999999" step="1">
                                <div class="flex_xc_yc padding_px-x_010 font_px_014 width_px_060" data-color="#666666">KM</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">업종선택</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030">
                        <div class="flex_yc padding_px-r_025"><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                data-bd-a-color="#aaaaaa" id="domestic_car" name="reservation_car_type" type="radio" value="국산차"
                                ><label class="pointer padding_px-l_005" for="domestic_car">국산차</label></div>
                        <div class="flex_yc "><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                id="imported_car" data-bd-a-color="#aaaaaa" name="reservation_car_type" type="radio" value="수입차"
                                ><label class="pointer padding_px-l_005" for="imported_car">수입차</label>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">제품</div>
                    <div class="flex_fl_yc padding_px-x_030 padding_px-y_030">
                        <div class="flex_yc padding_px-r_025"><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004" id="bring"
                                data-bd-a-color="#aaaaaa" name="reservation_car_product_check" type="radio" value="지참" ><label
                                class="pointer padding_px-l_005" for="bring">지참</label></div>
                        <div class="flex_yc padding_px-r_025"><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                id="not_bring" data-bd-a-color="#aaaaaa" name="reservation_car_product_check" type="radio" value="미지참"
                                ><label class="pointer padding_px-l_005" for="not_bring">미지참</label></div>
                        <div class="flex_yc "><input
                                class="pointer width_px_012 height_px_012 border_px-a_001 border_bre-a_004"
                                id="partially_bring" data-bd-a-color="#aaaaaa" name="reservation_car_product_check" type="radio" value="일부지참"
                                ><label class="pointer padding_px-l_005" for="partially_bring">일부지참</label>
                        </div>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">정비항목</div>
                    <div class="grid_xx padding_px-x_030 padding_px-y_030" data-xx="1fr 1fr 1fr 1fr">
                        <?php
                        // 옵션 그룹 조회
                        $tree = egb_option_flat('reservation_manual_item');

                        if (!empty($tree)) {
                            $i = 1;
                            foreach ($tree as $option) {
                                ?>
                                <div class="flex_fl_yc padding_px-y_005">
                                    <input class="pointer width_px_014 height_px_014 border_px-a_001 border_bre-a_004"
                                        data-bd-a-color="#aaaaaa" 
                                        id="reservation_car_maintenance_items_<?php echo $i; ?>" 
                                        name="reservation_car_maintenance_items[]" 
                                        type="checkbox" 
                                        value="<?php echo $option['uniq_id']; ?>"
                                        >
                                    <label class="pointer padding_px-l_005" 
                                        for="reservation_car_maintenance_items_<?php echo $i; ?>">
                                        <?php echo $option['label']; ?>
                                    </label>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">제목</div>
                                            <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <input type="text" name="reservation_title" required
                                class="width_box padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9" placeholder="예약 제목을 입력해주세요" 
                                maxlength="100">
                        </div>
                </div>
                <div class="grid_xx border_px-u_001" data-bd-u-color="#d9d9d9" data-xx="18% 82%">
                    <div class="flex_xc_yc padding_px-y_030" data-bg-color="#f4f4f4">내용</div>
                                            <div class="flex_fl_yc padding_px-x_030 padding_px-y_015">
                            <textarea name="reservation_contents" required
                                class="width_box height_px_450 padding_px-y_010 padding_px-x_010 fontstyle1 font_px_014 border_px-a_001 border_bre-a_006"
                                data-color="#1c1c1c" data-bd-a-color="#d9d9d9" placeholder="정비 내용이나 특이사항을 입력해주세요" 
                                maxlength="1000"></textarea>
                        </div>
                </div>
                <div class="font_style_center padding_px-t_015 padding_px-y_025">
                    <div data-color="#555555">예약취소는 마이페이지 예약확인/취소에서 해주세요.</div>
                    <div data-color="#15376b">당일취소는 불가하니 지점에 직접 요청해주세요.</div>
                </div>
                <div class="flex_xc">
                    <input type="submit" id="reservation_submit"
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


