<?php
require_once ROOT.THEMES_PATH.DS.'page'.DS.'mypage_menu.php';
?>

<section class="position1 width_box padding_px-y_060" data-bg-color="#ffffff">
    <div class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
        <div class="padding_px-x_020">
            <!-- 총 포인트 카드 -->
            <div class="width_box border_bre-a_005 padding_px-a_060 margin_px-b_060" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                <div class="flex_ft_xc_yc">
                    <div class="font_px_020 flv6 margin_px-b_020" data-color="#000000" data-xy="1-800: font_px_018">
                        총 포인트
                    </div>
                    <div class="font_px_048 flv7 margin_px-b_010" data-color="#000000" data-xy="1-800: font_px_040">
                        15,000P
                    </div>
                </div>
            </div>

            <!-- 포인트 내역 섹션 -->
            <div>
                <div class="font_px_024 flv6 margin_px-b_040" data-color="#000000" data-xy="1-800: font_px_020">
                    포인트 내역
                </div>
                
                <!-- 포인트 리스트 -->
                <div class="width_box">
                    
                    <!-- 적립 내역 -->
                    <div class="margin_px-b_040">
                        <div class="font_px_018 flv6 margin_px-b_020" data-color="#000000" data-xy="1-800: font_px_016">
                            적립 내역
                        </div>
                        
                        <!-- 포인트 적립 리스트 -->
                        <div class="width_box border_bre-a_005" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                            
                            <!-- 리스트 헤더 -->
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bg-color="#f8f9fa" data-bd-a-color="#e9ecef">
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    날짜
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    구분
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    포인트
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    상태
                                </div>
                            </div>
                            
                            <!-- 리스트 아이템들 -->
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bd-a-color="#e9ecef">
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    2024.01.20
                                </div>
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    서비스 이용
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    +5,000P
                                </div>
                                <div class="font_px_014" data-color="#28a745" data-xy="1-800: font_px_012">
                                    완료
                                </div>
                            </div>
                            
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bd-a-color="#e9ecef">
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    2024.02.10
                                </div>
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    추천인 등록
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    +10,000P
                                </div>
                                <div class="font_px_014" data-color="#28a745" data-xy="1-800: font_px_012">
                                    완료
                                </div>
                            </div>
                            
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bd-a-color="#e9ecef">
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    2024.03.01
                                </div>
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    이벤트 참여
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    +3,000P
                                </div>
                                <div class="font_px_014" data-color="#ffc107" data-xy="1-800: font_px_012">
                                    처리중
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- 사용 내역 -->
                    <div>
                        <div class="font_px_018 flv6 margin_px-b_020" data-color="#000000" data-xy="1-800: font_px_016">
                            소멸 내역
                        </div>
                        
                        <!-- 포인트 사용 리스트 -->
                        <div class="width_box border_bre-a_005" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                            
                            <!-- 리스트 헤더 -->
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bg-color="#f8f9fa" data-bd-a-color="#e9ecef">
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    날짜
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    구분
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    포인트
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    상태
                                </div>
                            </div>
                            
                            <!-- 리스트 아이템들 -->
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bd-a-color="#e9ecef">
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    2024.02.15
                                </div>
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    서비스 이용
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    -2,000P
                                </div>
                                <div class="font_px_014" data-color="#dc3545" data-xy="1-800: font_px_012">
                                    완료
                                </div>
                            </div>
                            
                            <div class="flex_xs1_yc padding_px-a_020 border_bre-a_005" data-bd-a-color="#e9ecef">
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    2024.03.05
                                </div>
                                <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                    서비스 이용
                                </div>
                                <div class="font_px_014 flv6" data-color="#000000" data-xy="1-800: font_px_012">
                                    -1,000P
                                </div>
                                <div class="font_px_014" data-color="#dc3545" data-xy="1-800: font_px_012">
                                    완료
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section> 