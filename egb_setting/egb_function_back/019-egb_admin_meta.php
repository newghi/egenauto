<?php
// aadmin 페이지가 호출 될때 메타정보를 설정 한다.
function egb_admin_meta(){
	
if (isset($_SESSION['admin_login'])){ $admin_login = $_SESSION['admin_login']; } else {$admin_login = '없음';}
if ($admin_login != 'Y') {egb_file_load('/egb_admin/admin-login.php'); exit;}// 로그인 상태가 아니라면 로그인 페이지 출력

$mata_title = '관리자 페이지';
$mata_subject = '관리자 페이지';
$mata_description = '관리자 페이지';
$mata_author = 'eungabi';
$mata_robots = 'none';
$mata_keyword = '관리자';
$site_title = '관리자 페이지';
$return_img = DS . 'egb_icon.webp';
$seo_publish_date = '2023-12-30';
$seo_last_modified_at = '2023-12-30';

$_POST['site_title'] = $site_title;
$_POST['return_content'] = null;
$_POST['mata_title'] = $mata_title;
$_POST['mata_subject'] = $mata_subject;
$_POST['mata_description'] = $mata_description;
$_POST['mata_keyword'] = $mata_keyword;
$_POST['mata_robots'] = $mata_robots;
$_POST['mata_author'] = $mata_author;
$_POST['mata_img'] = $return_img;
$_POST['seo_publish_date'] = $seo_publish_date;
$_POST['seo_last_modified_at'] = $seo_last_modified_at;

egb_head();

}//egb_admin_meta();

?>