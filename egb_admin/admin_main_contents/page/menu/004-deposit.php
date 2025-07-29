<?php
$menu_name = '예치금 관리';

//이 아래로는 건드릴 필요 없음.

$page_name = basename(dirname(dirname(__FILE__))); // 이전 이전 디렉토리 명을 가져옴
$menu_path_name = preg_replace('/^\d+\-|\.[^.]*$/', '', basename(__FILE__));

$folder_path = dirname(__FILE__);
$files = glob($folder_path . '/*.php');
$first_file = reset($files);
$last_file = end($files);

$active_menu = (basename(__FILE__) == basename($first_file)) ? 'active flv6' : '';
$last_menu = (basename(__FILE__) == basename($last_file)) ? true : false;

$site_page_name_menu = 'site_' . $page_name . '_menu';
$site_menu_id = $site_page_name_menu . $menu_path_name;

$modal_page_contents = 'modal_' . $page_name . '_contents';
$modal_page_contents_id = $modal_page_contents . '_' . $menu_path_name;

?>
<div id="<?php echo $site_menu_id; ?>"
  class="flex_fl_yc padding_px-y_008 position1 <?php echo $site_page_name_menu; ?> <?php echo $active_menu; ?>"
  egb:click="
egbT('<?php echo $modal_page_contents; ?>', 
'id=<?php echo $modal_page_contents_id; ?>
&path=/right_contents_box
&filter_page_name=<?php echo $page_name; ?>
&filter_menu_name=<?php echo $menu_path_name; ?>'

, true);
<?php
// add와 edit, column, view 메뉴 파일들 검사 
$types = ['add', 'edit', 'column', 'view', 'setting'];
foreach($types as $type) {
    $i = 1;
    while(true) {
        $suffix = $i > 1 ? $i : '';
        $menu_value = $type . $suffix . '_' . $menu_path_name;
        $path = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_name . DS . 'menu_' . $type . DS . $menu_value . '.php';
        
        if (!file_exists($path)) {
            break;
        }
        
        echo "egbTc('modal_list', 'id=" . $menu_value . "&path=/modal_box');";
        $i++;
    }
}
?>
">
  <div class="pointer"><?php echo $menu_name; ?></div>
</div>
<?php if($last_menu) { ?>
<div egb:function="egbInitializeMenu('<?php echo $page_name; ?>')"></div>
<?php } ?>