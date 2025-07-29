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

// 내가 작성한 댓글 동적 출력 (여러 게시판, 최신순)
$my_comments = [];
if ($user_uniq_id) {
    // 1. 내가 작성한 댓글의 게시판명, uniq_id 목록 조회
    $query = "SELECT log_target_table, log_comment_uniq_id, created_at FROM egb_comment_log WHERE log_user_uniq_id = :user_id AND is_status = 1 ORDER BY created_at DESC LIMIT 10";
    $binding = binding_sql(0, $query, [':user_id' => $user_uniq_id]);
    $comment_list = egb_sql($binding);
    
    // 3중 배열 구조에서 실제 데이터 추출
    $actual_comment_data = [];
    if (isset($comment_list[0]) && is_array($comment_list[0])) {
        foreach ($comment_list[0] as $item) {
            if (is_array($item) && isset($item['log_target_table']) && isset($item['log_comment_uniq_id'])) {
                $actual_comment_data[] = $item;
            }
        }
    }
    
    // 2. 각 게시판별로 댓글 정보 조회
    $my_comments = [];
    foreach ($actual_comment_data as $row) {
        $table = $row['log_target_table'];
        $comment_uniq_id = $row['log_comment_uniq_id'];
        
        // 댓글 테이블에서 실제 댓글 내용 조회 (egb_comment_ 테이블)
        $query = "SELECT *, '{$table}' as board_table FROM {$table} WHERE uniq_id = :comment_uniq_id AND is_status = 1";
        $binding = binding_sql(0, $query, [':comment_uniq_id' => $comment_uniq_id]);
        $result = egb_sql($binding);
        
        if (!empty($result)) {
            // 3중 배열 구조에서 실제 데이터 추출
            if (isset($result[0]) && is_array($result[0])) {
                foreach ($result[0] as $item) {
                    if (is_array($item) && isset($item['uniq_id'])) {
                        $my_comments[] = $item;
                    }
                }
            }
        }
    }
    
    // 3. 최신순 정렬 (created_at 기준 내림차순)
    usort($my_comments, function($a, $b) {
        $a_created = isset($a['created_at']) && !empty($a['created_at']) ? $a['created_at'] : '1970-01-01';
        $b_created = isset($b['created_at']) && !empty($b['created_at']) ? $b['created_at'] : '1970-01-01';
        return strtotime($b_created) - strtotime($a_created);
    });
    
    // 최종 댓글 배열
    $flat_comments = $my_comments;
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
                <!-- 댓글 목록 섹션 -->
                <div class="width_px_820 margin_px-u_080">
                    <!-- 댓글 목록 -->
                    <div class="width_box">
                        <?php if (!empty($flat_comments)): ?>
                            <?php 
                            // 화면에는 최대 9개만 표시
                            $display_comments = array_slice($flat_comments, 0, 9);
                            foreach ($display_comments as $comment): 
                            ?>
                                <div class="width_box padding_px-x_020 padding_px-y_015 border_px-u_001" data-bd-u-color="#f0f0f0">
                                    <div class="flex_xs1_yc width_box">
                                        <div class="width_box font_px_016" data-color="#333333">
                                            <?php 
                                            // 댓글 내용은 comment_contents 컬럼에 저장됨
                                            $comment_content = $comment['comment_contents'] ?? '댓글 내용 없음';
                                            echo htmlspecialchars($comment_content);
                                            ?>
                                        </div>
                                        <div class="font_px_014" data-color="#999999">
                                            <?php echo isset($comment['created_at']) ? date('Y.m.d', strtotime($comment['created_at'])) : '날짜 없음'; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- 댓글이 없는 경우 기본 댓글 표시 -->
                            <div class="width_box padding_px-x_020 padding_px-y_015 border_px-u_001" data-bd-u-color="#f0f0f0">
                                <div class="flex_xs1_yc width_box">
                                    <div class="width_box font_px_016" data-color="#333333">정말 유용한 정보네요! 감사합니다.</div>
                                    <div class="font_px_014" data-color="#999999">2024.01.15</div>
                                </div>
                            </div>
                            <div class="width_box padding_px-x_020 padding_px-y_015 border_px-u_001" data-bd-u-color="#f0f0f0">
                                <div class="flex_xs1_yc width_box">
                                    <div class="width_box font_px_016" data-color="#333333">좋은 글이네요. 공감합니다!</div>
                                    <div class="font_px_014" data-color="#999999">2024.01.14</div>
                                </div>
                            </div>
                            <div class="width_box padding_px-x_020 padding_px-y_015 border_px-u_001" data-bd-u-color="#f0f0f0">
                                <div class="flex_xs1_yc width_box">
                                    <div class="width_box font_px_016" data-color="#333333">이런 정보가 정말 필요했어요.</div>
                                    <div class="font_px_014" data-color="#999999">2024.01.13</div>
                                </div>
                            </div>
                            <div class="width_box padding_px-x_020 padding_px-y_015 border_px-u_001" data-bd-u-color="#f0f0f0">
                                <div class="flex_xs1_yc width_box">
                                    <div class="width_box font_px_016" data-color="#333333">잘 정리된 글이네요. 도움이 많이 됐습니다.</div>
                                    <div class="font_px_014" data-color="#999999">2024.01.12</div>
                                </div>
                            </div>
                            <div class="width_box padding_px-x_020 padding_px-y_015 border_px-u_001" data-bd-u-color="#f0f0f0">
                                <div class="flex_xs1_yc width_box">
                                    <div class="width_box font_px_016" data-color="#333333">첫 번째 댓글입니다.</div>
                                    <div class="font_px_014" data-color="#999999">2024.01.11</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (count($flat_comments) > 9): ?>
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