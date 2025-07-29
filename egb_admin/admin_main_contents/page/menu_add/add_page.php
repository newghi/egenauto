<?php
  
$filter_user_id = egb('filter_user_id');
if (!isset($filter_user_id)) {
    $filter_user_id = 'admin';
}

?>
<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<form class="height_box overflow_y_auto scrollbar" id="egb_page_add_input" action="<?php echo DOMAIN . '/?post=egb_page_add_input'; ?>" method="post" enctype="multipart/form-data">
    <div class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">추가하기
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
    <input type="hidden" name="filter_table_name" value="egb_page">
    <input type="hidden" name="page_view" value="0">
    <div class="height_box padding_px-t_010 padding_px-x_010 padding_px-u_050">
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">테마</div>
            <select class="menu_input_style" name="page_theme">
                <?php
                $themes = egb_theme_name_list();
                foreach ($themes as $theme) {
                    echo '<option value="' . $theme . '">' . $theme . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 제목</div>
            <input class="menu_input_style" type="text" name="page_title" placeholder="페이지 제목을 입력하세요" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 이름</div>
            <input class="menu_input_style" type="text" name="page_name" pattern="[A-Za-z0-9_]+" title="영문, 숫자, 언더바(_)만 입력 가능합니다" placeholder="영문, 숫자, 언더바(_)만 입력 가능" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 타입</div>
            <select class="menu_input_style" name="page_type" required>
                <option value="path">path</option>
                <option value="editor">editor</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">출력 순서</div>
            <input class="menu_input_style" type="number" name="display_order" value="0" placeholder="출력 순서를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 사용 여부</div>
            <select class="menu_input_style" name="page_seo">
                <option value="1">사용</option>
                <option value="0">미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 사용 여부</div>
            <select class="menu_input_style" name="page_use">
                <option value="1">사용</option>
                <option value="0">미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 우선순위</div>
            <input class="menu_input_style" type="number" name="page_rank" value="0" placeholder="페이지 우선순위를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 제목</div>
            <input class="menu_input_style" type="text" name="seo_title" placeholder="SEO 제목을 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 주제</div>
            <input class="menu_input_style" type="text" name="seo_subject" placeholder="SEO 주제를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 설명</div>
            <textarea class="menu_input_style" name="seo_description" style="min-height: 100px; resize: vertical;" placeholder="SEO 설명을 입력하세요"></textarea>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 키워드</div>
            <input class="menu_input_style" type="text" name="seo_keywords" placeholder="SEO 키워드를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 로봇설정</div>
            <select class="menu_input_style" name="seo_robots">
                <option value="nofollow, noindex">nofollow, noindex</option>
                <option value="follow, index">follow, index</option>
                <option value="nofollow, index">nofollow, index</option>
                <option value="follow, noindex">follow, noindex</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 중복방지 링크</div>
            <input class="menu_input_style" type="text" name="seo_canonical" placeholder="SEO 중복방지 링크를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO OG 제목</div>
            <input class="menu_input_style" type="text" name="seo_og_title" placeholder="SEO OG 제목을 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO OG 설명</div>
            <textarea class="menu_input_style" name="seo_og_description" style="min-height: 100px; resize: vertical;" placeholder="SEO OG 설명을 입력하세요"></textarea>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO OG 이미지</div>
            <div class="flex_fl_yc">
                <div class="flex_xc_yc width_px_342 height_px_180 border_px-a_001 border_bre-a_005 margin_px-x_010" data-bd-a-color="#dddddd">
                    <label for="seo_og_img_upload" class="width_box height_box">
                        <div id="seo_og_img_preview" class="width_box height_box">
                            <img src="<?php echo DS . 'egb_thumbnail.webp'; ?>" class="width_box height_box">
                        </div>
                    </label>
                </div>
                <label for="seo_og_img_upload" class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 fontstyle1 margin_px-x_010 pointer" data-bd-a-color="#dddddd" data-hover-bg-color="#d9d9d9">이미지 선택</label>
                <input type="file" name="seo_og_img" id="seo_og_img_upload" class="display_off" accept="image/*">
            </div>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 작성자</div>
            <input class="menu_input_style" type="text" name="seo_author" value="eungabi" placeholder="SEO 작성자를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">Header 사용 여부</div>
            <select class="menu_input_style" name="setting_header_use">
                <option value="1">사용</option>
                <option value="0">미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">Footer 사용 여부</div>
            <select class="menu_input_style" name="setting_footer_use">
                <option value="1">사용</option>
                <option value="0">미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">댓글 사용 여부</div>
            <select class="menu_input_style" name="setting_comment_use">
                <option value="1">사용</option>
                <option value="0">미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">접근 레벨</div>
            <input class="menu_input_style" type="number" name="setting_access_level" value="0" min="0" max="99" placeholder="접근 레벨을 입력하세요">
        </div>
    </div>
</form>

<script nonce="<?php echo NONCE; ?>">
    document.getElementById('seo_og_img_upload').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.querySelector('#seo_og_img_preview img');
                if (imgElement) {
                    imgElement.src = e.target.result;
                } else {
                    const newImgElement = document.createElement('img');
                    newImgElement.src = e.target.result;
                    newImgElement.classList.add('width_box', 'height_box');
                    document.getElementById('seo_og_img_preview').appendChild(newImgElement);
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>