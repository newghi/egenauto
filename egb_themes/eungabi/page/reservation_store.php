<?php
// 스토어 목록 조회
$sql = "SELECT uniq_id, store_name, store_address, store_phone_number, store_region1, store_region2 FROM egb_store WHERE is_status = 1 ORDER BY display_order ASC, store_name ASC";
$stores = egb_sql(binding_sql(0, $sql));
?>

<section class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
    <div class="padding_px-y_025 padding_px-x_010">
        <div class="padding_px-u_040 font_px_024 flv6 font_style_center">정비소 선택</div>
    </div>
    
    <div class="padding_px-x_010 padding_px-y_020">
        <div class="grid_xx border_px-a_001" data-xx="20% 30% 30% 20%" data-bd-a-color="#dddddd">
            <div class="flex_xc padding_px-y_013 border_px-r_001 bg-color-f4f4f4" data-bd-a-color="#dddddd">지역</div>
            <div class="flex_xc padding_px-y_013 border_px-r_001 bg-color-f4f4f4" data-bd-a-color="#dddddd">정비소명</div>
            <div class="flex_xc padding_px-y_013 border_px-r_001 bg-color-f4f4f4" data-bd-a-color="#dddddd">주소</div>
            <div class="flex_xc padding_px-y_013 bg-color-f4f4f4">연락처</div>
        </div>
        
        <?php foreach($stores[0] as $store): ?>
        <a href="/page/reservation/?store=<?php echo $store['uniq_id']; ?>">
            <div class="grid_xx border_px-x_001 border_px-u_001 pointer hover-bg-color-f4f4f4" data-xx="20% 30% 30% 20%" data-bd-a-color="#dddddd">
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd"><?php echo $store['store_region1'] . ' ' . $store['store_region2']; ?></div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd"><?php echo $store['store_name']; ?></div>
                <div class="flex_xc padding_px-y_013 border_px-r_001" data-bd-a-color="#dddddd"><?php echo $store['store_address']; ?></div>
                <div class="flex_xc padding_px-y_013"><?php echo $store['store_phone_number']; ?></div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>