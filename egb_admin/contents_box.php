<?php
//여기 페이지는 건드릴거 1개도 없음.
$page_name = egb('template_id');
$modal_page_contents = 'modal_' . $page_name . '_contents';
?>
<div class="display_off" egb:style="
    .rotate{transition: 0.5s;}
    .site_<?php echo $page_name; ?>_menu_animation_1{transform: rotate(90deg);}
    .site_<?php echo $page_name; ?>_menu div:last-child {position: relative; display: inline-block; padding-bottom: 1px;}
    .site_<?php echo $page_name; ?>_menu div:last-child::after {content: ''; position: absolute; left: 0; bottom: 0; width: 0; height: 1px; background-color: #000; transition: width 0.3s ease-out;}
    .site_<?php echo $page_name; ?>_menu.active div:last-child::after {width: 100%;}
    .no_scroll{align-content: flex-start; -webkit-user-select: none !important; -moz-user-select: none !important; -ms-user-select: none !important; user-select: none !important;}
    .<?php echo $page_name; ?>_input{border: 1px solid #eeeeee; border-radius: 5px; font-family: fontstyle1; font-size: 14px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff;}
    select {outline: none; border: 1px solid #eeeeee; border-radius: 5px; font-family: fontstyle1; font-size: 14px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff;}
    select:focus{background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040;}
    textarea{resize: none; all: unset; border: 1px solid #eeeeee; border-radius: 5px; font-family: fontstyle1; font-size: 14px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff;}
    textarea:focus{background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040;}
    .hourglass{display: block; background: var(--bg-color); width: 2em; height: 4em; animation: hourglass 1s linear infinite;}
    .outer{fill: var(--fill-color);}
    .middle{fill: var(--bg-color);}
    input.<?php echo $page_name; ?>s_input_design{all: unset; width: 100%; padding: 6px 10px; font-size: 12px; font-family: fontstyle1; border: 1px solid #eeeeee; border-radius: 5px; background-color: #ffffff; box-sizing: border-box;}
    input.<?php echo $page_name; ?>s_input_design:focus{background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040;}
    select{outline: none; border: 1px solid #eeeeee; border-radius: 5px; font-family: fontstyle1; font-size: 14px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff;}
">
</div>
<section class="grid_xx min_height_355 height_box" data-xx="200px 1fr">
    <div class="height_box min_width_200 border_px-r_001" data-bd-a-color="#e9e9e9">
        <div class="padding_px-a_015 font_px_014 no_scroll">
            <?php
            //왼쪽 컨텐츠
            //폴더의 경로
            $path = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_name . DS . 'menu';

            // 폴더가 존재하는지 확인
            if (is_dir($path)) {

                //폴더가 존재 하는 경우.
                $menu_folder = glob($path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기
            
                sort($menu_folder); // 파일명을 정렬
            
                foreach ($menu_folder as $menu_folder_file) {
                    require_once $menu_folder_file;
                } // 파일을 하나씩 require_once 시킴
            
            }
            ?>
        </div>
    </div>
    <div class="position1 height_box">
        <div class="position2 width_box height_box" data-top="0%" data-left="0%">
            <div id="<?php echo $modal_page_contents; ?>" class="position1 width_box height_box scrollbar no_scroll">
                <?php
				//오른쪽 컨텐츠
                //폴더의 경로
                $menu_name = '';
                if (!empty($menu_folder) && isset($menu_folder[0])) {
                    $menu_name = preg_replace('/^\d+\-|\.[^.]*$/', '', basename($menu_folder[0]));
                }
                $path = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_name . DS . 'menu_contents' . DS . $menu_name;

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
        </div>
        <div id="<?php echo $page_name; ?>_loading" class="position2 display_off width_box height_box z-index_9999 egb_loading">
            <div class="flex_xc_yc width_box height_box" data-bg-color="#ffffff">
                <img src="<?php echo DOMAIN . DS . 'egb_admin' . DS . 'loading.gif'; ?>" class="width_px_300 height_px_300">
            </div>
        </div>
    </div>
</section>
<div egb:function="egbInitializeMenu('<?php echo $page_name; ?>');"></div>