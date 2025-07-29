<div class="display_off" egb:style="
    input.menu_input_style{outline: none; padding: 5px 15px; font-family: fontstyle1; font-size: 14px; border: 1px solid #eeeeee; border-radius: 5px; box-sizing: border-box; box-shadow: 0px 0px 1px #00000020; background-color: #ffffff; pointer-events: auto;}
    input.menu_input_style:focus{outline: none; background-color: #616E7D20; transition: 0.4s; border: 1px solid #616E7D; border-radius: 5px; box-shadow: 0px 0px 5px #00000040; pointer-events: auto;}
"></div>

<form class="height_box overflow_y_auto scrollbar" id="egb_column_config_form" action="<?php echo DOMAIN . '/?post=egb_column_config_update'; ?>" method="post">
    <div class="position4 width_box font_px_014 padding_px-x_010 padding_px-t_010 z-index_100" data-top="0%" data-bg-color="#ffffff">
        <div class="position4 width_box height_px_042" data-top="0%" data-left="0%">
            <div class="position4 flex_xc_yc padding_px-y_008 border_px-a_001 border_bre-a_005 font_px_016 pointer egb_submit"
                data-bd-a-color="transparent" data-color="#ffffff" data-bg-color="#ffa500aa"
                data-hover-bg-color="#ffa500" data-top="0%" data-left="0%">칼럼 설정 저장
            </div>
        </div>
    </div>
    <input type="hidden" name="page_name" value="<?php echo egb('page_name'); ?>">
    <input type="hidden" name="menu_name" value="<?php echo egb('menu_name'); ?>">
    <input type="hidden" name="table_name" value="egb_page">
    
    <div class="height_box padding_px-t_010 padding_px-x_010">
        <?php
        // DB에서 설정 가져오기
        $sql = "SELECT column_config_data_json FROM egb_table_column_config 
                WHERE column_config_table_name = 'egb_page' 
                AND column_config_user_uniq_id IS NULL 
                AND deleted_at IS NULL 
                ORDER BY created_at DESC LIMIT 1";
                
        $dataBinding = binding_sql(1, $sql, []);
        $result = egb_sql($dataBinding);
        $column_config = [];
        
        if($result && !empty($result[0]['column_config_data_json'])) {
            $column_config = json_decode($result[0]['column_config_data_json'], true);
        }

        // 컬럼 설정 기본값 
        $default_config = [
            'visible' => 1,
            'order' => 0, 
            'width' => 200,
            'align' => 'left'
        ];

        // column_config 배열 순회
        foreach($column_config as $config) {
            $value = $config['name'];
            $display_name = $config['comment']; // name 대신 comment 사용
            
            // no 컬럼 특수처리
            $disabled = ($value === 'no') ? 'disabled' : '';
            $checked = ($value === 'no' || $config['visible']) ? 'checked' : '';
            
            // HTML 출력
            echo "<div class='flex_fl_yc padding_px-y_005 border_px-u_001' data-bd-a-color='#e9e9e9'>
                    <div class='width_px_200'>
                        <label>
                            <input type='checkbox' name='columns[]' value='$value' $checked $disabled> $display_name
                        </label>
                    </div>
                    <div class='flex_fl_yc'>
                        <input type='number' name='order[$value]' value='{$config['order']}' class='menu_input_style margin_px-r_005 width_px_150' placeholder='순서'>
                        <input type='number' name='width[$value]' value='{$config['width']}' class='menu_input_style margin_px-r_005 width_px_150' placeholder='너비'>
                        <select name='align[$value]' class='menu_input_style margin_px-r_005'>
                            <option value='left'" . ($config['align'] === 'left' ? ' selected' : '') . ">왼쪽</option>
                            <option value='center'" . ($config['align'] === 'center' ? ' selected' : '') . ">중앙</option>
                            <option value='right'" . ($config['align'] === 'right' ? ' selected' : '') . ">오른쪽</option>
                        </select>
                        <select name='hidden[$value]' class='menu_input_style'>
                            <option value='1'" . ($config['visible'] === 1 ? ' selected' : '') . ">보이기</option>
                            <option value='0'" . ($config['visible'] === 0 ? ' selected' : '') . ">숨기기</option>
                        </select>
                    </div>
                </div>";
        }
        ?>
    </div>
</form>

<script nonce="<?php echo NONCE; ?>">
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.egb_submit').addEventListener('click', function() {
        const form = document.getElementById('egb_column_config_form');
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('칼럼 설정이 저장되었습니다.');
                location.reload();
            } else {
                alert('저장 중 오류가 발생했습니다.');
            }
        });
    });
});
</script>