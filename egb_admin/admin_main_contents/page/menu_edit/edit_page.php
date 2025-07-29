<?php
// 조회할 ID
$uniq_id = egb('uniq_id');

// 조회 쿼리 
$query = "SELECT * FROM egb_page WHERE uniq_id = :uniq_id";
$params = [
    ':uniq_id' => $uniq_id
];

// 쿼리 바인딩
$binding = binding_sql(1, $query, $params);
$dataResult = egb_sql($binding);

?>
<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<form class="height_box overflow_y_auto scrollbar" id="egb_page_edit_input" action="<?php echo DOMAIN . '/?post=egb_page_edit_input'; ?>" method="post" enctype="multipart/form-data">
    <div class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">수정하기
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
    <input type="hidden" name="uniq_id" value="<?php echo $uniq_id; ?>">
    <input type="hidden" name="filter_table_name" value="egb_page">
    <div class="height_box padding_px-t_010 padding_px-x_010 padding_px-u_050">
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 제목</div>
            <input class="menu_input_style" type="text" name="page_title" value="<?php echo htmlspecialchars($dataResult[0]['page_title']); ?>" placeholder="페이지 제목을 입력하세요" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">출력 순서</div>
            <input class="menu_input_style" type="number" name="display_order" value="<?php echo intval($dataResult[0]['display_order']); ?>" placeholder="출력 순서를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 사용 여부</div>
            <select class="menu_input_style" name="page_seo">
                <option value="1" <?php echo $dataResult[0]['page_seo'] == 1 ? 'selected' : ''; ?>>사용</option>
                <option value="0" <?php echo $dataResult[0]['page_seo'] == 0 ? 'selected' : ''; ?>>미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 사용 여부</div>
            <select class="menu_input_style" name="page_use">
                <option value="1" <?php echo $dataResult[0]['page_use'] == 1 ? 'selected' : ''; ?>>사용</option>
                <option value="0" <?php echo $dataResult[0]['page_use'] == 0 ? 'selected' : ''; ?>>미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">페이지 우선순위</div>
            <input class="menu_input_style" type="number" name="page_rank" value="<?php echo intval($dataResult[0]['page_rank']); ?>" placeholder="페이지 우선순위를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 제목</div>
            <input class="menu_input_style" type="text" name="seo_title" value="<?php echo htmlspecialchars($dataResult[0]['seo_title']); ?>" placeholder="SEO 제목을 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 주제</div>
            <input class="menu_input_style" type="text" name="seo_subject" value="<?php echo htmlspecialchars($dataResult[0]['seo_subject']); ?>" placeholder="SEO 주제를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 설명</div>
            <textarea class="menu_input_style" name="seo_description" style="min-height: 100px; resize: vertical;" placeholder="SEO 설명을 입력하세요"><?php echo htmlspecialchars($dataResult[0]['seo_description']); ?></textarea>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 키워드</div>
            <input class="menu_input_style" type="text" name="seo_keywords" value="<?php echo htmlspecialchars($dataResult[0]['seo_keywords']); ?>" placeholder="SEO 키워드를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 로봇설정</div>
            <select class="menu_input_style" name="seo_robots">
                <option value="nofollow, noindex" <?php echo $dataResult[0]['seo_robots'] == 'nofollow, noindex' ? 'selected' : ''; ?>>nofollow, noindex</option>
                <option value="follow, index" <?php echo $dataResult[0]['seo_robots'] == 'follow, index' ? 'selected' : ''; ?>>follow, index</option>
                <option value="nofollow, index" <?php echo $dataResult[0]['seo_robots'] == 'nofollow, index' ? 'selected' : ''; ?>>nofollow, index</option>
                <option value="follow, noindex" <?php echo $dataResult[0]['seo_robots'] == 'follow, noindex' ? 'selected' : ''; ?>>follow, noindex</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 중복방지 링크</div>
            <input class="menu_input_style" type="text" name="seo_canonical" value="<?php echo htmlspecialchars($dataResult[0]['seo_canonical']); ?>" placeholder="SEO 중복방지 링크를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO OG 제목</div>
            <input class="menu_input_style" type="text" name="seo_og_title" value="<?php echo htmlspecialchars($dataResult[0]['seo_og_title']); ?>" placeholder="SEO OG 제목을 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO OG 설명</div>
            <textarea class="menu_input_style" name="seo_og_description" style="min-height: 100px; resize: vertical;" placeholder="SEO OG 설명을 입력하세요"><?php echo htmlspecialchars($dataResult[0]['seo_og_description']); ?></textarea>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO OG 이미지</div>
            <div class="flex_fl_yc">
                <div class="flex_xc_yc width_px_342 height_px_180 border_px-a_001 border_bre-a_005 margin_px-x_010" data-bd-a-color="#dddddd">
                    <label for="edit_seo_og_img_upload" class="width_box height_box">
                        <div id="edit_seo_og_img_preview" class="width_box height_box">
                            <img src="<?php echo !empty($dataResult[0]['seo_og_img']) ? htmlspecialchars($dataResult[0]['seo_og_img']) : DS . 'egb_thumbnail.webp'; ?>" class="width_box height_box object_fit_cover">
                        </div>
                    </label>
                </div>
                <label for="edit_seo_og_img_upload" class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 fontstyle1 margin_px-x_010 pointer" data-bd-a-color="#dddddd" data-hover-bg-color="#d9d9d9">이미지 선택</label>
                <input type="file" name="seo_og_img" id="edit_seo_og_img_upload" class="display_off" accept="image/*">
                <input type="hidden" name="old_seo_og_img" value="<?php echo htmlspecialchars($dataResult[0]['seo_og_img']); ?>">
            </div>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">SEO 작성자</div>
            <input class="menu_input_style" type="text" name="seo_author" value="<?php echo htmlspecialchars($dataResult[0]['seo_author']); ?>" placeholder="SEO 작성자를 입력하세요">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">Header 사용 여부</div>
            <select class="menu_input_style" name="setting_header_use">
                <option value="1" <?php echo $dataResult[0]['setting_header_use'] == 1 ? 'selected' : ''; ?>>사용</option>
                <option value="0" <?php echo $dataResult[0]['setting_header_use'] == 0 ? 'selected' : ''; ?>>미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">Footer 사용 여부</div>
            <select class="menu_input_style" name="setting_footer_use">
                <option value="1" <?php echo $dataResult[0]['setting_footer_use'] == 1 ? 'selected' : ''; ?>>사용</option>
                <option value="0" <?php echo $dataResult[0]['setting_footer_use'] == 0 ? 'selected' : ''; ?>>미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">댓글 사용 여부</div>
            <select class="menu_input_style" name="setting_comment_use">
                <option value="1" <?php echo $dataResult[0]['setting_comment_use'] == 1 ? 'selected' : ''; ?>>사용</option>
                <option value="0" <?php echo $dataResult[0]['setting_comment_use'] == 0 ? 'selected' : ''; ?>>미사용</option>
            </select>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">접근 레벨</div>
            <input class="menu_input_style" type="number" name="setting_access_level" value="<?php echo intval($dataResult[0]['setting_access_level']); ?>" min="0" max="99" placeholder="접근 레벨을 입력하세요">
        </div>
    </div>
</form>

<script nonce="<?php echo NONCE; ?>">
    document.getElementById('edit_seo_og_img_upload').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.querySelector('#edit_seo_og_img_preview img');
                if (imgElement) {
                    imgElement.src = e.target.result;
                } else {
                    const newImgElement = document.createElement('img');
                    newImgElement.src = e.target.result;
                    newImgElement.classList.add('width_box', 'height_box');
                    document.getElementById('edit_seo_og_img_preview').appendChild(newImgElement);
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>