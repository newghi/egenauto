<?php
// GET 요청으로 필터 값을 받습니다. 값이 없으면 기본값으로 초기화합니다.
$user_class = isset($_GET['user_class']) ? $_GET['user_class'] : '전체';
$user_type1 = isset($_GET['user_type1']) ? $_GET['user_type1'] : '전체';
$user_type2 = isset($_GET['user_type2']) ? $_GET['user_type2'] : '전체';
$view_count = isset($_GET['egen_search_view_count']) ? (int)$_GET['egen_search_view_count'] : 30;

// 기본 쿼리
$query = "SELECT * FROM auto_user WHERE is_status = 1";
$params = [];

// 필터링 조건 추가
if ($user_class !== '전체') {
    $query .= " AND user_class = :user_class";
    $params[':user_class'] = $user_class;
}

if ($user_type1 !== '전체') {
    $query .= " AND user_type1 = :user_type1";
    $params[':user_type1'] = $user_type1;
}

if ($user_type2 !== '전체') {
    $query .= " AND user_type2 = :user_type2";
    $params[':user_type2'] = $user_type2;
}

// 정렬 및 페이지당 보기 설정
$current_page = isset($_GET['list']) ? (int)$_GET['list'] : 1;
$offset = ($current_page - 1) * $view_count;
$query .= " ORDER BY created_at DESC LIMIT :offset, :view_count";
$params[':offset'] = $offset;
$params[':view_count'] = $view_count;

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$sql_results = egb_sql($binding);

// 결과가 null이면 빈 배열로 초기화
if (!is_array($sql_results) || !isset($sql_results[0])) {
    $sql_results = [[]];
}

$filteredCount = count($sql_results[0]);

// 총 데이터 수량 쿼리
$totalQuery = "SELECT COUNT(*) as total_count FROM auto_user WHERE is_status = 1";
$totalBinding = binding_sql(0, $totalQuery, []);
$totalResult = egb_sql($totalBinding);

// 결과가 null이면 기본값 설정
if (!is_array($totalResult) || !isset($totalResult[0][0]['total_count'])) {
    $totalCount = '0';
    $total_pages = 0;
} else {
    $totalCount = number_format($totalResult[0][0]['total_count']);
    $total_pages = ceil($totalResult[0][0]['total_count'] / $view_count);
}
?>

<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_level_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc padding_px-u_020"
                data-xy="1-800: flex_fu width_box padding_px-u_020, 801-1200: flex_xs1_yc padding_px-u_020">
                <div class="font_px_020 flv6">등급별회원관리</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>회원관리</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">등급별회원관리</div>
                    </div>
                </div>
            </div>
            <div class="flex_ft width_box border_px-a_002 font_px_016" data-bd-a-color="#d9d9d9"
                data-xy="1-800: font_px_014">
                <div class="flex_fl_yc width_box"
                    data-xy="1-800: flex_ft border_px-u_001, 801-968: flex_fl_yc border_px-u_001"
                    data-bg-color="#ffffff" data-bd-a-color="#d9d9d9">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010 height_box border_px-u_000, 801-968: padding_px-y_018 padding_px-l_010 height_box border_px-u_000">
                        커뮤니티 등급</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"
                        data-xy="1-968: flex_fl_yc_wrap padding_px-y_000 padding_px-x_010 border_px-u_000 del-height_px_055">
                        <?php
                        // 등급 정보 조회 - 커뮤니티 타입만 필터링
                        $query = "SELECT * FROM auto_user_grade WHERE is_status = 1 AND grade_type = 'community' ORDER BY display_order ASC";
                        $binding = binding_sql(0, $query, []);
                        $grades = egb_sql($binding);

                        // 전체 옵션 추가
                        ?>
                        <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                            <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                type="radio" name="crm_member_level_shoplevel"
                                id="crm_member_level_shoplevel_all" data-xy="1-800: width_px_016 height_px_016"
                                value="전체" <?php echo ($user_class === '전체') ? 'checked' : ''; ?>>
                            <label class="padding_px-l_005 padding_px-r_010"
                                for="crm_member_level_shoplevel_all">전체</label>
                        </div>
                        <?php
                        // 등급별 라디오 버튼 동적 생성
                        if (!empty($grades[0])) {
                            foreach ($grades[0] as $grade) {
                                $grade_id = $grade['uniq_id'];
                                $grade_name = htmlspecialchars($grade['grade_name']);
                                ?>
                                <div class="flex_fl_yc padding_px-y_000" data-xy="1-1000: padding_px-y_005">
                                    <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888"
                                        type="radio" name="crm_member_level_shoplevel"
                                        id="crm_member_level_shoplevel_<?php echo $grade_id; ?>"
                                        value="<?php echo $grade_id; ?>"
                                        <?php echo ($user_class === $grade_id) ? 'checked' : ''; ?>
                                        data-xy="1-800: width_px_016 height_px_016">
                                    <label class="padding_px-l_005 padding_px-r_010"
                                        for="crm_member_level_shoplevel_<?php echo $grade_id; ?>"><?php echo $grade_name; ?></label>
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
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 1</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_level_memberclass_level1" id="crm_member_level_memberclass_level1_all"
                            value="전체" <?php echo ($user_type1 === '전체') ? 'checked' : ''; ?>
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_level_memberclass_level1_all">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_level_memberclass_level1" id="crm_member_level_memberclass_level1_member1"
                            value="회원" <?php echo ($user_type1 === '회원') ? 'checked' : ''; ?>
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_level_memberclass_level1_member1">회원</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_level_memberclass_level1" id="crm_member_level_memberclass_level1_member2"
                            value="비회원" <?php echo ($user_type1 === '비회원') ? 'checked' : ''; ?>
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005" for="crm_member_level_memberclass_level1_member2">비회원</label>
                    </div>
                </div>
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">회원 구분 2</div>
                    <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box height_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-800: height_px_053">
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_level_memberclass_level2" id="crm_member_level_memberclass_level2"
                            value="전체" <?php echo ($user_type2 === '전체') ? 'checked' : ''; ?>
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_level_memberclass_level2">전체</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_level_memberclass_level2" id="crm_member_level_memberclass_level2_member1"
                            value="개인" <?php echo ($user_type2 === '개인') ? 'checked' : ''; ?>
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005 padding_px-r_010"
                            for="crm_member_level_memberclass_level2_member1">개인</label>
                        <input class="width_px_018 height_px_018 border_px-a_001" data-bd-a-color="#888888" type="radio"
                            name="crm_member_level_memberclass_level2" id="crm_member_level_memberclass_level2_member2"
                            value="사업자" <?php echo ($user_type2 === '사업자') ? 'checked' : ''; ?>
                            data-xy="1-800: width_px_016 height_px_016">
                        <label class="padding_px-l_005" for="crm_member_level_memberclass_level2_member2">사업자</label>
                    </div>
                </div>
            </div>
            <div class="flex_xc padding_px-t_010 padding_px-u_020">
                <div class="border_px-a_001 padding_px-x_030 padding_px-y_015 font_px_018 pointer"
                    data-xy="1-800: font_px_016" data-bd-a-color="#d9d9d9" data-bg-color="#333333" data-color="#ffffff">
                    <span id="egen_search">검색하기</span>
                </div>
            </div>
            <div class="font_px_020 flv6 padding_px-y_020">회원조회 결과</div>
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
                                <div class="pointer border_px-a_001 padding_px-x_005 padding_px-y_003"
                                    data-bg-color="#202020" data-color="#ffffff">EXCEL</div>
                            </div>
                        </div>
                    </div>
                    <div class="padding_px-r_010 padding_px-t_000"
                        data-xy="1-800: width_box flex_xr padding_px-t_010 padding_px-r_010">
                        <select class="width_px_120 border_px-a_001 font_px_014 padding_px-x_010 padding_px-y_005"
                            name="egen_search_view_count" id="egen_search_view_count" data-bd-a-color="#888888" data-xy="1-800: font_px_012">
                            <option value="30" <?php echo ($view_count == 30) ? 'selected' : ''; ?>>30개씩 보기</option>
                            <option value="20" <?php echo ($view_count == 20) ? 'selected' : ''; ?>>20개씩 보기</option>
                            <option value="10" <?php echo ($view_count == 10) ? 'selected' : ''; ?>>10개씩 보기</option>
                        </select>
                    </div>
                </div>
                <div class="scrolls width_box overflow_hidden">
                    <div class="flex_ft border_px-a_001 min_width_1300" data-bd-a-color="#d9d9d9">
                        <div class="grid_xx border_px-u_001 flv6" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%"
                            data-bd-a-color="#d9d9d9" data-bg-color="#efefef">
                            <label for="crm_searching_member_level_all"
                                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020" dat type="levelbox" name=""
                                    id="crm_searching_member_level_all" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">No
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">최근접속일</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">이름</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">아이디
                            </div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">게시판</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">게시글수</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">댓글수</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">회원등급</div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">포인트
                            </div>
                            <div class="flex_xc padding_px-y_015" data-bd-a-color="#d9d9d9">상세</div>
                        </div>
                        <?php 
                        if(isset($sql_results[0]) && count($sql_results[0]) > 0):
                            foreach ($sql_results[0] as $index => $result): 
                        ?>
                        <div class="grid_xx border_px-u_001 bd-a-color-d9d9d9 bg-color-ffffff xx-5per-5per-12per-10per-12per-12per-11per-10per-10per-8per-5per" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                            <label for="crm_searching_member_level_<?php echo $index + 1; ?>" class="flex_xc border_px-r_001 padding_px-y_015 pointer bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">
                                <input class="border_px-a_001 width_px_020 height_px_020 bd-a-color-d9d9d9" dat="" type="levelbox" name="" id="crm_searching_member_level_<?php echo $index + 1; ?>" data-bd-a-color="#d9d9d9">
                            </label>
                            <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo $offset + $index + 1; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['created_at']) ? $result['created_at'] : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_name']) ? htmlspecialchars($result['user_name']) : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_id']) ? htmlspecialchars($result['user_id']) : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_board_type']) ? htmlspecialchars($result['user_board_type']) : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_post_count']) ? $result['user_post_count'] . '개' : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_comment_count']) ? $result['user_comment_count'] . '개' : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_type2']) ? htmlspecialchars($result['user_type2']) : '-'; ?></div>
                            <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9"><?php echo isset($result['user_point']) ? number_format($result['user_point']) : '-'; ?></div>
                            <div class="flex_xc padding_px-y_015 pointer bd-a-color-d9d9d9 hover-bg-color-15376b hover-color-ffffff" data-bd-a-color="#d9d9d9" data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
                        </div>
                        <?php 
                            endforeach;
                        endif;
                        ?>
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
    .crm_member_level_color {
        background-color: #15376b;
    }

    .crm_member_level_3_bg {
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
    // 필터링 폼의 submit 버튼 클릭 시
    document.getElementById('egen_search').addEventListener('click', function(e) {
        e.preventDefault(); // 폼 기본 제출 동작 방지

        // 각 필드 값을 가져옵니다
        const userClass = document.querySelector('input[name="crm_member_level_shoplevel"]:checked')?.value || '전체';
        const userType1 = document.querySelector('input[name="crm_member_level_memberclass_level1"]:checked')?.value || '전체';
        const userType2 = document.querySelector('input[name="crm_member_level_memberclass_level2"]:checked')?.value || '전체';
        const viewCount = document.getElementById('egen_search_view_count')?.value || '30';

        // URL 쿼리 스트링을 생성합니다
        let queryParams = new URLSearchParams();

        // '전체' 값 필터링 후 필요한 필드만 추가
        if(userClass !== '전체') queryParams.append('user_class', userClass);
        if(userType1 !== '전체') queryParams.append('user_type1', userType1);
        if(userType2 !== '전체') queryParams.append('user_type2', userType2);
        if(viewCount) queryParams.append('view_count', viewCount);

        // 페이지를 필터링된 URL로 새로고침합니다
        window.location.href = '/page/crm_member_level_6/?' + queryParams.toString();
    });

    // hover 효과 처리
    document.querySelectorAll('[data-hover-bg-color]').forEach(function(element) {
        element.addEventListener('mouseenter', function() {
            this.style.backgroundColor = this.getAttribute('data-hover-bg-color');
            if(this.hasAttribute('data-hover-color')) {
                this.style.color = this.getAttribute('data-hover-color');
            }
        });

        element.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            if(this.hasAttribute('data-hover-color')) {
                this.style.color = '';
            }
        });
    });
});
</script>
