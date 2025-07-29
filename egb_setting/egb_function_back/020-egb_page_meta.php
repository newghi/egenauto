<?php
// page가 호출 될 때 메타정보를 설정 한다.
function egb_page_meta($site_title = null, $return_content = null, $return_title = null, $return_subject = null, $return_description = null, $return_keyword = null, $return_robots = null, $return_author = null, $return_img = DS . "egb_thumbnail.webp", $seo_publish_date = null, $seo_last_modified_at = null){

    // SEO 메타 정보 설정
    $_POST['site_title'] = $site_title; // 사이트 제목
    $_POST['return_content'] = $return_content; // 페이지 내용
    $_POST['seo_title'] = $return_title; // SEO 제목 
    $_POST['seo_subject'] = $return_subject; // SEO 주제
    $_POST['seo_description'] = $return_description; // SEO 설명
    $_POST['seo_keywords'] = $return_keyword; // SEO 키워드
    $_POST['seo_robots'] = $return_robots; // SEO 로봇 설정
    $_POST['seo_author'] = $return_author; // SEO 작성자
    $_POST['seo_og_img'] = DOMAIN.$return_img; // SEO OG 이미지
    $_POST['seo_publish_date'] = $seo_publish_date; // 발행일
    $_POST['seo_last_modified_at'] = $seo_last_modified_at; // 최종 수정일

    // 헤드 출력
    egb_head();

}
?>