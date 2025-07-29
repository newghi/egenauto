<?php
require_once ROOT.THEMES_PATH.DS.'page'.DS.'mypage_menu.php';

// 로그인 유저 정보 가져오기 (세션)
$user_uniq_id = isset($_SESSION['user_uniq_id']) ? $_SESSION['user_uniq_id'] : null;

// 사용자 정보 가져오기
$user_info = null;
if ($user_uniq_id) {
    $query = "SELECT * FROM egb_user WHERE uniq_id = :user_id AND is_status = 1";
    $binding = binding_sql(1, $query, [':user_id' => $user_uniq_id]);
    $result = egb_sql($binding);
    $user_info = isset($result[0]) ? $result[0] : null;
}

// 내가 스크랩한 게시글 동적 출력 (여러 게시판, 최신순)
$my_scrap_posts = [];
if ($user_uniq_id) {
    // 1. 내가 스크랩한 게시글의 게시판명, uniq_id 목록 조회
    $query = "SELECT scrap_target_table, scrap_target_uniq_id FROM egb_scrap_log WHERE scrap_user_uniq_id = :user_id AND scrap_type = 1 AND is_status = 1 ORDER BY created_at DESC LIMIT 10";
    $binding = binding_sql(0, $query, [':user_id' => $user_uniq_id]);
    $scrap_list = egb_sql($binding);
    
    // 2. 게시판별로 uniq_id 그룹핑 (3중 배열 구조 처리)
    $board_scrap_map = [];
    
    // 3중 배열 구조에서 실제 데이터 추출
    $actual_scrap_data = [];
    if (isset($scrap_list[0]) && is_array($scrap_list[0])) {
        foreach ($scrap_list[0] as $item) {
            if (is_array($item) && isset($item['scrap_target_table']) && isset($item['scrap_target_uniq_id'])) {
                $actual_scrap_data[] = $item;
            }
        }
    }
    
    // 게시판별로 그룹핑
    foreach ($actual_scrap_data as $row) {
        $table = $row['scrap_target_table'];
        $uniq_id = $row['scrap_target_uniq_id'];
        if (!isset($board_scrap_map[$table])) $board_scrap_map[$table] = [];
        $board_scrap_map[$table][] = $uniq_id;
    }

    // 3. 각 게시판별로 게시글 정보 조회
    foreach ($board_scrap_map as $board_table => $uniq_ids) {
        if (empty($uniq_ids)) continue;
        
        // 각 uniq_id를 개별적으로 조회 (IN 절 대신 OR 조건 사용)
        foreach ($uniq_ids as $uniq_id) {
            $query = "SELECT *, '{$board_table}' as board_table FROM {$board_table} WHERE uniq_id = :uniq_id AND is_status = 1";
            $binding = binding_sql(0, $query, [':uniq_id' => $uniq_id]);
            $result = egb_sql($binding);
            
            if (!empty($result)) {
                // 3중 배열 구조에서 실제 데이터 추출
                if (isset($result[0]) && is_array($result[0])) {
                    foreach ($result[0] as $item) {
                        if (is_array($item) && isset($item['uniq_id'])) {
                            $my_scrap_posts[] = $item;
                        }
                    }
                }
            }
        }
    }

    // 4. 최신순 정렬 (created_at 기준 내림차순)
    usort($my_scrap_posts, function($a, $b) {
        $a_created = isset($a['created_at']) && !empty($a['created_at']) ? $a['created_at'] : '1970-01-01';
        $b_created = isset($b['created_at']) && !empty($b['created_at']) ? $b['created_at'] : '1970-01-01';
        return strtotime($b_created) - strtotime($a_created);
    });

    // 최종 게시글 배열 (이미 평탄화되어 있음)
    $flat_posts = $my_scrap_posts;
}
?>

<div class="width_box">
    <div class="width_px_1220 margin_x_auto">
        <div class="flex_xs1_yt padding_px-y_030">
            <!-- 프로필 카드 -->
            <div class="flex_ft_yc width_px_270 height_px_430 border_px-a_001" data-bd-a-color="#dadce0">
                <div class="flex_xr_yc width_box padding_px-x_020 padding_px-t_020">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5 10.5L21 3" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21.5 7V2.5H17" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 2H8C4 2 2 4 2 8V16C2 20 4 22 8 22H16C20 22 22 20 22 16V14" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="flex_xc_yc width_box">
                    <div class="width_px_120 height_px_120 border_bre-a_035">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                           class="width_px_120 height_px_120 border_bre-a_035">
                    </div>
                </div>
                <div class="flex_xc_yc width_box padding_px-t_030 padding_px-u_015">
                    <div class="font_px_022 flv6"><?php echo htmlspecialchars($user_info['user_id'] ?? '아이디'); ?></div>
                </div>
                <div class="flex_xc_yc width_box">
                    <div class="pointer padding_px-x_015 padding_px-y_010 border_bre-a_005 font_px_014 flv6" data-bg-color="#15376b" data-color="#ffffff">회원정보 설정</div>
                </div>

                <div class="width_box padding_px-t_040">
                    <div class="margin_px-x_020 border_px-u_001" data-bd-u-color="#dadce0"></div>
                </div>

                <div class="flex_xs3_yc width_box height_box padding_px-x_020 padding_px-y_020">
                    <div class="flex_ft_xc_yc width_box">
                        <div class="flex_xc_yc width_box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="flex_xc_yc width_box padding_px-t_005 font_px_014">팔로워 0</div>
                    </div>
                    <div class="flex_ft_xc_yc width_box">
                        <div class="flex_xc_yc width_box">
                            <svg class="width_px_024 height_px_024" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                <g>
                                    <path d="m90.59766 2.28174h-81.19532a2.0001 2.0001 0 0 0 -2 2v90.71826a2.0004 2.0004 0 0 0 3.00391 1.73l39.59375-22.97414 39.59375 22.97414a2.0004 2.0004 0 0 0 3.00391-1.73v-90.71826a2.0001 2.0001 0 0 0 -2-2zm-2 89.2456-37.59375-21.814a2.00123 2.00123 0 0 0 -2.00782 0l-37.59375 21.814v-85.2456h77.19532z" stroke="#292D32" stroke-width="1.5"/>
                                </g>
                            </svg>
                        </div>
                        <div class="flex_xc_yc width_box padding_px-t_005 font_px_014">
                            스크랩 <?php 
                            if ($user_uniq_id) {
                                $query = "SELECT COUNT(*) as cnt FROM egb_scrap_log WHERE scrap_user_uniq_id = :user_id AND scrap_type = 1 AND is_status = 1";
                                $binding = binding_sql(1, $query, [':user_id' => $user_uniq_id]);
                                $result = egb_sql($binding);
                                echo isset($result[0]['cnt']) ? $result[0]['cnt'] : 0;
                            } else {
                                echo '0';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="flex_ft_xc_yc width_box">
                        <div class="flex_xc_yc width_box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="flex_xc_yc width_box padding_px-t_005 font_px_014">
                            좋아요 <?php 
                            if ($user_uniq_id) {
                                $query = "SELECT COUNT(*) as cnt FROM egb_like_log WHERE like_user_uniq_id = :user_id AND like_type = 1 AND is_status = 1";
                                $binding = binding_sql(1, $query, [':user_id' => $user_uniq_id]);
                                $result = egb_sql($binding);
                                echo isset($result[0]['cnt']) ? $result[0]['cnt'] : 0;
                            } else {
                                echo '0';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 메인 콘텐츠 영역 -->
            <div class="flex_ft_yc">
                <!-- 게시글 카드 섹션 -->
                <div class="width_px_820 margin_px-u_080">
                    <div class="display_grid gap_px_020" data-xx="1fr 1fr 1fr">
                        <?php if (!empty($flat_posts)): ?>
                            <?php 
                            // 화면에는 최대 9개만 표시
                            $display_posts = array_slice($flat_posts, 0, 9);
                            foreach ($display_posts as $post): 
                            ?>
                                <div class="flex_ft_xc_yc width_box margin_px-a_010">
                                    <div class="width_box height_px_185 border_bre-a_010" data-bg-color="#f5f5f5">
                                        <?php if (!empty($post['board_thumbnail_url'])): ?>
                                            <a href="/page/board_view?table=<?php echo urlencode($post['board_table']); ?>&id=<?php echo urlencode($post['uniq_id']); ?>" class="width_box height_box display_block pointer" style="text-decoration:none;">
                                                <div class="width_box height_box overflow_hidden border_bre-a_010">
                                                    <img src="<?php echo htmlspecialchars($post['board_thumbnail_url']); ?>" alt="썸네일" class="width_box height_box object_fit_cover">
                                                </div>
                                            </a>
                                        <?php else: ?>
                                            <!-- 썸네일이 없는 경우 제목 표시 -->
                                            <a href="/page/board_view?table=<?php echo urlencode($post['board_table']); ?>&id=<?php echo urlencode($post['uniq_id']); ?>" class="width_box height_box display_block pointer flex_xc_yc padding_px-a_020" style="text-decoration:none;">
                                                <div class="font_px_014 flv6 text_align_center line_height_140" data-color="#333333">
                                                    <?php echo htmlspecialchars($post['board_title'] ?? '제목 없음'); ?>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php
                            $remaining = 9 - count($display_posts);
                            for($i = 0; $i < $remaining; $i++): ?>
                                <div class="flex_ft_xc_yc width_box margin_px-a_010">
                                    <div class="width_box height_px_185 border_bre-a_010" data-bg-color="#f5f5f5">
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            <?php for($i = 0; $i < 9; $i++): ?>
                                <div class="flex_ft_xc_yc width_box margin_px-a_010">
                                    <div class="width_box height_px_185 border_bre-a_010" data-bg-color="#f5f5f5">
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                    <?php if (count($flat_posts) > 9): ?>
                    <div class="flex_xc_yc width_box padding_px-t_020">
                        <a href="/page/board_write" class="width_box margin_px-x_010">
                            <div class="flex_xc_yc width_box padding_px-x_020 padding_px-y_010 border_bre-a_005 border_px-a_001 pointer" data-bd-a-color="#dadce0">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M13 7L1 7" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span class="padding_px-x_010 padding_px-y_010 font_px_016 flv6" data-color="#292D32">더보기</span>
                            </div>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>