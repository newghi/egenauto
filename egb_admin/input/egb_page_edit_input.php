<?php
// 필터 값 가져오기
$filter_table_name = egb('filter_table_name', 53);
$filter_page_name = egb('filter_page_name');
$filter_menu_name = egb('filter_menu_name');
$filter_page = egb('filter_page'); 
$filter_per_page = egb('filter_per_page');
$filter_order = egb('filter_order');
$filter_is_status = egb('filter_is_status');
$filter_search_input = egb('filter_search_input');
$filter_user_id = egb('filter_user_id');
$uniq_id = egb('uniq_id');

// 페이지 정보 가져오기
$page_title = egb('page_title', 54);
$display_order = egb('display_order', 55);
$page_seo = egb('page_seo', 56);
$page_use = egb('page_use', 57);
$page_rank = egb('page_rank', 58);

// SEO 정보 가져오기
$seo_title = egb('seo_title', 59);
$seo_subject = egb('seo_subject', 60);
$seo_description = egb('seo_description', 61);
$seo_keywords = egb('seo_keywords', 62);
$seo_robots = egb('seo_robots', 63);
$seo_canonical = egb('seo_canonical', 64);
$seo_og_title = egb('seo_og_title', 65);
$seo_og_description = egb('seo_og_description', 66);
$seo_author = egb('seo_author', 67);

// 설정 정보 가져오기
$setting_header_use = egb('setting_header_use', 68);
$setting_footer_use = egb('setting_footer_use', 69);
$setting_comment_use = egb('setting_comment_use', 70);
$setting_access_level = egb('setting_access_level', 71);

// 기존 SEO 이미지 정보 가져오기
$existing_image_query = "SELECT seo_og_img FROM egb_page WHERE uniq_id = :uniq_id";
$existing_image_binding = binding_sql(1, $existing_image_query, [':uniq_id' => $uniq_id]);
$existing_image_result = egb_sql($existing_image_binding);
$existing_seo_og_img = isset($existing_image_result[0]['seo_og_img']) ? $existing_image_result[0]['seo_og_img'] : null;

// SEO 이미지 처리
$seo_og_img = $existing_seo_og_img; // 기본값으로 기존 이미지 설정
$seo_og_img_uniq_id = str_replace(DS . '?img3=', '', $existing_seo_og_img);

$resource_id = egb_resource($seo_og_img_uniq_id, 'seo_og_img');
if ($resource_id) {
    $seo_og_img = DS . '?img3=' . $resource_id;
}

/*
if (isset($_FILES['seo_og_img']) && $_FILES['seo_og_img']['error'] == 0) {
    if ($existing_seo_og_img == DS . 'egb_thumbnail.webp') {
        // 기본 이미지인 경우 새로운 리소스 생성
        $resource_id = egb_resource_insert('seo_og_img');
        if ($resource_id) {
            $seo_og_img = DS . '?img3=' . $resource_id;
        }
    } else {
        // 기존 이미지가 있는 경우 업데이트
        $seo_og_img_uniq_id = str_replace(DS . '?img3=', '', $existing_seo_og_img);
        $resource_id = egb_resource_update($seo_og_img_uniq_id, 'seo_og_img');
        if ($resource_id) {
            $seo_og_img = DS . '?img3=' . $resource_id;
        }
    }
}
*/
// 업데이트 쿼리 생성
$query = "UPDATE egb_page SET 
    page_title = :page_title,
    display_order = :display_order,
    page_seo = :page_seo,
    page_use = :page_use,
    page_rank = :page_rank,
    seo_title = :seo_title,
    seo_subject = :seo_subject,
    seo_description = :seo_description,
    seo_keywords = :seo_keywords,
    seo_robots = :seo_robots,
    seo_canonical = :seo_canonical,
    seo_og_title = :seo_og_title,
    seo_og_description = :seo_og_description,
    seo_author = :seo_author,
    setting_header_use = :setting_header_use,
    setting_footer_use = :setting_footer_use,
    setting_comment_use = :setting_comment_use,
    setting_access_level = :setting_access_level,
    seo_og_img = :seo_og_img";

$query .= " WHERE uniq_id = :uniq_id";

// 파라미터 설정
$params = [
    ':page_title' => $page_title,
    ':display_order' => $display_order,
    ':page_seo' => $page_seo,
    ':page_use' => $page_use,
    ':page_rank' => $page_rank,
    ':seo_title' => $seo_title,
    ':seo_subject' => $seo_subject,
    ':seo_description' => $seo_description,
    ':seo_keywords' => $seo_keywords,
    ':seo_robots' => $seo_robots,
    ':seo_canonical' => $seo_canonical,
    ':seo_og_title' => $seo_og_title,
    ':seo_og_description' => $seo_og_description,
    ':seo_author' => $seo_author,
    ':setting_header_use' => $setting_header_use,
    ':setting_footer_use' => $setting_footer_use,
    ':setting_comment_use' => $setting_comment_use,
    ':setting_access_level' => $setting_access_level,
    ':seo_og_img' => $seo_og_img,
    ':uniq_id' => $uniq_id
];

// 쿼리 실행
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

// 결과 반환
if ($sql[0]) {
    echo json_encode([
        'success' => true,
        'successCode' => 8,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_per_page,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input
    ]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 72]);
}
?>
