<?php
// admin 페이지가 호출 될때 메타정보를 설정 한다.
function egb_admin_meta(){
	
if (isset($_SESSION['admin_login'])){ $admin_login = $_SESSION['admin_login']; } else {$admin_login = 0;}
if ($admin_login != 1) {egb_file_load(DS . 'egb_admin' . DS . 'admin-login.php'); exit;}// 로그인 상태가 아니라면 로그인 페이지 출력

$page_title = '관리자 페이지';
$meta_title = '관리자 페이지';
$meta_subject = '관리자 페이지';
$meta_description = '관리자 페이지';
$meta_keywords = '관리자';
$meta_robots = 'nofollow, noindex';
$meta_author = 'eungabi';
$meta_image = DS . 'egb_icon.webp';
$publish_date = '2023-12-30';
$modified_date = '2023-12-30';

$_POST['page_title'] = $page_title;
$_POST['return_content'] = null;
$_POST['seo_title'] = $meta_title;
$_POST['seo_subject'] = $meta_subject;
$_POST['seo_description'] = $meta_description;
$_POST['seo_keywords'] = $meta_keywords;
$_POST['seo_robots'] = $meta_robots;
$_POST['seo_author'] = $meta_author;
$_POST['seo_og_img'] = DOMAIN.$meta_image;
$_POST['created_at'] = $publish_date;
$_POST['updated_at'] = $modified_date;

egb_head();

}//egb_admin_meta();

?>