<?php
// 조회할 ID
$uniq_id = egb('uniq_id');

// 조회 쿼리 
$query = "SELECT * FROM egb_option_group WHERE uniq_id = :uniq_id";
$params = [
    ':uniq_id' => $uniq_id
];

// 쿼리 바인딩
$binding = binding_sql(1, $query, $params);
$dataResult = egb_sql($binding);

?>
<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<form class="height_box overflow_y_auto scrollbar" id="egb_option_group_edit_input" action="<?php echo DOMAIN . '/?post=egb_option_group_edit_input'; ?>" method="post" enctype="multipart/form-data">
    <div class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">수정하기
            </div>
        </div>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="filter_page_name" value="<?php echo egb('filter_page_name'); ?>">
    <input type="hidden" name="filter_menu_name" value="<?php echo egb('filter_menu_name'); ?>">
    <input type="hidden" name="filter_page" value="<?php echo egb('filter_page'); ?>">
    <input type="hidden" name="filter_per_page" value="<?php echo egb('filter_per_page'); ?>">
    <input type="hidden" name="filter_order" value="<?php echo egb('filter_order'); ?>">
    <input type="hidden" name="filter_is_status" value="<?php echo egb('filter_is_status'); ?>">
    <input type="hidden" name="filter_search_input" value="<?php echo egb('filter_search_input'); ?>">
    <input type="hidden" name="filter_user_id" value="<?php echo egb('filter_user_id'); ?>">
    <input type="hidden" name="uniq_id" value="<?php echo $uniq_id; ?>">
    <input type="hidden" name="filter_table_name" value="egb_option_group">

    <div class="height_box padding_px-t_010 padding_px-x_010 padding_px-u_050">
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">옵션 그룹 코드</div>
            <input class="menu_input_style" type="text" value="<?php echo htmlspecialchars($dataResult[0]['group_code']); ?>" readonly disabled>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">옵션 그룹 제목</div>
            <input class="menu_input_style" type="text" name="group_title" value="<?php echo htmlspecialchars($dataResult[0]['group_title']); ?>" placeholder="옵션 그룹 제목을 입력하세요" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">옵션 그룹 설명</div>
            <textarea class="menu_input_style padding_px-a_005" name="group_description" style="min-height: 100px; resize: vertical;" placeholder="옵션 그룹 설명을 입력하세요"><?php echo htmlspecialchars($dataResult[0]['group_description']); ?></textarea>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">옵션 필수 여부</div>
            <select class="menu_input_style padding_px-a_005" name="group_required">
                <option value="2" <?php echo $dataResult[0]['group_required'] == 2 ? 'selected' : ''; ?>>필수</option>
                <option value="1" <?php echo $dataResult[0]['group_required'] == 1 ? 'selected' : ''; ?>>선택</option>
                <option value="0" <?php echo $dataResult[0]['group_required'] == 0 ? 'selected' : ''; ?>>미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">그룹 접근 레벨</div>
            <input class="menu_input_style" type="number" name="group_access_level" value="<?php echo intval($dataResult[0]['group_access_level']); ?>" min="0" max="99" placeholder="접근 레벨을 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">출력 순서</div>
            <input class="menu_input_style" type="number" name="display_order" value="<?php echo intval($dataResult[0]['display_order']); ?>" min="0" placeholder="출력 순서를 입력하세요">
        </div>
    </div>
</form>