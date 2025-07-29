<div class="display_none" egb:style="
    body{overflow: hidden;}
    .svg_shadow{filter: drop-shadow(1px 1px 5px #00000080);}
    .folder_name{word-break: break-all; white-space: normal; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;}
    .folder_name_border{text-shadow: -1px 0 1.5px #000000cc, 0 1px 1.5px #000000cc, 1px 0 1.5px #000000cc, 0 -1px 1.5px #000000cc;}
    .selected_folder_color{background-color: #00000060; border-radius: 15px;}
    .mouse_right_click{box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);}
    .center_position{transform: translate(-50%, -50%);}
    .dotted_border{border-bottom: #d9d9d9 dotted;}
    .icon_array{align-content: flex-start; -webkit-user-select: none !important; -moz-user-select: none !important; -ms-user-select: none !important; user-select: none !important;}
     ">
</div>
<section
    class="position1 main_box padding_px-t_070 padding_px-u_020 z-index_1 font_px_015 maximum_window_mode overflow_hidden"
    data-bg-color="#ffffff" data-bg-img="<?php echo DOMAIN . DS . 'egb_admin' . DS . 'admin_background_img.webp'; ?>">
    <div class="flex_ft_wrap height_box fontstyle2 icon_array no_color_change" data-color="#ffffff">
        <?php
        //폴더의 경로
        $path = ROOT . DS . 'egb_admin' . DS . 'admin_main_menu';

        // 폴더가 존재하는지 확인
        if (is_dir($path)) {

            //폴더가 존재 하는 경우.
            $folder = glob($path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기
        
            sort($folder); // 파일명을 정렬
        
            foreach ($folder as $folder_file) {
                require_once $folder_file;
            } // 파일을 하나씩 require_once 시킴
        
        }
        ?>
    </div>
    <div class="position2 mouse_right_click border_px-a_001 border_bre-a_005 z-index_4 display_none"
        data-bg-color="#ffffff" data-bd-a-color="#cccccc">
        <ul class="font_style_center white-_space_nowrap">
            <li class="padding_px-y_008 padding_px-x_020 pointer" data-hover-bg-color="#f0f0f0">1</li>
            <li class="padding_px-y_008 padding_px-x_020 pointer" data-hover-bg-color="#f0f0f0">2</li>
            <li class="padding_px-y_008 padding_px-x_020 pointer" data-hover-bg-color="#f0f0f0">3</li>
            <li class="padding_px-y_008 padding_px-x_020 pointer" data-hover-bg-color="#f0f0f0">4</li>
            <li class="padding_px-y_008 padding_px-x_020 pointer" data-hover-bg-color="#f0f0f0">5</li>
        </ul>
    </div>
</section>
<div id="modal_list"></div>