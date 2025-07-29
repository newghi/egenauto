

<form class="position1" action="<?php echo DOMAIN . '/?post=region_regional_studies_form_input'; ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <section class="position3 width_box height_px_080 border_px-u_001 z-index_2"
        data-bg-color="#ffffff" data-bd-a-color="#dddddd" data-top="0">
        <div class="position1 width_px_1220 height_px_080 margin_x_auto padding_px-a_010" data-xy="1-1220: width_box">
            <div class="flex_xs1_yc" data-color="#2F3438">
                <div class="flex_fl_yc font_px_018 flv6">
                    <div class="font_px_025 pointer">
                        <a href="<?php echo DOMAIN; ?>"><img class="width_px_160 height_px_060"
                                src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>"></a>
                    </div>
                </div>
                <div id="manual_write_header" class="flex_fr_yc font_px_014" style="white-space: nowrap;">
                    <button type="submit" id="mentoring_private_consultation_submit_button"
                        class="padding_px-x_040 flex_xc_yc height_px_040 border_bre-a_004 pointer buttonselect egb_submit"
                        data-bg-color="#15376b" data-color="#ffffff">
                        올리기
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="width_box height_px_080"></div>
    <section class="position1 width_box">
        <div class="width_px_800 margin_x_auto padding_px-t_020" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="mentoring_private_consultation_content border_bre-a_005 width_box height_px_500 flex_ft_yc font_px_016"
                    data-bg-color="#ffffff">
                    <div class="position1 width_box flex_fr_xr_yc font_px_018 flv6 border_px-u_001 budget2"
                        data-bd-a-color="#dddddd">
                        
                        
                        <select name="region" class="width_px_200 height_px_040 border_px-a_001 border_bre-a_005 padding_px-x_010 fontstyle1 font_px_014 margin_px-r_010" required>
                            <option value="">지역 선택</option>
                            <?php
                            $tree = egb_option_flat('egb_region_board_filter');
                            if (!empty($tree)) {
                                foreach ($tree as $option) {
                                    if($option['label'] != '전체') {
                                        echo '<option value="' . $option['value'] . '">' . $option['label'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                        <input type="text" name="title"
                            class="mentoring_private_consultation_content_title padding_px-x_025 padding_px-y_015 font_px_025 flv6 width_box nothover"
                            maxlength="80" placeholder="제목을 입력해주세요." data-color="#000000" data-xy="1-800: font_px_018" required>
                    </div>
                    <div class="width_box flex_ft_yc font_px_018 flv6 padding_px-t_015">
                        <textarea id="egbeditor2" name="content" 
                            class="mentoring_private_consultation_content_content padding_px-x_025 padding_px-y_015 width_box"
                            required></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="padding_px-u_100"></section>
</form>
<style>
    .egbeditor2_click {
        outline: none;
    }
</style>

<?php egbeditor2(); ?>

<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    .rotate {
        transform: rotate(180deg);
        transition: 0.5s;
    }

    .rotate.reverse {
        transform: rotate(0deg);
    }

    .guidebox {
        max-height: 9999px;
        transition: max-height 0.5s ease-out;
    }

    select {
        box-sizing: border-box;
        background-color: transparent;
        outline: none;
    }

    input,
    textarea {
        all: unset;
        box-sizing: border-box;
    }

    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"],
    textarea {
        outline: none;
    }

    select:focus {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
    }

    input[type="checkbox"]:checked {
        display: block;
        width: 20px;
        height: 20px;
        border: 1px solid #202020;
        border-radius: 4px;
        background: url('<?php echo $background_url; ?>') no-repeat 0 0px / cover;
    }

    input[type="text"]:focus:not(.nothover),
    input[type="password"]:focus:not(.nothover) {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
        transition: 0.3s;
        z-index: 3;
    }

    [type="radio"] {
        appearance: none;
        border: 1px solid #000000;
        border-radius: 50%;
        position: relative;
    }

    [type="radio"]::before {
        content: '';
        display: block;
        width: 15px;
        height: 15px;
        background-color: transparent;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.2s ease-in-out;
    }

    [type="radio"]:checked {
        background-color: #ffffff;
        border-color: #202020;
    }

    [type="radio"]:checked::before {
        width: 8px;
        height: 8px;
        background-color: #202020;
    }

    .budget {
        position: relative;
    }

    .budget input {
        padding-right: 40px;
    }

    .budget:after {
        content: '만 원';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #888888;
        pointer-events: none;
    }

    :root {
        --char-count: '0 / 80';
    }

</style>