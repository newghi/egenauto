<?php
// GET 요청으로 필터 값을 받습니다. 값이 없으면 빈 문자열로 초기화합니다.
$event_keyword = isset($_GET['event_keyword']) ? trim($_GET['event_keyword']) : '';
$event_status = isset($_GET['event_status']) ? $_GET['event_status'] : 'all';
$event_category = isset($_GET['event_category']) ? $_GET['event_category'] : 'all';
$event_type = isset($_GET['event_type']) ? $_GET['event_type'] : 'all';
$event_reward_type = isset($_GET['event_reward_type']) ? $_GET['event_reward_type'] : 'all';
$date_type = isset($_GET['date_type']) ? $_GET['date_type'] : 'created_at';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'created_at';
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 30;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 날짜 범위 설정
$start_year = isset($_GET['start_year']) ? $_GET['start_year'] : date('Y', strtotime('-1 month'));
$start_month = isset($_GET['start_month']) ? $_GET['start_month'] : date('n', strtotime('-1 month')); 
$start_day = isset($_GET['start_day']) ? $_GET['start_day'] : date('j', strtotime('-1 month'));

$end_year = isset($_GET['end_year']) ? $_GET['end_year'] : date('Y');
$end_month = isset($_GET['end_month']) ? $_GET['end_month'] : date('n');
$end_day = isset($_GET['end_day']) ? $_GET['end_day'] : date('j');

// 날짜 문자열 생성 (2자리 숫자로 포맷팅)
$start_date_str = sprintf('%04d.%02d.%02d', $start_year, $start_month, $start_day);
$end_date_str = sprintf('%04d.%02d.%02d', $end_year, $end_month, $end_day);

// 기본 쿼리 구성 - 구독료할인 이벤트만 조회
$query = "SELECT * FROM auto_event WHERE deleted_at IS NULL AND event_category = '구독료할인'";
$params = [];

// 검색어 조건 추가 (이벤트명과 키워드 검색)
if (!empty($event_keyword)) {
    $query .= " AND (event_name LIKE :keyword OR event_keyword LIKE :keyword)";
    $params[':keyword'] = '%' . $event_keyword . '%';
}

if ($event_status !== 'all') {
    $query .= " AND event_status = :status";
    $params[':status'] = $event_status;
}

if ($event_type !== 'all') {
    $query .= " AND event_type = :type";
    $params[':type'] = $event_type;
}

if ($event_reward_type !== 'all') {
    $query .= " AND event_reward_type = :reward_type";
    $params[':reward_type'] = $event_reward_type;
}

if ($start_date_str && $end_date_str) {
    $query .= " AND DATE({$date_type}) BETWEEN STR_TO_DATE(:start_date, '%Y.%m.%d') AND STR_TO_DATE(:end_date, '%Y.%m.%d')";
    $params[':start_date'] = $start_date_str;
    $params[':end_date'] = $end_date_str;
}

// 전체 개수 조회
$count_query = str_replace("SELECT *", "SELECT COUNT(*) as count", $query);
$binding = binding_sql(0, $count_query, $params);
$count_result = egb_sql($binding);
$total_count = isset($count_result[0][0]['count']) ? (int)$count_result[0][0]['count'] : 0;

// 페이징 적용
$offset = ($page - 1) * $per_page;
$query .= " ORDER BY {$sort_by} DESC LIMIT :offset, :per_page";
$params[':offset'] = (int)$offset;
$params[':per_page'] = (int)$per_page;

// 최종 쿼리 실행
$binding = binding_sql(0, $query, $params);
$results = egb_sql($binding);
$event_list = isset($results[0]) && is_array($results[0]) ? $results[0] : [];
$search_count = count($event_list);

require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php';
?>

<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_event_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020 "
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">진행내역</div>
                <div class="flex_xc" data-xy="1-800: flex_xr">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>이벤트</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">구독료할인이벤트</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;이벤트&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $total_count; ?></span>건&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $search_count; ?></span>건
                        </div>
                    </div>
                    <div class="flex_fl_yc">
                        <div class="padding_px-r_010 padding_px-t_000"
                            data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                            <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                                name="sort_by" id="sort_by" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                                <option value="created_at" <?php echo ($sort_by === 'created_at') ? 'selected' : ''; ?>>등록일</option>
                                <option value="event_start" <?php echo ($sort_by === 'event_start') ? 'selected' : ''; ?>>시작일</option>
                                <option value="event_end" <?php echo ($sort_by === 'event_end') ? 'selected' : ''; ?>>종료일</option>
                            </select>
                        </div>
                        <div class="padding_px-r_010 padding_px-t_000"
                            data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                            <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                                name="per_page" id="per_page" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                                <option value="30" <?php echo ($per_page === 30) ? 'selected' : ''; ?>>30개씩 보기</option>
                                <option value="20" <?php echo ($per_page === 20) ? 'selected' : ''; ?>>20개씩 보기</option>
                                <option value="10" <?php echo ($per_page === 10) ? 'selected' : ''; ?>>10개씩 보기</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 15% 12% 10% 15% 9% 15% 9% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_event_three_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox" name=""
                                    id="crm_searching_member_event_three_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이벤트명</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">리워드 유형</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">진행상태</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">진행기간</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등록자</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">등록일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">참여내역관리</div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <?php foreach($event_list as $index => $event): ?>
                        <form class="" id="egb_auto_event_list_input_<?php echo $event['uniq_id']; ?>" action="<?php echo DOMAIN . '/?post=auto_event_participation_list_fomr_input'; ?>" method="post" enctype="multipart/form-data">
                        <div class="grid_xx border_px-u_001 egb_submit" data-xx="5% 5% 15% 12% 10% 15% 9% 15% 9% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <input type="hidden" name="event_uniq_id" value="<?php echo $event['uniq_id']; ?>">
                            <label for="crm_searching_member_event_three_<?php echo $index+1; ?>"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 px_height_020" type="checkbox" name="selected_event"
                                    value="<?php echo $event['uniq_id']; ?>"
                                    id="crm_searching_member_event_three_<?php echo $index+1; ?>" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $index+1; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $event['event_name']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $event['event_reward_type']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $event['event_status']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                                <?php echo date('Y.n.j', strtotime($event['event_start'])); ?>~<?php echo date('Y.n.j', strtotime($event['event_end'])); ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo $event['created_by']; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9"><?php echo date('Y.n.j', strtotime($event['created_at'])); ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9"
                                data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                            <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9"
                                data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                        </div>
                        </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="flex_xs1_yc padding_px-y_020 "
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">구독료할인</div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;<span class="flv6"
                                data-color="#15376b"></span>건&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span class="flv6"
                                data-color="#15376b"></span>건
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
                    <div class="flex_fl_yc">
                        <div class="padding_px-r_010 padding_px-t_000"
                            data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                            <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                                name="" id="" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                                <option value="30개씩 보기">30개씩 보기</option>
                                <option value="20개씩 보기">20개씩 보기</option>
                                <option value="10개씩 보기">10개씩 보기</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden list_scroll">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 15% 10% 20% 20% 11% 9% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label class="flex_xc border_px-r_001 padding_px-y_015 pointer">
                                <input class="border_px-a_001 width_px_020 px_height_020" type="checkbox">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015">No</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015">회원등급명</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015">회원수</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015">연간구독료</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015">할인금액</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015">상태</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015">등록자</div>
                            <div class="flex_xc padding_px-y_015">상세</div>
                        </div>
                        <div class="grid_xx border_px-u_001" data-xx="5% 5% 15% 10% 20% 20% 11% 9% 5%" data-bd-a-color="#d9d9d9">
                            <div class="flex_xc padding_px-y_015 text-center" style="grid-column: 1/-1">이벤트를 선택해주세요</div>
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
    .crm_member_event_color {
        background-color: #15376b;
    }

    .crm_member_event_2_bg {
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