



<?php

function auto_comment($table_name, $comment_board_uniq_id, $auto_board_user_uniq_id = null) {
    // 특정 테이블 이름과 게시글 ID에 일치하는 댓글을 조회하는 쿼리 
    $comment_table_name = $table_name; // 조회할 테이블 이름
    $comment_board_uniq_id = $comment_board_uniq_id; // 조회할 게시글 ID

    $board_table_name = str_replace('egb_comment_', 'egb_board_', $table_name);

    // 메인 댓글만 조회하는 쿼리 (parent_uniq_id가 NULL인 것만) - 최신 10개만 가져오도록 수정
    $query = "
        SELECT 
            c.*,
            c.comment_reply_count as reply_count
        FROM {$table_name} c
        WHERE c.is_status = 1 
        AND c.deleted_at IS NULL
        AND c.comment_board_uniq_id = :comment_board_uniq_id
        AND c.comment_parent_uniq_id IS NULL
        ORDER BY c.display_order ASC, c.created_at DESC
        LIMIT 10
    ";

    $params = [
        ':comment_board_uniq_id' => $comment_board_uniq_id
    ];

    $binding = binding_sql(0, $query, $params);
    $sql = egb_sql($binding);

    // 게시글의 댓글 수를 가져오는 쿼리
    $count_query = "
        SELECT board_comment_count 
        FROM {$board_table_name}
        WHERE uniq_id = :board_id
    ";
    
    $count_params = [
        ':board_id' => $comment_board_uniq_id
    ];

    $count_binding = binding_sql(1, $count_query, $count_params);
    $count_result = egb_sql($count_binding);

    if (isset($count_result[0]['board_comment_count'])) {
        $comment_count = $count_result[0]['board_comment_count'];
        $display = 'display_block';
    } else {
        $comment_count = 0;
        $display = 'display_block';
    }

?>
<?php
    $login_user_uniq_id = $_SESSION['user_uniq_id'] ?? null;

    if ($login_user_uniq_id) {
        $user_login_check = 'div';
        $user_login_check_close = 'div';
        $user_login_check_button = 'egb_submit';
    } else {
        $user_login_check = 'a href="'.DOMAIN.'/page/login'.'" ';
        $user_login_check_close = 'a';
        $user_login_check_button = '';
    }
?>
<style>
    input {
        all: unset;
        font-family: fontstyle1;
        background-color: #ffffff;
    }

    ::placeholder {
        font-size: 15px;
        color: #a1a1a1;
    }

    textarea {
        all: unset;
        font-size: 14px;
        font-family: fontstyle1;
        resize: none;
    }

    .comment_textarea {
        width: 90%;
        min-height: 50px;
        max-height: 300px;
        resize: none;
        overflow-y: auto;
        word-break: break-all;
    }

    input:focus {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
        transition: 0.3s;
        border-color: #15376b;
    }

    .faketextarea:focus {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
        transition: 0.3s;
        border-color: #15376b;
    }

    .faketextarea.focused {
        box-shadow: 0 0 0 3px #15376b4d;
        border: 1px solid #15376b;
        border-color: #15376b;
        transition: 0.3s;
    }

    textarea:focus {
        outline: none;
    }

    .comment_item {
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .comment_re_write {
        transition: max-height 0.3s ease-in;
    }

    .view_replies_form button {
        all: unset;
        cursor: pointer;
    }

    .toggle_replies {
        color: #15376b;
    }
</style>

<?php if ($comment_count > 10): ?>
<form id="auto_comment_scroll_update_form" method="post" action="<?php echo DOMAIN . "/?post=auto_comment_scroll_update_form_input"; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>
<?php endif; ?>
<section class="position1" data-top="0%">
    <div class="padding_px-x_010">
        <div class="width_px_720 margin_x_auto padding_px-t_320 padding_px-u_050" data-xy="1-800: width_box">
            <div id="comment_list_container" class="position4 z-index_004 padding_px-t_110" 
            data-top="130px" 
            data-bg-color="#ffffff"
            data-xy="1-800: width_box padding_px-t_000"
            >
                <div class="font_px_020 flv6">댓글&nbsp;<span id="all_comment_count" data-color="#15376b"><?php echo $comment_count; ?></span></div>
                <div class="comment_write flex_fl_yc height_auto padding_px-t_020 padding_px-u_040"
                    data-xy="1-800: padding_px-t_010 padding_px-u_025">
                    <div class="flex_fl_yc min_width_060 max_width_060 width_box">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                            class="width_px_040 height_px_040 border_bre-a_035">
                    </div>
                    <form class="comment_form position1 flex_yc width_box height_auto border_px-a_001 border_bre-a_005 faketextarea"
                        tabindex="0" data-bd-a-color="#999999" method="POST" action="<?php echo DOMAIN . "/?post=comment_form_input"; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="comment_table_name" value="<?php echo $table_name; ?>">
                        <input type="hidden" name="comment_board_uniq_id" value="<?php echo $comment_board_uniq_id; ?>">
                        <input type="hidden" name="comment_user_uniq_id" value="<?php echo $login_user_uniq_id; ?>">
                        <input type="hidden" name="comment_user_ip" value="<?php echo EGB_USER_IP; ?>">
                        <input type="hidden" name="comment_user_agent" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">
                        <input type="hidden" name="comment_user_password" value="<?php echo $_POST['comment_user_password'] ?? null; ?>">
                        <textarea name="comment_contents" 
                            class="min_height_045 max_height_300 height_auto padding_px-y_009 padding_px-l_010 comment_textarea main_comment_textarea"
                            style="box-sizing: border-box;" placeholder="칭찬과 격려의 댓글은 작성자에게 힘이 됩니다:)"></textarea>
                        <<?php echo $user_login_check; ?> class="position2" data-bottom="5%" data-right="1%">
                            <div class="<?php echo $user_login_check_button; ?> flv6 text_input pointer" data-color="#d9d9d9">입력</div>
                        </<?php echo $user_login_check_close; ?>>
                    </form>
                </div>
            </div>
            <div id="comment_list" class="<?php echo $display; ?>" data-xy="1-800: width_box">
<?php
// 사용자 닉네임을 조회하는 함수
function getUserNickname($comment_user_uniq_id) {
    $user_query = "
        SELECT user_nick_name, user_name 
        FROM egb_user 
        WHERE uniq_id = :comment_user_uniq_id
        AND is_status = 1
    ";

    $user_params = [
        ':comment_user_uniq_id' => $comment_user_uniq_id
    ];

    $user_binding = binding_sql(1, $user_query, $user_params);
    $user_result = egb_sql($user_binding);

    if ($user_result && isset($user_result[0]['user_nick_name']) && !empty($user_result[0]['user_nick_name'])) {
        return $user_result[0]['user_nick_name'];
    } else if ($user_result && isset($user_result[0]['user_name'])) {
        return $user_result[0]['user_name'];
    }

    return '탈퇴한 회원';
}

// 댓글 렌더링 함수
function renderComment($comment, $table_name) {

    $comment_user_nickname = getUserNickname($comment['comment_user_uniq_id']);
    $reply_count = $comment['reply_count'] ?? 0;
?>
    <div id="item_<?php echo $comment['uniq_id']; ?>" class="comment_item">
        <div id="comment_<?php echo $comment['uniq_id']; ?>" class="comment_box flex_fl padding_px-y_010">
            <div class="flex_fl min_width_060 max_width_060 width_box max_height_040 pointer">
                <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                    class="width_px_040 height_px_040 border_bre-a_035">
            </div>
            <div class="flex_ft width_box font_px_016">
                <div class="flv6 pointer"><?php echo htmlspecialchars($comment_user_nickname); ?></div>
                <div class="padding_px-y_008">
                    <?php echo htmlspecialchars($comment['comment_contents']); ?>
                </div>
                <div class="flex_fl_yc_wrap font_px_012" data-color="#888888">
                    <div><?php echo $comment['created_at']; ?></div>
                    <div>・</div>
                    <div class="pointer flex_fl_yc">
                        <img class="width_px_016 height_px_016"
                            src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/heart.svg'; ?>">
                        <div>좋아요</div>
                    </div>
                    <div>・</div>
                    <div class="comment_recomment recomment_<?php echo $comment['uniq_id']; ?> pointer" data-comment-id="<?php echo $comment['uniq_id']; ?>">
                        댓글달기
                    </div>
                    <?php if($reply_count > 0): ?>
                    <div>・</div>
                    <form class="view_replies_form" method="POST" action="<?php echo DOMAIN . "/?post=auto_comment_view_replies_form_input"; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" id="comment_id_<?php echo $comment['uniq_id']; ?>" name="comment_id" value="<?php echo $comment['uniq_id']; ?>">
                        <input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
                        <div class="egb_submit toggle_replies pointer view_replies_btn_<?php echo $comment['uniq_id']; ?>" data-comment-id="<?php echo $comment['uniq_id']; ?>" data-reply-count="<?php echo $reply_count; ?>">
                            댓글 보기 (<?php echo $reply_count; ?>)
                        </div>
                    </form>
                    <?php endif; ?>
                    <div>・</div>
                    <div class="pointer">신고</div>
                </div>
            </div>
        </div>
        <div class="replies_container replies_wrapper_<?php echo $comment['uniq_id']; ?>" id="replies_<?php echo $comment['uniq_id']; ?>" style="display: none;"></div>
    </div>
<?php
}

if(isset($sql[0])) {
    foreach ($sql[0] as $comment) {
        renderComment($comment, $table_name);
    }
}
?>


<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    // URL에서 해시를 확인하고 해당 댓글로 스크롤
    if(window.location.hash) {
        const commentId = window.location.hash;
        let targetComment = document.querySelector(commentId);
        
        if(targetComment) {
            // 페이지 로드 후 해당 댓글로 스크롤
            setTimeout(() => {
                // 헤더 높이를 고려하여 스크롤 위치 조정 
                const headerHeight = 500; // 헤더 높이
                const targetPosition = targetComment.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                
                // 부드러운 스크롤 이동
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // 댓글 하이라이트 효과
                targetComment.style.backgroundColor = '#fff3cd';
                setTimeout(() => {
                    targetComment.style.backgroundColor = '';
                    targetComment.style.transition = 'background-color 0.5s ease';
                }, 2000);
            }, 500);
        } else {
            // 댓글을 찾지 못한 경우 자동 스크롤하면서 찾기
            let currentScroll = 0;
            const scrollInterval = setInterval(() => {
                window.scrollTo(0, currentScroll);
                currentScroll += 100;
                
                // 새로 로드된 댓글 중에서 다시 찾기
                targetComment = document.querySelector(commentId);
                if(targetComment) {
                    clearInterval(scrollInterval);
                    const headerHeight = 500;
                    const targetPosition = targetComment.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    targetComment.style.backgroundColor = '#fff3cd';
                    setTimeout(() => {
                        targetComment.style.backgroundColor = '';
                        targetComment.style.transition = 'background-color 0.5s ease';
                    }, 2000);
                }
                
                // 페이지 끝에 도달하면 중단
                if(currentScroll >= document.documentElement.scrollHeight) {
                    clearInterval(scrollInterval);
                }
            }, 100);
        }
    }

    // 댓글 스크롤 로딩 처리
    let isLoading = false;
    let lastScrollTop = 0;
    let noMoreComments = false; // 더 이상 불러올 댓글이 없는지 체크하는 플래그
    const scrollThreshold = 1000;
    
    window.addEventListener('scroll', () => {
        const commentList = document.getElementById('comment_list');
        if (!commentList) return;

        const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        // 스크롤이 하단에 가까워지면 자연스럽게 추가 댓글 로드
        if (currentScrollTop > lastScrollTop && 
            (scrollHeight - currentScrollTop - clientHeight) < scrollThreshold && 
            !isLoading) {
            
            isLoading = true;
            
            // 로딩 애니메이션 표시
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'comment-loading fade-in';
            loadingDiv.innerHTML = '<div class="loading-spinner"></div>';
            commentList.appendChild(loadingDiv);
            
            // 추가 댓글 불러오기
            EGB.form.submit('auto_comment_scroll_update_form', formData => {
                
                formData.append('comment_table_name', '<?php echo $table_name; ?>');
                formData.append('comment_board_uniq_id', '<?php echo $comment_board_uniq_id; ?>');
                
                const items = document.querySelectorAll('#comment_list .comment_item');
                const lastItem = items[items.length - 1];
                const lastId = lastItem.id.split('_')[1];
                formData.append('last_comment_uniq_id', lastId);
            });

            // 로딩 상태 해제 및 애니메이션 제거
            setTimeout(() => {
                const loadingElement = document.querySelector('.comment-loading');
                if (loadingElement) {
                    loadingElement.classList.add('fade-out');
                    setTimeout(() => loadingElement.remove(), 300);
                }
                isLoading = false;
            }, 700);
        }

        lastScrollTop = currentScrollTop;
    });

    const commentWriteTemplate = (commentId) => {
        const template = document.createElement('div');
        template.className = 'comment_re_write flex_fl_yc height_auto padding_px-t_020 padding_px-u_040';
        template.setAttribute('data-xy', '1-800: padding_px-t_010 padding_px-u_025');
        template.style.maxHeight = '0';
        template.style.overflow = 'hidden';
        template.style.transition = 'max-height 0.3s ease-in';
        
        template.innerHTML = `
            <div class="min_width_030 max_width_030 width_box"></div>
            <div class="flex_fl_yc min_width_060 max_width_060 width_box">
                <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                    class="width_px_040 height_px_040 border_bre-a_035">
            </div>
            <form class="comment_form position1 flex_yc width_box height_auto border_px-a_001 border_bre-a_005 faketextarea bd-a-color-999999"
                tabindex="0" method="POST" action="<?php echo DOMAIN . "/?post=comment_form_input"; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="comment_table_name" value="<?php echo $table_name; ?>">
                <input type="hidden" name="comment_board_uniq_id" value="<?php echo $comment_board_uniq_id; ?>">
                <input type="hidden" name="comment_parent_uniq_id" value="${commentId}">
                <input type="hidden" name="comment_user_uniq_id" value="<?php echo $login_user_uniq_id; ?>">
                <input type="hidden" name="comment_user_ip" value="<?php echo EGB_USER_IP; ?>">
                <input type="hidden" name="comment_user_agent" value="<?php echo $_SERVER['HTTP_USER_AGENT']; ?>">
                <input type="hidden" name="comment_user_password" value="<?php echo $_POST['comment_user_password'] ?? null; ?>">
                <textarea name="comment_contents" 
                    class="min_height_045 max_height_300 height_auto padding_px-y_009 padding_px-l_010 comment_textarea reply_comment_textarea"
                    style="box-sizing: border-box;" placeholder="칭찬과 격려의 댓글은 작성자에게 힘이 됩니다:)"></textarea>
                <div class="position2 bottom-5per right-1per">
                    <div class="egb_submit flv6 text_input color-d9d9d9">입력</div>
                </div>
            </form>
        `;
        
        return template;
    };

    // 댓글달기 이벤트 위임으로 처리
    document.body.addEventListener('click', function(e) {
        if (!e.target.classList.contains('comment_recomment')) return;
        
        const commentId = e.target.dataset.commentId;
        const commentBox = e.target.closest('.comment_box');
        
        // 이미 열려있는 대댓글 창이 있는지 확인
        const existingReWrite = commentBox.nextElementSibling;
        if (existingReWrite && existingReWrite.classList.contains('comment_re_write')) {
            return; // 이미 열려있으면 아무것도 하지 않음
        }
        
        // 다른 대댓글 창들 닫기
        document.querySelectorAll('.comment_re_write').forEach(el => {
            if (el !== existingReWrite) {
                el.style.maxHeight = '0';
                setTimeout(() => el.remove(), 300);
            }
        });
        
        const newCommentWrite = commentWriteTemplate(commentId);
        commentBox.insertAdjacentElement('afterend', newCommentWrite);
        
        // 댓글 보기 버튼이 있으면 클릭 이벤트 발생
        const viewRepliesBtn = commentBox.querySelector('.toggle_replies');
        if (viewRepliesBtn && viewRepliesBtn.textContent.includes('댓글 보기')) {
            viewRepliesBtn.click();
        }
        
        setTimeout(() => {
            newCommentWrite.style.maxHeight = '500px';
            // 대댓글 입력창에 포커스 주기
            const textarea = newCommentWrite.querySelector('.reply_comment_textarea');
            if (textarea) {
                textarea.focus();
            }
        }, 10);
    });

    // 답글 보기/숨기기 이벤트 리스너
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('toggle_replies')) {
            const commentId = e.target.dataset.commentId;
            const repliesContainer = document.querySelector(`.replies_wrapper_${commentId}`);
            const replyCount = e.target.dataset.replyCount;

            if (repliesContainer.style.display === 'none') {
                repliesContainer.style.display = 'block';
                e.target.textContent = `댓글 숨기기 (${replyCount})`;
            } else {
                repliesContainer.style.display = 'none';
                e.target.textContent = `댓글 보기 (${replyCount})`;
            }
        }
    });
});
</script>

            </div>
        </div>
    </div>
</section>
<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function () {
    const commentContainer = document.body;

    // 댓글 텍스트 영역의 자동 높이 조절
    commentContainer.addEventListener('input', function (event) {
        if (event.target.classList.contains('comment_textarea')) {
            const textarea = event.target;
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
    });

    // faketextarea와 comment_textarea의 포커스 효과 관리
    commentContainer.addEventListener('focus', function (event) {
        if (event.target.classList.contains('main_comment_textarea')) {
            const faketextarea = event.target.closest('.faketextarea');
            if (faketextarea) {
                faketextarea.classList.add('focused');
            }
        } else if (event.target.classList.contains('reply_comment_textarea')) {
            const faketextarea = event.target.closest('.faketextarea');
            if (faketextarea) {
                faketextarea.classList.add('focused');
            }
        }
    }, true);

    commentContainer.addEventListener('blur', function (event) {
        if (event.target.classList.contains('comment_textarea')) {
            const faketextarea = event.target.closest('.faketextarea');
            if (faketextarea) {
                faketextarea.classList.remove('focused');
            }
        }
    }, true);

    // 댓글 입력에 따른 포인터 효과 및 색상 변경 관리
    commentContainer.addEventListener('input', function (event) {
        if (event.target.classList.contains('comment_textarea')) {
            const textInput = event.target.closest('form').querySelector('.text_input');
            if (textInput) {
                if (event.target.value.trim() !== '') {
                    textInput.classList.add('pointer');
                    textInput.style.color = '#15376b';
                } else {
                    textInput.classList.remove('pointer');
                    textInput.style.color = '#d9d9d9';
                }
            }
        }
    });
});
</script>

<?php
}
?>