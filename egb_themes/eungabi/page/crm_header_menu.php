<section class="position1 width_box border_px-u_002 height_px_074 no_color_change" data-bd-a-color="#dddddd"
    data-xy="1-1200: height_px_064">
    <div class="position3 z-index_8 width_box margin_x_auto flex_xs1_yc no_color_change" data-xy="1-1200: width_box del-flex_xs1_yc"
        data-bg-color="#ffffff" data-top="0%" data-left="0%">
        <div class="flex_fl_yc padding_px-x_030 padding_px-y_015"
            data-xy="1-1200: flex_xs1_yc padding_px-x_010 padding_px-y_010">
            <div class="display_none" data-xy="1-1200: flex_xc_yc">
                <div class="flex_ft_xs1_yc height_px_025 pointer mobilemenus opxnmobilemenu">
                    <div class="width_px_030 height_px_003 mobilemenu_1" data-bg-color="#000000"></div>
                    <div class="width_px_030 height_px_003 mobilemenu_2" data-bg-color="#000000"></div>
                    <div class="width_px_030 height_px_003 mobilemenu_3" data-bg-color="#000000"></div>
                </div>
            </div>
            <div class="padding_px-r_100" data-xy="1-1200: padding_px-r_000">
                <a class="flex_fl pointer" href="<?php echo DOMAIN; ?>"><img class="width_px_150 height_px_040"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>"></a>
            </div>
            <div class="flex_xs1_yc width_px_600 font_px_015 flv6 padding_px-t_000 padding_px-u_000 crm_headermenu_select"
                data-xy="1-1200: display_none">
                <div class="flex_xc"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/crm_member_check_1'; ?>">회원조회</a>
                </div>
                <div class="flex_xc"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/crm_member_management_1'; ?>">회원관리</a>
                </div>
                <div class="flex_xc"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/crm_member_level_1'; ?>">등급관리</a>
                </div>
                <div class="flex_xc"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/crm_member_event_1'; ?>">이벤트</a>
                </div>
                <div class="flex_xc"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/crm_member_reward_1'; ?>">리워드</a>
                </div>
                <div class="flex_xc"><a class="pointer"
                        href="<?php echo DOMAIN . '/page/crm_member_reservation_1'; ?>">예약설정</a>
                </div>
                <?php
                $menu_tree = egb_menu_tree('crm_main_menu');

                if (!empty($menu_tree)) {
                    $menu_items = egb_menu($menu_tree[0]['uniq_id']);
                    
                    if (!empty($menu_items)) {
                        foreach ($menu_items as $item) {
                            echo '<div class="flex_xc">';
                            echo '<a class="pointer" href="' . DOMAIN . $item['menu_url'] . '">' . $item['menu_name'] . '</a>';
                            echo '</div>';
                        }
                    }
                }
                ?>
            <div class="height_px_000" data-xy="1-1200: height_px_001"></div>
        </div>
        <a href="<?php echo DOMAIN; ?>/?post=logout_input">
            <div class="font_px_015 padding_px-x_020 flv6 pointer no_color_change" data-color="#ff0000" data-xy="1-1200: display_none">
                로그아웃
            </div>
        </a>
    </div>
    <div class="position1" data-top="14%" data-right="2%" data-xy="1-1200: position2 del-position1">
        <!--<div class="flex_xs1_yc border_px-a_002 border_bre-a_040 width_px_180 height_px_040 padding_px-l_000 overflow_hidden"
                data-bd-a-color="#15376b" data-xy="1-1200: width_px_150 height_px_035 padding_px-l_005">
                <div class="min_width_030 height_px_015" data-xy="1-1200: min_width_020 height_px_015">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="100%" height="100%" x="0" y="0" viewBox="0 0 62.993 62.993"
                        style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path
                                d="M62.58 60.594 41.313 39.329c3.712-4.18 5.988-9.66 5.988-15.677C47.301 10.61 36.692.001 23.651.001 10.609.001 0 10.61 0 23.652c0 13.041 10.609 23.65 23.651 23.65 6.016 0 11.497-2.276 15.677-5.988l21.265 21.267a1.403 1.403 0 0 0 1.987 0c.55-.551.55-1.438 0-1.987zM23.651 44.492c-11.492 0-20.841-9.348-20.841-20.84S12.159 2.811 23.651 2.811c11.491 0 20.84 9.349 20.84 20.841 0 5.241-1.958 10.023-5.163 13.689a21.416 21.416 0 0 1-1.987 1.987c-3.666 3.206-8.449 5.164-13.69 5.164z"
                                style="" fill="#000000" data-original="#010002" opacity="1"></path>
                        </g>
                    </svg>
                </div>
                <input typx="text" name="" id="" class="width_box height_box padding_px-r_010 font_px_014 nothover"
                    placeholder="검색">
            </div>-->
    </div>
    </div>
</section>
<style>
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

    input {
        all: unset;
        font-family: fontstyle1;
        background-color: #ffffff;
        box-sizing: border-box;
    }

    .crm_headermenu_selected {
        text-decoration: underline;
        text-underline-offset: 8px;
        text-decoration-thickness: 4px;
        text-decoration-color: #15376b;
    }

    .scrolls {
        overflow: hidden;
        /* 요소 내부에서의 스크롤을 방지 */
    }
</style>
<script nonce="<?php echo NONCE; ?>">
    document.querySelector('.mobilemenus').addEventListener('click', function () {
        document.querySelector('.mobilemenu_1').classList.toggle('rotatemobile_1');
        document.querySelector('.mobilemenu_2').classList.toggle('rotatemobile_2');
        document.querySelector('.mobilemenu_3').classList.toggle('rotatemobile_3');
    });

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

    document.addEventListener('DOMContentLoaded', function () {
        const elements = document.querySelectorAll('.scrolls');

        elements.forEach(function (ele) {
            let isMouseDown = false;
            let startX;
            let scrollLeft;

            ele.addEventListener('mousedown', (e) => {
                isMouseDown = true;
                ele.style.cursor = 'grabbing';
                startX = e.pageX - ele.offsetLeft;
                scrollLeft = ele.scrollLeft;
            });

            ele.addEventListener('mouseleave', () => {
                isMouseDown = false;
                ele.style.cursor = 'grab';
            });

            ele.addEventListener('mouseup', () => {
                isMouseDown = false;
                ele.style.cursor = 'grab';
            });

            ele.addEventListener('mousemove', (e) => {
                if (!isMouseDown) return;
                e.preventDefault();
                const x = e.pageX - ele.offsetLeft;
                const walk = (x - startX) * 2; // 스크롤 속도 조절
                ele.scrollLeft = scrollLeft - walk;
            });

            // 터치 이벤트 처리
            ele.addEventListener('touchstart', (e) => {
                startX = e.touches[0].pageX - ele.offsetLeft;
                scrollLeft = ele.scrollLeft;
            });

            ele.addEventListener('touchmove', (e) => {
                if (e.cancelable) e.preventDefault();
                const x = e.touches[0].pageX - ele.offsetLeft;
                const walk = (x - startX) * 2;
                ele.scrollLeft = scrollLeft - walk;
            });
        });
    });
</script>
<section class="position3 height_box z-index_7 margin_px-t_064 mobilemenubg" data-top="0%">
    <div class="position1 height_box display_none white-_space_nowrap mobilemenu z-index_7" data-bg-color="#ffffff"
        data-xy="1-1200: flex_ft_xs1">
        <div class="font_px_015 scroll" style="overflow-y: auto;">
            <div class="flex_ft">
                <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer opxnguide crm_member_check_color"
                    data-bg-color="#444444" data-bd-a-color="#ffffff">
                    <div class="font_px_020 flv6" data-color="#ffffff">회원조회</div>
                    <div class="width_px_015 height_px_015 pointer rotate">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g
                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                <path
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('crm_member_check');
                    
                    if (!empty($menu_tree)) {
                        $menu_items = egb_menu($menu_tree[0]['uniq_id']);
                        
                        if (!empty($menu_items)) {
                            foreach ($menu_items as $item) {
                                echo '<a href="' . DOMAIN . $item['menu_url'] . '">';
                                echo '<div class="pointer padding_px-y_008 padding_px-l_010 pointer ' . basename($item['menu_url']) . '_bg">' . $item['menu_name'] . '</div>';
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="flex_ft">
                <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer opxnguide crm_member_management_color"
                    data-bg-color="#444444" data-bd-a-color="#ffffff">
                    <div class="font_px_020 flv6 pointer" data-color="#ffffff">회원관리</div>
                    <div class="width_px_015 height_px_015 pointer rotate">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g
                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                <path
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('crm_member_management');
                    
                    if (!empty($menu_tree)) {
                        foreach ($menu_tree[0]['children'] as $child) {
                            echo '<div class="padding_px-y_008 padding_px-l_010 font_px_018" data-bg-color="#999999">' . $child['group_name'] . '</div>';
                            
                            $menu_items = egb_menu($child['uniq_id']);
                            if (!empty($menu_items)) {
                                foreach ($menu_items as $item) {
                                    echo '<a href="' . DOMAIN . $item['menu_url'] . '">';
                                    echo '<div class="padding_px-y_008 padding_px-l_010 pointer ' . basename($item['menu_url']) . '_bg" data-bg-color="#ffffff">';
                                    echo $item['menu_name'];
                                    echo '</div>';
                                    echo '</a>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="flex_ft">
                <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer opxnguide crm_member_level_color"
                    data-bg-color="#444444" data-bd-a-color="#ffffff">
                    <div class="font_px_020 flv6 pointer" data-color="#ffffff">등급관리</div>
                    <div class="width_px_015 height_px_015 pointer rotate">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g
                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                <path
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">
                    <?php
                    $menu_tree = egb_menu_tree('crm_member_level');
                    
                    if (!empty($menu_tree)) {
                        foreach ($menu_tree[0]['children'] as $child) {
                            echo '<div class="padding_px-y_008 padding_px-l_010 font_px_018" data-bg-color="#999999">' . $child['group_name'] . '</div>';
                            
                            $menu_items = egb_menu($child['uniq_id']);
                            if (!empty($menu_items)) {
                                foreach ($menu_items as $item) {
                                    echo '<a href="' . DOMAIN . $item['menu_url'] . '">';
                                    echo '<div class="padding_px-y_008 padding_px-l_010 pointer ' . basename($item['menu_url']) . '_bg" data-bg-color="#ffffff">';
                                    echo $item['menu_name'];
                                    echo '</div>';
                                    echo '</a>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="flex_ft">
                <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer opxnguide crm_member_event_color"
                    data-bg-color="#444444" data-bd-a-color="#ffffff">
                    <div class="font_px_020 flv6 pointer" data-color="#ffffff">이벤트</div>
                    <div class="width_px_015 height_px_015 pointer rotate">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g
                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                <path
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">
                        <?php
                        $menu_tree = egb_menu_tree('crm_member_event');
                        
                        if (!empty($menu_tree)) {
                            $menu_items = egb_menu($menu_tree[0]['uniq_id']);
                            if (!empty($menu_items)) {
                                foreach ($menu_items as $item) {
                                    echo '<a href="' . DOMAIN . $item['menu_url'] . '">';
                                    echo '<div class="padding_px-y_008 padding_px-l_010 pointer ' . basename($item['menu_url']) . '_bg" data-bg-color="#ffffff">';
                                    echo $item['menu_name'];
                                    echo '</div>';
                                    echo '</a>';
                                }
                            }
                        }
                        ?>
                </div>
            </div>
            <div class="flex_ft">
                <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer opxnguide crm_member_reward_color"
                    data-bg-color="#444444" data-bd-a-color="#ffffff">
                    <div class="font_px_020 flv6 pointer" data-color="#ffffff">리워드</div>
                    <div class="width_px_015 height_px_015 pointer rotate">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g
                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                <path
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">
                        <?php
                        $menu_tree = egb_menu_tree('crm_member_reward');
                        
                        if (!empty($menu_tree)) {
                            foreach ($menu_tree[0]['children'] as $child) {
                                // 하위 메뉴나 메뉴 아이템이 있을 때만 출력
                                $menu_items = egb_menu($child['uniq_id']);
                                if (!empty($child['children']) || !empty($menu_items)) {
                                    echo '<div class="padding_px-y_008 padding_px-l_010 font_px_018" data-bg-color="#999999">' . $child['group_name'] . '</div>';
                                    
                                    if (!empty($menu_items)) {
                                        foreach ($menu_items as $item) {
                                            echo '<a href="' . DOMAIN . $item['menu_url'] . '">';
                                            echo '<div class="padding_px-y_008 padding_px-l_010 pointer ' . basename($item['menu_url']) . '_bg" data-bg-color="#ffffff">';
                                            echo $item['menu_name'];
                                            echo '</div>';
                                            echo '</a>';
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                </div>
            </div>
            <div class="flex_ft">
                <div class="flex_xs1_yc padding_px-y_015 border_px-u_001 padding_px-x_020 pointer opxnguide crm_member_reservation_color"
                    data-bg-color="#444444" data-bd-a-color="#ffffff">
                    <div class="font_px_020 flv6" data-color="#ffffff">예약설정</div>
                    <div class="width_px_015 height_px_015 pointer rotate">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                            <g
                                transform="matrix(-2.1676248344908158e-16,1.1800000000000006,-1.1800000000000006,-2.1676248344908158e-16,558.7299658203128,-58.64560897827164)">
                                <path
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1-30.167-30.166L332.5 256 155.583 79.083a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" fill="#ffffff" opacity="1" data-original="#000000"
                                    class=""></path>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="flex_ft guidebox overflow_hidden font_style_center" data-bg-color="#ffffff">
                        <?php
                        $menu_tree = egb_menu_tree('crm_member_reservation');
                        
                        if (!empty($menu_tree)) {
                            $menu_items = egb_menu($menu_tree[0]['uniq_id']);
                            
                            if (!empty($menu_items)) {
                                foreach ($menu_items as $item) {
                                    echo '<a href="' . DOMAIN . $item['menu_url'] . '">';
                                    echo '<div class="pointer padding_px-y_008 padding_px-l_010 pointer ' . basename($item['menu_url']) . '_bg">';
                                    echo $item['menu_name'];
                                    echo '</div>';
                                    echo '</a>';
                                }
                            }
                        }
                        ?>
                </div>
            </div>
        </div>
        <div class="flex_ft_xc_yc margin_px-u_080">
            <a href="https://auto.lii.kr/?post=logout_input">
                <div class="font_px_015 padding_px-x_020 margin_px-y_010 flv6 pointer" data-color="#ff0000">로그아웃</div>
            </a>
            <img class="width_px_150 height_px_040" src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>">
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
</style>
<script nonce="<?php echo NONCE; ?>">
    document.querySelectorAll('.opxnguide').forEach(function (button, index) {
        var guidebox = document.querySelectorAll('.guidebox')[index];
        var rotateIcon = document.querySelectorAll('.rotate')[index];
        var isGuideboxVisible = false;  // 가이드박스가 처음에는 접힌 상태로 시작

        // 초기 상태 강제 적용
        guidebox.style.maxHeight = '0'; // 처음에는 접힌 상태
        rotateIcon.classList.add('reverse'); // 처음에는 180도 회전 상태

        button.addEventListener('click', function () {
            // 동기화된 애니메이션 실행
            if (isGuideboxVisible) {
                guidebox.style.maxHeight = '0'; // 높이 0으로 설정 (접기)
                rotateIcon.classList.add('reverse'); // 아이콘을 0도로 회전
            } else {
                guidebox.style.maxHeight = guidebox.scrollHeight + "px"; // 높이 설정 (펼치기)

                // 레이아웃을 강제로 계산하여 변화 인식
                guidebox.offsetHeight;  // 강제로 레이아웃 계산
                rotateIcon.classList.remove('reverse'); // 아이콘을 180도로 회전
            }

            // 상태 반전
            isGuideboxVisible = !isGuideboxVisible;
        });
    });


    document.querySelectorAll('.opxnmobilemenu').forEach(function (button, index) {
        var mobilemenu = document.querySelectorAll('.mobilemenu')[index];
        var mobilemenubg = document.querySelectorAll('.mobilemenubg')[index]; // mobilemenubg div
        var ismobilemenuVisible = false;  // 가이드박스가 처음에는 접힌 상태로 시작

        // 초기 상태 강제 적용
        mobilemenu.style.maxWidth = '0'; // 처음에는 접힌 상태

        button.addEventListener('click', function () {
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
        });
    });
</script>