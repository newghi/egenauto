<?php
require_once ROOT.THEMES_PATH.DS.'page'.DS.'mypage_menu.php';
?>

<section class="position1 width_box padding_px-y_060" data-bg-color="#ffffff">
    <div class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
        <div class="padding_px-x_020">
            <!-- 리워드 카드 그리드 -->
            <div class="display_grid gap_px_030 margin_px-b_080" data-xx="1fr 1fr 1fr" data-xy="0-660: xx-1fr, 661-1200: xx-1fr~1fr">
                
                <!-- 예치금 카드 -->
                <div class="width_box border_bre-a_005 padding_px-a_040" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                    <div class="flex_ft_xc_yc">
                        <div class="font_px_018 flv6 margin_px-b_015" data-color="#000000" data-xy="1-800: font_px_016">
                            예치금
                        </div>
                        <div class="font_px_036 flv7 margin_px-b_010" data-color="#000000" data-xy="1-800: font_px_030">
                            ₩1,500,000
                        </div>
                    </div>
                </div>

                <!-- 적립금 카드 -->
                <div class="width_box border_bre-a_005 padding_px-a_040" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                    <div class="flex_ft_xc_yc">
                        <div class="font_px_018 flv6 margin_px-b_015" data-color="#000000" data-xy="1-800: font_px_016">
                            적립금
                        </div>
                        <div class="font_px_036 flv7 margin_px-b_010" data-color="#000000" data-xy="1-800: font_px_030">
                            ₩250,000
                        </div>
                    </div>
                </div>

                <!-- 멘티 마일리지 카드 -->
                <div class="width_box border_bre-a_005 padding_px-a_040" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                    <div class="flex_ft_xc_yc">
                        <div class="font_px_018 flv6 margin_px-b_015" data-color="#000000" data-xy="1-800: font_px_016">
                            멘티 마일리지
                        </div>
                        <div class="font_px_036 flv7 margin_px-b_010" data-color="#000000" data-xy="1-800: font_px_030">
                            ₩75,000
                        </div>
                    </div>
                </div>

            </div>

            <!-- 상세 정보 섹션 -->
            <div>
                <div class="font_px_024 flv6 margin_px-b_040" data-color="#000000" data-xy="1-800: font_px_020">
                    상세 내역
                </div>
                
                <!-- 상세 카드 그리드 -->
                <div class="display_grid gap_px_030" data-xx="1fr 1fr 1fr" data-xy="0-660: xx-1fr, 661-1200: xx-1fr~1fr">
                    
                    <!-- 예치금 상세 카드 -->
                    <div class="width_box border_bre-a_005 padding_px-a_030" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                        <div class="flex_xs1_yc margin_px-b_020">
                            <div class="font_px_016 flv6" data-color="#000000" data-xy="1-800: font_px_014">
                                예치금
                            </div>
                            <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                더보기
                            </div>
                        </div>
                        <div class="line_height_160 font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                            <div class="padding_px-y_005">2024.01.15 예치</div>
                            <div class="padding_px-y_005">2024.02.20 예치</div>
                            <div class="padding_px-y_005">2024.03.05 예치</div>
                        </div>
                    </div>

                    <!-- 적립금 상세 카드 -->
                    <div class="width_box border_bre-a_005 padding_px-a_030" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                        <div class="flex_xs1_yc margin_px-b_020">
                            <div class="font_px_016 flv6" data-color="#000000" data-xy="1-800: font_px_014">
                                적립금
                            </div>
                            <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                더보기
                            </div>
                        </div>
                        <div class="line_height_160 font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                            <div class="padding_px-y_005">2024.01.20 서비스 이용</div>
                            <div class="padding_px-y_005">2024.02.10 추천인 등록</div>
                            <div class="padding_px-y_005">2024.03.01 이벤트 참여</div>
                        </div>
                    </div>

                    <!-- 멘티 마일리지 상세 카드 -->
                    <div class="width_box border_bre-a_005 padding_px-a_030" data-bg-color="#ffffff" data-bd-a-color="#e9ecef" data-box-shadow="0 2px 8px rgba(0, 0, 0, 0.1)">
                        <div class="flex_xs1_yc margin_px-b_020">
                            <div class="font_px_016 flv6" data-color="#000000" data-xy="1-800: font_px_014">
                                멘티 마일리지
                            </div>
                            <div class="font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                                더보기
                            </div>
                        </div>
                        <div class="line_height_160 font_px_014" data-color="#6c757d" data-xy="1-800: font_px_012">
                            <div class="padding_px-y_005">2024.01.25 멘토링 완료</div>
                            <div class="padding_px-y_005">2024.02.15 추천인 성공</div>
                            <div class="padding_px-y_005">2024.03.10 멘토링 완료</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section> 