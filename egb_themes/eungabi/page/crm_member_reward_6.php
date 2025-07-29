<?php

// egb_reward 테이블에서 데이터를 조회하는 쿼리
$query = "SELECT * FROM egb_reward ORDER BY display_order ASC";
$params = [];
$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);
?>

<?php 
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>

<style>
input[type="checkbox"] {
    appearance: none;
    border: 1px solid #202020;
    border-radius: 4px;
}

input[type="checkbox"]:checked {
    display: block;
    width: 20px;
    height: 20px;
    border: 1px solid #202020;
    border-radius: 4px;
    background: url('<?php echo $background_url; ?>') no-repeat 0 0px / cover;
}
</style>

<?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_header_menu.php'; ?>
<section class="position1 width_box height_box">
    <div class="flex_fl width_box height_box padding_px-l_200" data-xy="1-1200: flex_ft padding_px-l_000">
        <?php require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'crm_member_reward_sub_menu.php'; ?>
        <div class="width_box height_box padding_px-a_020" data-bg-color="#E6E6E5">
            <div class="flex_xs1_yc"
                data-xy="1-800: flex_fu width_box, 801-1200: flex_xs1_yc">
                <div class="font_px_020 flv6">리워드 항목 설정</div>
                <div class="flex_xc" data-xy="1-800: flex_xr, 801-1200: flex_xc">
                    <div class="flex_xs1_yc width_px_300 font_px_016 padding_px-u_000" data-color="#888888"
                        data-xy="1-800: width_px_200 font_px_012 padding_px-u_010">
                        <div>CRM</div>
                        <div>></div>
                        <div>리워드</div>
                        <div>></div>
                        <div class="flv6" data-color="#000000">리워드 항목 설정</div>
                    </div>
                </div>
            </div>
<?php
// 조회한 결과를 확인 후 반복문으로 출력
if (isset($sql[0])) {
    $rewards = $sql[0];
    foreach ($rewards as $reward): ?>
        <form id="egb_reward_edit_input_<?php echo htmlspecialchars($reward['uniq_id']); ?>" action="<?php echo DOMAIN . '/?post=egb_crm_reward_edit_input'; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="uniq_id" value="<?php echo htmlspecialchars($reward['uniq_id']); ?>">
        <input type="hidden" name="mode" value="edit">
        <div class="font_px_020 flv6 padding_px-t_030 padding_px-u_010" data-xy="1-800: font_px_018"><?php echo htmlspecialchars($reward['reward_title']) ?></div>
        <div class="reward_box flex_ft width_box border_px-a_002 font_px_016 reward_id_<?php echo htmlspecialchars($reward['uniq_id']); ?>" data-bd-a-color="#d9d9d9" data-xy="1-800: font_px_014">
            
            <!-- 항목 -->
            <div class="flex_fl_yc width_box flv6" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 border_px-u_001"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">항목</div>
                <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff"><?php echo htmlspecialchars($reward['reward_name']) ?></div>
            </div>
            
            <!-- 횟수 -->
            <div class="flex_fl_yc width_box flv6" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">횟수</div>
                <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                    <?php
                    // 횟수 맵핑
                    $countMapping = [
                        '0' => '매회',
                        '1' => '최초 1회'
                    ];
                    echo isset($countMapping[$reward['reward_limit_count']]) 
                        ? htmlspecialchars($countMapping[$reward['reward_limit_count']]) 
                        : htmlspecialchars($reward['reward_limit_count']);
                    ?>
                </div>
            </div>
            
                        <!-- 커뮤니티 등급 -->
                <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                    <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                        data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                        data-xy="1-800: padding_px-y_010 padding_px-l_010">커뮤니티 등급</div>
                    <div class="reward_rank_box flex_fl_yc_wrap height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                        data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <?php
                        $target_grades = json_decode($reward['reward_data'], true);
                        
                        // 커뮤니티 회원 등급 옵션 조회
                        $community_grades = egb_option_flat('community_user_grade');
                        if (!empty($community_grades)) {
                            ?>
                            <div class="flex_fl padding_px-y_003 pointer">
                                <input id="community_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_all" 
                                    name="reward_ranks" 
                                    class="width_px_020 height_px_020 community_all_checkbox" 
                                    type="checkbox"
                                    data-reward-id="<?php echo htmlspecialchars($reward['uniq_id']); ?>"
                                    data-checkbox-type="community_all">
                                <label for="community_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_all" 
                                    class="padding_px-l_005 padding_px-r_010">전체</label>
                            </div>
                            <?php
                            foreach($community_grades as $index => $grade) {
                                $grade_id = $grade['uniq_id'];
                                $grade_name = $grade['label'];
                                $checked = in_array('community_'.$grade_id, $target_grades) ? 'checked' : '';
                                ?>
                                <div class="flex_fl padding_px-y_003 pointer">
                                    <input id="community_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_<?php echo $index ?>" 
                                        name="target_grades[]" 
                                        value="community_<?php echo $grade_id; ?>"
                                        class="width_px_020 height_px_020 community_checkbox_<?php echo htmlspecialchars($reward['uniq_id']); ?>" 
                                        type="checkbox"
                                        data-reward-id="<?php echo htmlspecialchars($reward['uniq_id']); ?>"
                                        data-checkbox-type="community"
                                        <?php echo $checked; ?>>
                                    <label for="community_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_<?php echo $index ?>" 
                                        class="padding_px-l_005 padding_px-r_010"><?php echo htmlspecialchars($grade_name) ?></label>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            <!-- 쇼핑몰 등급 -->
            <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">쇼핑몰 등급</div>
                <div class="reward_rank_box flex_fl_yc_wrap height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                        <?php
                        // 쇼핑몰 회원 등급 옵션 조회  
                        $shopping_grades = egb_option_flat('shopping_mall_user_grade');
                        if (!empty($shopping_grades)) {
                            ?>
                            <div class="flex_fl padding_px-y_003 pointer">
                                <input id="shop_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_all" 
                                    name="reward_shop_ranks" 
                                    class="width_px_020 height_px_020 shopping_all_checkbox" 
                                    type="checkbox"
                                    data-reward-id="<?php echo htmlspecialchars($reward['uniq_id']); ?>"
                                    data-checkbox-type="shopping_all">
                                <label for="shop_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_all" 
                                    class="padding_px-l_005 padding_px-r_010">전체</label>
                            </div>
                            <?php
                            foreach($shopping_grades as $index => $grade) {
                                $grade_id = $grade['uniq_id'];
                                $grade_name = $grade['label'];
                                $checked = in_array('shopping_'.$grade_id, $target_grades) ? 'checked' : '';
                                ?>
                                <div class="flex_fl padding_px-y_003 pointer">
                                    <input id="shop_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_<?php echo $index ?>" 
                                        name="target_grades[]" 
                                        value="shopping_<?php echo $grade_id; ?>"
                                        class="width_px_020 height_px_020 shopping_checkbox_<?php echo htmlspecialchars($reward['uniq_id']); ?>" 
                                        type="checkbox"
                                        data-reward-id="<?php echo htmlspecialchars($reward['uniq_id']); ?>"
                                        data-checkbox-type="shopping"
                                        <?php echo $checked; ?>>
                                    <label for="shop_level_signup_<?php echo htmlspecialchars($reward['uniq_id']); ?>_<?php echo $index ?>" 
                                        class="padding_px-l_005 padding_px-r_010"><?php echo htmlspecialchars($grade_name) ?></label>
                                </div>
                                <?php
                            }
                        }
                        ?>
                            <script nonce="<?php echo NONCE; ?>">
                            document.addEventListener('DOMContentLoaded', function() {
                                // 초기 로드시 전체 체크박스 상태 설정
                                const initCheckboxStates = () => {
                                    const rewardCheckboxes = document.querySelectorAll('input[data-checkbox-type="community"], input[data-checkbox-type="shopping"]');
                                    rewardCheckboxes.forEach(checkbox => {
                                        const rewardId = checkbox.dataset.rewardId;
                                        const checkboxType = checkbox.dataset.checkboxType;
                                        
                                        if (checkboxType === 'community') {
                                            const allCheckbox = document.getElementById(`community_level_signup_${rewardId}_all`);
                                            const checkboxes = document.getElementsByClassName(`community_checkbox_${rewardId}`);
                                            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                                            if(allCheckbox) allCheckbox.checked = allChecked;
                                        } else if (checkboxType === 'shopping') {
                                            const allCheckbox = document.getElementById(`shop_level_signup_${rewardId}_all`);
                                            const checkboxes = document.getElementsByClassName(`shopping_checkbox_${rewardId}`);
                                            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                                            if(allCheckbox) allCheckbox.checked = allChecked;
                                        }
                                    });
                                };

                                // 초기 상태 설정 실행
                                initCheckboxStates();

                                document.addEventListener('change', function(e) {
                                    if (!e.target.matches('input[type="checkbox"]')) return;
                                    
                                    const checkbox = e.target;
                                    const rewardId = checkbox.dataset.rewardId;
                                    const checkboxType = checkbox.dataset.checkboxType;

                                    if (checkboxType === 'community_all') {
                                        const checkboxes = document.getElementsByClassName(`community_checkbox_${rewardId}`);
                                        Array.from(checkboxes).forEach(cb => {
                                            cb.checked = checkbox.checked;
                                        });
                                    } else if (checkboxType === 'shopping_all') {
                                        const checkboxes = document.getElementsByClassName(`shopping_checkbox_${rewardId}`);
                                        Array.from(checkboxes).forEach(cb => {
                                            cb.checked = checkbox.checked;
                                        });
                                    } else if (checkboxType === 'community') {
                                        const allCheckbox = document.getElementById(`community_level_signup_${rewardId}_all`);
                                        const checkboxes = document.getElementsByClassName(`community_checkbox_${rewardId}`);
                                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                                        allCheckbox.checked = allChecked;
                                    } else if (checkboxType === 'shopping') {
                                        const allCheckbox = document.getElementById(`shop_level_signup_${rewardId}_all`);
                                        const checkboxes = document.getElementsByClassName(`shopping_checkbox_${rewardId}`);
                                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                                        allCheckbox.checked = allChecked;
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            <!-- 지급금액 -->
            <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">지급금액</div>
                <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                    <input class="width_box max_width_200 padding_px-x_015 padding_px-y_008 border_px-a_001" data-bd-a-color="#d9d9d9" type="number" name="reward_grant" value="<?php echo htmlspecialchars($reward['reward_grant']) ?>" placeholder="직접입력">
                </div>
            </div>
            
            <!-- 소멸일 -->
            <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">소멸일</div>
                <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                    <input class="width_box max_width_200 padding_px-x_015 padding_px-y_008 border_px-a_001" data-bd-a-color="#d9d9d9" type="number" name="reward_expired_days" value="<?php echo htmlspecialchars($reward['reward_expired_days']) ?>" placeholder="지급일로 부터 몇일 후">
                </div>
            </div>

            <!-- 저장 버튼 -->
            <div class="flex_fl_yc width_box" data-xy="1-800: flex_ft" data-bg-color="#ffffff">
                <div class="min_width_180 padding_px-y_018 padding_px-l_010 border_px-r_001 border_px-u_001 flv6"
                    data-bd-a-color="#d9d9d9" data-bg-color="#efefef"
                    data-xy="1-800: padding_px-y_010 padding_px-l_010">수정</div>
                <div class="flex_fl_yc height_px_055 border_px-u_001 padding_px-x_010 padding_px-y_010 width_box"
                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
                    <button type="submit" class="egb_submit padding_px-x_015 padding_px-y_008 border_px-a_001" data-bd-a-color="#d9d9d9">수정하기</button>
                </div>
            </div>

        </div>
        </form>
    <?php endforeach;
    } else {
    echo "리워드 데이터를 불러올 수 없습니다.";
}
?>