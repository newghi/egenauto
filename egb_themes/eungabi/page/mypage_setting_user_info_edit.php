<?php
require_once ROOT.THEMES_PATH.DS.'page'.DS.'mypage_menu.php';
?>

<section class="position1 width_box padding_px-y_080" data-bg-color="#f8f9fa">
    <div class="width_px_800 margin_x_auto" data-xy="1-800: width_box">
        <div class="padding_px-x_020">
            
            <!-- 페이지 타이틀 -->
            <div class="width_box text_align_center margin_px-b_080">
                <div class="font_px_040 flv7 margin_px-b_020" data-color="#000000" data-xy="1-800: font_px_032">
                    회원정보 수정
                </div>
                <div class="font_px_018" data-color="#6c757d" data-xy="1-800: font_px_016">
                    개인정보를 안전하게 관리하고 최신 정보로 유지해주세요
                </div>
            </div>
            
            <!-- 회원정보 수정 폼 -->
            <div class="width_box">
                <div class="width_box border_bre-a_010 padding_px-a_080" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 4px 20px rgba(0, 0, 0, 0.08)">
                    
                    <form id="userInfoForm" class="width_box" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <!-- 프로필 사진 -->
                        <div class="margin_px-b_060">
                            <label class="display_block margin_px-b_020 font_px_018 flv6" data-color="#000000">
                                프로필 사진
                            </label>
                            <div class="flex_xc_yc margin_px-b_030">
                                <div class="position1 width_px_150 height_px_150 border_bre-a_050 overflow_hidden" data-bg-color="#f8f9fa" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 10px rgba(0, 0, 0, 0.1)">
                                    <img id="profilePreview" 
                                         src="<?php echo isset($_SESSION['user_profile']) && $_SESSION['user_profile'] ? DOMAIN . '/egb_img/profile/' . $_SESSION['user_profile'] : 'https://picsum.photos/150/150?random=profile'; ?>" 
                                         alt="프로필 사진" 
                                         class="width_box height_box object_fit_cover">
                                    <div class="position2 width_box height_box flex_xc_yc" data-top="0%" data-bg-color="#00000040" style="opacity: 0; transition: opacity 0.3s ease;" id="profileOverlay">
                                        <div class="font_px_014 flv6" data-color="#ffffff">변경</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex_xc_yc gap_px_020">
                                <input id="profileImage" 
                                       class="width_box padding_px-a_015 border_bre-a_005 board_px-a_001 font_px_016" 
                                       data-color="#000000" 
                                       data-bd-a-color="#e9ecef"
                                       type="file" 
                                       name="user_profile" 
                                       accept="image/*"
                                       style="display: none;">
                                <button type="button" 
                                        class="padding_px-x_030 padding_px-y_015 border_bre-a_005 board_px-a_001 font_px_016 flv6" 
                                        data-bg-color="#15376b" 
                                        data-color="#ffffff"
                                        data-hover-bg-color="#0f2a52"
                                        onclick="document.getElementById('profileImage').click()">
                                    사진 선택
                                </button>
                                <button type="button" 
                                        class="padding_px-x_030 padding_px-y_015 border_bre-a_005 board_px-a_001 font_px_016 flv6" 
                                        data-bg-color="#6c757d" 
                                        data-color="#ffffff"
                                        data-hover-bg-color="#5a6268"
                                        onclick="removeProfileImage()">
                                    삭제
                                </button>
                            </div>
                            <div class="font_px_014 margin_px-t_015 text_align_center" data-color="#6c757d">
                                JPG, PNG, GIF 파일만 업로드 가능합니다 (최대 5MB)
                            </div>
                        </div>
                        
                        <!-- 이메일 -->
                        <div class="margin_px-b_050">
                            <label class="display_block margin_px-b_015 font_px_018 flv6" data-color="#000000" for="userEmail">
                                이메일
                            </label>
                            <input id="userEmail" 
                                   class="width_box padding_px-a_020 border_bre-a_005 board_px-a_001 font_px_016" 
                                   data-color="#000000" 
                                   data-bd-a-color="#e9ecef"
                                   data-hover-bd-a-color="#15376b"
                                   type="email" 
                                   name="user_email" 
                                   required 
                                   placeholder="이메일을 입력하세요"
                                   value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
                        </div>
                        
                        <!-- 휴대폰 번호 -->
                        <div class="margin_px-b_050">
                            <label class="display_block margin_px-b_015 font_px_018 flv6" data-color="#000000" for="userPhone">
                                휴대폰 번호
                            </label>
                            <input id="userPhone" 
                                   class="width_box padding_px-a_020 border_bre-a_005 board_px-a_001 font_px_016" 
                                   data-color="#000000" 
                                   data-bd-a-color="#e9ecef"
                                   data-hover-bd-a-color="#15376b"
                                   type="tel" 
                                   name="user_phone" 
                                   required 
                                   placeholder="휴대폰 번호를 입력하세요 (예: 010-1234-5678)"
                                   value="<?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_phone']) : ''; ?>">
                        </div>
                        
                        <!-- 버튼 영역 -->
                        <div class="flex_xc_yc margin_px-t_080">
                            <button type="submit" 
                                    class="width_px_200 padding_px-y_025 border_bre-a_010 board_px-a_000 font_px_018 flv6" 
                                    data-bg-color="#15376b" 
                                    data-color="#ffffff"
                                    data-hover-bg-color="#0f2a52"
                                    data-hover-transform="translateY(-2px)"
                                    data-box-shadow="0 4px 15px rgba(21, 55, 107, 0.3)">
                                회원정보 수정
                            </button>
                        </div>
                        
                    </form>
                    
                </div>
                
                <!-- 개인정보 안내 -->
                <div class="width_box margin_px-t_060 padding_px-a_040 border_bre-a_010" data-bg-color="#f8f9fa" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 10px rgba(0, 0, 0, 0.05)">
                    <div class="font_px_020 flv6 margin_px-b_025" data-color="#000000">
                        개인정보 안내
                    </div>
                    <div class="font_px_016 line_height_160" data-color="#6c757d">
                        • 수집된 개인정보는 서비스 제공 및 고객 지원 목적으로만 사용됩니다<br>
                        • 수신 동의는 언제든지 변경할 수 있으며, 동의 철회 시 일부 서비스 이용이 제한될 수 있습니다<br>
                        • 개인정보는 암호화되어 안전하게 보관되며, 제3자에게 제공되지 않습니다
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</section>

<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    // 프로필 사진 미리보기
    const profileImage = document.getElementById('profileImage');
    const profilePreview = document.getElementById('profilePreview');
    const profileOverlay = document.getElementById('profileOverlay');
    const profileContainer = profilePreview.parentElement;
    
    // 프로필 사진 호버 효과
    profileContainer.addEventListener('mouseenter', function() {
        profileOverlay.style.opacity = '1';
    });
    
    profileContainer.addEventListener('mouseleave', function() {
        profileOverlay.style.opacity = '0';
    });
    
    // 프로필 사진 클릭으로도 파일 선택 가능
    profileContainer.addEventListener('click', function() {
        document.getElementById('profileImage').click();
    });
    
    profileImage.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // 파일 크기 검증 (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('파일 크기는 5MB 이하여야 합니다.');
                this.value = '';
                return;
            }
            
            // 파일 형식 검증
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('JPG, PNG, GIF 파일만 업로드 가능합니다.');
                this.value = '';
                return;
            }
            
            // 미리보기 표시
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // 폼 제출 검증
    document.getElementById('userInfoForm').addEventListener('submit', function(e) {
        const userEmail = document.getElementById('userEmail').value.trim();
        const userPhone = document.getElementById('userPhone').value.trim();
        
        if (!userEmail) {
            alert('이메일을 입력해주세요.');
            e.preventDefault();
            return;
        }
        
        // 이메일 형식 검증
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(userEmail)) {
            alert('올바른 이메일 형식을 입력해주세요.');
            e.preventDefault();
            return;
        }
        
        if (!userPhone) {
            alert('휴대폰 번호를 입력해주세요.');
            e.preventDefault();
            return;
        }
        
        // 휴대폰 번호 형식 검증
        const phoneRegex = /^01[0-9]-[0-9]{3,4}-[0-9]{4}$/;
        if (!phoneRegex.test(userPhone)) {
            alert('올바른 휴대폰 번호 형식을 입력해주세요. (예: 010-1234-5678)');
            e.preventDefault();
            return;
        }
    });
});

// 프로필 사진 삭제
function removeProfileImage() {
    const profileImage = document.getElementById('profileImage');
    const profilePreview = document.getElementById('profilePreview');
    
    // 파일 입력 초기화
    profileImage.value = '';
    
    // 미리보기를 기본 이미지로 변경
    profilePreview.src = 'https://picsum.photos/150/150?random=profile';
    
    // 숨겨진 입력 필드 추가 (삭제 표시용)
    const deleteFlag = document.createElement('input');
    deleteFlag.type = 'hidden';
    deleteFlag.name = 'delete_profile';
    deleteFlag.value = '1';
    profileImage.parentNode.appendChild(deleteFlag);
}
</script>