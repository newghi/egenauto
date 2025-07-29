<?php
//바탕화면 폴더 이름
$egb_folder_name = 'shop';
//바탕화면 메뉴 이름
$egb_title_name = '쇼핑몰 설정';
//바탕화면 아이콘
$folder_icon_svg = '
<svg class="svg_shadow" id="Artboard_30" height="100%" viewBox="0 0 64 64" width="100%"
    xmlns="http://www.w3.org/2000/svg" data-name="Artboard 30">
    <path d="m60 59v-35.28a2 2 0 0 0 -1.7-1.978l-31.3-4.742v42z" fill="#b5b1a5" />
    <path d="m60 23.72a2 2 0 0 0 -1.7-1.978l-28.3-4.287v26.132a11.413 11.413 0 0 0 11.413 11.413h18.587z"
        fill="#d9d5ca" />
    <path
        d="m25 13.173v-7.731a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.568 21.568 0 0 0 -6.82-1.107 21.568 21.568 0 0 0 -6.82 1.107l-1.312.437a2 2 0 0 0 -1.368 1.898v7.732z"
        fill="#66c2ed" />
    <path
        d="m4 59v-42.362a4 4 0 0 1 2.424-3.677l.44-.188a21.916 21.916 0 0 1 8.636-1.773 21.916 21.916 0 0 1 8.636 1.773l.44.188a4 4 0 0 1 2.424 3.677v42.362z"
        fill="#66c2ed" />
    <path
        d="m27 16.638a4 4 0 0 0 -2.424-3.677l-.44-.188a21.712 21.712 0 0 0 -16.114-.429c-.007.1-.022.194-.022.294v31.732a10.63 10.63 0 0 0 10.63 10.63h8.37z"
        fill="#76d8ff" />
    <rect fill="#494949" height="3" rx="1.5" width="20" x="33" y="40" />
    <path d="m36 43h14v16h-14z" fill="#76d8ff" />
    <path d="m42 43h2v16h-2z" fill="#d6fdff" />
    <path
        d="m21 11.73c-.661-.171-1.326-.312-2-.421v9.022a19.511 19.511 0 0 0 -7 .02v-9.042c-.674.109-1.339.25-2 .421v9.094a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v7.9a19.272 19.272 0 0 0 -5.293 2.494l-.707.467v2.41l1.825-1.22a17.221 17.221 0 0 1 4.175-2.05v7.894a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v8.895a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v5.071h2v-5.623a17.5 17.5 0 0 1 7 0v5.623h2v-5.106a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-8.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.275 19.275 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948zm-2 39.6a19.511 19.511 0 0 0 -7 .02v-8.973a17.479 17.479 0 0 1 7 0zm0-11a19.511 19.511 0 0 0 -7 .02v-7.972a17.479 17.479 0 0 1 7 0zm0-10a19.488 19.488 0 0 0 -7 .02v-7.973a17.479 17.479 0 0 1 7 0z"
        fill="#d6fdff" />
    <g fill="#b53c33">
        <path
            d="m36 23.97h-1a1 1 0 0 0 -.928.628l-1.072 2.68-1.071-2.678a1 1 0 0 0 -.929-.63h-1a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-4.308l1.071 2.679a1 1 0 0 0 1.858 0l1.071-2.679v4.308a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-7a1 1 0 0 0 -1-1z" />
        <path
            d="m43 23.97h-2a1 1 0 0 0 -.97.757l-1.758 7.03a1 1 0 0 0 .728 1.213 1 1 0 0 0 1.213-.728l.568-2.272h2.438l.568 2.272a1 1 0 0 0 1.213.728 1 1 0 0 0 .728-1.213l-1.758-7.03a1 1 0 0 0 -.97-.757zm-1.719 4 .5-2h.438l.5 2z" />
        <path
            d="m48 23.97a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1h-2v-6a1 1 0 0 0 -1-1z" />
        <path d="m55 30.97v-6a1 1 0 0 0 -1-1 1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1z" />
    </g>
    <path
        d="m25 5.442a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.562 21.562 0 0 0 -13.64 0l-.68.226v4.613a2.085 2.085 0 0 0 2.631 2.028c5.84-1.706 12.016-.084 14.369.677z"
        fill="#76d8ff" />
    <rect fill="#494949" height="3" rx="1.5" width="60" x="2" y="59" />
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