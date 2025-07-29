<section class="position1 width_box height_box">
    <div class="padding_px-a_015">
        <a class="pointer" href="<?php echo DOMAIN; ?>"><img class="width_box height_box max_width_150 max_height_060"
                src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.webp' ?>"></a>
    </div>
    <div class="width_px_320 margin_x_auto padding_px-y_150">
        <div class="font_px_020 flv6 font_style_center" data-color="#424242">비밀번호 찾기
        </div>
        <div class="padding_px-t_050">
            <form class="padding_px-x_010">
                <div class="flex_ft width_box">
                    <div class="flex_yc width_box font_px_016 flv6 padding_px-u_005">
                        회원유형</div>
                    <div class="flex_yc width_box">
                        <select name="" id="findpwselect"
                            class="border_px-a_001 width_px_300 height_px_040 padding_px-x_015 border_bre-a_004 font_px_014 fontstyle1 pointer"
                            data-bd-a-color="#d9d9d9" required data-xy="1-600: width_box">
                            <option value="개인회원" selected>개인회원</option>
                            <option value="개인 사업자회원">개인 사업자회원</option>
                            <option value="법인 사업자회원">법인 사업자회원</option>
                        </select>
                    </div>
                </div>
                <div id="find_pw_1" class="box display_none width_box">
                    <div class="flex_fl_yc padding_px-t_010 padding_px-u_030">
                        <div class="">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_email"><input
                                    type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_email" name="find_pw" checked>이메일</label>
                        </div>
                        <div class="padding_px-l_015">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_phone"><input
                                    type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_phone" name="find_pw">휴대전화</label>
                        </div>
                    </div>
                    <div id="find_pw_1a" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            이메일로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="position1 flex_xc_yc width_box">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="가입하신 이메일을 입력해주세요" type="email">
                            <div class="position2 width_px_065 height_box " data-top="0%" data-right="0%">
                                <div class="pointer flex_ft_xc_yc width_box height_box font_px_010  border_bre-ry_004 fontstyle1 check"
                                    data-bg-color="#202020" data-color="#ffffff">
                                    <span data-color="#ffffff">인증번호</span>
                                    <span data-color="#ffffff">발송</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex_xc_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="인증번호를 입력해주세요" type="text">
                        </div>
                    </div>
                    <div id="find_pw_1b" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            휴대전화로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="position1 flex_fl_yc width_box">
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <div class="min_width_060 width_px_060 height_px_040">
                                <div class="pointer flex_ft_xc_yc width_box height_box font_px_010 border_bre-a_004 fontstyle1 check"
                                    data-bg-color="#202020" data-color="#ffffff">
                                    <span data-color="#ffffff">인증번호</span>
                                    <span data-color="#ffffff">발송</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex_xc_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="인증번호를 입력해주세요" type="text">
                        </div>
                    </div>
                </div>
                <div id="find_pw_2" class="box display_none width_box">
                    <div class="flex_fl_yc padding_px-t_010 padding_px-u_030">
                        <div class="">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_email_2"><input
                                    type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_email_2" name="find_pw_2" checked>이메일</label>
                        </div>
                        <div class="padding_px-l_015">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_phone_2"><input
                                    type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_phone_2" name="find_pw_2">휴대전화</label>
                        </div>
                    </div>
                    <div id="find_pw_2a" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            이메일로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="position1 flex_xc_yc width_box">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="가입하신 이메일을 입력해주세요" type="email">
                            <div class="position2 width_px_065 height_box " data-top="0%" data-right="0%">
                                <div class="pointer flex_ft_xc_yc width_box height_box font_px_010  border_bre-ry_004 fontstyle1 check"
                                    data-bg-color="#202020" data-color="#ffffff">
                                    <span data-color="#ffffff">인증번호</span>
                                    <span data-color="#ffffff">발송</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex_xc_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="인증번호를 입력해주세요" type="text">
                        </div>
                    </div>
                    <div id="find_pw_2b" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            휴대전화로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="position1 flex_fl_yc width_box">
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <div class="min_width_060 width_px_060 height_px_040">
                                <div class="pointer flex_ft_xc_yc width_box height_box font_px_010 border_bre-a_004 fontstyle1 check"
                                    data-bg-color="#202020" data-color="#ffffff">
                                    <span data-color="#ffffff">인증번호</span>
                                    <span data-color="#ffffff">발송</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex_xc_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="인증번호를 입력해주세요" type="text">
                        </div>
                    </div>
                </div>
                <div id="find_pw_3" class="box display_none width_box">
                    <div class="flex_fl_yc padding_px-t_010 padding_px-u_030">
                        <div class="">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_number_3">
                                <input type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_number_3" name="find_pw_3" checked>법인번호</label>
                        </div>
                        <div class="padding_px-l_015">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_email_3">
                                <input type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_email_3" name="find_pw_3">이메일</label>
                        </div>
                        <div class="padding_px-l_015">
                            <label class="flex_yc font_px_013 padding_px-l_005 pointer" for="find_pw_phone_3">
                                <input type="radio" class="width_px_012 height_px_012 pointer margin_px-r_005"
                                    id="find_pw_phone_3" name="find_pw_3">휴대전화</label>
                        </div>
                    </div>
                    <div id="find_pw_3a" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            법인번호로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class=" flex_xc_yc width_box">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="법인명을 입력해주세요">

                        </div>
                        <div class="flex_fl_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_010"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                        </div>
                    </div>
                    <div id="find_pw_3b" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            이메일로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="position1 flex_xc_yc width_box">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="가입하신 이메일을 입력해주세요" type="email">
                            <div class="position2 width_px_065 height_box " data-top="0%" data-right="0%">
                                <div class="pointer flex_ft_xc_yc width_box height_box font_px_010  border_bre-ry_004 fontstyle1 check"
                                    data-bg-color="#202020" data-color="#ffffff">
                                    <span data-color="#ffffff">인증번호</span>
                                    <span data-color="#ffffff">발송</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex_xc_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="인증번호를 입력해주세요" type="text">
                        </div>
                    </div>
                    <div id="find_pw_3c" class="display_none">
                        <div class="flex_yc width_box font_px_020 flv6 padding_px-u_005">
                            휴대전화로 비밀번호 찾기</div>
                        <div class="padding_px-u_010">
                            <input
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text" placeholder="아이디를 입력해주세요">
                        </div>
                        <div class="position1 flex_fl_yc width_box">
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <input name=""
                                class="width_box height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" type="text">
                            <div class="padding_px-r_005"></div>
                            <div class="min_width_060 width_px_060 height_px_040">
                                <div class="pointer flex_ft_xc_yc width_box height_box font_px_010 border_bre-a_004 fontstyle1 check"
                                    data-bg-color="#202020" data-color="#ffffff">
                                    <span data-color="#ffffff">인증번호</span>
                                    <span data-color="#ffffff">발송</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex_xc_yc width_box margin_px-t_010">
                            <input name=""
                                class="width_px_328 height_px_040 font_px_015 fontstyle1 border_bre-a_004 padding_px-x_015 border_px-a_001"
                                data-bd-a-color="#dbdbdb" placeholder="인증번호를 입력해주세요" type="text">
                        </div>
                    </div>
                </div>
                <div class="width_box flex_xc_yc padding_px-t_050">
                    <input
                        class="width_box border_bre-a_004 check flex_xc_yc height_px_048 font_style_center border_px-a_001 pointer font_px_016"
                        data-bg-color="#202020" data-color="#ffffff" data-bd-a-color="#ffffff" value="비밀번호 찾기"
                        type="submit">
                </div>
            </form>
        </div>
    </div>
</section>
<style>
    input {
        all: unset;
        font-family: fontstyle1;
        background-color: #ffffff;
        box-sizing: border-box;
    }

    ::placeholder {
        font-size: 15px;
        color: #a1a1a1;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
        transition: 0.3s;
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

    input[type="submit"] {
        color: #ffffff;
    }

    .check:hover {
        background-color: #15376b;
    }
</style>
<script nonce="<?php echo NONCE; ?>">
    document.addEventListener('DOMContentLoaded', function () {
        var optionSelect = document.getElementById('findpwselect');
        var boxA = document.getElementById('find_pw_1');
        var boxAEmail = document.getElementById('find_pw_1a');
        var boxAPhone = document.getElementById('find_pw_1b');
        var boxB = document.getElementById('find_pw_2');
        var boxBEmail = document.getElementById('find_pw_2a');
        var boxBPhone = document.getElementById('find_pw_2b');
        var boxC = document.getElementById('find_pw_3');
        var boxCNumber = document.getElementById('find_pw_3a');
        var boxCEmail = document.getElementById('find_pw_3b');
        var boxCPhone = document.getElementById('find_pw_3c');

        // 페이지 로드 시 선택을 초기화
        function initializeSelect() {
            updateVisibilityBasedOnSelection();
        }

        // 선택 상태에 따라 박스와 input 상태 업데이트
        function updateVisibilityBasedOnSelection() {
            var selectedValue = optionSelect.value;

            if (selectedValue === '개인회원') {
                toggleVisibility(boxA, [boxB, boxC]);
                updateInputRequirements(boxA, true);
                updateInputRequirements(boxB, false);
                updateInputRequirements(boxC, false);

                // 이메일/휴대전화 선택에 따른 추가 박스 보이기/숨기기
                var emailRadio = document.getElementById('find_pw_email');
                var phoneRadio = document.getElementById('find_pw_phone');

                emailRadio.addEventListener('change', function () {
                    toggleVisibility(boxAEmail, [boxAPhone]);
                    updateInputRequirements(boxAEmail, true);
                    updateInputRequirements(boxAPhone, false);
                });

                phoneRadio.addEventListener('change', function () {
                    toggleVisibility(boxAPhone, [boxAEmail]);
                    updateInputRequirements(boxAPhone, true);
                    updateInputRequirements(boxAEmail, false);
                });

                // 초기화 시 현재 선택된 옵션에 맞춰 표시 및 required 설정
                if (emailRadio.checked) {
                    toggleVisibility(boxAEmail, [boxAPhone]);
                    updateInputRequirements(boxAEmail, true);
                    updateInputRequirements(boxAPhone, false);
                } else if (phoneRadio.checked) {
                    toggleVisibility(boxAPhone, [boxAEmail]);
                    updateInputRequirements(boxAPhone, true);
                    updateInputRequirements(boxAEmail, false);
                }

            } else if (selectedValue === '개인 사업자회원') {
                toggleVisibility(boxB, [boxA, boxC]);
                updateInputRequirements(boxB, true);
                updateInputRequirements(boxA, false);
                updateInputRequirements(boxC, false);

                // 개인 사업자회원의 이메일/휴대전화 선택에 따른 추가 박스 보이기/숨기기
                var emailRadioB = document.getElementById('find_pw_email_2');
                var phoneRadioB = document.getElementById('find_pw_phone_2');

                emailRadioB.addEventListener('change', function () {
                    toggleVisibility(boxBEmail, [boxBPhone]);
                    updateInputRequirements(boxBEmail, true);
                    updateInputRequirements(boxBPhone, false);
                });

                phoneRadioB.addEventListener('change', function () {
                    toggleVisibility(boxBPhone, [boxBEmail]);
                    updateInputRequirements(boxBPhone, true);
                    updateInputRequirements(boxBEmail, false);
                });

                // 초기화 시 현재 선택된 옵션에 맞춰 표시 및 required 설정
                if (emailRadioB.checked) {
                    toggleVisibility(boxBEmail, [boxBPhone]);
                    updateInputRequirements(boxBEmail, true);
                    updateInputRequirements(boxBPhone, false);
                } else if (phoneRadioB.checked) {
                    toggleVisibility(boxBPhone, [boxBEmail]);
                    updateInputRequirements(boxBPhone, true);
                    updateInputRequirements(boxBEmail, false);
                }

            } else if (selectedValue === '법인 사업자회원') {
                toggleVisibility(boxC, [boxA, boxB]);
                updateInputRequirements(boxC, true);
                updateInputRequirements(boxA, false);
                updateInputRequirements(boxB, false);

                // 법인 사업자회원의 법인번호/이메일/휴대전화 선택에 따른 추가 박스 보이기/숨기기
                var numberRadioC = document.getElementById('find_pw_number_3');
                var emailRadioC = document.getElementById('find_pw_email_3');
                var phoneRadioC = document.getElementById('find_pw_phone_3');

                numberRadioC.addEventListener('change', function () {
                    toggleVisibility(boxCNumber, [boxCEmail, boxCPhone]);
                    updateInputRequirements(boxCNumber, true);
                    updateInputRequirements(boxCEmail, false);
                    updateInputRequirements(boxCPhone, false);
                });

                emailRadioC.addEventListener('change', function () {
                    toggleVisibility(boxCEmail, [boxCNumber, boxCPhone]);
                    updateInputRequirements(boxCEmail, true);
                    updateInputRequirements(boxCNumber, false);
                    updateInputRequirements(boxCPhone, false);
                });

                phoneRadioC.addEventListener('change', function () {
                    toggleVisibility(boxCPhone, [boxCNumber, boxCEmail]);
                    updateInputRequirements(boxCPhone, true);
                    updateInputRequirements(boxCNumber, false);
                    updateInputRequirements(boxCEmail, false);
                });

                // 초기화 시 현재 선택된 옵션에 맞춰 표시 및 required 설정
                if (numberRadioC.checked) {
                    toggleVisibility(boxCNumber, [boxCEmail, boxCPhone]);
                    updateInputRequirements(boxCNumber, true);
                    updateInputRequirements(boxCEmail, false);
                    updateInputRequirements(boxCPhone, false);
                } else if (emailRadioC.checked) {
                    toggleVisibility(boxCEmail, [boxCNumber, boxCPhone]);
                    updateInputRequirements(boxCEmail, true);
                    updateInputRequirements(boxCNumber, false);
                    updateInputRequirements(boxCPhone, false);
                } else if (phoneRadioC.checked) {
                    toggleVisibility(boxCPhone, [boxCNumber, boxCEmail]);
                    updateInputRequirements(boxCPhone, true);
                    updateInputRequirements(boxCNumber, false);
                    updateInputRequirements(boxCEmail, false);
                }

            } else {
                boxA.classList.add('display_none');
                boxB.classList.add('display_none');
                boxC.classList.add('display_none');
                removeAllRequired();
            }
        }

        function toggleVisibility(showBox, hideBoxes) {
            if (showBox) {
                showBox.classList.remove('display_none');
            }
            hideBoxes.forEach(function (box) {
                if (box) {
                    box.classList.add('display_none');
                }
            });
        }

        function updateInputRequirements(box, required) {
            if (box) {
                var inputs = box.querySelectorAll('input');
                inputs.forEach(function (input) {
                    if (required) {
                        input.setAttribute('required', 'true');
                    } else {
                        input.removeAttribute('required');
                    }
                });
            }
        }

        function removeAllRequired() {
            var allInputs = document.querySelectorAll('#find_pw_1 input, #find_pw_1a input, #find_pw_1b input, #find_pw_2 input, #find_pw_2a input, #find_pw_2b input, #find_pw_3 input, #find_pw_3a input, #find_pw_3b input, #find_pw_3c input');
            allInputs.forEach(function (input) {
                input.removeAttribute('required');
            });
        }

        initializeSelect();

        optionSelect.addEventListener('change', updateVisibilityBasedOnSelection);

        window.addEventListener('pageshow', function (event) {
            initializeSelect();
        });
    });

</script>