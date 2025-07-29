<?php
// page가 호출 될 때 메타정보를 설정 한다.
function egb_page_meta($page_title = null, $page_content = null, $meta_title = null, $meta_subject = null, $meta_description = null, $meta_keywords = null, $meta_robots = null, $meta_author = null, $meta_image = null, $publish_date = null, $modified_date = null){

    // SEO 메타 정보 설정
    $_POST['page_title'] = ($page_title) ? $page_title : '페이지 제목'; // 사이트 제목
    $_POST['return_content'] = $page_content; // 페이지 내용
    $_POST['seo_title'] = ($meta_title) ? $meta_title : 'SEO 제목'; // SEO 제목
    $_POST['seo_subject'] = ($meta_subject) ? $meta_subject : 'SEO 주제'; // SEO 주제
    $_POST['seo_description'] = ($meta_description) ? $meta_description : 'SEO 설명'; // SEO 설명
    $_POST['seo_keywords'] = ($meta_keywords) ? $meta_keywords : 'SEO 키워드'; // SEO 키워드
    $_POST['seo_robots'] = ($meta_robots) ? $meta_robots : 'nofollow, noindex'; // SEO 로봇 설정
    $_POST['seo_author'] = ($meta_author) ? $meta_author : 'SEO 작성자'; // SEO 작성자
    $_POST['seo_og_img'] = ($meta_image) ? DOMAIN.$meta_image : DS . "egb_thumbnail.webp"; // SEO OG 이미지
    $_POST['created_at'] = ($publish_date) ? $publish_date : date('Y-m-d'); // 발행일
    $_POST['updated_at'] = ($modified_date) ? $modified_date : date('Y-m-d'); // 최종 수정일

    // 헤드 출력
    egb_head();

}
?>