<?php
  
$filter_user_id = egb('filter_user_id');
if (!isset($filter_user_id)) {
    $filter_user_id = 'admin';
}

// 오늘 날짜를 YYYY-MM-DD 형식으로 가져오기
$today = date('Y-m-d');

// 이벤트 정보 조회
$uniq_id = egb('uniq_id');
$query = "SELECT * FROM egb_event WHERE uniq_id = :uniq_id";
$params = [':uniq_id' => $uniq_id];
$binding = binding_sql(1, $query, $params);
$event = egb_sql($binding)[0];

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
    <form id="egb_event_edit_input" action="<?php echo DOMAIN . '/?post=egb_event_edit_input'; ?>" method="post" enctype="multipart/form-data"
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
        <input type="hidden" name="filter_table_name" value="egb_event">
        <input type="hidden" name="uniq_id" value="<?php echo $uniq_id; ?>">
        
        <div class="padding_px-t_010 padding_px-x_010 padding_px-u_050">
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">이벤트 카테고리</div>
                <select class="menu_input_style" name="event_category" id="event_category" required>
                    <?php
                    // 이벤트 카테고리 옵션 그룹 조회
                    $tree = egb_option_flat('event_category');
                    if (!empty($tree)) {
                        foreach ($tree as $category) {
                            $category_id = $category['uniq_id'];
                            $category_name = $category['label'];
                            $selected = ($event['event_category'] == $category_name) ? 'selected' : '';
                            ?>
                            <option value="<?php echo htmlspecialchars($category_name); ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($category_name); ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">이벤트 유형</div>
                <select class="menu_input_style" name="event_type" id="event_type" required>
                    <?php
                    // 현재 카테고리의 이벤트 유형 옵션 조회
                    switch($event['event_category']) {
                        case '회원정보':
                            echo '<option value="회원정보수정" '.($event['event_type'] == '회원정보수정' ? 'selected' : '').'>회원정보수정</option>';
                            echo '<option value="평생회원" '.($event['event_type'] == '평생회원' ? 'selected' : '').'>평생회원</option>';
                            break;
                        case '회원가입':
                            echo '<option value="쿠폰" '.($event['event_type'] == '쿠폰' ? 'selected' : '').'>쿠폰</option>';
                            echo '<option value="마일리지" '.($event['event_type'] == '마일리지' ? 'selected' : '').'>마일리지</option>';
                            break;
                        case '구독료할인':
                            echo '<option value="연간구독" '.($event['event_type'] == '연간구독' ? 'selected' : '').'>연간구독</option>';
                            echo '<option value="월간구독" '.($event['event_type'] == '월간구독' ? 'selected' : '').'>월간구독</option>';
                            break;
                        default:
                            echo '<option value="">유형을 선택하세요</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">이벤트 제목</div>
                <input class="menu_input_style" type="text" name="event_title" value="<?php echo htmlspecialchars($event['event_title']); ?>" required>
            </div>
            
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">이벤트 설명</div>
                <textarea class="menu_input_style padding_px-x_010 padding_px-y_005" name="event_description"><?php echo htmlspecialchars($event['event_description']); ?></textarea>
            </div>
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">대상 회원등급</div>
                <div class="flex_fl flex_wrap">
                    <?php
                    $target_grades = json_decode($event['event_data'], true);
                    
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
                                       id="grade_<?php echo $grade_id; ?>" class="egb_checked cursor_pointer" <?php echo $checked; ?>>
                                <label for="grade_<?php echo $grade_id; ?>" class="font_px_012 padding_px-x_005 cursor_pointer margin_px-l_005">
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
                                       id="grade_<?php echo $grade_id; ?>" class="egb_checked cursor_pointer" <?php echo $checked; ?>>
                                <label for="grade_<?php echo $grade_id; ?>" class="font_px_012 padding_px-x_005 cursor_pointer margin_px-l_005">
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
                <div class="padding_px-u_005">시작일</div>
                <input class="menu_input_style" type="date" name="event_start_date" min="<?php echo $today; ?>" value="<?php echo $event['event_start_date']; ?>" required>
            </div>
            
            <div class="flex_ft padding_px-u_008">
                <div class="padding_px-u_005">종료일</div>
                <input class="menu_input_style" type="date" name="event_end_date" min="<?php echo $today; ?>" value="<?php echo $event['event_end_date']; ?>" required>
            </div>
        </div>
    </form>
</div>

<script nonce="<?php echo NONCE; ?>">
document.getElementById('event_category').addEventListener('change', function() {
    const eventType = document.getElementById('event_type');
    eventType.innerHTML = ''; // 기존 옵션 초기화
    
    // 선택된 카테고리에 따라 유형 옵션 설정
    switch(this.value) {
        case '회원정보':
            eventType.innerHTML = `
                <option value="회원정보수정">회원정보수정</option>
                <option value="평생회원">평생회원</option>
            `;
            break;
        case '회원가입':
            eventType.innerHTML = `
                <option value="쿠폰">쿠폰</option>
                <option value="마일리지">마일리지</option>
            `;
            break;
        case '구독료할인':
            eventType.innerHTML = `
                <option value="연간구독">연간구독</option>
                <option value="월간구독">월간구독</option>
            `;
            break;
        default:
            eventType.innerHTML = '<option value="">유형을 선택하세요</option>';
    }
});
</script>
