<?php
// 조회할 ID
$uniq_id = egb('uniq_id');
$filter_page_name = egb('filter_page_name');
$filter_table_name = 'egb_page';

// 컬럼 설정 조회
$config_query = "
SELECT column_config_data_json 
FROM egb_table_column_config 
WHERE column_config_table_name = :table_name 
  AND column_config_user_uniq_id IS NULL 
  AND deleted_at IS NULL
";
$config_params = [':table_name' => $filter_table_name];
$config_binding = binding_sql(1, $config_query, $config_params);
$config_result = egb_sql($config_binding);

$columns_config = [];
if (!empty($config_result) && isset($config_result[0]['column_config_data_json'])) {
    $columns_config = json_decode($config_result[0]['column_config_data_json'], true);
}

// viewer_filter가 1인 컬럼만 필터링
$viewer_columns = array_filter($columns_config, function($config) {
    return isset($config['viewer_filter']) && $config['viewer_filter'] == 1;
});

// 조회 쿼리 
$query = "SELECT * FROM egb_page WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $uniq_id];

// 쿼리 바인딩
$binding = binding_sql(1, $query, $params);
$dataResult = egb_sql($binding);
?>

<div class="height_box overflow_y_auto scrollbar">
    <div class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div id="<?php echo $filter_page_name; ?>_view_print_button" class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer" title="인쇄"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">
                <svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" style="margin-right:5px">
                    <g id="_01_align_center" data-name="01 align center">
                        <path d="M24,9a3,3,0,0,0-3-3H19V0H5V6H3A3,3,0,0,0,0,9V21H5v3H19V21h5ZM7,2H17V6H7ZM17,22H7V16H17Zm5-3H19V14H5v5H2V9A1,1,0,0,1,3,8H21a1,1,0,0,1,1,1Z" />
                        <rect x="15" y="10" width="4" height="2" />
                    </g>
                </svg>
                인쇄하기
            </div>
        </div>
    </div>
    <div id="column_<?php echo $filter_page_name; ?>_view_print_area" class="height_box padding_px-t_010 padding_px-x_010 padding_px-u_050">
        <?php foreach($viewer_columns as $config): ?>
            <?php 
            $field_name = $config['name'];
            $field_comment = $config['comment'];
            $field_value = $dataResult[0][$field_name];
            
            // 특별한 필드 처리
            if($field_name == 'seo_og_img'): ?>
                <div class="flex_ft padding_px-u_008">
                    <div class="padding_px-u_005"><?php echo htmlspecialchars($field_comment); ?></div>
                    <div class="flex_fl_yc">
                        <div class="flex_xc_yc width_px_342 height_px_180 border_px-a_001 border_bre-a_005 margin_px-x_010" data-bd-a-color="#dddddd">
                            <div class="width_px_342 height_px_180">
                                <img src="<?php echo !empty($field_value) ? $field_value : DS . 'egb_thumbnail.webp'; ?>" class="width_px_342 height_px_180">
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif(in_array($field_name, ['page_seo', 'page_use', 'setting_header_use', 'setting_footer_use', 'setting_comment_use'])): ?>
                <div class="flex_ft padding_px-u_008">
                    <div class="padding_px-u_005"><?php echo htmlspecialchars($field_comment); ?></div>
                    <div style="outline:none; padding:5px 15px; font-family:fontstyle1; font-size:14px; border:1px solid #eeeeee; border-radius:5px; box-sizing:border-box; box-shadow:0px 0px 1px #00000020; background-color:#ffffff;">
                        <?php echo $field_value ? '사용' : '미사용'; ?>
                    </div>
                </div>
            <?php elseif(in_array($field_name, ['seo_description', 'seo_og_description'])): ?>
                <div class="flex_ft padding_px-u_008">
                    <div class="padding_px-u_005"><?php echo htmlspecialchars($field_comment); ?></div>
                    <div style="outline:none; padding:5px 15px; font-family:fontstyle1; font-size:14px; border:1px solid #eeeeee; border-radius:5px; box-sizing:border-box; box-shadow:0px 0px 1px #00000020; background-color:#ffffff; min-height:100px;">
                        <?php echo htmlspecialchars($field_value); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex_ft padding_px-u_008">
                    <div class="padding_px-u_005"><?php echo htmlspecialchars($field_comment); ?></div>
                    <div style="outline:none; padding:5px 15px; font-family:fontstyle1; font-size:14px; border:1px solid #eeeeee; border-radius:5px; box-sizing:border-box; box-shadow:0px 0px 1px #00000020; background-color:#ffffff;">
                        <?php echo is_numeric($field_value) ? intval($field_value) : htmlspecialchars($field_value); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<script nonce="<?php echo NONCE; ?>">
document.getElementById('<?php echo $filter_page_name; ?>_view_print_button').addEventListener('click', function() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo DOMAIN . '/page/egb_admin_column_print'; ?>';
    form.target = '_blank';

    // CSRF 토큰 추가
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = 'csrf_token';
    csrfToken.value = '<?php echo $_SESSION['csrf_token']; ?>';
    form.appendChild(csrfToken);

    const printArea = document.getElementById('column_<?php echo $filter_page_name; ?>_view_print_area');
    
    // 인쇄 영역의 스타일을 임시로 조정
    const originalStyle = printArea.style.cssText;
    printArea.style.cssText = 'width: 100%; max-width: 100%; page-break-inside: avoid;';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'print_data';
    input.value = printArea.innerHTML;

    // 원래 스타일로 복구
    printArea.style.cssText = originalStyle;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    form.remove();
});
</script>