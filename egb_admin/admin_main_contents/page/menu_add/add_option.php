<?php
  
$filter_user_id = egb('filter_user_id');
if (!isset($filter_user_id)) {
    $filter_user_id = 'admin';
}

?>
<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
    select.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    select.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<div class="height_box overflow_y_auto scrollbar">
    <form id="egb_option_add_input" action="<?php echo DOMAIN . '/?post=egb_option_add_input'; ?>" method="post" enctype="multipart/form-data"
    class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
            <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
                <div class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                    data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                    data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">추가하기
                </div>
            </div>
        <input type="hidden" name="mode" value="add">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="filter_page_name" value="<?php echo egb('filter_page_name'); ?>">
        <input type="hidden" name="filter_menu_name" value="<?php echo egb('filter_menu_name'); ?>">
        <input type="hidden" name="filter_page" value="<?php echo egb('filter_page'); ?>">
        <input type="hidden" name="filter_per_page" value="<?php echo egb('filter_per_page'); ?>">
        <input type="hidden" name="filter_order" value="<?php echo egb('filter_order'); ?>">
        <input type="hidden" name="filter_is_status" value="<?php echo egb('filter_is_status'); ?>">
        <input type="hidden" name="filter_search_input" value="<?php echo egb('filter_search_input'); ?>">
        <input type="hidden" name="filter_user_id" value="<?php echo egb('filter_user_id'); ?>">
        <input type="hidden" name="filter_table_name" value="egb_option">
    </form>
    <div class="padding_px-t_010 padding_px-x_010 padding_px-u_050">
        <form class="" id="egb_option_group_search_input_add" action="<?php echo DOMAIN . '/?post=egb_option_group_search_input'; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="mode" value="add">
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">그룹 옵션 검색</div>
                <input class="menu_input_style text_change_submit" type="text" name="group_option_keyword" placeholder="그룹 옵션 키워드 입력">
            </div>
        </form>
    
        <div id="option_group_search_result_add" class="padding_px-u_008"></div>
        <div class="flex_ft padding_px-u_008">
            <select class="menu_input_style padding_px-a_005" name="option_group_uniq_id" id="option_group_uniq_id_add">
                <option value="">그룹 옵션 선택</option>
            </select>
        </div>
        <form class="" id="egb_option_parent_search_input_add" action="<?php echo DOMAIN . '/?post=egb_option_parent_search_input'; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="option_group_uniq_id" id="option_group_uniq_id_hidden_add">
            <input type="hidden" name="mode" value="add">
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">부모 옵션</div>
                <input class="menu_input_style text_change_submit" type="text" name="parent_option_keyword" placeholder="상위 옵션이 있을 경우만 키워드 입력">
            </div>
        </form>
    
        <div id="option_parent_search_result_add" class="padding_px-u_008"></div>
        <div class="flex_ft padding_px-u_008">
            <select class="menu_input_style padding_px-a_005" name="option_parent_uniq_id" id="option_parent_uniq_id_add">
                <option value="">부모 옵션 선택</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">옵션 라벨</div>
            <input class="menu_input_style" type="text" name="option_label" id="option_label_add" placeholder="옵션 표시 라벨을 입력하세요" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">접근 레벨</div>
            <input class="menu_input_style" type="number" name="option_access_level" id="option_access_level_add" value="0" min="0" max="99" placeholder="접근 레벨을 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">출력 순서</div>
            <input class="menu_input_style" type="number" name="display_order" id="display_order_add" value="0" min="0" placeholder="출력 순서를 입력하세요">
        </div>
    </div>
</div>
<script nonce="<?php echo NONCE; ?>">
// 그룹 옵션 선택 시 부모 옵션 검색을 위한 히든 필드 업데이트
document.querySelector('#option_group_uniq_id_add').addEventListener('change', function() {
    document.querySelector('#option_group_uniq_id_hidden_add').value = this.value;
});

// 메인 폼 제출 전 데이터 처리
egbAjaxDataHookAdd('egb_option_add_input', function(formData) {
    // 폼 필드에서 값 가져오기
    var optionLabel = document.querySelector('#option_label_add').value;
    var optionAccessLevel = document.querySelector('#option_access_level_add').value;
    var optionParentUniqId = document.querySelector('#option_parent_uniq_id_add').value;
    var displayOrder = document.querySelector('#display_order_add').value;
    var optionGroupUniqId = document.querySelector('#option_group_uniq_id_add').value;

    // FormData에 값 추가
    formData.append('option_label', optionLabel);
    formData.append('option_access_level', optionAccessLevel);
    formData.append('option_parent_uniq_id', optionParentUniqId);
    formData.append('display_order', displayOrder);
    formData.append('option_group_uniq_id', optionGroupUniqId);
});
</script>