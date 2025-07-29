<form action="">
    <section class="position1 width_box border_px-u_001" data-bd-a-color="#dddddd">
        <div class="width_px_1220 height_px_080 margin_x_auto padding_px-a_010" data-top="0%"
            data-xy="1-1220: width_box">
            <div class="flex_xs1_yc" data-color="#2F3438">
                <div class="flex_fl_yc font_px_018 flv6">
                    <div class="font_px_025 pointer">
                        <a href="<?php echo DOMAIN; ?>"><img class="width_px_160 height_px_060"
                                src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>"></a>
                    </div>
                </div>
                <div class="flex_fr_yc font_px_014">
                    <div class="padding_px-x_040 flex_xc_yc height_px_040 border_bre-a_004 pointer buttonselect"
                        data-bg-color="#15376b" data-color="#ffffff">
                        올리기
                    </div>
                    <div class="padding_px-x_040 flex_xc_yc height_px_040 border_bre-a_004 pointer"
                        data-bg-color="#eaedef" data-color="#c2c8cc">
                        올리기
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box border_px-u_001" data-bd-a-color="#dddddd">
        <div class="flex_xc width_px_1220 height_px_050 margin_x_auto font_px_015">
            <div class="flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer choicemenu selectmenu choicepicture"
                data-color="#888888" data-bd-a-color="transparent">인스타</div>
            <div class="flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer choicemenu youtubechoicevideo"
                data-color="#888888" data-bd-a-color="transparent">유튜브</div>
            <div class="flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer choicemenu shortchoicevideo"
                data-color="#888888" data-bd-a-color="transparent">숏츠</div>
            <a class="flex_yc border_px-u_002 padding_px-x_003 pointer choicemenu" data-bd-a-color="transparent"
                href="<?php echo DOMAIN . '/page/manual_write' ?>">
                <span data-color="#888888">셀프 정비 후기</span>
            </a>
        </div>
    </section>
    <style>
        .buttonselect:hover {
            background-color: #09addb;
        }

        .choicemenu:hover {
            color: #000000;
        }

        .selectmenu {
            font-weight: 600;
            color: #000000;
            border-color: #000000;
        }
    </style>
    <section class="position1 width_box padding_px-t_030 picture">
        <div class="position1 width_px_1000 margin_x_auto">
            <div class="position2 display_none width_px_150" data-top="0%" data-left="-10%">
                <div class="border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer">
                    <img class="width_px_060 height_px_060"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/example/example.webp'; ?>"
                        style="object-fit: cover;">
                </div>
                <div class="border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer">
                    <img class="width_px_060 height_px_060"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/example/example.webp'; ?>"
                        style="object-fit: cover;">
                </div>
                <div class="flex_xc_yc font_px_022 border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer dashborder"
                    data-color="#828c94" data-bg-color="#f7f9fa">
                    &plus;
                </div>

            </div>
            <div class="flex_xs1 padding_px-r_010 ">
                <div class="width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005" data-bg-color="#f7f9fa"
                    data-color="#888888">
                    <img class="width_px_025 height_px_025"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                    <div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">사진을 끌어다 놓으세요</div>
                    <div class="font_px_014 padding_px-u_010">10장까지 올릴 수 있어요.</div>
                    <div class="border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice"
                        data-bg-color="#15376b" data-color="#ffffff">PC에서 불러오기</div>
                </div>
                <div class="flex_ft width_px_540">
                    <textarea
                        class="autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden"
                        placeholder="어떤 사진인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요" data-color="#000000"
                        data-bd-a-color="#c2c8cc"></textarea>
                    <div class="padding_px-t_015">
                        <select
                            class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014"
                            data-color="#000000" data-bd-a-color="#c2c8cc">
                            <option value="공간정보추가" disabled selected hidden>공간정보추가</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .dashborder {
            border: 1px dashed #e6e6e6;
        }

        .filechoice:hover {
            background-color: #09addb;
        }

        ::placeholder {
            color: #c2c8cc;
        }
    </style>
    <script nonce="<?php echo NONCE; ?>">
        document.addEventListener('DOMContentLoaded', function () {
            var textareas = document.querySelectorAll('.autoexpand');
            textareas.forEach(function (textarea) {
                textarea.addEventListener('input', function () {
                    this.style.height = 'auto';  // 높이 초기화
                    this.style.height = this.scrollHeight + 'px';  // 내용에 맞게 높이 조정
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var selectBoxes = document.querySelectorAll('select'); // 모든 select 요소 선택

            selectBoxes.forEach(function (selectBox) {
                // 기본 선택된 옵션이 있을 경우 색상을 강제로 회색으로 적용
                var selectedOption = selectBox.options[selectBox.selectedIndex];
                if (selectedOption.hasAttribute('disabled')) {
                    selectBox.style.color = '#888888'; // 셀렉트 박스의 텍스트 색상 회색으로 설정
                }

                // 선택이 변경될 때마다 색상 변경
                selectBox.addEventListener('change', function () {
                    selectBox.style.color = '#000000'; // 기본 색상 검정
                });
            });
        });
    </script>
    <section class="position1 width_box padding_px-t_030 youtubevideo display_none">
        <div class="position1 width_px_1000 margin_x_auto">
            <div class="position2 display_none width_px_150" data-top="0%" data-left="-10%">
                <div class="border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer">
                    <img class="width_px_060 height_px_060"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/example/example.webp'; ?>"
                        style="object-fit: cover;">
                </div>
                <div class="border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer">
                    <img class="width_px_060 height_px_060"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/example/example.webp'; ?>"
                        style="object-fit: cover;">
                </div>
                <div class="flex_xc_yc font_px_022 border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer dashborder"
                    data-color="#828c94" data-bg-color="#f7f9fa">
                    &plus;
                </div>

            </div>
            <div class="flex_xs1 padding_px-r_010 ">
                <div class="width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005" data-bg-color="#f7f9fa"
                    data-color="#888888">
                    <img class="width_px_025 height_px_025"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                    <div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">동영상을 끌어다 놓으세요</div>
                    <div class="font_px_014 padding_px-u_010">5GB 미만, 3~60초의 세로 영상이 좋아요.</div>
                    <div class="border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice"
                        data-bg-color="#15376b" data-color="#ffffff">PC에서 불러오기</div>
                </div>
                <div class="flex_ft width_px_540">
                    <textarea
                        class="autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden"
                        placeholder="어떤 동영상인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요" data-color="#000000"
                        data-bd-a-color="#c2c8cc"></textarea>
                    <div class="padding_px-t_015">
                        <select
                            class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014"
                            data-color="#000000" data-bd-a-color="#c2c8cc">
                            <option value="공간정보추가" disabled selected hidden>공간정보추가</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box padding_px-t_030 shortvideo display_none">
        <div class="position1 width_px_1000 margin_x_auto">
            <div class="position2 display_none width_px_150" data-top="0%" data-left="-10%">
                <div class="border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer">
                    <img class="width_px_060 height_px_060"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/example/example.webp'; ?>"
                        style="object-fit: cover;">
                </div>
                <div class="border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer">
                    <img class="width_px_060 height_px_060"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/example/example.webp'; ?>"
                        style="object-fit: cover;">
                </div>
                <div class="flex_xc_yc font_px_022 border_bre-a_005 overflow_hidden width_px_060 height_px_060 margin_px-u_010 pointer dashborder"
                    data-color="#828c94" data-bg-color="#f7f9fa">
                    &plus;
                </div>

            </div>
            <div class="flex_xs1 padding_px-r_010 ">
                <div class="width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005" data-bg-color="#f7f9fa"
                    data-color="#888888">
                    <img class="width_px_025 height_px_025"
                        src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                    <div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">동영상을 끌어다 놓으세요</div>
                    <div class="font_px_014 padding_px-u_010">5GB 미만, 3~60초의 세로 영상이 좋아요.</div>
                    <div class="border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice"
                        data-bg-color="#15376b" data-color="#ffffff">PC에서 불러오기</div>
                </div>
                <div class="flex_ft width_px_540">
                    <textarea
                        class="autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden"
                        placeholder="어떤 동영상인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요" data-color="#000000"
                        data-bd-a-color="#c2c8cc"></textarea>
                    <div class="padding_px-t_015">
                        <select
                            class="width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014"
                            data-color="#000000" data-bd-a-color="#c2c8cc">
                            <option value="공간정보추가" disabled selected hidden>공간정보추가</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        textarea {
            resize: none;
            outline: none;
        }

        select {
            outline: none;
        }

        select option {
            color: #888888;
        }

        select option[disabled] {
            color: #888888;
        }
    </style>
    <script nonce="<?php echo NONCE; ?>">
        const choiceMenus = document.querySelectorAll('.choicemenu');

        choiceMenus.forEach(menu => {
            menu.addEventListener('click', () => {
                // 모든 메뉴에서 selectmenu 클래스 제거
                choiceMenus.forEach(m => m.classList.remove('selectmenu'));

                // 클릭된 메뉴에만 selectmenu 클래스 추가
                menu.classList.add('selectmenu');
            });
        });

        const choicePicture = document.querySelector('.choicepicture');
        const choiceVideo = document.querySelector('.youtubechoicevideo');
        const shortChoiceVideo = document.querySelector('.shortchoicevideo');
        const picture = document.querySelector('.picture');
        const youtubeVideo = document.querySelector('.youtubevideo');  // youtubeChoiceVideo 대신 youtubeVideo로 이름 변경
        const shortVideo = document.querySelector('.shortvideo');

        // 선택된 미디어만 보이도록 처리하는 함수
        function showOnlySelected(selectedElement) {
            // 모든 요소를 숨김
            picture.classList.add('display_none');
            youtubeVideo.classList.add('display_none');  // youtubeChoiceVideo 대신 youtubeVideo로 변경
            shortVideo.classList.add('display_none');

            // 선택된 요소만 보이도록 처리
            selectedElement.classList.remove('display_none');
        }

        choicePicture.addEventListener('click', () => {
            showOnlySelected(picture);  // picture만 보이도록
        });

        choiceVideo.addEventListener('click', () => {
            showOnlySelected(youtubeVideo);  // youtube video만 보이도록
        });

        shortChoiceVideo.addEventListener('click', () => {
            showOnlySelected(shortVideo);  // short video만 보이도록
        });

    </script>
</form>