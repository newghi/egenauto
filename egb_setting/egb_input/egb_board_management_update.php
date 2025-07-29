<?php
// POST 데이터를 변수에 할당
$board_mangement_uniq_id = $_POST['board_mangement_uniq_id'] ?? null;
$board_mangement_admin_uniq_id = $_POST['board_mangement_admin_uniq_id'] ?? null;
$board_mangement_board_no = $_POST['board_mangement_board_no'] ?? null;
$board_mangement_board_themes = $_POST['board_mangement_board_themes'] ?? 'default';
$board_mangement_board_editor = $_POST['board_mangement_board_editor'] ?? 'smarteditor2';
$board_mangement_table_comment_name = $_POST['board_mangement_table_comment_name'] ?? null;
$board_mangement_route_board_name = $_POST['board_mangement_route_board_name'] ?? null;

// 현재 변수에 할당된 값과 데이터베이스에 있는 값이 같은지 비교하는 쿼리
$checkExistingQuery = "SELECT board_mangement_route_board_name FROM egb_board_mangement WHERE board_mangement_uniq_id = :board_mangement_uniq_id";
$checkExistingParams = [':board_mangement_uniq_id' => $board_mangement_uniq_id];
$checkExistingBinding = binding_sql(1, $checkExistingQuery, $checkExistingParams);
$existingResult = egb_sql($checkExistingBinding);

if ($existingResult && isset($existingResult[0])) {
    $existingRouteBoardName = $existingResult[0]['board_mangement_route_board_name'];

    // 라우트 이름이 다른 경우 중복 확인
    if ($existingRouteBoardName !== $board_mangement_route_board_name) {
        if (isset($board_mangement_route_board_name)) {
            // 라우트 이름 중복 확인 쿼리 (현재 레코드를 제외한 중복 확인)
            $checkQueryRoute = "SELECT COUNT(*) as count FROM egb_board_mangement WHERE board_mangement_route_board_name = :board_mangement_route_board_name AND board_mangement_uniq_id != :board_mangement_uniq_id";
            $checkParamsRoute = [
                ':board_mangement_route_board_name' => $board_mangement_route_board_name,
                ':board_mangement_uniq_id' => $board_mangement_uniq_id
            ];
            $checkBindingRoute = binding_sql(1, $checkQueryRoute, $checkParamsRoute);
            $checkResultRoute = egb_sql($checkBindingRoute);

            // 라우트 이름 중복 확인 결과 처리
            if ($checkResultRoute[0]['count'] > 0) {
                echo json_encode(['success' => false, 'failureCode' => 20]); // 라우트 이름 중복
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'failureCode' => 21]); // 라우트 이름 필수값 없음
            exit;
        }
    }
}

$board_mangement_route_board_type = $_POST['board_mangement_route_board_type'] ?? null;
$board_mangement_comment_name = $_POST['board_mangement_comment_name'] ?? null;
$board_mangement_custom_name = $_POST['board_mangement_custom_name'] ?? '';
$board_mangement_category_name = $_POST['board_mangement_category_name'] ?? null;
$board_mangement_class_name = $_POST['board_mangement_class_name'] ?? null;
$board_mangement_board_status = $_POST['board_mangement_board_status'] ?? 'on';
$board_mangement_comment_status = $_POST['board_mangement_comment_status'] ?? 'on';
$board_mangement_comment_count = $_POST['board_mangement_comment_count'] ?? '0';
$board_mangement_board_list_count = $_POST['board_mangement_board_list_count'] ?? '5';
$board_mangement_board_list_pagination_count = $_POST['board_mangement_board_list_pagination_count'] ?? '5';
$board_mangement_board_write_after_page = $_POST['board_mangement_board_write_after_page'] ?? null;
$board_mangement_board_view_level = $_POST['board_mangement_board_view_level'] ?? 1;
$board_mangement_board_write_level = $_POST['board_mangement_board_write_level'] ?? 1;
$board_mangement_board_edit_level = $_POST['board_mangement_board_edit_level'] ?? 1;
$board_mangement_board_delete_level = $_POST['board_mangement_board_delete_level'] ?? 1;
$board_mangement_board_upload_level = $_POST['board_mangement_board_upload_level'] ?? 1;
$board_mangement_board_download_level = $_POST['board_mangement_board_download_level'] ?? 1;
$board_mangement_board_reply_level = $_POST['board_mangement_board_reply_level'] ?? 1;
$board_mangement_board_homepage_level = $_POST['board_mangement_board_homepage_level'] ?? 1;
$board_mangement_board_link_level = $_POST['board_mangement_board_link_level'] ?? 1;
$board_mangement_comment_view_level = $_POST['board_mangement_comment_view_level'] ?? 1;
$board_mangement_comment_write_level = $_POST['board_mangement_comment_write_level'] ?? 1;
$board_mangement_comment_edit_level = $_POST['board_mangement_comment_edit_level'] ?? 1;
$board_mangement_comment_delete_level = $_POST['board_mangement_comment_delete_level'] ?? 1;
$board_mangement_comment_upload_level = $_POST['board_mangement_comment_upload_level'] ?? 1;
$board_mangement_comment_download_level = $_POST['board_mangement_comment_download_level'] ?? 1;
$board_mangement_comment_reply_level = $_POST['board_mangement_comment_reply_level'] ?? 1;
$board_mangement_comment_homepage_level = $_POST['board_mangement_comment_homepage_level'] ?? 1;
$board_mangement_comment_link_level = $_POST['board_mangement_comment_link_level'] ?? 1;
$board_mangement_board_comment_count_edit_level = $_POST['board_mangement_board_comment_count_edit_level'] ?? 1;
$board_mangement_board_comment_count_delete_level = $_POST['board_mangement_board_comment_count_delete_level'] ?? 1;
$board_mangement_board_top = $_POST['board_mangement_board_top'] ?? 'on';
$board_mangement_board_secret = $_POST['board_mangement_board_secret'] ?? 'off';
$board_mangement_comment_secret = $_POST['board_mangement_comment_secret'] ?? 'off';
$board_mangement_board_user_name_use = $_POST['board_mangement_board_user_name_use'] ?? 'off';
$board_mangement_board_user_sign_use = $_POST['board_mangement_board_user_sign_use'] ?? 'off';
$board_mangement_board_user_ip_view = $_POST['board_mangement_board_user_ip_view'] ?? 'off';
$board_mangement_board_recommended = $_POST['board_mangement_board_recommended'] ?? 'off';
$board_mangement_board_not_recommended = $_POST['board_mangement_board_not_recommended'] ?? 'off';
$board_mangement_board_upload_file_count = $_POST['board_mangement_board_upload_file_count'] ?? '1';
$board_mangement_board_upload_file_size = $_POST['board_mangement_board_upload_file_size'] ?? '0';
$board_mangement_board_min_string = $_POST['board_mangement_board_min_string'] ?? '0';
$board_mangement_board_max_string = $_POST['board_mangement_board_max_string'] ?? '0';
$board_mangement_comment_min_string = $_POST['board_mangement_comment_min_string'] ?? '0';
$board_mangement_comment_max_string = $_POST['board_mangement_comment_max_string'] ?? '0';
$board_mangement_board_share_use = $_POST['board_mangement_board_share_use'] ?? 'off';
$board_mangement_board_user_captcha_use = $_POST['board_mangement_board_user_captcha_use'] ?? 'off';
$board_mangement_board_non_user_captcha_use = $_POST['board_mangement_board_non_user_captcha_use'] ?? 'off';
$board_mangement_board_top_contents = $_POST['board_mangement_board_top_contents'] ?? null;
$board_mangement_board_bottom_contents = $_POST['board_mangement_board_bottom_contents'] ?? null;
$board_mangement_board_default_contents = $_POST['board_mangement_board_default_contents'] ?? null;
$board_mangement_board_list_sort = $_POST['board_mangement_board_list_sort'] ?? null;
$board_mangement_board_view_upload = $_POST['board_mangement_board_view_upload'] ?? '0';
$board_mangement_board_write_upload = $_POST['board_mangement_board_write_upload'] ?? '0';
$board_mangement_board_edit_upload = $_POST['board_mangement_board_edit_upload'] ?? '0';
$board_mangement_board_delete_upload = $_POST['board_mangement_board_delete_upload'] ?? '0';
$board_mangement_board_upload_upload = $_POST['board_mangement_board_upload_upload'] ?? '0';
$board_mangement_board_download_upload = $_POST['board_mangement_board_download_upload'] ?? '0';
$board_mangement_etc1 = $_POST['board_mangement_etc1'] ?? null;
$board_mangement_etc2 = $_POST['board_mangement_etc2'] ?? null;
$board_mangement_etc3 = $_POST['board_mangement_etc3'] ?? null;
$board_mangement_etc4 = $_POST['board_mangement_etc4'] ?? null;
$board_mangement_etc5 = $_POST['board_mangement_etc5'] ?? null;
$board_mangement_etc6 = $_POST['board_mangement_etc6'] ?? null;
$board_mangement_etc7 = $_POST['board_mangement_etc7'] ?? null;
$board_mangement_etc8 = $_POST['board_mangement_etc8'] ?? null;
$board_mangement_etc9 = $_POST['board_mangement_etc9'] ?? null;
$board_mangement_publish_date = $_POST['board_mangement_publish_date'] ?? null;
$board_mangement_last_modified_at = $_POST['board_mangement_last_modified_at'] ?? null;

// 쿼리 작성
$query = "
    UPDATE egb_board_mangement SET
        board_mangement_admin_uniq_id = :board_mangement_admin_uniq_id,
        board_mangement_board_no = :board_mangement_board_no,
        board_mangement_board_themes = :board_mangement_board_themes,
        board_mangement_board_editor = :board_mangement_board_editor,
        board_mangement_table_comment_name = :board_mangement_table_comment_name,
        board_mangement_route_board_name = :board_mangement_route_board_name,
        board_mangement_route_board_type = :board_mangement_route_board_type,
        board_mangement_comment_name = :board_mangement_comment_name,
        board_mangement_custom_name = :board_mangement_custom_name,
        board_mangement_category_name = :board_mangement_category_name,
        board_mangement_class_name = :board_mangement_class_name,
        board_mangement_board_status = :board_mangement_board_status,
        board_mangement_comment_status = :board_mangement_comment_status,
        board_mangement_comment_count = :board_mangement_comment_count,
        board_mangement_board_list_count = :board_mangement_board_list_count,
        board_mangement_board_list_pagination_count = :board_mangement_board_list_pagination_count,
        board_mangement_board_write_after_page = :board_mangement_board_write_after_page,
        board_mangement_board_view_level = :board_mangement_board_view_level,
        board_mangement_board_write_level = :board_mangement_board_write_level,
        board_mangement_board_edit_level = :board_mangement_board_edit_level,
        board_mangement_board_delete_level = :board_mangement_board_delete_level,
        board_mangement_board_upload_level = :board_mangement_board_upload_level,
        board_mangement_board_download_level = :board_mangement_board_download_level,
        board_mangement_board_reply_level = :board_mangement_board_reply_level,
        board_mangement_board_homepage_level = :board_mangement_board_homepage_level,
        board_mangement_board_link_level = :board_mangement_board_link_level,
        board_mangement_comment_view_level = :board_mangement_comment_view_level,
        board_mangement_comment_write_level = :board_mangement_comment_write_level,
        board_mangement_comment_edit_level = :board_mangement_comment_edit_level,
        board_mangement_comment_delete_level = :board_mangement_comment_delete_level,
        board_mangement_comment_upload_level = :board_mangement_comment_upload_level,
        board_mangement_comment_download_level = :board_mangement_comment_download_level,
        board_mangement_comment_reply_level = :board_mangement_comment_reply_level,
        board_mangement_comment_homepage_level = :board_mangement_comment_homepage_level,
        board_mangement_comment_link_level = :board_mangement_comment_link_level,
        board_mangement_board_comment_count_edit_level = :board_mangement_board_comment_count_edit_level,
        board_mangement_board_comment_count_delete_level = :board_mangement_board_comment_count_delete_level,
        board_mangement_board_top = :board_mangement_board_top,
        board_mangement_board_secret = :board_mangement_board_secret,
        board_mangement_comment_secret = :board_mangement_comment_secret,
        board_mangement_board_user_name_use = :board_mangement_board_user_name_use,
        board_mangement_board_user_sign_use = :board_mangement_board_user_sign_use,
        board_mangement_board_user_ip_view = :board_mangement_board_user_ip_view,
        board_mangement_board_recommended = :board_mangement_board_recommended,
        board_mangement_board_not_recommended = :board_mangement_board_not_recommended,
        board_mangement_board_upload_file_count = :board_mangement_board_upload_file_count,
        board_mangement_board_upload_file_size = :board_mangement_board_upload_file_size,
        board_mangement_board_min_string = :board_mangement_board_min_string,
        board_mangement_board_max_string = :board_mangement_board_max_string,
        board_mangement_comment_min_string = :board_mangement_comment_min_string,
        board_mangement_comment_max_string = :board_mangement_comment_max_string,
        board_mangement_board_share_use = :board_mangement_board_share_use,
        board_mangement_board_user_captcha_use = :board_mangement_board_user_captcha_use,
        board_mangement_board_non_user_captcha_use = :board_mangement_board_non_user_captcha_use,
        board_mangement_board_top_contents = :board_mangement_board_top_contents,
        board_mangement_board_bottom_contents = :board_mangement_board_bottom_contents,
        board_mangement_board_default_contents = :board_mangement_board_default_contents,
        board_mangement_board_list_sort = :board_mangement_board_list_sort,
        board_mangement_board_view_upload = :board_mangement_board_view_upload,
        board_mangement_board_write_upload = :board_mangement_board_write_upload,
        board_mangement_board_edit_upload = :board_mangement_board_edit_upload,
        board_mangement_board_delete_upload = :board_mangement_board_delete_upload,
        board_mangement_board_upload_upload = :board_mangement_board_upload_upload,
        board_mangement_board_download_upload = :board_mangement_board_download_upload,
        board_mangement_etc1 = :board_mangement_etc1,
        board_mangement_etc2 = :board_mangement_etc2,
        board_mangement_etc3 = :board_mangement_etc3,
        board_mangement_etc4 = :board_mangement_etc4,
        board_mangement_etc5 = :board_mangement_etc5,
        board_mangement_etc6 = :board_mangement_etc6,
        board_mangement_etc7 = :board_mangement_etc7,
        board_mangement_etc8 = :board_mangement_etc8,
        board_mangement_etc9 = :board_mangement_etc9,
        board_mangement_publish_date = :board_mangement_publish_date,
        board_mangement_last_modified_at = :board_mangement_last_modified_at
    WHERE board_mangement_uniq_id = :board_mangement_uniq_id;
";

// 데이터 배열로 만들기
$data = [
    ':board_mangement_uniq_id' => $board_mangement_uniq_id,
    ':board_mangement_admin_uniq_id' => $board_mangement_admin_uniq_id,
    ':board_mangement_board_no' => $board_mangement_board_no,
    ':board_mangement_board_themes' => $board_mangement_board_themes,
    ':board_mangement_board_editor' => $board_mangement_board_editor,
    ':board_mangement_table_comment_name' => $board_mangement_table_comment_name,
    ':board_mangement_route_board_name' => $board_mangement_route_board_name,
    ':board_mangement_route_board_type' => $board_mangement_route_board_type,
    ':board_mangement_comment_name' => $board_mangement_comment_name,
    ':board_mangement_custom_name' => $board_mangement_custom_name,
    ':board_mangement_category_name' => $board_mangement_category_name,
    ':board_mangement_class_name' => $board_mangement_class_name,
    ':board_mangement_board_status' => $board_mangement_board_status,
    ':board_mangement_comment_status' => $board_mangement_comment_status,
    ':board_mangement_comment_count' => $board_mangement_comment_count,
    ':board_mangement_board_list_count' => $board_mangement_board_list_count,
    ':board_mangement_board_list_pagination_count' => $board_mangement_board_list_pagination_count,
    ':board_mangement_board_write_after_page' => $board_mangement_board_write_after_page,
    ':board_mangement_board_view_level' => $board_mangement_board_view_level,
    ':board_mangement_board_write_level' => $board_mangement_board_write_level,
    ':board_mangement_board_edit_level' => $board_mangement_board_edit_level,
    ':board_mangement_board_delete_level' => $board_mangement_board_delete_level,
    ':board_mangement_board_upload_level' => $board_mangement_board_upload_level,
    ':board_mangement_board_download_level' => $board_mangement_board_download_level,
    ':board_mangement_board_reply_level' => $board_mangement_board_reply_level,
    ':board_mangement_board_homepage_level' => $board_mangement_board_homepage_level,
    ':board_mangement_board_link_level' => $board_mangement_board_link_level,
    ':board_mangement_comment_view_level' => $board_mangement_comment_view_level,
    ':board_mangement_comment_write_level' => $board_mangement_comment_write_level,
    ':board_mangement_comment_edit_level' => $board_mangement_comment_edit_level,
    ':board_mangement_comment_delete_level' => $board_mangement_comment_delete_level,
    ':board_mangement_comment_upload_level' => $board_mangement_comment_upload_level,
    ':board_mangement_comment_download_level' => $board_mangement_comment_download_level,
    ':board_mangement_comment_reply_level' => $board_mangement_comment_reply_level,
    ':board_mangement_comment_homepage_level' => $board_mangement_comment_homepage_level,
    ':board_mangement_comment_link_level' => $board_mangement_comment_link_level,
    ':board_mangement_board_comment_count_edit_level' => $board_mangement_board_comment_count_edit_level,
    ':board_mangement_board_comment_count_delete_level' => $board_mangement_board_comment_count_delete_level,
    ':board_mangement_board_top' => $board_mangement_board_top,
    ':board_mangement_board_secret' => $board_mangement_board_secret,
    ':board_mangement_comment_secret' => $board_mangement_comment_secret,
    ':board_mangement_board_user_name_use' => $board_mangement_board_user_name_use,
    ':board_mangement_board_user_sign_use' => $board_mangement_board_user_sign_use,
    ':board_mangement_board_user_ip_view' => $board_mangement_board_user_ip_view,
    ':board_mangement_board_recommended' => $board_mangement_board_recommended,
    ':board_mangement_board_not_recommended' => $board_mangement_board_not_recommended,
    ':board_mangement_board_upload_file_count' => $board_mangement_board_upload_file_count,
    ':board_mangement_board_upload_file_size' => $board_mangement_board_upload_file_size,
    ':board_mangement_board_min_string' => $board_mangement_board_min_string,
    ':board_mangement_board_max_string' => $board_mangement_board_max_string,
    ':board_mangement_comment_min_string' => $board_mangement_comment_min_string,
    ':board_mangement_comment_max_string' => $board_mangement_comment_max_string,
    ':board_mangement_board_share_use' => $board_mangement_board_share_use,
    ':board_mangement_board_user_captcha_use' => $board_mangement_board_user_captcha_use,
    ':board_mangement_board_non_user_captcha_use' => $board_mangement_board_non_user_captcha_use,
    ':board_mangement_board_top_contents' => $board_mangement_board_top_contents,
    ':board_mangement_board_bottom_contents' => $board_mangement_board_bottom_contents,
    ':board_mangement_board_default_contents' => $board_mangement_board_default_contents,
    ':board_mangement_board_list_sort' => $board_mangement_board_list_sort,
    ':board_mangement_board_view_upload' => $board_mangement_board_view_upload,
    ':board_mangement_board_write_upload' => $board_mangement_board_write_upload,
    ':board_mangement_board_edit_upload' => $board_mangement_board_edit_upload,
    ':board_mangement_board_delete_upload' => $board_mangement_board_delete_upload,
    ':board_mangement_board_upload_upload' => $board_mangement_board_upload_upload,
    ':board_mangement_board_download_upload' => $board_mangement_board_download_upload,
    ':board_mangement_etc1' => $board_mangement_etc1,
    ':board_mangement_etc2' => $board_mangement_etc2,
    ':board_mangement_etc3' => $board_mangement_etc3,
    ':board_mangement_etc4' => $board_mangement_etc4,
    ':board_mangement_etc5' => $board_mangement_etc5,
    ':board_mangement_etc6' => $board_mangement_etc6,
    ':board_mangement_etc7' => $board_mangement_etc7,
    ':board_mangement_etc8' => $board_mangement_etc8,
    ':board_mangement_etc9' => $board_mangement_etc9,
    ':board_mangement_publish_date' => $board_mangement_publish_date,
    ':board_mangement_last_modified_at' => $board_mangement_last_modified_at
];

// 바인딩 및 쿼리 실행
$binding = binding_sql(2, $query, $data);
$result = egb_sql($binding);

// 결과 확인
if ($result) {
    echo json_encode(['success' => true, 'successCode' => 11]); // 업데이트 성공
	exit;
} else {
	echo json_encode(['success' => false, 'failureCode' => 22]); // 업데이트 실패
	exit;
}
?>
