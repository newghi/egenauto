<?php
$filter_page_name = egb('filter_page_name');
$filter_menu_name = egb('filter_menu_name');
$filter_page = egb('filter_page');
$filter_perPage = egb('filter_per_page');
$filter_order = egb('filter_order');
$filter_is_status = egb('filter_is_status');
$filter_search_input = egb('filter_search_input');
$filter_user_id = egb('filter_user_id');
$filter_table_name = egb('filter_table_name');
?>
<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<form class="height_box overflow_y_auto scrollbar" id="egb_column_config_form" action="<?php echo DOMAIN . '/?post=egb_column_config_update'; ?>" method="post">
    <div class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">칼럼 설정 저장
            </div>
        </div>
    </div>
    
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="filter_page_name" value="<?php echo $filter_page_name; ?>">
    <input type="hidden" name="filter_menu_name" value="<?php echo $filter_menu_name; ?>">
    <input type="hidden" name="filter_page" value="<?php echo $filter_page; ?>">
    <input type="hidden" name="filter_per_page" value="<?php echo $filter_perPage; ?>">
    <input type="hidden" name="filter_order" value="<?php echo $filter_order; ?>">
    <input type="hidden" name="filter_is_status" value="<?php echo $filter_is_status; ?>">
    <input type="hidden" name="filter_search_input" value="<?php echo $filter_search_input; ?>">
    <input type="hidden" name="filter_user_id" value="<?php echo $filter_user_id; ?>">
    <input type="hidden" name="filter_table_name" value="<?php echo $filter_table_name; ?>">
    
    <div class="height_box padding_px-t_010 padding_px-x_010">
        <div class="flex_fl_yc padding_px-y_005 border_px-u_001 font_weight_700" data-bd-a-color="#e9e9e9">
            <div class="width_px_250">칼럼명</div>
            <div class="flex_fl_yc">
                <div class="margin_px-r_005 width_px_080 text_align_center">출력순서</div>
                <div class="margin_px-r_005 width_px_080 text_align_center">출력너비</div>
                <div class="margin_px-r_005 width_px_080 text_align_center">정렬</div>
                <div class="margin_px-r_005 width_px_080 text_align_center">출력여부</div>
                <div class="margin_px-r_005 width_px_080 text_align_center">키워드필터</div>
                <div class="margin_px-r_005 width_px_080 text_align_center">상세필터</div>
                <div class="width_px_080 text_align_center">뷰어필터</div>
            </div>
        </div>
        <?php
        // DB에서 설정 가져오기
        $sql = "SELECT column_config_data_json FROM egb_table_column_config 
                WHERE column_config_table_name = :table_name 
                AND column_config_user_uniq_id IS NULL 
                AND deleted_at IS NULL 
                ORDER BY created_at DESC LIMIT 1";
                
        $dataBinding = binding_sql(1, $sql, [':table_name' => $filter_table_name]);
        $result = egb_sql($dataBinding);
        $column_config = [];
        
        if($result && !empty($result[0]['column_config_data_json'])) {
            $column_config = json_decode($result[0]['column_config_data_json'], true);
        }

        // 컬럼 설정 기본값 
        $default_config = [
            'visible' => 1,
            'order' => 0, 
            'width' => 200,
            'align' => 'left',
            'keyword_filter' => 0,
            'detail_filter' => 0,
            'viewer_filter' => 0
        ];

        // column_config 배열 순회
        foreach($column_config as $config) {
            $value = $config['name'];
            $checked = $config['visible'] ? 'checked' : '';
            
            // HTML 출력
            echo "<div class='flex_fl_yc padding_px-y_005 border_px-u_001' data-bd-a-color='#e9e9e9'>
                    <div class='width_px_250'>
                        <label>
                            <input type='checkbox' name='columns[]' value='$value' $checked> {$config['comment']}
                        </label>
                    </div>
                    <div class='flex_fl_yc'>
                        <input type='number' name='order[$value]' value='{$config['order']}' class='menu_input_style margin_px-r_005 width_px_080' placeholder='순서'>
                        <input type='number' name='width[$value]' value='{$config['width']}' class='menu_input_style margin_px-r_005 width_px_080' placeholder='너비'>
                        <select name='align[$value]' class='menu_input_style margin_px-r_005 width_px_080'>
                            <option value='left'" . ($config['align'] == 'left' ? ' selected' : '') . ">왼쪽</option>
                            <option value='center'" . ($config['align'] == 'center' ? ' selected' : '') . ">중앙</option>
                            <option value='right'" . ($config['align'] == 'right' ? ' selected' : '') . ">오른쪽</option>
                        </select>
                        <select name='hidden[$value]' class='menu_input_style margin_px-r_005 width_px_080'>
                            <option value='1'" . ($config['visible'] == 1 ? ' selected' : '') . ">보이기</option>
                            <option value='0'" . ($config['visible'] == 0 ? ' selected' : '') . ">숨기기</option>
                        </select>
                        <select name='keyword_filter[$value]' class='menu_input_style margin_px-r_005 width_px_080'>
                            <option value='1'" . ($config['keyword_filter'] == 1 ? ' selected' : '') . ">포함</option>
                            <option value='0'" . ($config['keyword_filter'] == 0 ? ' selected' : '') . ">미포함</option>
                        </select>
                        <select name='detail_filter[$value]' class='menu_input_style margin_px-r_005 width_px_080'>
                            <option value='1'" . ($config['detail_filter'] == 1 ? ' selected' : '') . ">포함</option>
                            <option value='0'" . ($config['detail_filter'] == 0 ? ' selected' : '') . ">미포함</option>
                        </select>
                        <select name='viewer_filter[$value]' class='menu_input_style width_px_080'>
                            <option value='1'" . (isset($config['viewer_filter']) && $config['viewer_filter'] == 1 ? ' selected' : '') . ">포함</option>
                            <option value='0'" . (!isset($config['viewer_filter']) || $config['viewer_filter'] == 0 ? ' selected' : '') . ">미포함</option>
                        </select>
                    </div>
                    <input type='hidden' name='comment[$value]' value='{$config['comment']}'>
                </div>";
        }
        ?>
    </div>
</form>