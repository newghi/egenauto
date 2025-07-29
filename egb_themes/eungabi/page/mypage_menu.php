<div egb:style="
    .mypage_menu_active {
        color: #15376b;
    }
    .mypage_menu_active_hover {
        color: #15376b;
        border-bottom: 2px solid #15376b;
    }
">
</div>
<?php
// 마이페이지 메뉴 구조 정의
$menu_tree = egb_menu_tree('mypage_main_menu');

// 첫 번째 메뉴에서 자식요소의 menu_url을 가공해서 배열로 저장
$submenu_page_names = [];
$parent_active_index = null; // 부모 메뉴 활성화 인덱스

if (!empty($menu_tree)) {
    // 트리가 비어있지 않으면
    $menu_items = egb_menu($menu_tree[0]['uniq_id']); // 부모 메뉴의 uniq_id로 메뉴 항목을 가져옵니다

    // $menu_items가 배열일 때만 출력
    if (!empty($menu_items)) {
        echo '<div class="flex_xc_yc width_box height_px_050 border_px-y_001 font_px_016 flv6" data-bd-y-color="#f8f6ef">';
        foreach ($menu_items as $index => $item) {
            echo '<a href="' . DOMAIN . $item['menu_url'] . '" class="egb_spa">';
            echo '<div class="padding_px-x_020 pointer" data-hover-color="#15376b" id="mypage_menu_'.$index.'">' . $item['menu_name'] . '</div>';
            echo '</a>';
            echo '<div class="-function-urlToggle" data-arg-1="mypage_menu_'.$index.'" data-arg-2="false" data-arg-3="'.$item['menu_url'].'" data-arg-4="mypage_menu_active"></div>';
            
            // menu_url에서 페이지 이름 추출 (/page/페이지이름 -> 페이지이름)
            $url_parts = explode('/', trim($item['menu_url'], '/'));
            $page_name = end($url_parts);
            $submenu_page_names[] = ['name' => $page_name, 'parent_index' => $index]; // 부모 메뉴의 인덱스도 저장
        }
        echo '</div>';
    }
}

// 현재 페이지 URL에서 페이지 이름 추출
$current_url = URL;
$url_parts = explode('/', trim($current_url, '/'));
$current_page_name = end($url_parts);

// 첫 번째 방법: 현재 페이지 이름으로 _menu와 결합해서 메뉴트리 가져오기
$menu_tree = egb_menu_tree($current_page_name . '_menu');

if (!empty($menu_tree)) {
    // 트리가 비어있지 않으면
    $menu_items = egb_menu($menu_tree[0]['uniq_id']); 

    // $menu_items가 배열일 때만 출력
    if (!empty($menu_items)) {
        // 현재 페이지 이름에 해당하는 부모 메뉴 인덱스 찾기
        foreach ($submenu_page_names as $page_info) {
            if ($page_info['name'] === $current_page_name) {
                $parent_active_index = $page_info['parent_index'];
                break;
            }
        }
        
        echo '<div class="flex_xc_yc width_box height_px_050 border_px-y_001 font_px_016 flv6" data-bd-y-color="#f8f6ef">';
        foreach ($menu_items as $index => $item) {
            echo '<a href="' . DOMAIN . $item['menu_url'] . '" class="egb_spa">';
            echo '<div class="margin_px-x_020 padding_px-y_013 pointer" data-hover-class-add="mypage_menu_active_hover" id="mypage_menu2_'.$index.'">' . $item['menu_name'] . '</div>';
            echo '</a>';
            echo '<div class="-function-urlToggle" data-arg-1="mypage_menu2_'.$index.'" data-arg-2="false" data-arg-3="'.$item['menu_url'].'" data-arg-4="focusheaderrowmenu"></div>';
        }
        echo '</div>';
    }
} else {
    // 두 번째 방법: 첫 번째 방법이 안되면 배열로 저장한 이름과 현재 URL을 대조해서 맞는 트리 가져오기
    foreach ($submenu_page_names as $page_info) {
        $menu_tree = egb_menu_tree($page_info['name'] . '_menu');
        if (!empty($menu_tree)) {
            $menu_items = egb_menu($menu_tree[0]['uniq_id']);
            if (!empty($menu_items)) {
                // 이 서브메뉴 중에 현재 URL과 일치하는 것이 있는지 확인
                foreach ($menu_items as $item) {
                    if (strpos($current_url, $item['menu_url']) !== false) {
                        // 일치하는 서브메뉴를 찾았으므로 해당 트리 출력
                        $parent_active_index = $page_info['parent_index']; // 부모 메뉴 인덱스 저장
                        echo '<div class="flex_xc_yc width_box height_px_050 border_px-y_001 font_px_016 flv6" data-bd-y-color="#f8f6ef">';
                        foreach ($menu_items as $index => $submenu_item) {
                            echo '<a href="' . DOMAIN . $submenu_item['menu_url'] . '" class="egb_spa">';
                            echo '<div class="margin_px-x_020 padding_px-y_013 pointer" data-hover-class-add="mypage_menu_active_hover" id="mypage_menu2_'.$index.'">' . $submenu_item['menu_name'] . '</div>';
                            echo '</a>';
                            echo '<div class="-function-urlToggle" data-arg-1="mypage_menu2_'.$index.'" data-arg-2="false" data-arg-3="'.$submenu_item['menu_url'].'" data-arg-4="focusheaderrowmenu"></div>';
                        }
                        echo '</div>';
                        break 2; // 두 개의 루프 모두 종료
                    }
                }
            }
        }
    }
}

// 부모 메뉴 활성화 처리
if ($parent_active_index !== null) {
    echo '<div class="-function-urlToggle" data-arg-1="mypage_menu_'.$parent_active_index.'" data-arg-2="false" data-arg-3="" data-arg-4="mypage_menu_active"></div>';
}
?>