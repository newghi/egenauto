<?php
  
$filter_user_id = egb('filter_user_id');
if (!isset($filter_user_id)) {
    $filter_user_id = 'admin';
}

// 리워드 정보 조회
$uniq_id = egb('uniq_id');
$query = "SELECT * FROM egb_reward WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $uniq_id];
$binding = binding_sql(1, $query, $params);
$reward = egb_sql($binding)[0];

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
    <form id="egb_reward_edit_input" action="<?php echo DOMAIN . '/?post=egb_reward_edit_input'; ?>" method="post" enctype="multipart/form-data"
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
        <input type="hidden" name="filter_table_name" value="egb_reward">
        <input type="hidden" name="uniq_id" value="<?php echo $uniq_id; ?>">
        
        <div class="padding_px-t_010 padding_px-x_010 padding_px-u_050">

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">리워드 제목</div>
                <input class="menu_input_style" type="text" name="reward_title" value="<?php echo htmlspecialchars($reward['reward_title']); ?>" required>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">리워드 이름</div>
                <input class="menu_input_style" type="text" name="reward_name" value="<?php echo htmlspecialchars($reward['reward_name']); ?>" required>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">리워드 타입</div>
                <select class="menu_input_style" name="reward_type" required>
                    <option value="0" <?php echo $reward['reward_type'] == 0 ? 'selected' : ''; ?>>예치금</option>
                    <option value="1" <?php echo $reward['reward_type'] == 1 ? 'selected' : ''; ?>>적립금</option>
                    <option value="2" <?php echo $reward['reward_type'] == 2 ? 'selected' : ''; ?>>마일리지</option>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">대상 회원등급</div>
                <div class="flex_fl flex_wrap">
                    <?php
                    $target_grades = json_decode($reward['reward_data'], true);
                    
                    // 커뮤니티 회원 등급 옵션 조회
                    $community_grades = egb_option_flat('community_user_grade');
                    if (!empty($community_grades)) {
                        echo '<div class="width_box padding_px-u_005 flv6">커뮤니티 회원</div>';
                        foreach ($community_grades as $grade) {
                            $grade_id = $grade['uniq_id'];
                            $grade_name = $grade['label'];
                            $checked = in_array('community_'.$grade_id, $target_grades) ? 'checked' : '';
                            ?>
                            <div class="flex_fl_yc padding_px-r_015 padding_px-u_005">
                                <input type="checkbox" name="target_grades[]" value="community_<?php echo $grade_id; ?>" 
                                       id="grade_community_<?php echo $grade_id; ?>" class="egb_checked cursor_pointer" <?php echo $checked; ?>>
                                <label for="grade_community_<?php echo $grade_id; ?>" class="font_px_012 padding_px-x_005 cursor_pointer margin_px-l_005">
                                    <?php echo htmlspecialchars($grade_name); ?>
                                </label>
                            </div>
                            <?php
                        }
                    }

                    // 쇼핑몰 회원 등급 옵션 조회  
                    $shopping_grades = egb_option_flat('shopping_mall_user_grade');
                    if (!empty($shopping_grades)) {
                        echo '<div class="width_box padding_px-u_005 flv6">쇼핑몰 회원</div>';
                        foreach ($shopping_grades as $grade) {
                            $grade_id = $grade['uniq_id'];
                            $grade_name = $grade['label'];
                            $checked = in_array('shopping_'.$grade_id, $target_grades) ? 'checked' : '';
                            ?>
                            <div class="flex_fl_yc padding_px-r_015 padding_px-u_005">
                                <input type="checkbox" name="target_grades[]" value="shopping_<?php echo $grade_id; ?>" 
                                       id="grade_shopping_<?php echo $grade_id; ?>" class="egb_checked cursor_pointer" <?php echo $checked; ?>>
                                <label for="grade_shopping_<?php echo $grade_id; ?>" class="font_px_012 padding_px-x_005 cursor_pointer margin_px-l_005">
                                    <?php echo htmlspecialchars($grade_name); ?>
                                </label>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">지급 횟수</div>
                <select class="menu_input_style" name="reward_limit_count">
                    <option value="0" <?php echo ($reward['reward_limit_count'] == 0) ? 'selected' : ''; ?>>매회</option>
                    <option value="1" <?php echo ($reward['reward_limit_count'] == 1) ? 'selected' : ''; ?>>1회</option>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">지급 금액/포인트</div>
                <input class="menu_input_style" type="number" name="reward_grant" value="<?php echo htmlspecialchars($reward['reward_grant']); ?>" required>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">소멸일</div>
                <input class="menu_input_style" type="number" name="reward_expired_days" value="<?php echo htmlspecialchars($reward['reward_expired_days']); ?>" required>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">리워드 메모</div>
                <textarea class="menu_input_style padding_px-x_010 padding_px-y_005" name="reward_memo"><?php echo htmlspecialchars($reward['reward_memo']); ?></textarea>
            </div>
        </div>
    </form>
</div>