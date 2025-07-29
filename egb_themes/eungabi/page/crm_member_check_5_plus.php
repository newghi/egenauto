<?php
$mentor_id = $_GET['mentor_id'] ?? null;

// mentor_id가 있을 경우 특정 멘토의 멘티 수와 세부 정보를 조회
if ($mentor_id) {
    // 멘티 수를 조회
    $query = "SELECT COUNT(*) as mentee_count FROM auto_user WHERE user_class = :user_class AND user_mentor_id = :mentor_id";
    $params = [
        ':user_class' => 2,
        ':mentor_id' => $mentor_id
    ];
    $binding = binding_sql(1, $query, $params);
    $result = egb_sql($binding);

    // 멘티 세부 정보 조회
    $query2 = "SELECT * FROM auto_user WHERE user_class = :user_class AND user_mentor_id = :mentor_id";
    $params2 = [
        ':user_class' => 2,
        ':mentor_id' => $mentor_id
    ];
    $binding2 = binding_sql(0, $query2, $params2);
    $mentees = egb_sql($binding2);

    // 멘티 수와 세부 정보 출력
    if (isset($result[0]['mentee_count'])) {
        $mentee_count = $result[0]['mentee_count'];
        //echo "Mentor ID: $mentor_id, Total Mentees: $mentee_count<br>";

        foreach ($mentees[0] as $mentee) {
            $mentee_id = $mentee['user_id'];
            $mentee_name = $mentee['user_name'];
            $mentee_points = $mentee['accumulated_points'] ?? '-';
            //echo "&emsp;Mentee ID: $mentee_id, Name: $mentee_name, Accumulated Points: $mentee_points<br>";
        }
    } else {
        //echo "No mentees found for the specified mentor.";
    }
} else {
    // mentor_id가 없을 경우 모든 멘토의 멘티 수와 세부 정보를 조회
    $query = "SELECT user_mentor_id, COUNT(*) as mentee_count FROM auto_user WHERE user_class = :user_class GROUP BY user_mentor_id";
    $params = [
        ':user_class' => 2
    ];
    $binding = binding_sql(0, $query, $params);
    $results = egb_sql($binding);

    // 멘티 수와 세부 정보를 멘토별로 출력
    if (isset($results[0])) {
        foreach ($results[0] as $row) {
            $mentor_id = $row['user_mentor_id'];
            $mentee_count = $row['mentee_count'];
            //echo "Mentor ID: $mentor_id, Total Mentees: $mentee_count<br>";

            // 각 멘토의 멘티 목록 조회
            $query2 = "SELECT * FROM auto_user WHERE user_class = :user_class AND user_mentor_id = :mentor_id";
            $params2 = [
                ':user_class' => 2,
                ':mentor_id' => $mentor_id
            ];
            $binding2 = binding_sql(0, $query2, $params2);
            $mentees = egb_sql($binding2);

            foreach ($mentees[0] as $mentee) {
                $mentee_id = $mentee['user_id'];
                $mentee_name = $mentee['user_name'];
                $mentee_points = $mentee['accumulated_points'] ?? '-';
                //echo "&emsp;Mentee ID: $mentee_id, Name: $mentee_name, Accumulated Points: $mentee_points<br>";
            }
        }
    } else {
        //echo "No mentees found.";
    }
}
?>


<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_check_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-x_010 padding_px-y_020 font_px_016" data-bg-color="#E6E6E5"
            data-xy="1-800: font_px_014">
            <div class="padding_px-x_010">
                <div class="flex_xs1_yc padding_px-u_020"
                    data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                    <div class="font_px_020 flv6">멘토회원관리+</div>
                    <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                        <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                            data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                            <div>CRM</div>
                            <div>></div>
                            <div>회원조회</div>
                            <div>></div>
                            <div class="flv6" data-color="#000000">멘토회원관리+</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid_xx width_px_900 padding_px-u_020 font_px_012" data-xx="1fr 1fr 1fr"
                data-xy="1-550: width_box xx-100per, 551-900: width_box xx-50per~50per">
                <div class="width_box padding_px-a_010">
                    <div class="flex_xs1 border_px-a_002 padding_px-t_006 padding_px-x_005 padding_px-u_040"
                        data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                        <div class="flex_xc_yc width_px_50 height_px_50 border_bre-a_100" data-bg-color="#F1A441">
                            <div class="flex_xc_yc width_px_026 height_px_026 border_bre-a_025 overflow_hidden"
                                data-bg-color="#ffffff">
                                <svg width="16px" height="16px" fill="#f1a441"
                                    id="Layer_2_00000120517509751581745740000011018345030536315564_"
                                    enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="Icon">
                                        <path id="i"
                                            d="m306 186.6c-4.4 35.4-7.8 150.4-6.6 203.5.6 21.6 10.5 40.4 26.5 54.2l-133.8 1.1c19.4-13.3 27.1-32.1 27.7-75.7.5-13.3.5-26.5 1.1-39.8 1.1-22.7 1.1-51.4-.6-75.2-1.6-23.8-9.4-53.1-34.3-61.9zm-92.9-81.3c5.5-27.6 24.9-38.7 48.1-38.7 2.8 0 5.5 0 8.3.6 28.2 3.9 45.9 22.1 42 50.9-3.9 29.9-23.8 40.9-47.5 40.9-2.8 0-6.1 0-8.9-.6-27.6-2.8-48-21.5-42-53.1z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="flex_xr" data-color="#aaaaaa">추천인정보</div>
                            <div class="flex_xr padding_px-t_010 font_px_018 flv6"><?php echo $mentor_id; ?></div>
                        </div>
                    </div>
                </div>
                <div class="width_box padding_px-a_010">
                    <div class="flex_xs1 border_px-a_002 padding_px-t_006 padding_px-x_005 padding_px-u_040"
                        data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                        <div class="flex_xc_yc width_px_50 height_px_50 border_bre-a_100" data-bg-color="#3579CE">
                            <!DOCTYPE svg
                                PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                            <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="26px" height="26px"
                                viewBox="0 0 80.13 80.13" style="enable-background:new 0 0 80.13 80.13;"
                                xml:space="preserve">
                                <g>
                                    <path d="M48.355,17.922c3.705,2.323,6.303,6.254,6.776,10.817c1.511,0.706,3.188,1.112,4.966,1.112
        c6.491,0,11.752-5.261,11.752-11.751c0-6.491-5.261-11.752-11.752-11.752C53.668,6.35,48.453,11.517,48.355,17.922z M40.656,41.984
        c6.491,0,11.752-5.262,11.752-11.752s-5.262-11.751-11.752-11.751c-6.49,0-11.754,5.262-11.754,11.752S34.166,41.984,40.656,41.984
        z M45.641,42.785h-9.972c-8.297,0-15.047,6.751-15.047,15.048v12.195l0.031,0.191l0.84,0.263
        c7.918,2.474,14.797,3.299,20.459,3.299c11.059,0,17.469-3.153,17.864-3.354l0.785-0.397h0.084V57.833
        C60.688,49.536,53.938,42.785,45.641,42.785z M65.084,30.653h-9.895c-0.107,3.959-1.797,7.524-4.47,10.088
        c7.375,2.193,12.771,9.032,12.771,17.11v3.758c9.77-0.358,15.4-3.127,15.771-3.313l0.785-0.398h0.084V45.699
        C80.13,37.403,73.38,30.653,65.084,30.653z M20.035,29.853c2.299,0,4.438-0.671,6.25-1.814c0.576-3.757,2.59-7.04,5.467-9.276
        c0.012-0.22,0.033-0.438,0.033-0.66c0-6.491-5.262-11.752-11.75-11.752c-6.492,0-11.752,5.261-11.752,11.752
        C8.283,24.591,13.543,29.853,20.035,29.853z M30.589,40.741c-2.66-2.551-4.344-6.097-4.467-10.032
        c-0.367-0.027-0.73-0.056-1.104-0.056h-9.971C6.75,30.653,0,37.403,0,45.699v12.197l0.031,0.188l0.84,0.265
        c6.352,1.983,12.021,2.897,16.945,3.185v-3.683C17.818,49.773,23.212,42.936,30.589,40.741z" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <div class="flex_xr" data-color="#aaaaaa">총추천수</div>
                            <div class="flex_xr padding_px-t_010 font_px_018 flv6"><?php echo $mentee_count; ?></div>
                        </div>
                    </div>
                </div>
                <div class="width_box padding_px-a_010">
                    <div class="flex_xs1 border_px-a_002 padding_px-t_006 padding_px-x_005 padding_px-u_040"
                        data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                        <div class="flex_xc_yc width_px_50 height_px_50 border_bre-a_100" data-bg-color="#DB5850">
                            <svg width="26px" height="26px" fill="#ffffff" id="glyph" viewBox="0 0 64 64" fill="#ffffff"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m57.591 31.122h-4.245l1.285-4.476h2.96a2.409 2.409 0 1 0 0-4.817h-1.585l2.7-9.423a2.417 2.417 0 0 0 -4.646-1.335l-3.072 10.758h-13.188l-3-10.517a2.925 2.925 0 0 0 -5.6 0l-3 10.517h-13.188l-3.081-10.758a2.412 2.412 0 0 0 -4.631 1.335l2.7 9.423h-1.591a2.409 2.409 0 0 0 0 4.817h2.96l1.285 4.476h-4.245a2.409 2.409 0 0 0 0 4.818h5.61l4.787 16.719a2.924 2.924 0 0 0 5.6 0l4.777-16.719h9.634l4.777 16.719a2.872 2.872 0 0 0 2.8 2.108 2.9 2.9 0 0 0 2.81-2.108l4.777-16.719h5.61a2.409 2.409 0 0 0 0-4.818zm-37.985 13.79-2.569-8.972h5.138zm3.944-13.79h-7.888l-1.275-4.476h10.437zm8.45-12.063.793 2.77h-1.586zm-3.452 12.063 1.284-4.476h4.336l1.284 4.476zm15.846 13.79-2.569-8.972h5.138zm3.944-13.79h-7.888l-1.274-4.476h10.437z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex_xr" data-color="#aaaaaa">총적립금</div>
                            <div class="flex_xr padding_px-t_010 font_px_018 flv6">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="padding_px-x_010">
                <div class="font_px_020 flv6 padding_px-y_020">피추천인 목록</div>
            </div>
            <div class="padding_px-x_010">
                <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                    data-xy="1-800: font_px_014">
                    <!--<div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                        <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                            data-xy="1-800: flex_ft font_px_012">
                            <div class="" data-color="#888888">총&nbsp;회원수&nbsp;<span class="flv6"
                                    data-color="#15376b">58,828</span>명&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                    data-color="#15376b">3</span>명
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
                                name="" id="" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                                <option value="30개씩 보기">30개씩 보기</option>
                                <option value="30개씩 보기">20개씩 보기</option>
                                <option value="30개씩 보기">10개씩 보기</option>
                            </select>
                        </div>
                    </div>-->
                    <div class="height_px_044" data-bg-color="#ffffff"></div>
                    <div class="scrolls width_box overflow_hidden">
                        <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                            <div class="grid_xx border_px-u_001 flv6" data-xx="10% 15% 13% 17% 14% 14% 17%"
                                data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">No
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">아이디
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">이름
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">누적
                                    적립금
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">총
                                    피추천인수
                                </div>
                                <div class="flex_ft_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">
                                    <p>피추천인</p>
                                    <p>총 주문건수</p>
                                </div>
                                <div class="flex_ft_yc padding_px-y_010" data-bd-a-color="#d9d9d9">
                                    <p>피추천인</p>
                                    <p>총 실제금액</p>
                                </div>
                            </div>
<?php

$index = 1;

// 멘토회원 목록과 피추천인 수 출력
foreach ($mentees[0] as $mentee) {
    $mentor_id = $mentee['user_id'];
    $mentor_name = $mentee['user_name'];
    $mentor_accumulated_points = $mentee['accumulated_points'] ?? '-';
    $total_recommendees = isset($recommendee_count[$mentor_id]) ? $recommendee_count[$mentor_id] : '-';
?>
	<div class="grid_xx border_px-u_001" data-xx="10% 15% 13% 17% 14% 14% 17%"
		data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
		<div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9"><?php echo $index; ?></div>
		<div class="flex_ft_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">
			<div class="padding_px-u_005"><?php echo $mentor_id; ?></div>
			<div class="font_px_010 padding_px-x_008 padding_px-y_005 pointer"
				data-bg-color="#777777" data-color="#ffffff" data-hover-bg-color="#444444">회원상세
			</div>
		</div>
		<div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9"><?php echo $mentor_name; ?>
		</div>
		<div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">-
		</div>
		<div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">-</div>
		<div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">-</div>
		<div class="flex_xc_yc padding_px-y_010" data-bd-a-color="#d9d9d9">-
		</div>
	</div>
<?php
$index++;
    //echo "Mentor ID: $mentor_id, Name: $mentor_name, Accumulated Points: $mentor_accumulated_points, Total Recommendees: $total_recommendees<br>";
}

?>
<!--
                            <div class="grid_xx border_px-u_001" data-xx="10% 15% 13% 17% 14% 14% 17%"
                                data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">2
                                </div>
                                <div class="flex_ft_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">
                                    <div class="padding_px-u_005">katarinabluu</div>
                                    <div class="font_px_010 padding_px-x_008 padding_px-y_005 pointer"
                                        data-bg-color="#777777" data-color="#ffffff" data-hover-bg-color="#444444">회원상세
                                    </div>
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">유지민
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">947,800
                                </div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">1</div>
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_010" data-bd-a-color="#d9d9d9">1</div>
                                <div class="flex_xc_yc padding_px-y_010" data-bd-a-color="#d9d9d9">947,800
                                </div>
                            </div>
-->
                        </div>
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
    .check_5_plus {
        background-color: #e6e6e5;
        color: #15376b;
        font-weight: 600;
    }

    .crm_member_check_color {
        background-color: #15376b;
    }

    .crm_member_check_5_bg {
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