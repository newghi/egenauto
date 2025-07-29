<?php
//바탕화면 폴더 이름
$egb_folder_name = 'page';
//바탕화면 메뉴 이름
$egb_title_name = '사이트 관리';
//바탕화면 아이콘
$folder_icon_svg = '
<svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
    <g id="Layer_17" data-name="Layer 17">
        <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
        <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
        <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
        <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
            fill="#ebf7fe" />
        <path d="m6 14h21v14h-21z" fill="#4472b0" />
        <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
        <path d="m18 2h30v8h-30z" fill="#698ec0" />
        <path d="m2 2h16v8h-16z" fill="#4472b0" />
        <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
        <g fill="#fff">
            <path d="m55 56h2v2h-2z" />
            <path d="m51 56h2v2h-2z" />
            <path d="m46 43-3-10 10 3-5 2z" />
            <path d="m5 5h2v2h-2z" />
            <path d="m9 5h2v2h-2z" />
            <path d="m13 5h2v2h-2z" />
            <path d="m21 5h24v2h-24z" />
        </g>
        <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
        <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
        <path d="m6 32h34v4h-34z" fill="#976947" />
        <path d="m31 14h13v6h-13z" fill="#976947" />
        <path d="m30 27h15v2h-15z" fill="#976947" />
        <path d="m30 23h15v2h-15z" fill="#976947" />
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
// 모든 출력을 하나의 문자열로 구성
$output = '<div';
$output .= ' class="cm_'.$egb_folder_name.' width_px_090 height_px_110 flex_ft_yc margin_px-a_005 padding_px-a_005 font_style_center pointer egb_title selected_folder"';
$output .= ' egb:click="';
$output .= "egbTc('modal_list', 'id=".$egb_folder_name."&path=/modal_box');";

// add와 edit, column, view 메뉴 파일들 검사 
$types = ['add', 'edit', 'column', 'view', 'setting'];
foreach($types as $type) {
    $i = 1;
    while(true) {
        $suffix = $i > 1 ? $i : '';
        $menu_value = $type . $suffix . '_' . $menu_name_1;
        $path = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $egb_folder_name . DS . 'menu_' . $type . DS . $menu_value . '.php';
        
        if (!file_exists($path)) {
            break;
        }
        
        $output .= "egbTc('modal_list', 'id=" . $menu_value . "&path=/modal_box');";
        $i++;
    }
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