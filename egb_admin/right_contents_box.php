<?php

$filter_page_name = egb('filter_page_name') ?? null;
$filter_menu_name = egb('filter_menu_name') ?? null;
//폴더의 경로
$path = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $filter_page_name . DS . 'menu_contents' . DS . $filter_menu_name;

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