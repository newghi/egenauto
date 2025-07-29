<?php

$filter_table_name = egb('filter_table_name', 29);

$filter_page_name = egb('filter_page_name');
$filter_menu_name = egb('filter_menu_name'); 
$filter_page = egb('filter_page');
$filter_per_page = egb('filter_per_page');
$filter_order = egb('filter_order');
$filter_is_status = egb('filter_is_status');
$filter_search_input = egb('filter_search_input');
$filter_user_id = egb('filter_user_id');

$page_title = egb('page_title', 30);
$page_name = egb('page_name', 31); 
$page_type = egb('page_type', 32);
$display_order = egb('display_order', 33);
$page_seo = egb('page_seo', 34);
$page_use = egb('page_use', 35);
$page_rank = egb('page_rank', 36);
$page_view = egb('page_view', 37);
$page_theme = egb('page_theme', 52);;
$page_plugin = null;
$page_source = 'admin';

$seo_title = egb('seo_title', 38);
$seo_subject = egb('seo_subject', 39);
$seo_description = egb('seo_description', 40);
$seo_keywords = egb('seo_keywords', 41);
$seo_robots = egb('seo_robots', 40);
$seo_canonical = egb('seo_canonical', 41);
$seo_og_title = egb('seo_og_title', 42);
$seo_og_description = egb('seo_og_description', 43);
$seo_author = egb('seo_author', 44);
$setting_header_use = egb('setting_header_use', 45);
$setting_footer_use = egb('setting_footer_use', 46);
$setting_comment_use = egb('setting_comment_use', 47);
$setting_access_level = egb('setting_access_level', 48);

// page_name 중복 체크 (데이터베이스) - 동일 테마 내에서만 체크
$check_query = "SELECT COUNT(*) as cnt FROM $filter_table_name WHERE page_name = :page_name AND page_theme = :page_theme";
$check_params = [
    ':page_name' => $page_name,
    ':page_theme' => $page_theme
];
$check_binding = binding_sql(1, $check_query, $check_params);
$check_result = egb_sql($check_binding);

if ($check_result[0]['cnt'] > 0) {
    echo json_encode(['success' => false, 'failureCode' => 49]); // 페이지명 중복 에러 코드
    exit;
}

// 파일 중복 체크
$check_file_path = ROOT . DS . 'egb_themes' . DS . $page_theme . DS . 'page' . DS . $page_name . '.php';
if (file_exists($check_file_path)) {
    echo json_encode(['success' => false, 'failureCode' => 49]); // 페이지명 중복 에러 코드
    exit;
}

$uniq_id = uniqid();
$page_path = '';
$created_by = $filter_user_id;

// page_type이 path인 경우 페이지 파일 생성
if ($page_type == 'path') {
    $page_file_path = ROOT . DS . 'egb_themes' . DS . $page_theme . DS . 'page' . DS . $page_name . '.php';
    $page_path = DS . 'egb_themes' . DS . $page_theme . DS . 'page' . DS . $page_name . '.php';
    
    // 디렉토리 존재 여부 확인 및 생성
    $dir_path = dirname($page_file_path);
    if (!is_dir($dir_path)) {
        mkdir($dir_path, 0755, true);
    }

    // 파일 생성
    $file_created = file_put_contents($page_file_path, "<?php\n// 자동 생성 페이지\n?>\n<p>페이지가 추가되었습니다.</p>");

    if ($file_created == false) {
        echo json_encode(['success' => false, 'failureCode' => 50]); 
        exit;
    }
}

$seo_og_img = DS . 'egb_thumbnail.webp';
if (isset($_FILES['seo_og_img'])) {
    $seo_og_img_uniq_id = uniqid();
    $resource_id = egb_resource($seo_og_img_uniq_id, 'seo_og_img');
    if ($resource_id) {
        $seo_og_img = DS . '?img3=' . $resource_id;
    }
}

$query = "
INSERT INTO egb_page (
    uniq_id, is_status, display_order,
    page_title, page_name, page_path, page_type, page_seo, page_use, page_rank, page_view,
    page_theme, page_plugin, page_source,
    seo_title, seo_subject, seo_description, seo_keywords, seo_robots, seo_canonical,
    seo_og_title, seo_og_description, seo_og_img, seo_author,
    setting_header_use, setting_footer_use, setting_comment_use, setting_access_level,
    created_by
) VALUES (
    :uniq_id, 1, :display_order,
    :page_title, :page_name, :page_path, :page_type, :page_seo, :page_use, :page_rank, :page_view,
    :page_theme, :page_plugin, :page_source,
    :seo_title, :seo_subject, :seo_description, :seo_keywords, :seo_robots, :seo_canonical,
    :seo_og_title, :seo_og_description, :seo_og_img, :seo_author,
    :setting_header_use, :setting_footer_use, :setting_comment_use, :setting_access_level,
    :created_by
)";
$params = [
    ':uniq_id' => $uniq_id,
    ':display_order' => $display_order,
    ':page_title' => $page_title,
    ':page_name' => $page_name,
    ':page_path' => $page_path,
    ':page_type' => $page_type,
    ':page_seo' => $page_seo,
    ':page_use' => $page_use,
    ':page_rank' => $page_rank,
    ':page_view' => $page_view,
    ':page_theme' => $page_theme,
    ':page_plugin' => $page_plugin,
    ':page_source' => $page_source,
    ':seo_title' => $seo_title,
    ':seo_subject' => $seo_subject,
    ':seo_description' => $seo_description,
    ':seo_keywords' => $seo_keywords,
    ':seo_robots' => $seo_robots,
    ':seo_canonical' => $seo_canonical,
    ':seo_og_title' => $seo_og_title,
    ':seo_og_description' => $seo_og_description,
    ':seo_og_img' => $seo_og_img,
    ':seo_author' => $seo_author,
    ':setting_header_use' => $setting_header_use,
    ':setting_footer_use' => $setting_footer_use,
    ':setting_comment_use' => $setting_comment_use,
    ':setting_access_level' => $setting_access_level,
    ':created_by' => $created_by
];
$binding = binding_sql(2, $query, $params);
$sql = egb_sql($binding);

if ($sql[0]) {
    // 페이지 추가 성공 시 레코드 카운트 증가
    increase_record_total_count('egb_page');
    increase_record_active_count('egb_page');

    echo json_encode([
        'success' => true,
        'successCode' => 7,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name, 
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_per_page,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input
    ]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 51]);
}
?>
