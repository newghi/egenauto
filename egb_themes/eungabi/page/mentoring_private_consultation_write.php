<?php jquery(); ?>
<form class="position1" action="mentoring_private_consultation_form" method="POST">
    <section class="position3 width_box height_px_080 border_px-u_001 z-index_2"
        data-bg-color="#ffffff" data-bd-a-color="#dddddd" data-top="0">
        <div class="width_px_1220 height_px_080 margin_x_auto padding_px-a_010 el_c" data-xy="1-1220: width_box">
            <div class="flex_xs1_yc" data-color="#2F3438">
                <div class="flex_fl_yc font_px_018 flv6">
                    <div class="font_px_025 pointer">
                        <a href="<?php echo DOMAIN; ?>"><img class="width_px_160 height_px_060"
                                src="<?php echo DOMAIN . THEMES_PATH . '/img/logo.svg' ?>"></a>
                    </div>
                </div>
                <div id="manual_write_header" class="flex_fr_yc font_px_014" style="white-space: nowrap;">
                    <div id="mentoring_private_consultation_submit_button"
                        class="padding_px-x_040 flex_xc_yc height_px_040 border_bre-a_004 pointer buttonselect"
                        data-bg-color="#15376b" data-color="#ffffff">
                        올리기
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="width_box height_px_080"></div>
    <section class="position1 width_box display_none">
        <div class="width_px_800 margin_x_auto padding_px-t_020" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="flex_ft_xc_yc border_bre-a_005 width_box min_height_500 height_box font_px_016 font_style_center"
                    data-bg-color="#e5e5e5" data-xy="1-800: font_px_013 min_height_200">
                    <div class="flex_ft_xc_yc mentoring_private_consultation_img_box width_box min_height_500 border_bre-a_005 overflow_hidden"
                        data-xy="1-800: min_height_200">
                        <input type="file" name="images[]" multiple accept="image/*" class="img_files display_none">
                        <img class="mentoring_private_consultation_img width_px_025 height_px_025 "
                            src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                        <div class="padding_px-t_010">
                            <div class="mentoring_private_consultation_contents_img_upload_button filechoice border_bre-a_005 padding_px-y_015 padding_px-x_025 flv6 pointer"
                                data-bg-color="#15376b" data-color="#ffffff">썸네일 이미지 등록</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box">
        <div class="width_px_800 margin_x_auto padding_px-t_020" data-xy="1-800: width_box">
            <div class="padding_px-x_000" data-xy="1-800: padding_px-x_020">
                <div class="mentoring_private_consultation_content border_bre-a_005 width_box height_px_500 flex_ft_yc font_px_016"
                    data-bg-color="#ffffff">
                    <div class="position1 width_box flex_ft_yc font_px_018 flv6 border_px-u_001 budget2"
                        data-bd-a-color="#dddddd">
                        <input type="text" name="titles[]"
                            class="mentoring_private_consultation_content_title padding_px-x_025 padding_px-y_015 font_px_025 flv6 width_box nothover"
                            maxlength="80" placeholder="제목을 입력해주세요." data-color="#000000" data-xy="1-800: font_px_018">
                    </div>
                    <div class="width_box flex_ft_yc font_px_018 flv6 padding_px-t_015">
                        <div id="egbeditor2" class="mentoring_private_consultation_content_content padding_px-x_025 padding_px-y_015 width_box"
                            name="contents[]"></div>
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

<script nonce="<?php echo NONCE; ?>">
    document.addEventListener("DOMContentLoaded", function () {
        function setUpUploadButton(uploadButton) {
            if (uploadButton.dataset.initialized) {
                return;
            }
            uploadButton.dataset.initialized = true;

            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.accept = "image/*";

            uploadButton.addEventListener("click", function () {
                fileInput.click();
            });

            fileInput.addEventListener("change", function (event) {
                const file = event.target.files[0];
                if (file) {
                    uploadButton.fileInput = fileInput;
                    handleFileUpload(file, uploadButton, !uploadButton.file && !uploadButton.dataset.replaced && !uploadButton.dataset.dragged);
                }
            });

            setUpDragAndDrop(uploadButton.closest(".mentoring_private_consultation_img_box"), uploadButton);

            const imgElement = uploadButton.closest(".mentoring_private_consultation_img_box").querySelector(".mentoring_private_consultation_img");
            imgElement.onclick = function () {
                uploadButton.click();
            };
        }

        function handleFileUpload(file, uploadButton, isNewUpload) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgBox = uploadButton.closest(".mentoring_private_consultation_img_box");
                imgBox.classList.remove("height_px_420");
                const dataUrl = e.target.result;
                const imgElement = imgBox.querySelector(".mentoring_private_consultation_img");
                imgElement.src = dataUrl;
                imgElement.style.width = "100%";
                imgElement.style.height = "auto";

                imgElement.onclick = function () {
                    uploadButton.click();
                };

                Array.from(imgBox.children).forEach(child => {
                    if (!child.classList.contains("mentoring_private_consultation_img")) {
                        child.style.display = "none";
                    }
                });

                uploadButton.file = file;

            };
            reader.readAsDataURL(file);
        }

        function setUpDragAndDrop(dropArea, uploadButton) {
            if (dropArea.dataset.initialized) {
                return;
            }
            dropArea.dataset.initialized = true;

            dropArea.addEventListener("dragenter", (e) => {
                e.preventDefault();
                dropArea.classList.add("drag-over");
            });

            dropArea.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropArea.classList.add("drag-over");
            });

            dropArea.addEventListener("dragleave", (e) => {
                e.preventDefault();
                dropArea.classList.remove("drag-over");
            });

            dropArea.addEventListener("drop", (e) => {
                e.preventDefault();
                dropArea.classList.remove("drag-over");
                const file = e.dataTransfer.files[0];
                if (file) {
                    if (!uploadButton.dataset.dragged) {
                        uploadButton.dataset.dragged = true;
                        handleFileUpload(file, uploadButton, !uploadButton.file && !uploadButton.dataset.replaced);
                        delete uploadButton.dataset.dragged;
                    }
                }
            });
        }

        const uploadButton = document.querySelector(".mentoring_private_consultation_contents_img_upload_button");
        setUpUploadButton(uploadButton);

        function validateField(input, message) {
            if (!input || !input.value) {
                alert(message);
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                input.focus();
                return false;
            }
            return true;
        }

        function sanitizeContent(content) {
            // contenteditable="true" 제거
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = content;
            tempDiv.querySelectorAll('[contenteditable="true"]').forEach(el => el.removeAttribute('contenteditable'));
            return tempDiv.innerHTML;
        }
		
        document.getElementById("mentoring_private_consultation_submit_button").addEventListener("click", function () {

            const firstTitleInput = document.querySelector('.mentoring_private_consultation_content_title[name="titles[]"]');
            const firstContentInput = document.querySelector('.mentoring_private_consultation_content_content[name="contents[]"]');
            const uploadButton = document.querySelector(".mentoring_private_consultation_contents_img_upload_button");
            const firstFile = uploadButton.file;

/*             // 이미지, 제목, 내용 유효성 검사
            if (!firstFile) {
                alert("기본 이미지를 업로드해주세요.");
                return;
            } */
            if (!validateField(firstTitleInput, "기본 제목을 입력해주세요.")) return;
            // div에서 콘텐츠를 가져와 유효성 검사 수행
           const firstContentValue = sanitizeContent(firstContentInput.innerHTML.trim());
            if (!firstContentValue) {
                alert("기본 내용을 입력해주세요.");
                return;
            }



            const formData = new FormData();
            formData.append('titles', firstTitleInput.value);
            formData.append('contents', firstContentValue);
            formData.append('images', firstFile);

            $.ajax({
                url: '<?php echo DOMAIN . '/?post=mentoring_private_consultation_form_input'; ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    console.log('서버 응답:', response);

                    if (response.success) {
                        alert('성공적으로 업로드되었습니다.');
						window.location.href = response.url;
                    } else {
                        var errorMessage = '';
                        switch (response.errorCode) {
                            case 101:
                                errorMessage = '제목이 누락되었습니다. 제목을 입력해주세요.';
                                break;
                            case 102:
                                errorMessage = '내용이 누락되었습니다. 내용을 입력해주세요.';
                                break;
                            case 103:
                                errorMessage = '이미지가 누락되었습니다. 이미지를 업로드해주세요.';
                                break;
                            case 4:
                                errorMessage = '허용되지 않은 파일 형식입니다. 지원되는 파일 형식: jpg, jpeg, png, gif';
                                break;
                            case 5:
                                errorMessage = '파일 크기가 너무 큽니다. 최대 허용 크기는 5MB입니다.';
                                break;
                            case 6:
                                errorMessage = '이미지를 서버에 저장하는 중 오류가 발생했습니다.';
                                break;
                            case 7:
                                errorMessage = '이미지를 데이터베이스에 등록하는 중 오류가 발생했습니다.';
                                break;
                            case 8:
                                errorMessage = '게시물 데이터를 데이터베이스에 저장하는 중 오류가 발생했습니다.';
                                break;
                            case 9:
                                errorMessage = '멘티에게 알림을 전송 하지 못했습니다.';
                                break;
                            case 10:
                                errorMessage = '멘토에게 알림을 전송 하지 못했습니다.';
                                break;
                            default:
                                errorMessage = '알 수 없는 오류가 발생했습니다. 다시 시도해주세요.';
                        }
                        alert('업로드 실패: ' + errorMessage);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('AJAX 요청 실패:', xhr, status, error);
                    alert('서버와의 통신 중 오류가 발생했습니다.');
                }
            });
        });
    });
</script>
<?php
$domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$themes_path = 'egb_themes/eungabi';
$background_url = $domain . '/' . $themes_path . '/img/icon/check.svg';
?>
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

    .drag-over {
        background-color: #d0e6f7;
        /* 밝은 블루 색상으로 드래그 가능 상태를 강조 */
        border: 2px dashed #0275d8;
        /* 테두리를 점선으로 표시하여 드래그 대상임을 나타냄 */
        transition: background-color 0.3s ease-in-out, border 0.3s ease-in-out;
        /* 부드러운 전환 효과 추가 */
    }

    .instargram_img_box.drag-over {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
        /* 파란색 그림자로 드래그 가능 영역 강조 */
        transform: scale(1.05);
        /* 약간 확대하여 사용자가 드래그 중임을 강조 */
    }
</style>
<style>
    .rotate {
        transform: rotate(180deg);
        transition: 0.5s;
    }

    .rotate.reverse {
        transform: rotate(0deg);
        /* 반대 방향 회전 */
    }

    .guidebox {
        max-height: 9999px;
        /* 처음에 보이도록 */
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
        /* 만 원이 보일 공간을 만듦 */
    }

    .budget:after {
        content: '만 원';
        /* "만 원"을 input 필드 끝에 추가 */
        position: absolute;
        right: 10px;
        /* input 끝에서 조금 띄워서 위치 설정 */
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #888888;
        pointer-events: none;
        /* "만 원" 텍스트가 선택되지 않도록 설정 */
    }

    :root {
        --char-count: '0 / 80';
        /* 초기 값 설정 */
    }

</style>