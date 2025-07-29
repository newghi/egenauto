<?php
//바탕화면 폴더 이름
$egb_folder_name = 'game';
//바탕화면 메뉴 이름
$egb_title_name = '미니게임';
//바탕화면 아이콘
$folder_icon_svg = '
<svg class="svg_shadow" id="Layer_1" height="100%" viewBox="0 0 48 48" width="100%"
    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-name="Layer 1">
    <linearGradient id="linear-gradient" gradientUnits="userSpaceOnUse" x1="24" x2="24" y1="9.126" y2="40.022">
        <stop offset="0" stop-color="#3e4154" />
        <stop offset="1" stop-color="#1b2129" />
    </linearGradient>
    <linearGradient id="linear-gradient-2" x2="24" xlink:href="#linear-gradient" y1="24.921" y2="26.96" />
    <linearGradient id="linear-gradient-3" x1="36" x2="36" xlink:href="#linear-gradient" y1="2.56"
        y2="24.881" />
    <linearGradient id="linear-gradient-4" x1="12" x2="12" xlink:href="#linear-gradient" y1="2.56"
        y2="24.881" />
    <linearGradient id="linear-gradient-5" gradientUnits="userSpaceOnUse" x1="34.5" x2="37.5" y1="15.5"
        y2="15.5">
        <stop offset="0" stop-color="#fed200" />
        <stop offset="1" stop-color="#f59815" />
    </linearGradient>
    <linearGradient id="linear-gradient-6" gradientUnits="userSpaceOnUse" x1="34.939" x2="37.061" y1="21.439"
        y2="23.561">
        <stop offset="0" stop-color="#6fc6fc" />
        <stop offset="1" stop-color="#50a7f6" />
    </linearGradient>
    <linearGradient id="linear-gradient-7" gradientUnits="userSpaceOnUse" x1="38.439" x2="40.561" y1="17.939"
        y2="20.061">
        <stop offset="0" stop-color="#34ca82" />
        <stop offset="1" stop-color="#37a477" />
    </linearGradient>
    <linearGradient id="linear-gradient-8" gradientUnits="userSpaceOnUse" x1="31.439" x2="33.561" y1="17.939"
        y2="20.061">
        <stop offset="0" stop-color="#e85155" />
        <stop offset="1" stop-color="#c21d2c" />
    </linearGradient>
    <linearGradient id="linear-gradient-9" gradientUnits="userSpaceOnUse" x1="8.468" x2="15.316" y1="15.468"
        y2="22.316">
        <stop offset="0" stop-color="#edf1f2" />
        <stop offset="1" stop-color="#c6cbcc" />
    </linearGradient>
    <path
        d="m42.059 40c-3.252 0-7.162-3.224-10.812-9h-14.494c-4.237 6.706-8.824 9.973-12.323 8.75a5.5 5.5 0 0 1 -3.077-3.056c-2.215-4.646-1.653-13.749 1.373-22.137a10.049 10.049 0 0 1 15.443-4.557h11.662a10.049 10.049 0 0 1 15.443 4.557c3.024 8.388 3.588 17.491 1.373 22.137a5.5 5.5 0 0 1 -3.077 3.056 4.555 4.555 0 0 1 -1.511.25z"
        fill="url(#linear-gradient)" />
    <path d="m26 27h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z" fill="url(#linear-gradient-2)" />
    <circle cx="36" cy="19" fill="url(#linear-gradient-3)" r="7.5" />
    <circle cx="12" cy="19" fill="url(#linear-gradient-4)" r="7" />
    <circle cx="36" cy="15.5" fill="url(#linear-gradient-5)" r="1.5" />
    <circle cx="36" cy="22.5" fill="url(#linear-gradient-6)" r="1.5" />
    <circle cx="39.5" cy="19" fill="url(#linear-gradient-7)" r="1.5" />
    <circle cx="32.5" cy="19" fill="url(#linear-gradient-8)" r="1.5" />
    <path
        d="m15.5 17.5h-2v-2a1.5 1.5 0 0 0 -3 0v2h-2a1.5 1.5 0 0 0 0 3h2v2a1.5 1.5 0 0 0 3 0v-2h2a1.5 1.5 0 0 0 0-3z"
        fill="url(#linear-gradient-9)" />
</svg>
';

//이 아래로는 건드릴 필요 없음.
//폴더의 경로
$path = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $egb_folder_name . DS . 'menu';
// 폴더가 존재하는지 확인
if (is_dir($path)) {
	//폴더가 존재 하는 경우.
	$menu_folder = glob($path . DS . '*.php'); // 폴더내 PHP 파일을 모두 가져오기

	sort($menu_folder); // 파일명을 정렬

	$menu_name_1 = preg_replace('/^\d+\-|\.[^.]*$/', '', basename($menu_folder[0]));

}
//egb:click 메인 폴더의 클릭은 해당 폴더의 모달 그리고 첫번째 메뉴에 대한 모달만 로드 한다.
?>
<?php
// 파일 경로 설정
$path_1 = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $egb_folder_name . 'menu_add/add_'.$menu_name_1.'.php';
$path_2 = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $egb_folder_name . 'menu_edit/edit_'.$menu_name_1.'.php';

// 모든 출력을 하나의 문자열로 구성
$output = '<div';
$output .= ' class="cm_'.$egb_folder_name.' width_px_090 height_px_110 flex_ft_yc margin_px-a_005 padding_px-a_005 font_style_center pointer egb_title selected_folder"';
$output .= ' egb:click="';
$output .= "egbTc('modal_list', 'id=".$egb_folder_name."&path=/egb/002-modal/modal_box');";

if (file_exists($path_1)) {
    $output .= "egbTc('modal_list', 'id=add_".$menu_name_1."&path=/egb/002-modal/modal_box');";
}

if (file_exists($path_2)) {
    $output .= "egbTc('modal_list', 'id=edit_".$menu_name_1."&path=/egb/002-modal/modal_box');";
}

$output .= '">';

// 한 번에 출력
echo $output;
?>
    <div class="width_px_055 height_px_055">
        <?php echo $folder_icon_svg; ?>
    </div>
    <div class="egb_drop padding_px-t_005 folder_name folder_name_border padding_px-t_005 egb_title_name"><?php echo $egb_title_name; ?></div>
</div>