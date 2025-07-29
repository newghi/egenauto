<?php
// 조회할 ID
$uniq_id = egb('uniq_id');

// 조회 쿼리
$query = "
    SELECT eo.*, og.group_title AS option_group_title, og.group_code AS option_group_code,
           po.option_label AS parent_option_label
    FROM egb_option eo
    LEFT JOIN egb_option_group og ON eo.option_group_uniq_id = og.uniq_id
    LEFT JOIN egb_option po ON eo.option_parent_uniq_id = po.uniq_id
    WHERE eo.uniq_id = :uniq_id
";
$params = [ ':uniq_id' => $uniq_id ];
$binding = binding_sql(1, $query, $params);
$dataResult = egb_sql($binding);

$filter_user_id = egb('filter_user_id') ?? 'admin';
?>

<div class="height_box overflow_y_auto scrollbar">
    <form id="egb_option_edit_input" action="<?php echo DOMAIN . '/?post=egb_option_edit_input'; ?>" method="post" enctype="multipart/form-data"
    class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">수정하기
            </div>
        </div>    
    <input type="hidden" name="mode" value="edit">
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
        <input type="hidden" name="uniq_id" value="<?php echo $uniq_id; ?>">
    </form>

    <div class="padding_px-t_010 padding_px-x_010 padding_px-u_050">
        <!-- 그룹 옵션 -->
        <form id="egb_option_group_search_input_edit" action="<?php echo DOMAIN . '/?post=egb_option_group_search_input'; ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="mode" value="edit">
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">그룹 옵션 검색</div>
                <input class="menu_input_style text_change_submit" type="text" name="group_option_keyword" placeholder="그룹 옵션 키워드 입력">
            </div>
        </form>

        <div class="flex_ft padding_px-u_008">
            <select class="menu_input_style padding_px-a_005" name="option_group_uniq_id" id="option_group_uniq_id_edit">
                <option value="<?php echo $dataResult[0]['option_group_uniq_id']; ?>" selected>
                    <?php echo $dataResult[0]['option_group_title']; ?> (<?php echo $dataResult[0]['option_group_code']; ?>)
                </option>
            </select>
        </div>

        <!-- 부모 옵션 -->
        <form id="edit_egb_option_parent_search_input" action="<?php echo DOMAIN . '/?post=egb_option_parent_search_input'; ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="mode" value="edit">
            <input type="hidden" name="option_group_uniq_id" id="option_group_uniq_id_hidden_edit" value="<?php echo egb('option_group_uniq_id'); ?>">
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">부모 옵션</div>
                <input class="menu_input_style text_change_submit" type="text" name="parent_option_keyword" placeholder="상위 옵션이 있을 경우만 키워드 입력">
            </div>
        </form>

        <div class="flex_ft padding_px-u_008">
            <select class="menu_input_style padding_px-a_005" name="option_parent_uniq_id" id="option_parent_uniq_id_edit">
                <?php if (!empty($dataResult[0]['option_parent_uniq_id'])): ?>
                <option value="<?php echo $dataResult[0]['option_parent_uniq_id']; ?>" selected>
                    <?php echo htmlspecialchars($dataResult[0]['parent_option_label']); ?> (<?php echo $dataResult[0]['option_parent_uniq_id']; ?>)
                </option>
                <?php else: ?>
                <option value="" selected>부모 옵션 선택</option>
                <?php endif; ?>
            </select>
        </div>

        <!-- 기타 입력 -->
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">옵션 라벨</div>
            <input class="menu_input_style" type="text" name="option_label" value="<?php echo htmlspecialchars($dataResult[0]['option_label']); ?>" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">접근 레벨</div>
            <input class="menu_input_style" type="number" name="option_access_level" value="<?php echo intval($dataResult[0]['option_access_level']); ?>" min="0" max="99">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">출력 순서</div>
            <input class="menu_input_style" type="number" name="display_order" value="<?php echo intval($dataResult[0]['display_order']); ?>" min="0">
        </div>
    </div>
</div>

<script nonce="<?php echo NONCE; ?>">
document.querySelector('#option_group_uniq_id_edit').addEventListener('change', function() {
    document.querySelector('#option_group_uniq_id_hidden_edit').value = this.value;
});

egbAjaxDataHookAdd('egb_option_edit_input', function(formData) {
    formData.append('option_label', document.querySelector('input[name="option_label"]').value);
    formData.append('option_access_level', document.querySelector('input[name="option_access_level"]').value);
    formData.append('option_parent_uniq_id', document.querySelector('select[name="option_parent_uniq_id"]').value);
    formData.append('display_order', document.querySelector('input[name="display_order"]').value);
    formData.append('option_group_uniq_id', document.querySelector('select[name="option_group_uniq_id"]').value);
});
</script>
