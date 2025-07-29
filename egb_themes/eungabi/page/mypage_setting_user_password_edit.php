<?php
require_once ROOT.THEMES_PATH.DS.'page'.DS.'mypage_menu.php';
?>

<section class="position1 width_box padding_px-y_060" data-bg-color="#ffffff">
    <div class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
        <div class="padding_px-x_020">
            
            <!-- 페이지 타이틀 -->
            <div class="width_box text_align_center margin_px-b_060">
                <div class="font_px_032 flv7 margin_px-b_020" data-color="#000000" data-xy="1-800: font_px_024">
                    비밀번호 변경
                </div>
                <div class="font_px_016" data-color="#6c757d" data-xy="1-800: font_px_014">
                    안전한 계정 관리를 위해 주기적으로 비밀번호를 변경해주세요
                </div>
            </div>
            
            <!-- 비밀번호 변경 폼 -->
            <div class="width_px_600 margin_x_auto" data-xy="1-800: width_box">
                <div class="width_box border_bre-a_005 padding_px-a_060" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                    
                    <form id="passwordChangeForm" class="width_box" method="post" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        
                        <!-- 현재 비밀번호 -->
                        <div class="margin_px-b_040">
                            <label class="display_block margin_px-b_010 font_px_016 flv6" data-color="#333333" for="currentPassword">
                                현재 비밀번호
                            </label>
                            <input id="currentPassword" 
                                   class="width_box padding_px-a_015 border_bre-a_005 board_px-a_001 font_px_016" 
                                   data-color="#000000" 
                                   data-bd-a-color="#e9ecef"
                                   type="password" 
                                   name="current_password" 
                                   required 
                                   placeholder="현재 비밀번호를 입력하세요">
                        </div>
                        
                        <!-- 새 비밀번호 -->
                        <div class="margin_px-b_040">
                            <label class="display_block margin_px-b_010 font_px_016 flv6" data-color="#333333" for="newPassword">
                                새 비밀번호
                            </label>
                            <input id="newPassword" 
                                   class="width_box padding_px-a_015 border_bre-a_005 board_px-a_001 font_px_016" 
                                   data-color="#000000" 
                                   data-bd-a-color="#e9ecef"
                                   type="password" 
                                   name="new_password" 
                                   required 
                                   placeholder="새 비밀번호를 입력하세요 (8자 이상)">
                            <div class="font_px_012 margin_px-t_010" data-color="#6c757d">
                                • 영문, 숫자, 특수문자를 포함하여 8자 이상 입력해주세요
                            </div>
                        </div>
                        
                        <!-- 새 비밀번호 확인 -->
                        <div class="margin_px-b_040">
                            <label class="display_block margin_px-b_010 font_px_016 flv6" data-color="#333333" for="confirmPassword">
                                새 비밀번호 확인
                            </label>
                            <input id="confirmPassword" 
                                   class="width_box padding_px-a_015 border_bre-a_005 board_px-a_001 font_px_016" 
                                   data-color="#000000" 
                                   data-bd-a-color="#e9ecef"
                                   type="password" 
                                   name="confirm_password" 
                                   required 
                                   placeholder="새 비밀번호를 다시 입력하세요">
                        </div>
                        
                        <!-- 비밀번호 강도 표시 -->
                        <div class="margin_px-b_040">
                            <div class="font_px_014 flv6 margin_px-b_010" data-color="#333333">
                                비밀번호 강도
                            </div>
                            <div class="width_box height_px_010 border_bre-a_005" data-bg-color="#f8f9fa" data-bd-a-color="#e9ecef">
                                <div id="passwordStrength" class="height_box width_px_000 border_bre-a_005" data-bg-color="#dc3545" data-transition="width 0.3s ease"></div>
                            </div>
                            <div id="passwordStrengthText" class="font_px_012 margin_px-t_010" data-color="#dc3545">
                                비밀번호를 입력해주세요
                            </div>
                        </div>
                        
                        <!-- 버튼 영역 -->
                        <div class="flex_xc_yc margin_px-t_040">
                            <button type="submit" 
                                    class="width_px_200 padding_px-y_025 border_bre-a_010 board_px-a_000 font_px_018 flv6" 
                                    data-bg-color="#15376b" 
                                    data-color="#ffffff"
                                    data-hover-bg-color="#0f2a52"
                                    data-hover-transform="translateY(-2px)"
                                    data-box-shadow="0 4px 15px rgba(21, 55, 107, 0.3)">
                                비밀번호 변경
                            </button>
                        </div>
                        
                    </form>
                    
                </div>
                
                <!-- 보안 안내 -->
                <div class="width_box margin_px-t_040 padding_px-a_030 border_bre-a_005" data-bg-color="#f8f9fa" data-bd-a-color="#e9ecef">
                    <div class="font_px_016 flv6 margin_px-b_020" data-color="#000000">
                        보안 안내
                    </div>
                    <div class="font_px_014 line_height_150" data-color="#6c757d">
                        • 비밀번호는 주기적으로 변경하여 계정 보안을 강화하세요<br>
                        • 다른 사이트에서 사용하지 않는 고유한 비밀번호를 사용하세요<br>
                        • 개인정보와 관련된 정보는 비밀번호에 포함하지 마세요
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</section>

<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordStrengthText = document.getElementById('passwordStrengthText');
    
    // 비밀번호 강도 체크
    function checkPasswordStrength(password) {
        let strength = 0;
        let feedback = '';
        
        if (password.length >= 8) strength += 1;
        if (/[a-z]/.test(password)) strength += 1;
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        const width = (strength / 5) * 100;
        passwordStrength.style.width = width + '%';
        
        if (strength <= 1) {
            passwordStrength.style.backgroundColor = '#dc3545';
            feedback = '매우 약함';
        } else if (strength <= 2) {
            passwordStrength.style.backgroundColor = '#fd7e14';
            feedback = '약함';
        } else if (strength <= 3) {
            passwordStrength.style.backgroundColor = '#ffc107';
            feedback = '보통';
        } else if (strength <= 4) {
            passwordStrength.style.backgroundColor = '#28a745';
            feedback = '강함';
        } else {
            passwordStrength.style.backgroundColor = '#20c997';
            feedback = '매우 강함';
        }
        
        passwordStrengthText.textContent = feedback;
        passwordStrengthText.style.color = passwordStrength.style.backgroundColor;
    }
    
    // 비밀번호 입력 이벤트
    newPassword.addEventListener('input', function() {
        checkPasswordStrength(this.value);
    });
    
    // 폼 제출 검증
    document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
        const currentPw = document.getElementById('currentPassword').value;
        const newPw = newPassword.value;
        const confirmPw = confirmPassword.value;
        
        if (!currentPw) {
            alert('현재 비밀번호를 입력해주세요.');
            e.preventDefault();
            return;
        }
        
        if (newPw.length < 8) {
            alert('새 비밀번호는 8자 이상 입력해주세요.');
            e.preventDefault();
            return;
        }
        
        if (newPw !== confirmPw) {
            alert('새 비밀번호와 확인 비밀번호가 일치하지 않습니다.');
            e.preventDefault();
            return;
        }
        
        if (currentPw === newPw) {
            alert('현재 비밀번호와 새 비밀번호가 동일합니다.');
            e.preventDefault();
            return;
        }
    });
});
</script>