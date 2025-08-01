<?php

// 관리자 로그인 체크
$admin_login = '';
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1) {
    $admin_login = 'admin';
}
// 사용자 로그인 체크 및 등급 정보 조회
if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    $login_type = 'user';
    $login_user_uniq_id = $_SESSION['user_uniq_id'];
    // 옵션 그룹 정보 조회
    $query_grade = "SELECT uniq_id FROM egb_option_group WHERE group_code = 'community_user_grade' AND is_status = 1";
    $binding_grade = binding_sql(1, $query_grade, []);
    $result_grade = egb_sql($binding_grade);
    // 멘토/멘티 정보 가져오기
    if (!empty($result_grade)) {
        // 멘토 정보
        $query_mentor = "SELECT uniq_id FROM egb_option WHERE option_group_uniq_id = :option_group_uniq_id AND option_label = '멘토' AND is_status = 1";
        $params_mentor = [':option_group_uniq_id' => $result_grade[0]['uniq_id']];
        $binding_mentor = binding_sql(1, $query_mentor, $params_mentor);
        $sql_mentor = egb_sql($binding_mentor);
        $mentor_uniq_id = !empty($sql_mentor) ? $sql_mentor[0]['uniq_id'] : null;
        // 멘티 정보
        $query_mentee = "SELECT uniq_id FROM egb_option WHERE option_group_uniq_id = :option_group_uniq_id AND option_label = '멘티' AND is_status = 1";
        $params_mentee = [':option_group_uniq_id' => $result_grade[0]['uniq_id']];
        $binding_mentee = binding_sql(1, $query_mentee, $params_mentee);
        $sql_mentee = egb_sql($binding_mentee);
        $mentee_uniq_id = !empty($sql_mentee) ? $sql_mentee[0]['uniq_id'] : null;
        // 사용자 등급 확인
        $query_user = "SELECT community_user_grade FROM egb_user WHERE uniq_id = :login_user_uniq_id AND is_status = 1";
        $params_user = [':login_user_uniq_id' => $login_user_uniq_id];
        $binding_user = binding_sql(1, $query_user, $params_user);
        $sql_user = egb_sql($binding_user);
        if (!empty($sql_user)) {
            $user_grade = $sql_user[0]['community_user_grade'];
            $is_mentor = ($user_grade == $mentor_uniq_id);
            $is_mentee = ($user_grade == $mentee_uniq_id);
        }
    }
} else {
    $login_type = null;
    $is_mentor = false;
    $is_mentee = false;
}
?>
<div class="display_off height_box" data-bg-color="#000000" egb:style="
    input{outline: none;}
">
</div>

<header class="position1 width_box z-index_5 flex_xc">
    <div class="padding_px-t_130 alarmbaroff display_none"></div>
    <div id="header_height" class="padding_px-t_180 alarmbaron"></div>
    <div class="position3 width_box z-index_2" data-top="0%">
        <div class="position1 flex_xc_yc width_box height_px_050 alarmbar">
            <div class="flex_xc_yc width_box height_box">
                <img src="<?php echo DOMAIN . '/?img2=header/banner1'; ?>"
                    class="width_box height_px_050" style="object-fit: cover;" data-xy="1-600: height_px_030">
            </div>
            <div class="position2 flex_xc_yc width_px_050 height_px_050 font_px_025 z-index_4" data-top="0%" data-right="0%">
                <div class="width_box height_box flex_xc_yc padding_px-u_005 pointer closealarmbar size_change" data-bg-color="#005387" data-color="#ffffff">&times;</div>
            </div>
        </div>
        <div id="egb_header_menu_1" class="position1 z-index_3 width_box height_px_080 border_px-u_001 flex_xc" data-top="0%" data-bg-color="#ffffff" data-bd-a-color="#EAEDEF" data-egb-header-menu-one="1">
            <div class="width_px_1220 height_box margin_x_auto padding_px-a_010" data-top="0%" data-xy="1-1220: width_box">
                <div class="flex_fl_xs1_yc" data-color="#2F3438">
                    <div class="flex_fl_yc font_px_018 flv6">
                        <div class="font_px_025 pointer">
                            <a class="egb_spa" href="/" aria-label="홈으로 이동"><img class="width_px_150 height_px_060" 
                                    src="<?php echo DOMAIN . '/?img2=logo' ?>" alt="로고"></a>
                        </div>
                        <?php
                        // 트리 구조를 기반으로 메뉴를 렌더링하는 부분
                        $menu_tree = egb_menu_tree('home_main_menu');  // egb_menu_tree 호출하여 트리 구조 가져오기
                        
                        // 트리 구조가 비어있다면 아무 것도 출력하지 않음
                        if (!empty($menu_tree)) {
                            echo '<div class="flex_xl_yc" data-xy="0-900: display_none">';
                        
                            // 각 그룹코드별로 메뉴 출력
                            $group_codes = ['community_main_menu', 'self_repair_shop_main_menu', 'shopping_main_menu', 'crm_admin'];
                            
                            foreach ($menu_tree as $menu) {
                                if (!empty($menu['children'])) {
                                    foreach ($menu['children'] as $child) {
                                        if (!in_array($child['group_code'], $group_codes)) continue;
                                        
                                        // crm_admin은 관리자만 볼 수 있음
                                        if ($child['group_code'] === 'crm_admin' && $admin_login !== 'admin') continue;
                                        
                                        // 그룹코드별 설정
                                        switch($child['group_code']) {
                                            case 'community_main_menu':
                                                $menu_class = 'egb_radio_menu1_1 egb_menu1_active';
                                                $data_attrs = 'data-hover-menu="1"';
                                                break;
                                            case 'self_repair_shop_main_menu':
                                                $menu_class = 'egb_radio_menu1_2';
                                                $data_attrs = 'data-hover-menu="2"';
                                                break;
                                            case 'shopping_main_menu':
                                                $menu_class = 'egb_radio_menu1_3';
                                                $data_attrs = 'data-hover-menu="3"';
                                                break;
                                            case 'crm_admin':
                                                $menu_class = 'egb_radio_menu1_4';
                                                $data_attrs = 'data-hover-menu="4"';
                                                break;
                                        }
                                        echo '<div class="padding_px-x_015 pointer ' . $menu_class . '" ' . $data_attrs . ' data-color="#15376b">';
                                        echo '<a class="egb_spa" href="/">' . $child['group_name'] . '</a>';
                                        echo '</div>';
                                    }
                                }
                            }
                            
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="flex_fr_yc font_px_014" data-xy="0-900: display_none">
                        <?php
                        if (isset($login_type) && $login_type === 'user' || isset($admin_login) && $admin_login === 'admin') {
                            // 특정 문자열이 경로에 포함되어 있는지 확인
                            $page_write_url = '/page/board_write';
                            if (strpos(URL, '/page/mentoring_private') !== false && ($is_mentor || $is_mentee)) {
                                $page_write_url = '/page/mentoring_private_write';
                            }
                            if (strpos(URL, '/page/mentoring_release') !== false) {
                                $page_write_url = '/page/mentoring_release_write';
                            }
                            if (strpos(URL, '/page/region_regional_studies') !== false) {
                                $page_write_url = '/page/region_regional_studies_write';
                            }
                            if (strpos(URL, '/page/region_maintenance_meeting') !== false) {
                                $page_write_url = '/page/region_maintenance_meeting_write';
                            }
                            if (strpos(URL, '/page/region_regular_meeting') !== false) {
                                $page_write_url = '/page/region_regular_meeting_write';
                            }
                            if (strpos(URL, '/page/club_regional_studies') !== false) {
                                $page_write_url = '/page/club_regional_studies_write';
                            }
                            if (strpos(URL, '/page/club_maintenance_meeting') !== false) {
                                $page_write_url = '/page/club_maintenance_meeting_write';
                            }
                            if (strpos(URL, '/page/club_regular_meeting') !== false) {
                                $page_write_url = '/page/club_regular_meeting_write';
                            }
                            ?>
                            <a class="" href="<?php echo $page_write_url; ?>">
                                <div class="padding_px-x_016 margin_px-l_010 flex_xc_yc height_px_040 border_bre-a_004 pointer"
                                    data-bg-color="#15376b" data-color="#ffffff">
                                    <span class="padding_px-r_005">글쓰기&nbsp;&nbsp;</span><span
                                        class="width_px_014 height_px_014 flex_xc_yc">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0"
                                            y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g
                                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                                <path
                                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1"
                                                    data-original="#000000" class=""></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a class="" href="/page/login">
                                <div class="padding_px-x_016 margin_px-l_010 flex_xc_yc height_px_040 border_bre-a_004 pointer"
                                    data-bg-color="#15376b" data-color="#ffffff">
                                    <span class="padding_px-r_005">글쓰기&nbsp;&nbsp;</span><span
                                        class="width_px_014 height_px_014 flex_xc_yc">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0"
                                            y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g
                                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                                <path
                                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1"
                                                    data-original="#000000" class=""></path>
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        <?php } ?>
                        <a class="egb_spa egb_cache" href="/page/qna">
                            <div class="padding_px-x_005 pointer">고객센터</div>
                        </a>
                        <div data-color="#EAEDEF">｜</div>
                        <?php
                        if ($login_type === 'user') {
                            $query_alarm = "
                                SELECT * 
                                FROM auto_alarm_log 
                                WHERE auto_alarm_log_user_uniq_id = :login_user_uniq_id 
                                AND auto_alarm_log_is_read = 0
                                ORDER BY created_at DESC
                            ";
                            $binding_alarm = binding_sql(0, $query_alarm, [':login_user_uniq_id' => $login_user_uniq_id]);
                            $sql_alarm = egb_sql($binding_alarm);

                            $alarm_check = !empty($sql_alarm[0]) ? 'on' : 'off';
                            ?>
                            <div class="padding_px-x_005 pointer"><a class="pointer" href="/?post=logout_input">로그아웃</a></div>
                            <div data-color="#EAEDEF">｜</div>
                            <div class="flex_yc padding_px-r_010">
                              <a href="/page/mypage_profile" class="pointer">
                                <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                                   class="width_px_025 height_px_040 border_bre-a_035">
                              </a>
                            </div>
                            <?php
                        } else {
                            $alarm_check = 'off';
                            ?>
                            <div class="padding_px-x_005 pointer"><a class="pointer" href="/page/signup">회원가입</a></div>
                            <div data-color="#EAEDEF">｜</div>
                            <div class="padding_px-x_005 pointer"><a class="pointer" href="/page/login">로그인</a></div>
                        <?php } ?>
                        <div class="margin_px-r_010 pointer flex_yc_xc width_px_020 height_px_030">
                            <svg width="100%" height="100%" id="Layer_1" viewBox="0 0 32 32"
                                xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" fill="#777777">
                                <g>
                                    <path
                                        d="m28.031 8.124a2.986 2.986 0 0 0 -2.341-1.124h-17.97l-.772-2.316c0-.012-.014-.021-.019-.033a.967.967 0 0 0 -.106-.186 1 1 0 0 0 -.1-.147.983.983 0 0 0 -.138-.107.978.978 0 0 0 -.171-.111 1 1 0 0 0 -.15-.042.959.959 0 0 0 -.228-.046c-.012-.005-.023-.012-.036-.012h-3a1 1 0 0 0 0 2h2.28l.754 2.261 2.643 11.89a2.982 2.982 0 0 0 2.923 2.349h11.979a2.985 2.985 0 0 0 2.93-2.349l2.109-9.5a2.983 2.983 0 0 0 -.587-2.527zm-3.474 11.592a1 1 0 0 1 -.978.784h-11.979a.992.992 0 0 1 -.976-.783l-2.377-10.717h17.443a1 1 0 0 1 .976 1.217z" />
                                    <path
                                        d="m12.691 23.5a3 3 0 1 0 3 3 3 3 0 0 0 -3-3zm0 4a1 1 0 1 1 1-1 1 1 0 0 1 -1 1z" />
                                    <path
                                        d="m22.691 23.5a3 3 0 1 0 3 3 3 3 0 0 0 -3-3zm0 4a1 1 0 1 1 1-1 1 1 0 0 1 -1 1z" />
                                </g>
                            </svg>
                        </div>
                        
                        
                        
                        <div id="egb_push" class="position1 margin_px-r_010 flex_yc_xc width_px_020 height_px_030">
                            <svg id="alarm_bell_icon" class="pointer alarm_bell_on_off" height="100%" viewBox="0 0 32 32" width="100%"
                                xmlns="http://www.w3.org/2000/svg" fill="#777777">
                                <g id="_28" data-name="28">
                                    <path
                                        d="m28.07 22.66-1.71-2.46a2 2 0 0 1 -.36-1.14v-7.06a10 10 0 0 0 -20 0v7.06a2 2 0 0 1 -.36 1.14l-1.71 2.46a2 2 0 0 0 1.48 3.34h5.69a5 5 0 0 0 9.8 0h5.69a2 2 0 0 0 1.48-3.34zm-12.07 5.34a3 3 0 0 1 -2.82-2h5.64a3 3 0 0 1 -2.82 2zm-10.59-4a.81.81 0 0 0 .12-.14l1.75-2.52a4 4 0 0 0 .72-2.28v-7.06a8 8 0 0 1 16 0v7.06a4 4 0 0 0 .72 2.28l1.75 2.52a.81.81 0 0 0 .12.14z" />
                                </g>
                            </svg>
                            <?php
                            $alarm_check = 'off';
                            
                            if (isset($login_user_uniq_id)) {
                                // 알림 체크 쿼리 
                                $query_alarm = "
                                    SELECT COUNT(*) as unread_count 
                                    FROM egb_alarm_log 
                                    WHERE alarm_log_user_uniq_id = :login_user_uniq_id 
                                    AND alarm_log_is_read = 0
                                    AND is_status = 1
                                    AND deleted_at IS NULL
                                ";
                                $params_alarm = [':login_user_uniq_id' => $login_user_uniq_id];
                                $binding_alarm = binding_sql(1, $query_alarm, $params_alarm);
                                $sql_alarm = egb_sql($binding_alarm);

                                $alarm_check = (!empty($sql_alarm) && $sql_alarm[0]['unread_count'] > 0) ? 'on' : 'off';
                            }
                            ?>

                            <?php if ($alarm_check === 'on'): ?>
                                <div id="alarm_red_check" class="position2 width_px_008 height_px_008 border_bre-a_100"
                                    data-top="10%" data-right="10%" data-bg-color="#ff0000"></div>
                            <?php else: ?>
                                <div id="alarm_red_check"
                                    class="position2 width_px_008 height_px_008 border_bre-a_100 display_off" data-top="10%"
                                    data-right="10%" data-bg-color="#ff0000"></div>
                            <?php endif; ?>

                            <div id="alarm_list_container" class="position2 z-index_6 display_none alarm_bell" data-top="130%" data-left="-1000%">
                                <div id="alarm_list_box" class="position1 width_px_300 min_height_350 max_height_600 arrow_box"
                                    data-bg-color="#f9f9f9" style="box-shadow: 0 0 4px #00000080;">
                                    <div id="alarm_list_scroll" class="position1 max_height_600 padding_px-x_015 font_px_014 scrollbar_hide overflow_hidden"
                                        style="overflow-y: auto;">
                                        <div id="alarm_list_title" class="position4 font_px_016 flv6 padding_px-t_020 padding_px-u_010"
                                            data-bg-color="#f9f9f9" data-top="0%">알림</div>
                                        <?php
                                        if (isset($login_user_uniq_id)) {
                                            // 알림 목록 조회
                                            $query_alarm_list = "
                                                SELECT * 
                                                FROM egb_alarm_log
                                                WHERE alarm_log_user_uniq_id = :login_user_uniq_id
                                                AND alarm_log_is_read = 0 
                                                AND is_status = 1
                                                AND deleted_at IS NULL
                                                ORDER BY created_at DESC
                                            ";
                                            $binding_alarm_list = binding_sql(0, $query_alarm_list, $params_alarm);
                                            $sql_alarm_list = egb_sql($binding_alarm_list);

                                            if (!empty($sql_alarm_list[0])) {
                                                foreach ($sql_alarm_list[0] as $alarm) {
                                                ?>
                                                    <form id="alarm_form_<?php echo $alarm['uniq_id']; ?>" method="POST" action="<?php echo DOMAIN . '/?post=egb_alarm_read_input'; ?>">
                                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                                        <input type="hidden" name="alarm_uniq_id" value="<?php echo $alarm['uniq_id']; ?>">
                                                        <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($alarm['alarm_log_link']); ?>">
                                                        <input type="hidden" name="from_page" value="header">
                                                        <button id="alarm_item_<?php echo $alarm['uniq_id']; ?>" type="submit" class="block_link width_box" style="border:none; background:none; text-align:left;">
                                                            <div class="border_px-u_001 padding_px-y_010 pointer hover_item" data-bd-a-color="#d9d9d9">
                                                                <div class="flex_xr flv6" data-color="#888888">
                                                                    <?php echo htmlspecialchars($alarm['created_at']); ?></div>
                                                                <div class="flex_xs1_yc padding_px-y_010">
                                                                    <div class="flex_ft font_px_017 flv6">
                                                                        <span class="flex_fl_yc">
                                                                            <?php echo htmlspecialchars($alarm['alarm_log_title']); ?></span>
                                                                        <span><?php echo htmlspecialchars($alarm['alarm_log_message']); ?></span>
                                                                    </div>
                                                                    <div class="width_px_024 height_px_024 svg_container" fill="#999999">
                                                                        <svg class="svg_hover" fill="#888888" height="100%"
                                                                            viewBox="0 0 24 24" width="100%"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path clip-rule="evenodd"
                                                                                d="m7.57613 3.57573c.23431-.23431.61421-.23431.84852 0l8.00005 7.99997c.2343.2343.2343.6142 0 .8486l-8.00005 8c-.23431.2343-.61421.2343-.84852 0-.23432-.2344-.23432-.6143 0-.8486l7.57577-7.5757-7.57577-7.57574c-.23432-.23432-.23432-.61422 0-.84853z"
                                                                                fill-rule="evenodd" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div class="font_px_012 padding_px-u_020" data-color="#888888">알림 내용을 자세히
                                                                    확인해보세요.</div>
                                                            </div>
                                                        </button>
                                                    </form>
                                                <?php
                                                }
                                            } else {
                                                echo '<div id="no_alarm_message">알림이 없습니다.</div>';
                                            }
                                        } else {
                                            echo '<div id="login_required_message">로그인이 필요한 서비스입니다.</div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="padding_px-x_010 pointer" data-xy="0-1220: display_none">
                            <div class="border_px-a_001 border_bre-a_004 height_px_040 padding_px-x_010 font_px_015 flex_yc fakeinput"
                                data-bd-a-color="#DADDE0">
                                <div class="flex_xc_yc width_px_20 height_px_020"><svg
                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0"
                                        y="0" viewBox="0 0 62.993 62.993" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve">
                                        <g>
                                            <path
                                                d="M62.58 60.594 41.313 39.329c3.712-4.18 5.988-9.66 5.988-15.677C47.301 10.61 36.692.001 23.651.001 10.609.001 0 10.61 0 23.652c0 13.041 10.609 23.65 23.651 23.65 6.016 0 11.497-2.276 15.677-5.988l21.265 21.267a1.403 1.403 0 0 0 1.987 0c.55-.551.55-1.438 0-1.987zM23.651 44.492c-11.492 0-20.841-9.348-20.841-20.84S12.159 2.811 23.651 2.811c11.491 0 20.84 9.349 20.84 20.841 0 5.241-1.958 10.023-5.163 13.689a21.416 21.416 0 0 1-1.987 1.987c-3.666 3.206-8.449 5.164-13.69 5.164z"
                                                style="" fill="#828c94" data-original="#010002" opacity="1"></path>
                                        </g>
                                    </svg></div>
                                    <form action="<?php echo DOMAIN . '/?post=search_input'; ?>" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <label for="search-input" class="sr-only"></label>
                                    <input
                                        id="search-input"
                                        name="search"
                                        class="flex_xc_yc width_px_200 height_box border_px-a_000 border_px-a_000 padding_px-x_010 inputstyle1 font_px_014"
                                        type="text"
                                        placeholder="검색어를 입력하세요">
                                    <div class="flex_xc_yc width_px_020"></div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <div class="display_none" data-xy="1-900: flex_xc_yc">
                        <div class="flex_ft_xs1_yc height_px_025 pointer mobilemenus openmobilemenu">
                            <div class="width_px_030 height_px_003 mobilemenu_1" data-bg-color="#000000"></div>
                            <div class="width_px_030 height_px_003 mobilemenu_2" data-bg-color="#000000"></div>
                            <div class="width_px_030 height_px_003 mobilemenu_3" data-bg-color="#000000"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="egb_header_menu_2" class="position1 z-index_2 width_box height_px_050 border_px-u_001 flex_xc display_none" data-bd-a-color="#EAEDEF" data-egb-header-menu-one="2" data-xy="0-900: display_none">
            <div class="position1 width_px_1220 height_box margin_x_auto font_px_016 flv6 flex_xc_yc padding_px-x_010"
                data-xy="1-1220: width_box" data-bottom="0%" data-bg-color="#ffffff">
                <ul id="community_main_menu" class="position2 width_box height_box hover_menus_1 flex_fl z-index_2" data-bottom="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_main_menu');
                    if (!empty($menu_tree)) {
                        $menu_count = 1;
                        foreach ($menu_tree[0]['children'] as $menu) {
                            echo '<li class="padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer  productmenu_' . $menu_count . '">';
                            echo '<a class="egb_spa" href="/">' . $menu['group_name'] . '</a>';
                            echo '</li>';
                            $menu_count++;
                        }
                    }
                    ?>
                </ul>
                <ul id="self_repair_shop_main_menu" class="position2 width_box height_box hover_menus_2 flex_fl z-index_2" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('self_repair_shop_main_menu');

                    if (!empty($menu_tree)) {
                        // 트리가 비어있지 않으면
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']); // 부모 메뉴의 uniq_id로 메뉴 항목을 가져옵니다
                    
                        // $menu_items가 배열일 때만 출력
                        if (!empty($menu_items)) {
                            $first = true;
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                if ($first) {
                                    $class .= ' focusheaderrowmenu';
                                    $first = false;
                                }
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <ul id="shopping_main_menu" class="position2 width_box height_box hover_menus_3 flex_fl z-index_2" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('shopping_main_menu');

                    if (!empty($menu_tree)) {
                        // 트리가 비어있지 않으면
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']); // 부모 메뉴의 uniq_id로 메뉴 항목을 가져옵니다
                    
                        // $menu_items가 배열일 때만 출력
                        if (!empty($menu_items)) {
                            $first = true;
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                if ($first) {
                                    $class .= ' focusheaderrowmenu';
                                    $first = false;
                                }
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>

                </ul>
                <?php if(isset($admin_login) && $admin_login === 'admin'): ?>
                <ul id="crm_admin_menu" class="position2 width_box height_box hover_menus_4 flex_fl z-index_2" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('crm_admin');
                                    
                    if (!empty($menu_tree)) {
                        // 트리가 비어있지 않으면
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']); // 부모 메뉴의 uniq_id로 메뉴 항목을 가져옵니다
                    
                        // $menu_items가 배열일 때만 출력
                        if (!empty($menu_items)) {
                            $first = true;
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                if ($first) {
                                    $class .= ' focusheaderrowmenu';
                                    $first = false;
                                }
                                echo '<li class="' . $class . '">';
                                echo '<a class="" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
        <div id="egb_header_menu_3" class="position1 z-index_1 width_box height_px_050 border_px-u_001 flex_xc" data-bd-a-color="#EAEDEF" data-egb-header-menu-one="3" data-xy="0-900: display_none">
            <div class="position1 width_px_1220 height_box margin_x_auto font_px_016 flv6 flex_xc_yc padding_px-x_010"
                data-xy="1-1220: width_box" data-bottom="0%" data-bg-color="#ffffff">
                <ul id="community_home_menu" class="position2 flex_fl width_box height_box z-index_1 productmenus_1" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_home');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>             
                <ul id="community_self_repair_content_menu" class="position2 width_box height_box z-index_1 productmenus_2 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_self_repair_content');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <!--
                <ul id="community_self_repair_menu" class="position2 width_box height_box z-index_1 productmenus_3 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_self_repair');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                -->
                <!--
                <ul id="community_self_repair_shop_menu" class="position2 width_box height_box z-index_1 productmenus_4 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_self_repair_shop');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                -->
                <ul id="community_qna_menu" class="position2 width_box height_box z-index_1 productmenus_3 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_qna');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa egb_cache" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <ul id="community_local_meeting_menu" class="position2 width_box height_box z-index_1 productmenus_4 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_local_meeting');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <ul id="community_club_menu" class="position2 width_box height_box z-index_1 productmenus_5 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_club');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <!--
                <ul id="community_foreign_car_menu" class="position2 width_box height_box z-index_1 productmenus_8 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_foreign_car');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
                -->
                <ul id="community_mentoring_menu" class="position2 width_box height_box z-index_1 productmenus_6 flex_fl" data-top="0%"
                    data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('community_mentoring');

                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);

                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                $class = 'padding_px-x_003 padding_px-y_015 margin_px-x_007 pointer ';
                                echo '<li class="' . $class . '">';
                                echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">' . $item['menu_name'] . '</a>';
                                echo '</li>';
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<style>
    .scrollbar_hide::-webkit-scrollbar {
        display: none;
    }

    .svg_hover:hover {
        fill: #000000;
    }

    .text_hide {
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 95px;
    }

    .arrow_box:after,
    .arrow_box:before {
        bottom: 100%;
        left: 70%;
        border: solid transparent;
        content: "";
        height: 0;
        width: 0;
        position: absolute;
    }

    .arrow_box:after {
        border-color: transparent;
        border-bottom-color: #f9f9f9;
        border-width: 8px;
        margin-left: -8px;
    }

    .arrow_box:before {
        border-color: transparent;
        border-bottom-color: #00000045;
        border-width: 9px;
        margin-left: -9px;
    }

    .mobilemenu_1,
    .mobilemenu_2,
    .mobilemenu_3 {
        transition: 0.5s;
    }

    .rotatemobile_1 {
        transform: translateY(11px) rotate(45deg);
    }

    .rotatemobile_2 {
        background-color: transparent;
    }

    .rotatemobile_3 {
        transform: translateY(-11px) rotate(-45deg);
    }

    .focusheaderrowmenu {
        color: #15376b;
        border-bottom: 2px solid #15376b;

    }

    :hover {
        color: #15376b;
    }

    .inputstyle1 {
        font-family: fontstyle1;
        color: #2F3438;
    }

    .inputstyle1:focus {
        outline: none;
    }

    .fakeinput:focus-within {
        outline: 1px solid #15376b;
    }

    .active {
        display: flex;
        flex-direction: row;
    }

    /* 메뉴 애니메이션 효과 */
    #egb_header_menu_2 {
        transform: translateY(-100%);
        transition: transform 0.3s ease-in-out;
        background: transparent;
    }

    #egb_header_menu_2.show {
        transform: translateY(0);
    }

    #egb_header_menu_3 {
        transform: translateY(-100%);
        transition: transform 0.3s ease-in-out;
        background: transparent;
    }

    #egb_header_menu_3.show {
        transform: translateY(0);
    }

    #egb_header_menu_4 {
        transform: translateY(-100%);
        transition: transform 0.3s ease-in-out;
        background: transparent;
    }

    #egb_header_menu_4.show {
        transform: translateY(0);
    }
</style>

<!-- 알림 벨 관련 스크립트 -->
<script nonce="<?php echo NONCE; ?>">
    document.querySelector('.alarm_bell_on_off').addEventListener('click', function (e) {
        e.stopPropagation(); // 이벤트 버블링 방지
        const alarmBell = document.querySelector('.alarm_bell');
        if (alarmBell.style.display === 'none' || alarmBell.style.display === '') {
            // 보여줄 때
            alarmBell.style.display = 'block';
            alarmBell.style.opacity = '0';
            setTimeout(() => {
                alarmBell.style.transition = 'opacity 0.5s';
                alarmBell.style.opacity = '1';
            }, 10);
        } else {
            // 사라질 때
            alarmBell.style.opacity = '0';
            alarmBell.addEventListener('transitionend', function onFadeOut() {
                alarmBell.style.display = 'none';
                alarmBell.removeEventListener('transitionend', onFadeOut);
            });
        }
    });

    // 알림창 외부 클릭시 닫기
    document.addEventListener('click', function(e) {
        const alarmBell = document.querySelector('.alarm_bell');
        const alarmBellOnOff = document.querySelector('.alarm_bell_on_off');
        
        // 클릭된 요소가 알림창이나 알림 버튼이 아닐 경우에만 닫기
        if (!alarmBell.contains(e.target) && !alarmBellOnOff.contains(e.target)) {
            if (alarmBell.style.display === 'block') {
                alarmBell.style.opacity = '0';
                alarmBell.addEventListener('transitionend', function onFadeOut() {
                    alarmBell.style.display = 'none';
                    alarmBell.removeEventListener('transitionend', onFadeOut);
                });
            }
        }
    });
</script>

<!-- 모바일 메뉴 토글 스크립트 -->
<script nonce="<?php echo NONCE; ?>">
    document.querySelector('.mobilemenus').addEventListener('click', function () {
        document.querySelector('.mobilemenu_1').classList.toggle('rotatemobile_1');
        document.querySelector('.mobilemenu_2').classList.toggle('rotatemobile_2');
        document.querySelector('.mobilemenu_3').classList.toggle('rotatemobile_3');
    });
</script>

<!-- 현재 페이지 메뉴 하이라이트 스크립트 -->
<script nonce="<?php echo NONCE; ?>">
    document.addEventListener('DOMContentLoaded', function () {
        // 현재 페이지의 URL을 가져옵니다.
        var currentUrl = window.location.href;

        // 모든 메뉴 항목을 가져옵니다.
        var menuItems = document.querySelectorAll('.crm_headermenu_select a');

        // 각 메뉴 항목의 URL과 현재 URL을 비교합니다.
        menuItems.forEach(function (menuItem) {
            var menuUrl = menuItem.getAttribute('href');

            // 만약 URL이 "crm_member_check_"로 시작하는 경우도 포함하여 일치시키기
            if (currentUrl.includes(menuUrl) || currentUrl.startsWith(menuUrl.replace('1', ''))) {
                menuItem.classList.add('crm_headermenu_selected');
            } else {
                menuItem.classList.remove('crm_headermenu_selected');
            }
        });
    });
</script>

<!-- 알람바 관련 스크립트 -->
<script nonce="<?php echo NONCE; ?>">
    document.addEventListener('DOMContentLoaded', function () {
        // 알람바 관련 요소
        const closeAlarmBar = document.querySelector('.closealarmbar');
        const alarmBar = document.querySelector('.alarmbar');
        const alarmBarOff = document.querySelector('.alarmbaroff');
        const alarmBarOn = document.querySelector('.alarmbaron');

        // 알람바 닫기 이벤트
        closeAlarmBar?.addEventListener('click', () => {
            alarmBar.classList.remove('flex_xc_yc');
            alarmBar.classList.add('display_none');

            if (alarmBar.classList.contains('display_none')) {
                alarmBarOff.classList.remove('display_none');
                alarmBarOn.classList.add('display_none');
            }
        });
    });
</script>

<!-- 메뉴 호버 기능 스크립트 -->
<script nonce="<?php echo NONCE; ?>">
    document.addEventListener('DOMContentLoaded', function () {
        // 메뉴 호버 관련 요소들
        const menuButtons = document.querySelectorAll('.egb_radio_menu1_1, .egb_radio_menu1_2, .egb_radio_menu1_3, .egb_radio_menu1_4');
        const menuContainers = {
            menu1: document.getElementById('egb_header_menu_1'),
            menu2: document.getElementById('egb_header_menu_2'),
            menu3: document.getElementById('egb_header_menu_3'),
            menu4: document.getElementById('egb_header_menu_4')
        };
        
        const subMenus = {
            hover1: document.querySelector('.hover_menus_1'),
            hover2: document.querySelector('.hover_menus_2'),
            hover3: document.querySelector('.hover_menus_3'),
            hover4: document.querySelector('.hover_menus_4')
        };

        const productMenus = {
            product1: document.querySelector('.productmenus_1'),
            product2: document.querySelector('.productmenus_2'),
            product3: document.querySelector('.productmenus_3'),
            product4: document.querySelector('.productmenus_4'),
            product5: document.querySelector('.productmenus_5'),
            product6: document.querySelector('.productmenus_6')
        };

        // 메뉴 버튼 호버 이벤트
        menuButtons.forEach(button => {
            const hoverMenu = button.getAttribute('data-hover-menu');
            
            button.addEventListener('mouseenter', function() {
                // 모든 서브메뉴 숨기기
                Object.values(subMenus).forEach(menu => {
                    if (menu) menu.classList.add('display_none');
                });
                
                // 모든 프로덕트 메뉴 숨기기
                Object.values(productMenus).forEach(menu => {
                    if (menu) menu.classList.add('display_none');
                });
                
                // 해당하는 서브메뉴 보이기
                const targetSubMenu = subMenus[`hover${hoverMenu}`];
                if (targetSubMenu) {
                    targetSubMenu.classList.remove('display_none');
                }
                
                // 메뉴 컨테이너 상태 변경 - 모든 메뉴에서 2번째 메뉴가 나오도록 수정
                if (menuContainers.menu2) {
                    menuContainers.menu2.classList.remove('display_none');
                    menuContainers.menu2.classList.add('flex_xc');
                    // 애니메이션을 위해 약간의 지연 후 show 클래스 추가
                    setTimeout(() => {
                        menuContainers.menu2.classList.add('show');
                    }, 10);
                }
                
                // 3번째 메뉴는 숨기기
                if (menuContainers.menu3) {
                    menuContainers.menu3.classList.remove('show');
                    menuContainers.menu3.classList.add('display_none');
                }
                
                // 4번째 메뉴는 CRM 관리자일 때만 보이기
                if (hoverMenu === '4') {
                    if (menuContainers.menu4) {
                        menuContainers.menu4.classList.remove('display_none');
                        menuContainers.menu4.classList.add('flex_xc');
                        setTimeout(() => {
                            menuContainers.menu4.classList.add('show');
                        }, 10);
                    }
                } else {
                    if (menuContainers.menu4) {
                        menuContainers.menu4.classList.remove('show');
                        menuContainers.menu4.classList.add('display_none');
                    }
                }
            });
        });

        // 서브메뉴 아이템 호버 이벤트 (커뮤니티 메뉴용)
        const communityMenuItems = document.querySelectorAll('#community_main_menu li');
        communityMenuItems.forEach((item, index) => {
            item.addEventListener('mouseenter', function() {
                // 모든 메뉴 아이템에서 focusheaderrowmenu 클래스 제거
                document.querySelectorAll('#community_main_menu li, #self_repair_shop_main_menu li, #shopping_main_menu li, #crm_admin_menu li').forEach(menuItem => {
                    menuItem.classList.remove('focusheaderrowmenu');
                });
                
                // 현재 아이템에 focusheaderrowmenu 클래스 추가
                this.classList.add('focusheaderrowmenu');
                
                // 모든 프로덕트 메뉴 숨기기
                Object.values(productMenus).forEach(menu => {
                    if (menu) menu.classList.add('display_none');
                });
                
                // 해당하는 프로덕트 메뉴 보이기
                const targetProductMenu = productMenus[`product${index + 1}`];
                if (targetProductMenu) {
                    targetProductMenu.classList.remove('display_none');
                }
                
                // 메뉴3 컨테이너 보이기
                if (menuContainers.menu3) {
                    menuContainers.menu3.classList.remove('display_none');
                    menuContainers.menu3.classList.add('flex_xc');
                    setTimeout(() => {
                        menuContainers.menu3.classList.add('show');
                    }, 10);
                }
            });
            
            item.addEventListener('mouseleave', function() {
                // 마우스가 벗어날 때 focusheaderrowmenu 클래스 제거
                this.classList.remove('focusheaderrowmenu');
            });
        });

        // 셀프정비소 메뉴 아이템 호버 이벤트
        const selfRepairMenuItems = document.querySelectorAll('#self_repair_shop_main_menu li');
        selfRepairMenuItems.forEach((item, index) => {
            item.addEventListener('mouseenter', function() {
                // 모든 메뉴 아이템에서 focusheaderrowmenu 클래스 제거
                document.querySelectorAll('#community_main_menu li, #self_repair_shop_main_menu li, #shopping_main_menu li, #crm_admin_menu li').forEach(menuItem => {
                    menuItem.classList.remove('focusheaderrowmenu');
                });
                
                // 현재 아이템에 focusheaderrowmenu 클래스 추가
                this.classList.add('focusheaderrowmenu');
            });
            
            item.addEventListener('mouseleave', function() {
                // 마우스가 벗어날 때 focusheaderrowmenu 클래스 제거
                this.classList.remove('focusheaderrowmenu');
            });
        });

        // 쇼핑 메뉴 아이템 호버 이벤트
        const shoppingMenuItems = document.querySelectorAll('#shopping_main_menu li');
        shoppingMenuItems.forEach((item, index) => {
            item.addEventListener('mouseenter', function() {
                // 모든 메뉴 아이템에서 focusheaderrowmenu 클래스 제거
                document.querySelectorAll('#community_main_menu li, #self_repair_shop_main_menu li, #shopping_main_menu li, #crm_admin_menu li').forEach(menuItem => {
                    menuItem.classList.remove('focusheaderrowmenu');
                });
                
                // 현재 아이템에 focusheaderrowmenu 클래스 추가
                this.classList.add('focusheaderrowmenu');
            });
            
            item.addEventListener('mouseleave', function() {
                // 마우스가 벗어날 때 focusheaderrowmenu 클래스 제거
                this.classList.remove('focusheaderrowmenu');
            });
        });

        // CRM 관리자 메뉴 아이템 호버 이벤트
        const crmMenuItems = document.querySelectorAll('#crm_admin_menu li');
        crmMenuItems.forEach((item, index) => {
            item.addEventListener('mouseenter', function() {
                // 모든 메뉴 아이템에서 focusheaderrowmenu 클래스 제거
                document.querySelectorAll('#community_main_menu li, #self_repair_shop_main_menu li, #shopping_main_menu li, #crm_admin_menu li').forEach(menuItem => {
                    menuItem.classList.remove('focusheaderrowmenu');
                });
                
                // 현재 아이템에 focusheaderrowmenu 클래스 추가
                this.classList.add('focusheaderrowmenu');
            });
            
            item.addEventListener('mouseleave', function() {
                // 마우스가 벗어날 때 focusheaderrowmenu 클래스 제거
                this.classList.remove('focusheaderrowmenu');
            });
        });

        // 메뉴3 영역의 모든 하위 메뉴 아이템 호버 이벤트
        const menu3Items = document.querySelectorAll('#egb_header_menu_3 li');
        menu3Items.forEach((item, index) => {
            item.addEventListener('mouseenter', function() {
                // 모든 메뉴 아이템에서 focusheaderrowmenu 클래스 제거
                document.querySelectorAll('#community_main_menu li, #self_repair_shop_main_menu li, #shopping_main_menu li, #crm_admin_menu li, #egb_header_menu_3 li').forEach(menuItem => {
                    menuItem.classList.remove('focusheaderrowmenu');
                });
                
                // 현재 아이템에 focusheaderrowmenu 클래스 추가
                this.classList.add('focusheaderrowmenu');
            });
            
            item.addEventListener('mouseleave', function() {
                // 마우스가 벗어날 때 focusheaderrowmenu 클래스 제거
                this.classList.remove('focusheaderrowmenu');
            });
        });

        // 헤더 영역에서 마우스가 벗어날 때 메뉴 숨기기
        const headerArea = document.querySelector('header');
        headerArea.addEventListener('mouseleave', function() {
            // 모든 메뉴 아이템에서 focusheaderrowmenu 클래스 제거
            document.querySelectorAll('#community_main_menu li, #self_repair_shop_main_menu li, #shopping_main_menu li, #crm_admin_menu li, #egb_header_menu_3 li').forEach(menuItem => {
                menuItem.classList.remove('focusheaderrowmenu');
            });
            
            // 모든 서브메뉴 숨기기
            Object.values(subMenus).forEach(menu => {
                if (menu) menu.classList.add('display_none');
            });
            
            // 모든 프로덕트 메뉴 숨기기
            Object.values(productMenus).forEach(menu => {
                if (menu) menu.classList.add('display_none');
            });
            
            // 메뉴 컨테이너 초기 상태로 복원
            if (menuContainers.menu2) {
                menuContainers.menu2.classList.remove('show');
                setTimeout(() => {
                    menuContainers.menu2.classList.remove('flex_xc');
                    menuContainers.menu2.classList.add('display_none');
                }, 300);
            }
            if (menuContainers.menu3) {
                menuContainers.menu3.classList.remove('show');
                setTimeout(() => {
                    menuContainers.menu3.classList.add('display_none');
                }, 300);
            }
            if (menuContainers.menu4) {
                menuContainers.menu4.classList.remove('show');
                setTimeout(() => {
                    menuContainers.menu4.classList.add('display_none');
                }, 300);
            }
        });

        // 서브메뉴 영역에서 마우스가 벗어날 때 처리
        const subMenuArea = document.getElementById('egb_header_menu_2');
        if (subMenuArea) {
            subMenuArea.addEventListener('mouseleave', function(e) {
                // 마우스가 서브메뉴 영역을 벗어나지만 다른 메뉴 영역으로 이동하는 경우는 무시
                const relatedTarget = e.relatedTarget;
                if (relatedTarget && (
                    relatedTarget.closest('#egb_header_menu_1') ||
                    relatedTarget.closest('#egb_header_menu_3') ||
                    relatedTarget.closest('.egb_radio_menu1_1') ||
                    relatedTarget.closest('.egb_radio_menu1_2') ||
                    relatedTarget.closest('.egb_radio_menu1_3') ||
                    relatedTarget.closest('.egb_radio_menu1_4')
                )) {
                    return;
                }
                
                // 서브메뉴 영역에서 벗어날 때는 메뉴3만 숨기기
                if (menuContainers.menu3) {
                    menuContainers.menu3.classList.remove('show');
                    setTimeout(() => {
                        menuContainers.menu3.classList.add('display_none');
                    }, 300);
                }
                
                // 모든 프로덕트 메뉴 숨기기
                Object.values(productMenus).forEach(menu => {
                    if (menu) menu.classList.add('display_none');
                });
            });
        }

        // 메뉴3 영역에서 마우스가 벗어날 때 처리
        const menu3Area = document.getElementById('egb_header_menu_3');
        if (menu3Area) {
            menu3Area.addEventListener('mouseleave', function(e) {
                // 마우스가 메뉴3 영역을 벗어나지만 다른 메뉴 영역으로 이동하는 경우는 무시
                const relatedTarget = e.relatedTarget;
                if (relatedTarget && (
                    relatedTarget.closest('#egb_header_menu_2') || 
                    relatedTarget.closest('#egb_header_menu_1') ||
                    relatedTarget.closest('.egb_radio_menu1_1') ||
                    relatedTarget.closest('.egb_radio_menu1_2') ||
                    relatedTarget.closest('.egb_radio_menu1_3') ||
                    relatedTarget.closest('.egb_radio_menu1_4')
                )) {
                    return;
                }
                
                // 메뉴3 영역에서 벗어날 때는 프로덕트 메뉴만 숨기기
                Object.values(productMenus).forEach(menu => {
                    if (menu) menu.classList.add('display_none');
                });
            });
        }
    });
</script>

<section class="position3 height_box z-index_7 size_change_129 size_change_mobile mobilemenubg" data-top="0%">
    <div class="position1 height_box display_none white_space_nowrap mobilemenu z-index_7" data-bg-color="#ffffff"
        data-xy="1-1200: flex_ft_xs1">
        <div class="font_px_015 scroll" style="overflow-y: auto;">
            <div class="flex_xs2_yc padding_px-x_010 padding_px-y_020 font_px_014" data-color="#202020">
                <?php
                if (isset($user_login) && $user_login === 'user') {
                    ?>
                    <div class="flex_yc padding_px-r_010">
                      <a href="/page/mypage_profile" class="pointer">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                           class="width_px_025 height_px_040 border_bre-a_035">
                      </a>
                    </div>
                    <a class="pointer egb_spa" href="/?post=logout_input">로그아웃</a>
                <?php } else { ?>
                    <a class="pointer egb_spa" href="/page/login">로그인</a>
                    <span>｜</span>
                    <a class="pointer egb_spa" href="/page/signup">회원가입</a>
                <?php } ?>
                <span>｜</span>
                <a class="pointer egb_spa egb_cache" href="/page/qna">고객센터</a>
            </div>
            <div class="" data-bg-color="#15376b">
                <a class="egb_spa" href="/page/board_write">
                    <div class="flex_xs1_yc padding_px-x_020 padding_px-y_015 height_px_055 pointer"
                        data-bg-color="#15376b" data-color="#ffffff">
                        <span class="padding_px-r_005 font_px_020 flv6">글쓰기&nbsp;&nbsp;</span><span
                            class="width_px_014 height_px_014 flex_xc_yc" style="transform: rotate(-90deg);">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                class="">
                                <g
                                    transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                    <path
                                        d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                        data-name="chevron-right-Bold" fill="#ffffff" opacity="1"
                                        data-original="#000000" class=""></path>
                                </g>
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
<?php
$menu_tree = egb_menu_tree('home_main_menu', 10);

function renderMenuItems($items) {
    if (!empty($items)) {
        echo '<div class="flex_ft guidebox font_style_center" data-bg-color="#ffffff">';
        foreach ($items as $item) {
            echo '<a class="egb_spa" href="' . $item['menu_url'] . '" target="' . $item['menu_target'] . '">';
            echo '<div class="padding_px-y_008 padding_px-x_010 pointer" data-bg-color="#ffffff">' . $item['menu_name'] . '</div>';
            echo '</a>';
        }
        echo '</div>';
    }
}

function renderSubMenus($menus) {
    if (!empty($menus)) {
        echo '<div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">';
        foreach ($menus as $submenu) {
            // 해당 그룹의 메뉴 아이템 가져오기
            $menu_items = egb_menu($submenu['uniq_id']);
            
            // 하위 메뉴나 메뉴 아이템이 있을 때만 출력
            if (!empty($submenu['children']) || !empty($menu_items)) {
                echo '<div class="">';
                echo '<div class="openguide flex_xs1_yc padding_px-y_008 padding_px-x_010 font_px_018" data-bg-color="#999999">';
                echo '<div>' . $submenu['group_name'] . '</div>';
                
                echo '<div class="width_px_015 height_px_015 pointer rotate">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">';
                echo '<g transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">';
                echo '<path d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z" data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000" class=""></path>';
                echo '</g>';
                echo '</svg>';
                echo '</div>';
                echo '</div>';

                if (!empty($submenu['children'])) {
                    renderSubMenus($submenu['children']);
                }
                
                renderMenuItems($menu_items);
                echo '</div>';
            }
        }
        echo '</div>';
    }
}

if (!empty($menu_tree)) {
    foreach ($menu_tree as $menu) {
        foreach ($menu['children'] as $child) {
            // 하위 메뉴나 메뉴 아이템이 있을 때만 출력
            $menu_items = egb_menu($child['uniq_id']);
            if (!empty($child['children']) || !empty($menu_items)) {
                echo '<div class="flex_ft">';
                echo '<div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer openguide" data-bg-color="#444444" data-bd-a-color="#ffffff">';
                echo '<div class="font_px_020 flv6" data-color="#ffffff">' . $child['group_name'] . '</div>';
                
                echo '<div class="width_px_015 height_px_015 pointer rotate">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">';
                echo '<g transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">';
                echo '<path d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z" data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000" class=""></path>';
                echo '</g>';
                echo '</svg>';
                echo '</div>';
                echo '</div>';

                if (!empty($child['children'])) {
                    renderSubMenus($child['children']);
                }
                
                renderMenuItems($menu_items);
                echo '</div>';
            }
        }
    }
}
?>
            <?php
            if (isset($admin_crm)) {
                ?>
                <div class="flex_ft">
                    <a class="" href="/page/crm_member_check_1">
                        <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer"
                            data-bg-color="#444444" data-bd-a-color="#ffffff">
                            <div class="font_px_020 flv6 pointer" data-color="#ffffff">CRM</div>
                            <div class="width_px_015 height_px_015 pointer" style="transform: rotate(-90deg);">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" x="0" y="0"
                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                    class="">
                                    <g
                                        transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                        <path
                                            d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                            data-name="chevron-right-Bold" fill="#ffffff" opacity="1"
                                            data-original="#000000" class=""></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            } else {
            }
            ?>
        </div>
        <div class="flex_xc_yc margin_px-t_010 margin_px-u_139">
            <a class="egb_spa" href="/"><img class="width_px_150 height_px_040 pointer"
                    src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>"></a>
        </div>
    </div>
</section>
<style>
    .rotate {
        transform: rotate(0deg);
        transition: 0.5s;
    }

    .rotate.reverse {
        transform: rotate(-90deg);
    }

    .guidebox {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-out;
    }

    .mobilemenu {
        max-width: 0;
        overflow: hidden;
        transition: max-width 0.5s ease-out;
        box-shadow: 4px 1px 8px 0px #00000080;
    }

    .scroll::-webkit-scrollbar {
        display: none;
    }

    .scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .size_change_129 {
        margin-top: 129px;
    }

    .size_change_79 {
        margin-top: 79px;
    }
</style>
<script nonce="<?php echo NONCE; ?>">
    document.querySelectorAll('.openguide').forEach(function (button) {
        var guidebox = button.nextElementSibling; // 바로 다음에 위치한 guidebox를 선택
        var rotateIcon = button.querySelector('.rotate'); // 현재 openguide 내부의 rotate 아이콘 선택
        var isGuideboxVisible = false;  // 가이드박스가 처음에는 접힌 상태로 시작

        // 초기 상태 강제 적용
        if (guidebox) {
            guidebox.style.maxHeight = '0'; // 처음에는 접힌 상태
        }
        if (rotateIcon) {
            rotateIcon.classList.add('reverse'); // 처음에는 180도 회전 상태
        }

        // 자식 요소의 높이 변화를 감지하고 maxHeight를 업데이트하는 함수
        function updateMaxHeight() {
            if (guidebox && isGuideboxVisible) {
                // guidebox의 자식 요소들의 높이를 계산하여 반영
                guidebox.style.maxHeight = guidebox.scrollHeight + 'px';
            }
        }

        button.addEventListener('click', function () {
            if (guidebox && rotateIcon) {
                // 동기화된 애니메이션 실행
                if (isGuideboxVisible) {
                    guidebox.style.maxHeight = '0'; // 높이 0으로 설정 (접기)
                    rotateIcon.classList.add('reverse'); // 아이콘을 0도로 회전
                } else {
                    guidebox.style.maxHeight = guidebox.scrollHeight + "px"; // 자식 요소들의 높이를 기반으로 높이 설정 (펼치기)

                    // 레이아웃을 강제로 계산하여 변화 인식
                    guidebox.offsetHeight;  // 강제로 레이아웃 계산
                    rotateIcon.classList.remove('reverse'); // 아이콘을 180도로 회전
                }

                // 상태 반전
                isGuideboxVisible = !isGuideboxVisible;
            }
        });

        // 자식 요소가 변경될 때마다 maxHeight 재계산 (childList, subtree 변경 감지)
        var mutationObserver = new MutationObserver(updateMaxHeight);
        if (guidebox) {
            mutationObserver.observe(guidebox, { childList: true, subtree: true, attributes: true });
        }

        // 자식 요소들의 크기 변화를 감지하는 ResizeObserver
        var resizeObserver = new ResizeObserver(updateMaxHeight);
        if (guidebox) {
            // 모든 자식 요소에 대해 크기 변화 감지
            guidebox.querySelectorAll('*').forEach(function (child) {
                resizeObserver.observe(child);
            });
        }

        // 부모 요소가 펼쳐질 때만 ResizeObserver를 활성화
        var handleResizeOnExpand = function () {
            if (guidebox && isGuideboxVisible) {
                // 자식 요소들이 변경될 때만 ResizeObserver 활성화
                guidebox.querySelectorAll('*').forEach(function (child) {
                    resizeObserver.observe(child);
                });
            } else if (guidebox) {
                // 접혔을 때는 ResizeObserver 비활성화
                guidebox.querySelectorAll('*').forEach(function (child) {
                    resizeObserver.unobserve(child);
                });
            }
        };

        button.addEventListener('click', handleResizeOnExpand);
    });

    document.querySelectorAll('.openmobilemenu').forEach(function (button, index) {
        var mobilemenu = document.querySelectorAll('.mobilemenu')[index];
        var mobilemenubg = document.querySelectorAll('.mobilemenubg')[index]; // mobilemenubg div
        var ismobilemenuVisible = false;  // 가이드박스가 처음에는 접힌 상태로 시작

        // 초기 상태 강제 적용
        if (mobilemenu) {
            mobilemenu.style.maxWidth = '0'; // 처음에는 접힌 상태
        }

        button.addEventListener('click', function () {
            if (mobilemenu && mobilemenubg) {
                // 동기화된 애니메이션 실행
                if (ismobilemenuVisible) {
                    mobilemenu.style.maxWidth = '0'; // 접기
                    mobilemenubg.classList.remove('width_box'); // width_box 클래스 제거
                    mobilemenubg.style.backgroundColor = ''; // 배경색 제거
                    document.body.style.overflowY = ''; // 스크롤 다시 활성화
                } else {
                    // 펼칠 때는 강제 200px 너비로 설정
                    mobilemenu.style.width = '200px'; // 올바른 속성 (소문자 사용)
                    mobilemenu.style.maxWidth = '200px'; // 고정된 200px로 설정 (펼치기)

                    // mobilemenubg 처리
                    mobilemenubg.classList.add('width_box'); // width_box 클래스 추가
                    mobilemenubg.style.backgroundColor = '#88888888'; // 배경색 설정

                    // 레이아웃을 강제로 계산하여 변화 인식
                    mobilemenu.offsetWidth;  // 강제로 레이아웃 계산

                    // body 스크롤 비활성화
                    document.body.style.overflowY = 'hidden';
                }

                // 상태 반전
                ismobilemenuVisible = !ismobilemenuVisible;
            }
        });
    });

    document.querySelector('.size_change').addEventListener('click', function () {
        const element = document.querySelector('.size_change_mobile');
        if (element) {
            element.classList.remove('size_change_129');
            element.classList.add('size_change_79');
        }
    });
</script>

<form id="auto_get_alarm_list_form_input" method="post" action="<?php echo DOMAIN . "/?post=auto_get_alarm_list_form_input"; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<script nonce="<?php echo NONCE; ?>">
// 알림 UI 처리
function updateAlarmUI() {
    const alarmRedCheck = document.getElementById('alarm_red_check');
    if (alarmRedCheck) {
        alarmRedCheck.classList.remove('display_off');
    }

    // 알림 목록 리프레시 AJAX 호출
    EGB.form.submit('auto_get_alarm_list_form_input', formData => {
        // 알림 리스트 갱신 후 필요한 처리를 여기서 진행
    });
}

</script>