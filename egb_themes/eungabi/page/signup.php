<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){$user_login = 'user'; redirect(DOMAIN);}
?>

<section class="position1 width_box height_box padding_px-y_050">
    <div class="width_px_620 margin_x_auto letterm_spacing_030" data-xy="1-620: width_box">
        <div class="padding_px-x_010" data-xy="1-620: padding_px-x_020">
            <div class="flex_xc_yc font_px_024 flv6" data-color="#202020">회원가입</div>
            <div class="step1">
                <div class="flex_xs1_yc width_px_450 margin_x_auto padding_px-y_050 font_px_016"
                    data-xy="1-450: width_box flex_xs3_yc font_px_014, 451-800: flex_xs3_yc font_px_014">
                    <div class="stepselect stepcolor" data-color="#888888">1.약관동의</div>
                    <div class="flex_xc_yc width_px_015 height_px_015">
                        <svg fill="#888888" id="magicoon-Bold" height="100%" viewBox="0 0 512 512" width="100%"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="chevron-right-Bold">
                                <path id="chevron-right-Bold-2"
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1 -30.167-30.166l176.917-176.917-176.917-176.917a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" />
                            </g>
                        </svg>
                    </div>
                    <div class="stepselect " data-color="#888888">2.정보입력</div>
                    <div class="flex_xc_yc width_px_015 height_px_015">
                        <svg fill="#888888" id="magicoon-Bold" height="100%" viewBox="0 0 512 512" width="100%"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="chevron-right-Bold">
                                <path id="chevron-right-Bold-2"
                                    d="m377.75 271.083-192 192a21.331 21.331 0 1 1 -30.167-30.166l176.917-176.917-176.917-176.917a21.331 21.331 0 1 1 30.167-30.166l192 192a21.325 21.325 0 0 1 0 30.166z"
                                    data-name="chevron-right-Bold" />
                            </g>
                        </svg>
                    </div>
                    <div class="stepselect " data-color="#888888">3.가입완료</div>
                </div>
                <div class="font_px_020 flv6 padding_px-u_025 border_px-u_003" data-color="#202020"
                    data-bd-a-color="#202020">전체동의</div>
                <div>
                    <div class="flex_fl padding_px-y_025 border_px-u_001 font_px_016" data-color="#202020"
                        data-bd-a-color="#d9d9d9" data-xy="1-620: font_px_014">
                        <div class="flex_ft">
                            <div class="flex_fl_yc">
                                <input id="checkall"
                                    class="border_px-a_001 border_bre-a_004 width_px_020 min_width_020  height_px_020 pointer"
                                    data-bd-a-color="#888888" type="checkbox">
                                <label for="checkall" class="flex_fl_yc padding_px-l_012 flv6 pointer"
                                    data-xy="1-620: flex_ft">
                                    <span>이용약관(필수), 개인정보수집 및 이용(필수),&nbsp;</span>
                                    <span>쇼핑정보 수신(선택)에 모두 동의합니다.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex_ft padding_px-t_010 font_px_015" data-color="#202020"
                        data-xy="1-620: font_px_013">
                        <div class="flex_fl_yc width_px_360 height_px_030 padding_px-y_008"
                            data-xy="1-360: width_box">
                            <input id="check1"
                                class="border_px-a_001 border_bre-a_004 width_px_020 height_px_020 subCheckbox pointer"
                                data-bd-a-color="#888888" type="checkbox" required>
                            <label class="padding_px-l_012 pointer" for="check1">이용약관 동의 (필수)</label>
                            <div>
                            </div>
                        </div>
                        <div class="padding_px-y_015 font_px_013" data-xy="1-620: font_px_010">
                            <div class="border_px-a_001 height_px_120 padding_px-a_010" style="overflow-y:scroll;"
                                data-bd-a-color="#dddddd">
                                <?php require_once(ROOT . THEMES_PATH . '/page/terms_and_conditions1.php'); ?>
                            </div>
                        </div>
                        <div class="flex_fl_yc width_px_360 height_px_030 padding_px-y_008"
                            data-xy="1-360: width_box">
                            <input id="check2"
                                class="border_px-a_001 border_bre-a_004 width_px_020 height_px_020 subCheckbox pointer"
                                data-bd-a-color="#888888" type="checkbox" required>
                            <label class="padding_px-l_012 pointer" for="check2">개인정보 수집 및 이용 동의 (필수)</label>
                            <div>
                            </div>
                        </div>
                        <div class="padding_px-y_015 font_px_013" data-xy="1-620: font_px_010">
                            <div class="border_px-a_001 height_px_100 padding_px-a_010" style="overflow-y:scroll;"
                                data-bd-a-color="#dddddd">
                                <?php require_once(ROOT . THEMES_PATH . '/page/terms_and_conditions2.php'); ?>
                            </div>
                        </div>
                        <div class="flex_fl_yc width_px_360 height_px_030 padding_px-y_008"
                            data-xy="1-360: width_box">
                            <input id="check3"
                                class="border_px-a_001 border_bre-a_004 width_px_020 height_px_020 subCheckbox pointer"
                                data-bd-a-color="#888888" type="checkbox" required>
                            <label class="padding_px-l_012 pointer" for="check3">쇼핑정보 수신 동의 (선택)</label>
                            <div>
                            </div>
                        </div>
                        <div class="padding_px-y_015 font_px_013" data-xy="1-620: font_px_010">
                            <div class="border_px-a_001 height_px_100 padding_px-a_010" style="overflow-y:scroll;"
                                data-bd-a-color="#dddddd">
                                <?php require_once(ROOT . THEMES_PATH . '/page/terms_and_conditions3.php'); ?>
                            </div>
                        </div>
                        <div class="flex_xc width_box padding_px-t_020 font_px_016">
                            <div class="width_box padding_px-r_005">
                                <a href="<?php echo DOMAIN; ?>">
                                    <div class="flex_xc_yc width_box border_px-a_001 border_bre-a_005 padding_px-y_015 pointer cancelsignup"
                                        data-bd-a-color="#d9d9d9" data-color="#202020">취소</div>
                                </a>
                            </div>
                            <div class="width_box padding_px-l_005">
                                <div class="flex_xc_yc width_box border_px-a_001 border_bre-a_005 padding_px-y_015 pointer nextstep check"
                                    data-bd-a-color="#202020" data-bg-color="#202020" data-color="#ffffff">다음</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
<style>
    select {
        box-sizing: border-box;
        background-color: transparent;
    }

    .signup_bgcolor {
        background-color: #f3f3f3;
    }

    .cancelsignup:hover {
        border-color: #202020;
    }

    p {
        margin-bottom: 10px;
    }

    .stepcolor {
        color: #202020;
        font-weight: 600;
    }

    input {
        all: unset;
        box-sizing: border-box;
    }

    .check:hover {
        background-color: #15376b;
    }

    ::placeholder {
        font-family: fontstyle1;
        color: #bdbdbd;
    }

    input[type="text"],
    input[type="password"],
    input[type="checkbox"],
    input[type="submit"] {
        outline: none;
    }

    select {
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

    input[type="text"]:focus,
    input[type="password"]:focus {
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
        width: 12px;
        height: 12px;
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

    .email_custom_close {
        position: absolute;
        top: 50%;
        right: 2%;
        transform: translateY(-50%);
        display: none;
        cursor: pointer;
    }

    .hidden {
        opacity: 0;
        pointer-events: none;
    }

    .blink {
        animation: blink-animation 0.5s step-end infinite alternate;
    }

    @keyframes blink-animation {
        50% {
            outline: 2px solid #ff5555;
        }

        100% {
            outline: 2px solid transparent;
        }
    }
</style>
<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkall');
    const subCheckboxes = document.querySelectorAll('.subCheckbox');
    const nextStepButton = document.querySelector('.nextstep');

    // 전체 동의 체크박스 이벤트
    checkAll.addEventListener('change', function() {
        subCheckboxes.forEach(checkbox => {
            checkbox.checked = checkAll.checked;
        });
        checkNextButton();
    });

    // 개별 체크박스 이벤트
    subCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let allChecked = true;
            subCheckboxes.forEach(box => {
                if (!box.checked) {
                    allChecked = false;
                }
            });
            checkAll.checked = allChecked;
            checkNextButton();
        });
    });

    // 다음 버튼 활성화 체크
    function checkNextButton() {
        const check1 = document.getElementById('check1');
        const check2 = document.getElementById('check2');
        
        if (check1.checked && check2.checked) {
            nextStepButton.style.opacity = '1';
            nextStepButton.style.pointerEvents = 'auto';
        } else {
            nextStepButton.style.opacity = '0.5';
            nextStepButton.style.pointerEvents = 'none';
        }
    }

    // 초기 다음 버튼 상태 설정
    checkNextButton();

    // onclick 대신 addEventListener 사용
    nextStepButton.addEventListener('click', function() {
        const check1 = document.getElementById('check1');
        const check2 = document.getElementById('check2');
        
        if (check1.checked && check2.checked) {
            window.location.href = '<?php echo DOMAIN; ?>/page/signup_step2';
        }
    });
});
</script>