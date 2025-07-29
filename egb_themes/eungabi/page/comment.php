<?php 

function auto_commnet($table_name, $post_id){
	
// 특정 테이블 이름과 게시글 ID에 일치하는 댓글을 조회하는 쿼리
$auto_comment_table_name = $table_name; // 조회할 테이블 이름
$auto_comment_post_uniq_id = $post_id; // 조회할 게시글 ID

$query = "
    SELECT 
        no, 
        auto_comment_uniq_id, 
        auto_comment_user_uniq_id, 
        auto_comment_table_name, 
        auto_comment_post_uniq_id, 
        auto_comment_status, 
        auto_comment_depth, 
        auto_comment_publish_date, 
        auto_comment_last_modified_at 
    FROM auto_comment
    WHERE auto_comment_table_name = :auto_comment_table_name
    AND auto_comment_post_uniq_id = :auto_comment_post_uniq_id
";

$params = [
    ':auto_comment_table_name' => $auto_comment_table_name,
    ':auto_comment_post_uniq_id' => $auto_comment_post_uniq_id
];

$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);
?>
<section class="position1" data-top="0%">
    <div class="padding_px-x_010">
        <div class="width_px_720 margin_x_auto padding_px-u_050" data-xy="1-800: width_box">
            <div class="font_px_020 flv6">댓글&nbsp;<span data-color="#15376b">1</span></div>
            <div class="flex_fl_yc height_auto padding_px-t_020 padding_px-u_040"
                data-xy="1-800: padding_px-t_010 padding_px-u_025">
                <div class="flex_fl_yc min_width_060 max_width_060 width_box">
                    <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                        class="width_px_040 height_px_040 border_bre-a_035">
                </div>
                <div class="position1 flex_yc width_box height_auto border_px-a_001 border_bre-a_005 faketextarea"
                    tabindex="0" data-bd-a-color="#999999">
                    <textarea
                        class="min_height_045 max_height_300 height_auto padding_px-y_009 padding_px-l_010 comment_textarea"
                        style="box-sizing: border-box;" placeholder="칭찬과 격려의 댓글은 작성자에게 힘이 됩니다:)"></textarea>
                    <div class="position2" data-bottom="5%" data-right="1%">
                        <div class="flv6 text_input" data-color="#d9d9d9">입력</div>
                    </div>
                </div>
            </div>
            <div class="flex_fl padding_px-y_010">
                <div class="flex_fl min_width_060 max_width_060 width_box max_height_040 pointer">
                    <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                        class="width_px_040 height_px_040 border_bre-a_035">
                </div>
                <div class="flex_ft width_box font_px_016">
                    <div class="flv6 pointer">닉네임</div>
                    <div class="padding_px-y_008">
                        내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용내용
                    </div>
                    <div class="flex_fl_yc font_px_012" data-color="#888888">
                        <div>12시간</div>
                        <div>・</div>
                        <div class="pointer flex_fl_yc">
                            <img class="width_px_016 height_px_016"
                                src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/heart.svg'; ?>">
                            <svg class="width_px_016 height_px_016" xmlns="http://www.w3.org/2000/svg" fill="#aaaaaa"
                                id="Layer_1" height="512" viewBox="0 0 512 512" width="512" data-name="Layer 1">
                                <path
                                    d="m256 436a54.62 54.62 0 0 1 -29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1 -29.53 8.68zm-101.84-334.94a89.41 89.41 0 0 0 -23.42 3.1 90.93 90.93 0 0 0 -48.15 32.44c-13.14 17.22-20.09 39-20.09 63 0 35.52 22.81 76.12 67.81 120.68 39 38.66 85.47 70.5 109.67 86a29.72 29.72 0 0 0 32 0c24.2-15.54 70.63-47.38 109.67-86 45-44.56 67.81-85.16 67.81-120.68 0-24-6.95-45.74-20.09-63a90.93 90.93 0 0 0 -48.15-32.44c-34.17-9.28-82.18.42-114.48 55.48a12.49 12.49 0 0 1 -21.56 0c-25.38-43.34-60.54-58.58-91.02-58.58z" />
                            </svg>
                            <svg class="width_px_016 height_px_016" xmlns="http://www.w3.org/2000/svg" id="Layer_1"
                                height="512" viewBox="0 0 512 512" width="512" data-name="Layer 1">
                                <g transform="translate(256, 256) rotate(1) translate(-256, -256)">
                                    <path fill="#15376b"
                                        d="M256 436a54.62 54.62 0 0 1-29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1-29.53 8.68z" />
                                </g>
                            </svg>
                            <svg class="width_px_016 height_px_016" xmlns="http://www.w3.org/2000/svg" id="Layer_1"
                                height="512" viewBox="0 0 512 512" width="512" data-name="Layer 1">
                                <path
                                    d="m256 436a54.62 54.62 0 0 1 -29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1 -29.53 8.68zm-101.84-334.94a89.41 89.41 0 0 0 -23.42 3.1 90.93 90.93 0 0 0 -48.15 32.44c-13.14 17.22-20.09 39-20.09 63 0 35.52 22.81 76.12 67.81 120.68 39 38.66 85.47 70.5 109.67 86a29.72 29.72 0 0 0 32 0c24.2-15.54 70.63-47.38 109.67-86 45-44.56 67.81-85.16 67.81-120.68 0-24-6.95-45.74-20.09-63a90.93 90.93 0 0 0 -48.15-32.44c-34.17-9.28-82.18.42-114.48 55.48a12.49 12.49 0 0 1 -21.56 0c-25.38-43.34-60.54-58.58-91.02-58.58z" />
                            </svg>




                            <div>좋아요</div>
                        </div>
                        <div>・</div>
                        <div class="pointer">답글달기</div>
                        <div>・</div>
                        <div class="pointer">신고</div>
                    </div>
                </div>
            </div>
            <div class="flex_fl padding_px-y_010">
                <div class="min_width_060 max_width_060 width_box"></div>
                <div class="flex_fl width_box padding_px-a_015" data-bg-color="#f7f9fa">
                    <div class="flex_fl min_width_060 max_width_060 max_height_040 width_box pointer">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                            class="width_px_040 height_px_040 border_bre-a_035">
                    </div>
                    <div class="flex_ft width_box font_px_016">
                        <div class="flv6 pointer">닉네임</div>
                        <div class="padding_px-y_008">
                            답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글답글z
                        </div>
                        <div class="flex_fl_yc_wrap font_px_012" data-color="#888888">
                            <div>12시간</div>
                            <div>・</div>
                            <div class="pointer flex_fl_yc">
                                <img class="width_px_016 height_px_016"
                                    src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/heart.svg'; ?>">
                                <div>좋아요</div>
                            </div>
                            <div>・</div>
                            <div class="pointer">답글달기</div>
                            <div>・</div>
                            <div class="pointer">신고</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="padding_px-t_025 flex_xc_yc">
                <div class="padding_px-a_005">
                    <div class="flex_xc_yc border_px-a_001 border_bre-a_005 width_px_032 height_px_032 pointer"
                        data-bg-color="#ffffff" data-bd-a-color="#dddddd">
                        <img class="width_px_010 height_px_020"
                            src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/leftarrow.svg'; ?>">
                    </div>
                </div>
                <div class="padding_px-a_005">
                    <div class="flex_xc_yc border_px-a_001 border_bre-a_005 width_px_032 height_px_032 numberhover pointer"
                        data-bg-color="#15376b" data-bd-a-color="#15376b" data-color="#ffffff">
                        1
                    </div>
                </div>
                <div class="padding_px-a_005">
                    <div class="flex_xc_yc border_px-a_001 border_bre-a_005 width_px_032 height_px_032 pointer"
                        data-bg-color="#ffffff" data-bd-a-color="#dddddd" data-color="#000000">
                        2
                    </div>
                </div>
                <div class="padding_px-a_005">
                    <div class="flex_xc_yc border_px-a_001 border_bre-a_005 width_px_032 height_px_032 pointer"
                        data-bg-color="#ffffff" data-bd-a-color="#dddddd">
                        <img class="width_px_010 height_px_020"
                            src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/rightarrow.svg'; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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

    .numberhover:hover {
        background-color: #09addb;
        border-color: #09addb;
    }
</style>
<script nonce="<?php echo NONCE; ?>">
    const textareas = document.querySelectorAll('.comment_textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto'; // 높이를 초기화해서 다시 계산
            this.style.height = this.scrollHeight + 'px'; // 내용에 맞는 높이로 조절
        });
    });




    const faketextarea = document.querySelector('.faketextarea');
    const textarea = document.querySelector('.comment_textarea');

    // textarea에 포커스가 들어왔을 때 faketextarea에 포커스 효과를 추가
    textarea.addEventListener('focus', function () {
        faketextarea.classList.add('focused');
    });

    // textarea에서 포커스가 빠질 때 faketextarea의 포커스 효과 제거
    textarea.addEventListener('blur', function () {
        faketextarea.classList.remove('focused');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.querySelector('.comment_textarea');
        const textInput = document.querySelector('.text_input');





        textarea.addEventListener('input', function () {
            if (textarea.value.trim() !== '') {
                textInput.classList.add('pointer');
                textInput.style.color = '#15376b';
            } else {
                textInput.classList.remove('pointer');
                textInput.style.color = '#d9d9d9';  // 초기 색상으로 변경
            }
        });
    });

</script>
<?php
}

?>