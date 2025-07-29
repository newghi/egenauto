<?php
//바탕화면 폴더 이름
$egb_folder_name = 'media';
//바탕화면 메뉴 이름
$egb_title_name = '미디어 설정';
//바탕화면 아이콘
$folder_icon_svg = '
<svg class="svg_shadow" height="100%" viewBox="0 0 64 64" width="100%" xmlns="http://www.w3.org/2000/svg">
    <g id="music_·_multimedia_·_audio_·_player_·_media" data-name="music · multimedia · audio · player · media">
        <path d="m9 13h46a4 4 0 0 1 4 4v36a0 0 0 0 1 0 0h-54a0 0 0 0 1 0 0v-36a4 4 0 0 1 4-4z" fill="#004fac" />
        <path d="m9 17h46v32h-46z" fill="#2488ff" />
        <path d="m23 49h32v-32a32 32 0 0 1 -32 32z" fill="#006df0" />
        <rect fill="#ff9811" height="22" rx="2" width="26" x="3" y="23" />
        <rect fill="#ffcd00" height="22" rx="2" width="26" x="35" y="23" />
        <rect fill="#5eac24" height="22" rx="2" width="26" x="19" y="3" />
        <path d="m5 53h-2v4a4 4 0 0 0 4 4h50a4 4 0 0 0 4-4v-4z" fill="#003f8a" />
        <path d="m26 55a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-2h-12z" fill="#939598" />
        <path d="m7 27h18v14h-18z" fill="#d1e7f8" />
        <path d="m7 41h6l.903-1.505-2.903-5.495z" fill="#4e901e" />
        <path d="m13 41h12l-6-10z" fill="#5eac24" />
        <path d="m39 27h18v14h-18z" fill="#ff5023" />
        <path d="m23 7h18v14h-18z" fill="#ed1c24" />
        <circle cx="45" cy="37" fill="#ffc477" r="1" />
        <circle cx="51" cy="36" fill="#ffc477" r="1" />
        <g fill="#f1f2f2">
            <path d="m29 18 7-4.029-7-3.971z" />
            <path
                d="m51.835 29.014-6 1a1 1 0 0 0 -.835.986v4a2 2 0 1 0 2 2v-5.153l4-.666v2.819a2 2 0 1 0 2 2v-6a1 1 0 0 0 -1.165-.986z" />
        </g>
    </g>
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