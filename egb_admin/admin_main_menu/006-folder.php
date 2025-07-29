<?php
//바탕화면 폴더 이름
$egb_folder_name = 'folder';
//바탕화면 메뉴 이름
$egb_title_name = '관리 폴더';
//바탕화면 아이콘
$folder_icon_svg = '
<svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
    <g id="Folder">
        <path
            d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
            fill="#ffb125" />
        <path
            d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
            fill="#fcd354" />
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