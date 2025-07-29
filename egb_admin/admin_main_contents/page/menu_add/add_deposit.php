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
    input.egb_checked{all: unset; width: 14px; height: 14px; border: 1px solid #d9d9d9; border-radius: 3px;}
    input.egb_checked:checked {background-color: #4caf50; border-color: #4caf50;}
    input.egb_checked:checked::after {content: ''; display: block; width: 4px; height: 9px; margin: 2px auto; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg);}
"></div>

<div class="height_box overflow_y_auto scrollbar">
    <form id="egb_deposit_add_input" action="<?php echo DOMAIN . '/?post=egb_deposit_add_input'; ?>" method="post" enctype="multipart/form-data"
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
        <input type="hidden" name="filter_table_name" value="egb_deposit">
        
        <div class="padding_px-t_010 padding_px-x_010 padding_px-u_050">
            <form class="" id="egb_deposit_add_search_input" action="<?php echo DOMAIN . '/?post=egb_deposit_user_search_input'; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="flex_ft padding_px-u_008">
                    <div class="padding_px-u_005">회원</div>
                    <input id="user_keyword_deposit" class="menu_input_style text_change_submit" type="text" name="user_keyword" placeholder="회원 아이디 입력" required>
                </div>
            </form>
            
            <div id="deposit_add_search_result" class="padding_px-u_008"></div>
            <div class="flex_ft padding_px-u_008">
                <select class="menu_input_style padding_px-a_005" name="deposit_target_uniq_id" required>
                    <option value="">회원 선택</option>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">처리 유형</div>
                <select class="menu_input_style padding_px-a_005" name="deposit_type" required>
                    <option value="1">지급</option>
                    <option value="0">차감</option>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">처리 사유</div>
                <select class="menu_input_style padding_px-a_005" name="deposit_reason" required>
                    <option value="주문취소">주문취소</option>
                    <option value="예치금환불">예치금환불</option>
                    <option value="상품구매">상품구매</option>
                    <option value="임의조정" selected>임의조정</option>
                    <option value="현금환불">현금환불</option>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">변경 금액</div>
                <input class="menu_input_style" type="text" name="deposit_amount" placeholder="금액을 입력" required>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">메모</div>
                <textarea class="menu_input_style padding_px-x_010 padding_px-y_005" name="deposit_memo" placeholder="메모를 입력"></textarea>
            </div>
        </div>
    </form>
</div>

<script nonce="<?php echo NONCE; ?>">
// 숫자만 입력 가능하도록 이벤트 리스너 추가
document.querySelector('input[name="deposit_amount"]').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>