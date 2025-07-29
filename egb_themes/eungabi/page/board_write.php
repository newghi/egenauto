
<?php 
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1) {
    $admin_crm = 1;
} else if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    $admin_crm = 0;
} else {
    echo "<script nonce=".NONCE." type='text/javascript'>window.location.href='". DOMAIN."/page/login'; </script>";
    exit;
}
?>
<div>
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
                    <div id="instagram_submit_button" 
                        class="padding_px-x_040 flex_xc_yc height_px_040 border_bre-a_004 pointer"
                        data-bg-color="#15376b" 
                        data-hover-bg-color="#09addb"
                        data-color="#ffffff">
                        올리기
                    </div>
                    <form id="instagram_form_input" 
                        action="<?php echo DOMAIN. '/?post=instagram_form_input'; ?>" method="post"
                        enctype="multipart/form-data">
                    </form>
                    <div id="youtube_submit_button" 
                        class="display_none padding_px-x_040 height_px_040 border_bre-a_004 pointer "
                        data-bg-color="#15376b" 
                        data-hover-bg-color="#09addb"
                        data-color="#ffffff">
                        올리기
                    </div>
                    <form id="youtube_form_input"
                        action="<?php echo DOMAIN. '/?post=youtube_form_input'; ?>" method="post"
                        enctype="multipart/form-data">
                    </form>

                    <div id="shorts_submit_button"
                        class="display_none padding_px-x_040 height_px_040 border_bre-a_004 pointer"
                        data-bg-color="#15376b" 
                        data-hover-bg-color="#09addb"
                        data-color="#ffffff">
                        올리기
                    </div>
                    <form id="shorts_form_input"
                        action="<?php echo DOMAIN. '/?post=shorts_form_input'; ?>" method="post"
                        enctype="multipart/form-data">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="position1 width_box border_px-u_001" data-bd-a-color="#dddddd">
        <div class="flex_xc width_px_1220 height_px_050 margin_x_auto font_px_015" data-xy="1-1220: width_box">
            <div class="egb_radio_menu flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer egb_menu_active"
                data-color="#888888"
                data-hover-color="#000000" 
                data-bd-a-color="transparent"
                data-radio-target-add-1="#instagram_submit_button, flex_xc_yc"
                data-radio-target-add-2="#youtube_submit_button, display_none"
                data-radio-target-add-3="#shorts_submit_button, display_none"
                data-radio-target-add-4="#instagram_form_section, flex_xc_yc"
                data-radio-target-add-5="#youtube_form_section, display_none"
                data-radio-target-add-6="#shorts_form_section, display_none">인스타</div>
            <div class="egb_radio_menu flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer"
                data-color="#888888"
                data-hover-color="#000000"
                data-bd-a-color="transparent"
                data-radio-target-add-1="#instagram_submit_button, display_none"
                data-radio-target-add-2="#youtube_submit_button, flex_xc_yc"
                data-radio-target-add-3="#shorts_submit_button, display_none"
                data-radio-target-add-4="#instagram_form_section, display_none"
                data-radio-target-add-5="#youtube_form_section, flex_xc_yc"
                data-radio-target-add-6="#shorts_form_section, display_none">유튜브</div>
            <div class="egb_radio_menu flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer"
                data-color="#888888"
                data-hover-color="#000000"
                data-bd-a-color="transparent"
                data-radio-target-add-1="#instagram_submit_button, display_none"
                data-radio-target-add-2="#youtube_submit_button, display_none"
                data-radio-target-add-3="#shorts_submit_button, flex_xc_yc"
                data-radio-target-add-4="#instagram_form_section, display_none"
                data-radio-target-add-5="#youtube_form_section, display_none"
                data-radio-target-add-6="#shorts_form_section, flex_xc_yc">숏츠</div>
            <a href="<?php echo DOMAIN . '/page/blog_board_write' ?>" class="egb_radio_menu flex_yc border_px-u_002 padding_px-x_003 margin_px-r_015 pointer"
                data-color="#888888"
                data-hover-color="#000000"
                data-bd-a-color="transparent">블로그</a>
			<?php
			if (isset($admin_crm) && $admin_crm == 1) {
			?>
            <a class="egb_radio_menu flex_yc border_px-u_002 padding_px-x_003 pointer" data-bd-a-color="transparent"
                href="<?php echo DOMAIN . '/page/manual_write' ?>">
                <span data-color="#888888">셀프 정비 매뉴얼</span>
            </a>
			<?php
			}
			?>
        </div>
    </section>
    <section id="instagram_form_section" class="position1 width_box padding_px-t_030">
        <div class="position1 width_px_1000 margin_x_auto" data-xy="1-1000: width_box">
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
            <div data-bg-color="#15376b" data-color="#ffffff"></div>
            <div data-bg-color="#f7f9fa" data-color="#888888"></div>
            <div data-bd-a-color="#c2c8cc" data-color="#000000"></div>
            <form id="instagram_form">
				<div class="instagram_contents flex_xs1 padding_px-u_030" data-xy="1-1000: flex_ft_yc">
					<div class="width_px_440 padding_px-a_000"
						data-xy="1-460: width_box padding_px-a_010, 461-1000: width_px_440 padding_px-a_010">
						<div class="instagram_img_box width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005 bg-color-f7f9fa color-888888" data-xy="1-440: width_box">
							<input type="file" name="image[]" multiple accept="image/*" class="img_files display_none">
							<img class="instagram_img width_px_025 height_px_025"
								src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
							<div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">사진을 끌어다 놓으세요</div>
							<div class="font_px_014 padding_px-u_010">10장까지 올릴 수 있어요.</div>
							<div class="instagram_contents_img_upload_button border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice bg-color-15376b color-ffffff">PC에서 불러오기</div>
						</div>
					</div>
					<div class="instagram_content width_px_540 padding_px-a_000"
						data-xy="1-560: width_box padding_px-a_010, 561-1000: width_px_540 padding_px-a_010">
						<div class="flex_ft width_px_540" data-xy="1-560: width_box">
							<div class="padding_px-u_015">
								<input type="text" placeholder="제목을 입력 해주세요." name="title[]"
									class="instagram_content_title width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014 color-000000 bd-a-color-c2c8cc">
							</div>
							<textarea name="content[]"
								class="instagram_content_content autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden color-000000 bd-a-color-c2c8cc"
								placeholder="어떤 사진인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요"></textarea>
						</div>
						<div class="flex_xc_yc padding_px-t_010">
							<button type="button" class="delete_content_btn border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 bg-color-ff0000 color-ffffff">삭제</button>
							<button type="button" class="move_up_btn border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 margin_px-x_005 bg-color-15376b color-ffffff">위로</button>
							<button type="button" class="move_down_btn border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 bg-color-15376b color-ffffff">아래로</button>
						</div>
					</div>
                </div>
            </form>
            <script nonce="<?php echo NONCE; ?>">
            document.addEventListener("DOMContentLoaded", function() {
                function setUpUploadButton(uploadButton) {
                    if (uploadButton.dataset.initialized) {
                        return;
                    }
                    uploadButton.dataset.initialized = true;
                
                    const fileInput = document.createElement("input");
                    fileInput.type = "file";
                    fileInput.accept = "image/*";
                
                    uploadButton.addEventListener("click", function() {
                        fileInput.click();
                    });
                
                    fileInput.addEventListener("change", function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            uploadButton.fileInput = fileInput;
                            handleFileUpload(file, uploadButton, true);
                        }
                    });
                
                    setUpDragAndDrop(uploadButton.closest(".instagram_img_box"), uploadButton);
                
                    const imgElement = uploadButton.closest(".instagram_img_box").querySelector(".instagram_img");
                    imgElement.onclick = function() {
                        uploadButton.click();
                    };
                }
            
                function handleFileUpload(file, uploadButton, isNewUpload) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgBox = uploadButton.closest(".instagram_img_box");
                        imgBox.classList.remove("height_px_420");
                        const dataUrl = e.target.result;
                        const imgElement = imgBox.querySelector(".instagram_img");
                        imgElement.src = dataUrl;
                        imgElement.style.width = "100%";
                        imgElement.style.height = "auto";
                    
                        imgElement.onclick = function() {
                            uploadButton.click();
                        };
                    
                        Array.from(imgBox.children).forEach(child => {
                            if (!child.classList.contains("instagram_img")) {
                                child.style.display = "none";
                            }
                        });
                    
                        uploadButton.file = file;
                    
                        if (isNewUpload) {
                            const form = document.querySelector("#instagram_form");
                            if (form.children.length < 10) {
                                const newContent = document.createElement("div");
                                newContent.className = "instagram_contents flex_xs1 padding_px-u_030";
                                newContent.dataset.xy = "1-1000: flex_ft_yc";
                                newContent.innerHTML = `
            					<div class="width_px_440 padding_px-a_000"
            						data-xy="1-460: width_box padding_px-a_010, 461-1000: width_px_440 padding_px-a_010">
            						<div class="instagram_img_box width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005 bg-color-f7f9fa color-888888" data-xy="1-440: width_box">
            							<input type="file" name="image[]" multiple accept="image/*" class="img_files display_none">
            							<img class="instagram_img width_px_025 height_px_025"
            								src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
            							<div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">사진을 끌어다 놓으세요</div>
            							<div class="font_px_014 padding_px-u_010">10장까지 올릴 수 있어요.</div>
            							<div class="instagram_contents_img_upload_button border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice bg-color-15376b color-ffffff">PC에서 불러오기</div>
            						</div>
            					</div>
            					<div class="instagram_content width_px_540 padding_px-a_000"
            						data-xy="1-560: width_box padding_px-a_010, 561-1000: width_px_540 padding_px-a_010">
            						<div class="flex_ft width_px_540" data-xy="1-560: width_box">
            							<div class="padding_px-u_015">
            								<input type="text" placeholder="제목을 입력 해주세요." name="title[]"
            									class="instagram_content_title width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014 color-000000 bd-a-color-c2c8cc">
            							</div>
            							<textarea name="content[]"
            								class="instagram_content_content autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden color-000000 bd-a-color-c2c8cc"
            								placeholder="어떤 사진인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요"></textarea>
            						</div>
            						<div class="flex_xc_yc padding_px-t_010">
            							<button type="button" class="delete_content_btn border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 bg-color-ff0000 color-ffffff">삭제</button>
            							<button type="button" class="move_up_btn border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 margin_px-x_005 bg-color-15376b color-ffffff">위로</button>
            							<button type="button" class="move_down_btn border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 bg-color-15376b color-ffffff">아래로</button>
            						</div>
            					</div>
                                `;
                                form.appendChild(newContent);
                                const newUploadButton = newContent.querySelector(".instagram_contents_img_upload_button");
                                setUpUploadButton(newUploadButton);
                                setUpDeleteButton(newContent.querySelector(".delete_content_btn"));
                                setUpMoveButtons(newContent);
                            }
                        }
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
                            handleFileUpload(file, uploadButton, true);
                        }
                    });
                }
            
                function setUpDeleteButton(deleteButton) {
                    deleteButton.addEventListener("click", function() {
                        const contentSection = this.closest(".instagram_contents");
                        if (document.querySelectorAll(".instagram_contents").length > 1) {
                            contentSection.remove();
                        } else {
                            alert("최소 1개의 컨텐츠는 유지해야 합니다.");
                        }
                    });
                }
            
                function setUpMoveButtons(contentSection) {
                    const upButton = contentSection.querySelector(".move_up_btn");
                    const downButton = contentSection.querySelector(".move_down_btn");
                
                    upButton.addEventListener("click", function() {
                        const currentContent = this.closest(".instagram_contents");
                        const prevContent = currentContent.previousElementSibling;

                        // 현재 컨텐츠가 비어있는지 확인
                        const currentUploadButton = currentContent.querySelector(".instagram_contents_img_upload_button");
                        const currentFile = currentUploadButton ? currentUploadButton.file : null;
                        const currentTitle = currentContent.querySelector('.instagram_content_title').value.trim();
                        const currentContentText = currentContent.querySelector('.instagram_content_content').value.trim();

                        if (!currentFile || !currentTitle || !currentContentText) {
                            alert("이미지, 제목, 내용을 모두 입력해야 이동할 수 있습니다.");
                            return;
                        }
                    
                        if (prevContent) {
                            // 이전 컨텐츠가 비어있는지 확인
                            const prevUploadButton = prevContent.querySelector(".instagram_contents_img_upload_button");
                            const prevFile = prevUploadButton ? prevUploadButton.file : null;
                            const prevTitle = prevContent.querySelector('.instagram_content_title').value.trim();
                            const prevContentText = prevContent.querySelector('.instagram_content_content').value.trim();
                        
                            if (!prevFile || !prevTitle || !prevContentText) {
                                alert("이전 컨텐츠의 이미지, 제목, 내용을 모두 입력해야 이동할 수 있습니다.");
                                return;
                            }
                        
                            currentContent.parentNode.insertBefore(currentContent, prevContent);
                        }
                    });
                
                    downButton.addEventListener("click", function() {
                        const currentContent = this.closest(".instagram_contents");
                        const nextContent = currentContent.nextElementSibling;

                        // 현재 컨텐츠가 비어있는지 확인
                        const currentUploadButton = currentContent.querySelector(".instagram_contents_img_upload_button");
                        const currentFile = currentUploadButton ? currentUploadButton.file : null;
                        const currentTitle = currentContent.querySelector('.instagram_content_title').value.trim();
                        const currentContentText = currentContent.querySelector('.instagram_content_content').value.trim();

                        if (!currentFile || !currentTitle || !currentContentText) {
                            alert("이미지, 제목, 내용을 모두 입력해야 이동할 수 있습니다.");
                            return;
                        }
                    
                        if (nextContent) {
                            // 다음 컨텐츠가 비어있는지 확인
                            const nextUploadButton = nextContent.querySelector(".instagram_contents_img_upload_button");
                            const nextFile = nextUploadButton ? nextUploadButton.file : null;
                            const nextTitle = nextContent.querySelector('.instagram_content_title').value.trim();
                            const nextContentText = nextContent.querySelector('.instagram_content_content').value.trim();
                        
                            if (!nextFile || !nextTitle || !nextContentText) {
                                alert("다음 컨텐츠의 이미지, 제목, 내용을 모두 입력해야 이동할 수 있습니다.");
                                return;
                            }
                        
                            currentContent.parentNode.insertBefore(nextContent, currentContent);
                        }
                    });
                }
            
                const uploadButton = document.querySelector(".instagram_contents_img_upload_button");
                setUpUploadButton(uploadButton);
                setUpDeleteButton(document.querySelector(".delete_content_btn"));
                setUpMoveButtons(document.querySelector(".instagram_contents"));
            
                document.getElementById("instagram_submit_button").addEventListener("click", function() {
                    const firstTitleInput = document.querySelector('.instagram_content_title[name="title[]"]');
                    const firstContentInput = document.querySelector('.instagram_content_content[name="content[]"]');
                    const firstFile = uploadButton.file;
                
                    // 기본 유효성 검사
                    if (!firstFile) {
                        alert("기본 이미지를 업로드해주세요.");
                        return;
                    }
                    if (!firstTitleInput || !firstTitleInput.value.trim()) {
                        alert("기본 제목을 입력해주세요.");
                        firstTitleInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstTitleInput.focus();
                        return;
                    }
                    if (!firstContentInput || !firstContentInput.value.trim()) {
                        alert("기본 내용을 입력해주세요.");
                        firstContentInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstContentInput.focus();
                        return;
                    }
                
                    // 모든 폼 요소 유효성 검사
                    const formElements = document.querySelectorAll('.instagram_contents');
                    let valid = true;
                
                    formElements.forEach((formElement) => {
                        const titleInput = formElement.querySelector('.instagram_content_title[name="title[]"]');
                        const contentInput = formElement.querySelector('.instagram_content_content[name="content[]"]');
                        const uploadButton = formElement.querySelector('.instagram_contents_img_upload_button');
                        const file = uploadButton ? uploadButton.file : null;
                    
                        if (file && titleInput && contentInput) {
                            if (!titleInput.value.trim()) {
                                alert("제목을 입력해주세요.");
                                titleInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                titleInput.focus();
                                valid = false;
                                return false;
                            }
                            if (!contentInput.value.trim()) {
                                alert("내용을 입력해주세요.");
                                contentInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                contentInput.focus();
                                valid = false;
                                return false;
                            }
                        }
                    });
                
                    if (valid) {
                        EGB.form.submit('instagram_form_input', function(formData) {
                            // CSRF 토큰 추가
                            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');
                        
                            formElements.forEach((formElement) => {
                                const titleInput = formElement.querySelector('.instagram_content_title[name="title[]"]');
                                const contentInput = formElement.querySelector('.instagram_content_content[name="content[]"]');
                                const uploadButton = formElement.querySelector('.instagram_contents_img_upload_button');
                                const file = uploadButton ? uploadButton.file : null;
                            
                                if (file) {
                                    formData.append('titles[]', titleInput.value.trim());
                                    formData.append('contents[]', contentInput.value.trim());
                                    formData.append('images[]', file);
                                }
                            });
                        });
                    }
                });
            });
            </script>

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
        .drag-over {
            background-color: #d0e6f7;  /* 밝은 블루 색상으로 드래그 가능 상태를 강조 */
            border: 2px dashed #0275d8;  /* 테두리를 점선으로 표시하여 드래그 대상임을 나타냄 */
            transition: background-color 0.3s ease-in-out, border 0.3s ease-in-out;  /* 부드러운 전환 효과 추가 */
        }
        .instagram_img_box.drag-over {
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);  /* 파란색 그림자로 드래그 가능 영역 강조 */
            transform: scale(1.05);  /* 약간 확대하여 사용자가 드래그 중임을 강조 */
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


    <section id="youtube_form_section" class="position1 width_box padding_px-t_030 display_none">
        <div class="position1 width_px_1000 margin_x_auto" data-xy="1-1000: width_box">
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
            <form id="youtube_form" action="<?php echo DOMAIN . '/youtube_form_input.php'; ?>" method="POST" enctype="multipart/form-data">
                <div class="youtube_contents flex_xs1 padding_px-u_030" data-xy="1-1000: flex_ft_yc">
                    <div class="width_px_440 padding_px-a_000" data-xy="1-460: width_box padding_px-a_010, 461-1000: width_px_440 padding_px-a_010">
                        <div class="youtube_img_box width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005 bg-color-f7f9fa color-888888" data-xy="1-440: width_box">
                            <input type="file" name="video" accept="video/*" class="video_file display_none">
                            <video class="youtube_video" controls style="display: none; width: 100%; height: auto;"></video>
                            <img class="youtube_img width_px_025 height_px_025" src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                            <div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">동영상을 끌어다 놓으세요</div>
                            <div class="font_px_014 padding_px-u_010">5GB 미만, 3~60초의 세로 영상이 좋아요.</div>
                            <div class="youtube_contents_img_upload_button border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice bg-color-15376b color-ffffff">PC에서 불러오기</div>
                        </div>
                    </div>
                    <div class="youtube_content width_px_540 padding_px-a_000" data-xy="1-560: width_box padding_px-a_010, 561-1000: width_px_540 padding_px-a_010">
                        <div class="flex_ft width_px_540" data-xy="1-560: width_box">
                            <div class="padding_px-u_015">
                                <input type="text" placeholder="제목을 입력 해주세요." name="title" class="youtube_content_title width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014 color-000000 bd-a-color-c2c8cc">
                            </div>
                            <textarea name="content" class="youtube_content_content autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden color-000000 bd-a-color-c2c8cc" placeholder="어떤 동영상인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요"></textarea>
                        </div>
                    </div>
                </div>
            </form>

            <script nonce="<?php echo NONCE; ?>">
                document.addEventListener("DOMContentLoaded", function() {
                    function setUpUploadButton(uploadButton) {
                        if (uploadButton.dataset.initialized) return;
                        uploadButton.dataset.initialized = true;

                        const fileInput = uploadButton.closest('.youtube_img_box').querySelector('.video_file');
                        const videoElement = uploadButton.closest('.youtube_img_box').querySelector('.youtube_video');
                        const dropArea = uploadButton.closest(".youtube_img_box");

                        uploadButton.addEventListener("click", function() {
                            fileInput.click();
                        });

                        fileInput.addEventListener("change", function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                uploadButton.fileInput = fileInput;
                                handleFileUpload(file, uploadButton);
                            }
                        });

                        setUpDragAndDrop(dropArea, uploadButton);

                        videoElement.addEventListener('click', function() {
                            uploadButton.click();
                        });
                    }

                    function handleFileUpload(file, uploadButton) {
                        const imgBox = uploadButton.closest(".youtube_img_box");
                        const videoElement = imgBox.querySelector(".youtube_video");

                        if (file.type.startsWith("video/")) {
                            if (file.size > 5000000000) {
                                alert("파일 크기가 너무 큽니다. 5GB 이하의 파일을 선택해주세요.");
                                return;
                            }

                            const videoURL = URL.createObjectURL(file);
                            videoElement.src = videoURL;
                            videoElement.preload = 'auto';
                            videoElement.style.display = 'block';
                            videoElement.style.width = '100%';
                            videoElement.style.height = 'auto';

                            Array.from(imgBox.children).forEach(child => {
                                if (!child.classList.contains("youtube_video")) {
                                    child.style.display = "none";
                                }
                            });

                            uploadButton.file = file;

                            videoElement.addEventListener('loadeddata', function() {
                                generateThumbnail(videoElement, function(thumbnailBlob) {
                                    uploadButton.thumbnailBlob = thumbnailBlob;
                                });
                            }, { once: true });

                            videoElement.addEventListener('error', function() {
                                alert("비디오를 로드하는 중 오류가 발생했습니다.");
                                URL.revokeObjectURL(videoURL);
                                videoElement.remove();
                            }, { once: true });
                        } else {
                            alert("동영상 파일을 선택해주세요.");
                        }
                    }

                    function generateThumbnail(videoElement, callback) {
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');

                        canvas.width = videoElement.videoWidth;
                        canvas.height = videoElement.videoHeight;
                        context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

                        canvas.toBlob(function(blob) {
                            callback(blob);
                        }, 'image/jpeg', 0.75);
                    }

                    function setUpDragAndDrop(dropArea, uploadButton) {
                        if (dropArea.dataset.initialized) return;
                        dropArea.dataset.initialized = true;

                        dropArea.addEventListener("dragover", (e) => e.preventDefault());
                        dropArea.addEventListener("drop", (e) => {
                            e.preventDefault();
                            const file = e.dataTransfer.files[0];
                            if (file) handleFileUpload(file, uploadButton);
                        });
                    }

                    const uploadButton = document.querySelector(".youtube_contents_img_upload_button");
                    setUpUploadButton(uploadButton);

                    document.getElementById("youtube_submit_button").addEventListener("click", function() {
                        const uploadButton = document.querySelector(".youtube_contents_img_upload_button");
                        const videoElement = document.querySelector(".youtube_video");
                        
                        // 동영상 파일 체크
                        if (!uploadButton.file) {
                            alert("동영상 파일을 선택해주세요.");
                            return;
                        }
                        
                        EGB.form.submit('youtube_form_input', function(formData) {
                            const titleInput = document.querySelector('.youtube_content_title[name="title"]');
                            const contentInput = document.querySelector('.youtube_content_content[name="content"]');
                            const file = uploadButton ? uploadButton.file : null;
                            const thumbnailBlob = uploadButton ? uploadButton.thumbnailBlob : null;

                            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');   
                            
                            formData.append('title', titleInput.value.trim());
                            formData.append('content', contentInput.value.trim());
                            formData.append('video', file);

                            if (thumbnailBlob) {
                                formData.append('thumbnail', thumbnailBlob, 'thumbnail.jpg');
                            }
                        });
                    });
                });
            </script>
        </div>
    </section>

    <section id="shorts_form_section" class="position1 width_box padding_px-t_030 display_none">
        <div class="position1 width_px_1000 margin_x_auto" data-xy="1-1000: width_box">
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
            <form id="shorts_form" class="flex_xs1" data-xy="1-1000: flex_ft_yc">
                <div class="shorts_contents padding_px-a_000" data-xy="1-440: width_box padding_px-a_010, 461-1000: width_px_440 padding_px-a_010">
                    <div class="shorts_img_box width_px_420 height_px_420 flex_ft_xc_yc border_bre-a_005" data-bg-color="#f7f9fa"
                        data-color="#888888" data-xy="1-420: width_box">
                        <input type="file" name="video" accept="video/*" class="video_file display_none">
                        <video class="shorts_video" controls style="display: none; width: 100%; height: auto;"></video>
                        <img class="shorts_img width_px_025 height_px_025" src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/camera.svg'; ?>">
                        <div class="font_px_016 flv6 padding_px-t_015 padding_px-u_005">동영상을 끌어다 놓으세요</div>
                        <div class="font_px_014 padding_px-u_010">5GB 미만, 3~60초의 세로 영상이 좋아요.</div>
                        <div class="shorts_contents_img_upload_button border_bre-a_005 pointer padding_px-y_008 padding_px-x_020 filechoice"
                            data-bg-color="#15376b" data-color="#ffffff">PC에서 불러오기</div>
                    </div>
                </div>
                <div class="shorts_content width_px_540 padding_px-a_000" data-xy="1-540: width_box padding_px-a_010, 461-1000: width_px_540 padding_px-a_010">
                    <div class="flex_ft width_px_540" data-xy="1-540: width_box">
                        <div class="padding_px-u_015">
                            <input type="text" placeholder="제목을 입력 해주세요."
                                class="shorts_content_title width_box padding_px-x_015 padding_px-y_008 border_px-a_001 border_bre-a_005 fontstyle1 font_px_014"
                                data-color="#000000" data-bd-a-color="#c2c8cc">
                        </div>
                        <textarea
                            class="shorts_content_content autoexpand width_box min_height_180 padding_px-a_015 border_bre-a_005 border_px-a_001 fontstyle1 font_px_014 overflow_hidden"
                            placeholder="어떤 동영상인지 짧은 소개로 시작해보세요.&#13;&#10;다양한 #태그도 추가할 수 있어요" data-color="#000000"
                            data-bd-a-color="#c2c8cc"></textarea>
                    </div>
                </div>
            </form>
            <script nonce="<?php echo NONCE; ?>">
                document.addEventListener("DOMContentLoaded", function() {
                    function setUpUploadButton(uploadButton) {
                        if (uploadButton.dataset.initialized) return;
                        uploadButton.dataset.initialized = true;

                        const fileInput = uploadButton.closest('.shorts_img_box').querySelector('.video_file');
                        const videoElement = uploadButton.closest('.shorts_img_box').querySelector('.shorts_video');
                        const dropArea = uploadButton.closest(".shorts_img_box");

                        uploadButton.addEventListener("click", function() {
                            fileInput.click();
                        });

                        fileInput.addEventListener("change", function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                uploadButton.fileInput = fileInput;
                                handleFileUpload(file, uploadButton);
                            }
                        });

                        setUpDragAndDrop(dropArea, uploadButton);

                        videoElement.addEventListener('click', function() {
                            uploadButton.click();
                        });
                    }

                    function handleFileUpload(file, uploadButton) {
                        const imgBox = uploadButton.closest(".shorts_img_box");
                        const videoElement = imgBox.querySelector(".shorts_video");

                        if (file.type.startsWith("video/")) {
                            if (file.size > 5000000000) {
                                alert("파일 크기가 너무 큽니다. 5GB 이하의 파일을 선택해주세요.");
                                return;
                            }

                            const videoURL = URL.createObjectURL(file);
                            videoElement.src = videoURL;
                            videoElement.preload = 'auto';
                            videoElement.style.display = 'block';
                            videoElement.style.width = '100%';
                            videoElement.style.height = 'auto';

                            Array.from(imgBox.children).forEach(child => {
                                if (!child.classList.contains("shorts_video")) {
                                    child.style.display = "none";
                                }
                            });

                            uploadButton.file = file;

                            videoElement.addEventListener('loadeddata', function() {
                                generateThumbnail(videoElement, function(thumbnailBlob) {
                                    uploadButton.thumbnailBlob = thumbnailBlob;
                                });
                            }, { once: true });

                            videoElement.addEventListener('error', function() {
                                alert("비디오를 로드하는 중 오류가 발생했습니다.");
                                URL.revokeObjectURL(videoURL);
                                videoElement.remove();
                            }, { once: true });
                        } else {
                            alert("동영상 파일을 선택해주세요.");
                        }
                    }

                    function generateThumbnail(videoElement, callback) {
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');

                        canvas.width = videoElement.videoWidth;
                        canvas.height = videoElement.videoHeight;
                        context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

                        canvas.toBlob(function(blob) {
                            callback(blob);
                        }, 'image/jpeg', 0.75);
                    }

                    function setUpDragAndDrop(dropArea, uploadButton) {
                        if (dropArea.dataset.initialized) return;
                        dropArea.dataset.initialized = true;

                        dropArea.addEventListener("dragover", (e) => e.preventDefault());
                        dropArea.addEventListener("drop", (e) => {
                            e.preventDefault();
                            const file = e.dataTransfer.files[0];
                            if (file) handleFileUpload(file, uploadButton);
                        });
                    }

                    const uploadButton = document.querySelector(".shorts_contents_img_upload_button");
                    setUpUploadButton(uploadButton);

                    document.getElementById("shorts_submit_button").addEventListener("click", function() {
                        const uploadButton = document.querySelector(".shorts_contents_img_upload_button");
                        
                        // 동영상 파일 체크
                        if (!uploadButton.file) {
                            alert("동영상 파일을 선택해주세요.");
                            return;
                        }
                        
                        EGB.form.submit('shorts_form_input', function(formData) {
                            const titleInput = document.querySelector('.shorts_content_title');
                            const contentInput = document.querySelector('.shorts_content_content');
                            const file = uploadButton ? uploadButton.file : null;
                            const thumbnailBlob = uploadButton ? uploadButton.thumbnailBlob : null;

                            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');   
                            
                            formData.append('title', titleInput.value.trim());
                            formData.append('content', contentInput.value.trim());
                            formData.append('video', file);

                            if (thumbnailBlob) {
                                formData.append('thumbnail', thumbnailBlob, 'thumbnail.jpg');
                            }
                        });
                    });
                });
            </script>
        </div>
    </section>
    <style>

        .egb_menu_active {
            font-weight: 600;
            color: #000000;
            border-color: #000000;
        }
    </style>