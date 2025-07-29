<?php
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 30;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $itemsPerPage;

// 검색 파라미터 가져오기
$search_type = isset($_GET['select_option']) ? $_GET['select_option'] : '';
$search_value = isset($_GET['option_input']) ? $_GET['option_input'] : '';
$menti_count = isset($_GET['menti_count']) ? $_GET['menti_count'] : '';
$menti_count_check = isset($_GET['menti_count_check']) ? $_GET['menti_count_check'] : '이상';

// 페이지네이션에 표시할 링크 수를 정의
$num_links = 5;

// 기본 쿼리 작성
$baseQuery = "FROM auto_user u 
              LEFT JOIN (
                SELECT user_mentor_id, COUNT(*) as mentee_count 
                FROM auto_user 
                WHERE user_class = 2 
                GROUP BY user_mentor_id
              ) m ON u.user_id = m.user_mentor_id 
              WHERE u.user_class = 3";

// 검색 조건 추가
$searchParams = [];
if($search_type && $search_value) {
    switch($search_type) {
        case '아이디':
            $baseQuery .= " AND u.user_id LIKE :search_value";
            $searchParams[':search_value'] = "%$search_value%";
            break;
        case '이름':
            $baseQuery .= " AND u.user_name LIKE :search_value";
            $searchParams[':search_value'] = "%$search_value%";
            break;
    }
}

if($menti_count !== '') {
    if($menti_count_check === '이상') {
        $baseQuery .= " AND COALESCE(m.mentee_count, 0) >= :menti_count";
    } else {
        $baseQuery .= " AND COALESCE(m.mentee_count, 0) <= :menti_count";
    }
    $searchParams[':menti_count'] = (int)$menti_count;
}

// 전체 회원 수 조회
$totalQuery = "SELECT COUNT(*) as total FROM auto_user";
$totalBinding = binding_sql(1, $totalQuery, []);
$totalResult = egb_sql($totalBinding);
$totalCount2 = $totalResult[0]['total'];

// 필터링된 멘토 회원 수 조회
$countQuery = "SELECT COUNT(*) as total " . $baseQuery;
$countBinding = binding_sql(1, $countQuery, $searchParams);
$countResult = egb_sql($countBinding);
$totalCount1 = $countResult[0]['total'];

// 멘토 회원 목록 조회
$query = "SELECT u.*, COALESCE(m.mentee_count, 0) as total_mentees " . $baseQuery . 
         " ORDER BY total_mentees DESC LIMIT :offset, :limit";
$params = array_merge($searchParams, [
    ':offset' => $offset,
    ':limit' => $itemsPerPage
]);

$binding = binding_sql(0, $query, $params);
$mentors = egb_sql($binding);

$total_pages = ceil($totalCount1 / $itemsPerPage);
?>

<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_check_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">멘토회원관리</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원조회</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">멘토회원관리</div>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 font_px_016" data-bg-color="#ffffff" data-bd-a-color="#d9d9d9"
                data-xy="1-800: font_px_014">
                <div class="flex_ft border_px-l_005 padding_px-y_010 font_px_013" data-bg-color="#ffffff"
                    data-bd-a-color="#333333">
                    <div class="flex_fl">
                        <span class="min_width_024 min_height_025 max_width_024 max_height_025 padding_px-x_005">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g>
                                    <path fill="#424242"
                                        d="m54.18 3.002-31.922 38.79L8.846 28.743 0 38.342l23.294 22.656L64 11.534z"
                                        opacity="1" data-original="#ff3d2e"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="flex_yc padding_px-r_005">멘토는 멘티가 회원가입 또는 회원정보 수정 시 추천인 아이디로 기입한 아이디 당사자를
                            지칭합니다.</span>
                    </div>
                    <div class="flex_fl">
                        <span class="min_width_024 min_height_025 max_width_024 max_height_025 padding_px-x_005">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g>
                                    <path fill="#424242"
                                        d="m54.18 3.002-31.922 38.79L8.846 28.743 0 38.342l23.294 22.656L64 11.534z"
                                        opacity="1" data-original="#ff3d2e"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="flex_yc padding_px-r_005">멘토 리스트는 멘티회원수가 1 이상인 회원만 노출이 됩니다.</span>
                    </div>
                    <div class="flex_fl">
                        <span class="min_width_024 min_height_025 max_width_024 max_height_025 padding_px-x_005">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g>
                                    <path fill="#424242"
                                        d="m54.18 3.002-31.922 38.79L8.846 28.743 0 38.342l23.294 22.656L64 11.534z"
                                        opacity="1" data-original="#ff3d2e"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="flex_yc padding_px-r_005">멘티 총 추천 횟수, 멘티 총 주문건수, 멘티 총 실결제금액은 멘토를 추천한 합산
                            데이터입니다.</span>
                    </div>
                </div>
            </div>
            <div class="width_box border_px-a_002 margin_px-t_025 font_px_016" data-bg-color="#ffffff"
                data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
                <form id="searchForm" method="GET">
                    <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                        <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: padding_px-y_010 padding_px-l_010">검색어</div>
                        <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                            <div>
                                <select
                                    class="width_px_200 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001 emailbox"
                                    data-bd-a-color="#888888" name="select_option" id="select_option"
                                    data-xy="1-800: width_box font_px_012">
                                    <option value="" <?php echo !$search_type ? 'selected' : ''; ?>>선택하세요</option>
                                    <option value="아이디" <?php echo $search_type === '아이디' ? 'selected' : ''; ?>>아이디</option>
                                    <option value="이름" <?php echo $search_type === '이름' ? 'selected' : ''; ?>>이름</option>
                                </select>
                            </div>
                            <div class="width_px_020"></div>
                            <div class="" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                                <input class="width_px_200 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001"
                                    data-bd-a-color="#888888" type="text" name="option_input" id="option_input"
                                    value="<?php echo htmlspecialchars($search_value); ?>"
                                    data-xy="1-800: width_box font_px_012">
                            </div>
                        </div>
                    </div>
                    <div class="flex_fl width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                        <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                            data-xy="1-800: padding_px-y_010 padding_px-l_010">추천수</div>
                        <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                            <div class="" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                                <input
                                    class="width_px_080 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001 font_style_right"
                                    data-bd-a-color="#888888" type="text" name="menti_count" id="menti_count"
                                    value="<?php echo htmlspecialchars($menti_count); ?>"
                                    data-xy="1-800: width_box font_px_012">
                            </div>
                            <div class="width_px_020"></div>
                            <div>
                                <select
                                    class="width_px_080 padding_px-y_008 padding_px-x_015 font_px_014 border_px-a_001 emailbox"
                                    data-bd-a-color="#888888" name="menti_count_check" id="menti_count_check"
                                    data-xy="1-800: width_box font_px_012">
                                    <option value="이상" <?php echo $menti_count_check === '이상' ? 'selected' : ''; ?>>이상</option>
                                    <option value="이하" <?php echo $menti_count_check === '이하' ? 'selected' : ''; ?>>이하</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span id="egen_search">검색하기</span>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">멘토회원조회 결과</div>
            <div class="width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                data-xy="1-800: font_px_014">
                <div class="flex_xs1_yc" data-xy="1-800: flex_fu">
                    <div class="flex_fl_yc padding_px-y_010 padding_px-x_015 font_px_014"
                        data-xy="1-800: flex_ft font_px_012">
                        <div class="" data-color="#888888">총&nbsp;회원수&nbsp;<span class="flv6"
                                data-color="#15376b"><?php echo $totalCount2; ?></span>명&nbsp;중&nbsp;검색&nbsp;결과&nbsp;<span
                                class="flv6" data-color="#15376b"><?php echo $totalCount1; ?></span>명
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
                    <div class="padding_px-r_010 padding_px-t_000" data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                        <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                                name="egen_search_view_count" id="egen_search_view_count" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                            <option value="30" <?php echo ($itemsPerPage == 30) ? 'selected' : ''; ?>>30개씩 보기</option>
                            <option value="20" <?php echo ($itemsPerPage == 20) ? 'selected' : ''; ?>>20개씩 보기</option>
                            <option value="10" <?php echo ($itemsPerPage == 10) ? 'selected' : ''; ?>>10개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="8% 14% 12% 15% 13% 13% 15% 10%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No</div>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디</div>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이름</div>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">누적 적립금</div>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">총 피추천인수</div>
                            <div class="flex_ft_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                                <p>피추천인</p>
                                <p>총 주문건수</p>
                            </div>
                            <div class="flex_ft_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                                <p>피추천인</p>
                                <p>총 실제금액</p>
                            </div>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">멘토회원 상세</div>
                        </div>

                        <?php
                        if(isset($mentors[0]) && !empty($mentors[0])) {
                            $counter = $offset + 1;
                            foreach($mentors[0] as $mentor) {
                                echo "<div class='grid_xx border_px-u_001' data-xx='8% 14% 12% 15% 13% 13% 15% 10%' data-bd-a-color='#d9d9d9' data-bg-color='#ffffff'>";
                                echo "    <div class='flex_xc_yc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>{$counter}</div>";
                                echo "    <div class='flex_xc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>{$mentor['user_id']}</div>";
                                echo "    <div class='flex_xc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>{$mentor['user_name']}</div>";
                                echo "    <div class='flex_xc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>{$mentor['accumulated_points']}</div>";
                                echo "    <div class='flex_xc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>{$mentor['total_mentees']}</div>";
                                echo "    <div class='flex_xc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>-</div>";
                                echo "    <div class='flex_xc border_px-r_001 padding_px-y_015' data-bd-a-color='#d9d9d9'>-</div>";
                                echo "    <a class='flex_xc_yc width_box' href='" . DOMAIN . "/page/crm_member_check_5_plus/?mentor_id={$mentor['user_id']}'>";
                                echo "        <div class='flex_xc_yc width_box padding_px-y_015 pointer' data-bd-a-color='#d9d9d9' data-hover-bg-color='#15376b' data-hover-color='#ffffff'>멘토회원 상세</div>";
                                echo "    </a>";
                                echo "</div>";
                                $counter++;
                            }
                        } else {
                            echo "<div class='flex_xc_yc padding_px-y_030'>검색 결과가 없습니다.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="padding_px-u_060"></div>
            <div class="flex_xc_yc width_box font_px_015 padding_px-u_030" data-xy="1-700: font_px_010"
                data-color="#666666">
                <?php
                // 페이지네이션 로직
                $start = max(1, min($current_page - floor($num_links / 2), $total_pages - $num_links + 1));
                $end = min($start + $num_links - 1, $total_pages);

                // 이전 페이지 버튼
                $prev_page = max(1, $current_page - 1);
                echo "<a href='?page={$prev_page}&select_option={$search_type}&option_input={$search_value}&menti_count={$menti_count}&menti_count_check={$menti_count_check}&itemsPerPage={$itemsPerPage}' class='padding_px-y_010 padding_px-x_005 pointer'>";
                echo "<div class='pointer border_px-a_001 width_px_040 height_px_040 flex_xc_yc hovernumber' data-bd-a-color='#ffffff' data-xy='1-700: height_px_030 width_px_030'>＜</div>";
                echo "</a>";

                // 페이지 번호
                for($i = $start; $i <= $end; $i++) {
                    $active = ($current_page == $i) ? 'choicenumber' : '';
                    echo "<a href='?page={$i}&select_option={$search_type}&option_input={$search_value}&menti_count={$menti_count}&menti_count_check={$menti_count_check}&itemsPerPage={$itemsPerPage}' class='padding_px-y_010 padding_px-x_005 pointer'>";
                    echo "<div class='pointer border_px-a_001 width_px_040 height_px_040 flex_xc_yc hovernumber {$active}' data-bd-a-color='#ffffff' data-xy='1-700: height_px_030 width_px_030'>{$i}</div>";
                    echo "</a>";
                }

                // 다음 페이지 버튼
                $next_page = min($total_pages, $current_page + 1);
                echo "<a href='?page={$next_page}&select_option={$search_type}&option_input={$search_value}&menti_count={$menti_count}&menti_count_check={$menti_count_check}&itemsPerPage={$itemsPerPage}' class='padding_px-y_010 padding_px-x_005 pointer'>";
                echo "<div class='pointer border_px-a_001 width_px_040 height_px_040 flex_xc_yc hovernumber' data-bd-a-color='#ffffff' data-xy='1-700: height_px_030 width_px_030'>＞</div>";
                echo "</a>";
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
    }
</style>

<script nonce="<?php echo NONCE; ?>">
    document.addEventListener('DOMContentLoaded', function() {
        // 검색 버튼 클릭 이벤트 
        document.getElementById('egen_search').addEventListener('click', function(e) {
            e.preventDefault();

            // 각 필드 값을 가져옵니다
            const search_keyword = document.querySelector('input[name="search_keyword"]')?.value.trim() || '';
            const recommend_count = document.querySelector('input[name="recommend_count"]')?.value.trim() || '';
            const viewCount = document.getElementById('egen_search_view_count')?.value || '30';

            // URL 쿼리 스트링을 생성합니다
            const queryParams = new URLSearchParams(window.location.search);

            // 기존 파라미터 유지하면서 새로운 값 설정
            queryParams.set('search_keyword', search_keyword);
            queryParams.set('recommend_count', recommend_count);
            queryParams.set('egen_search_view_count', viewCount);

            // 빈 값인 파라미터 제거
            for (const [key, value] of queryParams.entries()) {
                if (!value) {
                    queryParams.delete(key);
                }
            }

            // 페이지를 필터링된 URL로 새로고침합니다
            window.location.href = '/page/crm_member_check_5/?' + queryParams.toString();
        });

        // egen_search_view_count 선택 시 자동 새로고침
        document.getElementById('egen_search_view_count').addEventListener('change', function() {
            const queryParams = new URLSearchParams(window.location.search);
            queryParams.set('egen_search_view_count', this.value);
            
            // 현재 스크롤 위치 저장
            const scrollPosition = window.scrollY;
            queryParams.set('scrollTo', scrollPosition);
            
            window.location.href = '/page/crm_member_check_5/?' + queryParams.toString();
        });

        // URL 파라미터로 입력 필드 초기화
        const initializeFields = () => {
            const params = new URLSearchParams(window.location.search);
            
            // 각 필드 초기화
            if(params.get('search_keyword')) {
                document.querySelector('input[name="search_keyword"]').value = params.get('search_keyword');
            }
            if(params.get('recommend_count')) {
                document.querySelector('input[name="recommend_count"]').value = params.get('recommend_count');
            }
            if(params.get('egen_search_view_count')) {
                document.getElementById('egen_search_view_count').value = params.get('egen_search_view_count');
            }
        };

        // 페이지 로드 시 필드 초기화 실행
        initializeFields();
    });
</script>