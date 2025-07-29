<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<form class="height_box" id="egb_main_banner_add_input" action="<?php echo DOMAIN . '/?post=egb_game_banner_add_input'; ?>" method="post" enctype="multipart/form-data">
    <div class="position1 width_box font_px_014 padding_px-x_010">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 margin_px-t_010 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">추가하기
            </div>
        </div>
    </div>
    <input type="hidden" name="page_name" value="<?php echo $_GET['page_name']; ?>">
    <input type="hidden" name="menu_name" value="<?php echo $_GET['menu_name']; ?>">
    <div class="height_box padding_px-t_010 padding_px-x_010 padding_px-u_050 overflow_y_auto scrollbar">
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">배너 제목</div>
            <input class="menu_input_style" type="text" name="banner_title" required>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">배너 내용</div>
            <textarea class="menu_input_style" name="banner_content" required style="min-height: 100px; resize: vertical;"></textarea>
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">출력 순서</div>
            <input class="menu_input_style" type="number" name="display_order" value="0">
        </div>
        <div class="flex_ft padding_px-u_008">
            <div class="padding_px-u_005">배너 이미지</div>
            <div class="flex_fl_yc">
                <div class="flex_xc_yc width_px_180 height_px_180 border_px-a_001 border_bre-a_005 margin_px-x_010" data-bd-a-color="#dddddd">
                    <label for="banner_image_upload" class="width_box height_box">
                        <div id="banner_image_preview" class="width_box height_box">
                        </div>
                    </label>
                </div>
                <label for="banner_image_upload" class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 fontstyle1 margin_px-x_010 pointer" data-bd-a-color="#dddddd" data-hover-bg-color="#d9d9d9">배너 이미지 선택</label>
                <input type="file" name="banner_image" id="banner_image_upload" class="display_off" accept="image/*" required>
            </div>
        </div>
    </div>
</form>

<script nonce="<?php echo NONCE; ?>">
    document.getElementById('banner_image_upload').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgElement = document.querySelector('#banner_image_preview img');
                if (imgElement) {
                    imgElement.src = e.target.result;
                } else {
                    const newImgElement = document.createElement('img');
                    newImgElement.src = e.target.result;
                    newImgElement.classList.add('width_box', 'height_box');
                    document.getElementById('banner_image_preview').appendChild(newImgElement);
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>