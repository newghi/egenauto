<?php 

$query_board = "
    SELECT * FROM egb_board_manual
    WHERE is_status = 1 AND deleted_at IS NULL
    ORDER BY display_order DESC, created_at DESC
";
$params_board = [];
$binding_board = binding_sql(0, $query_board, $params_board);
$sql_board = egb_sql($binding_board);

// 첫 번째 배열의 타이틀과 이미지를 출력하는 함수
    function print_first_array_title_and_image($data) 
{
    if (!is_array($data) || empty($data)) {
        return ['title' => 'No Title', 'image' => '/img/default_image.webp'];
    }

    $first_item = reset($data);

    $title = isset($first_item['title']) ? htmlspecialchars($first_item['title']) : 'No Title';
    $image = isset($first_item['image']) ? htmlspecialchars($first_item['image']) : '/img/default_image.webp';
    
    $manual_category = '';
    if (isset($first_item['manual_category'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['manual_category']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $manual_category = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }
    
    $manual_worker = isset($first_item['manual_worker']) ? $first_item['manual_worker'] : '';
    $manual_self_repair_shop = isset($first_item['manual_self_repair_shop']) ? $first_item['manual_self_repair_shop'] : '';
    $manual_worker_time = isset($first_item['manual_worker_time']) ? $first_item['manual_worker_time'] : '';
    $manual_worker_budget_part = isset($first_item['manual_worker_budget_part']) ? $first_item['manual_worker_budget_part'] : '';
    $manual_worker_budget_consumable = isset($first_item['manual_worker_budget_consumable']) ? $first_item['manual_worker_budget_consumable'] : '';
    
    $manual_worker_type = '';
    if (isset($first_item['manual_worker_type'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['manual_worker_type']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $manual_worker_type = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $manual_worker_brand = '';
    if (isset($first_item['manual_worker_brand'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['manual_worker_brand']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $manual_worker_brand = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $auto_manual_board_car_model = '';
    if (isset($first_item['auto_manual_board_car_model'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_model']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_model = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $auto_manual_board_car_type = '';
    if (isset($first_item['auto_manual_board_car_type'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_type']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_type = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $manual_car_model_name = isset($first_item['manual_car_model_name']) ? $first_item['manual_car_model_name'] : '';
    
    $auto_manual_board_car_oil_type = '';
    if (isset($first_item['auto_manual_board_car_oil_type'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_oil_type']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_oil_type = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    $auto_manual_board_car_model_year = '';
    if (isset($first_item['auto_manual_board_car_model_year'])) {
        $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id";
        $params = [':uniq_id' => $first_item['auto_manual_board_car_model_year']];
        $binding = binding_sql(1, $query, $params);
        $result = egb_sql($binding);
        $auto_manual_board_car_model_year = isset($result[0]['option_label']) ? $result[0]['option_label'] : '';
    }

    return [
        'title' => $title,
        'image' => $image,
        'manual_category' => $manual_category,
        'manual_worker' => $manual_worker, 
        'manual_self_repair_shop' => $manual_self_repair_shop,
        'manual_worker_time' => $manual_worker_time,
        'manual_worker_budget_part' => $manual_worker_budget_part,
        'manual_worker_budget_consumable' => $manual_worker_budget_consumable,
        'manual_worker_type' => $manual_worker_type,
        'manual_worker_brand' => $manual_worker_brand,
        'auto_manual_board_car_model' => $auto_manual_board_car_model,
        'auto_manual_board_car_type' => $auto_manual_board_car_type,
        'manual_car_model_name' => $manual_car_model_name,
        'auto_manual_board_car_oil_type' => $auto_manual_board_car_oil_type,
        'auto_manual_board_car_model_year' => $auto_manual_board_car_model_year
    ];
}

?>

<section class="position1 width_box">
    <div class="width_px_1220 margin_x_auto padding_px-y_030 " data-color="#2f3438" data-xy="0-1220: width_box">
        <div class="padding_px-u_050 grid_xx font_px_016 line_height_150" data-xx="1fr 1fr 1fr" data-xy="0-600: xx-1ft, 601-1220: xx-1fr-1fr">
            
            <?php if (isset($sql_board[0])): ?>
                <?php foreach ($sql_board[0] as $board_row): ?>
                    <?php
                        // 게시물 데이터 JSON을 파싱하여 첫 번째 배열의 타이틀과 이미지 가져오기
                        $post_data = json_decode($board_row['board_data'], true);
                        $post_info = print_first_array_title_and_image($post_data);
                        
                        // 유저 정보 가져오기
                        $query_user = "
                            SELECT * FROM egb_user 
                            WHERE uniq_id = :user_uniq_id
                        ";
                        $params_user = [
                            ':user_uniq_id' => $board_row['board_user_uniq_id']
                        ];
                        $binding_user = binding_sql(1, $query_user, $params_user);
                        $sql_user = egb_sql($binding_user);

                        $user_name = isset($sql_user[0]['user_name']) ? $sql_user[0]['user_name'] : '관리자';
                    ?>

                    <a href="<?php echo DOMAIN.'/page/manual_board_view/?uniq_id='.$board_row['uniq_id']; ?>">
                        <div class="padding_px-a_010">
                            <div class="height_px_280 pointer">
                                <img class="border_bre-a_004 width_box height_px_280"
                                     src="<?php echo DOMAIN . $post_info['image']; ?>"
                                     style="object-fit: cover;">
                            </div>
                            <div class="flex_ft padding_px-t_010 pointer">
                                <div class="font_px_016 flv6 hidetext" data-color="#222222">
                                    <?php echo htmlspecialchars($post_info['title']); ?>
                                </div>
                                <div class="flex_fl_yc padding_px-t_010 font_px_014">
                                    <div class="flex_fl_yc">
                                        <div class="flex_yc padding_px-r_005">
                                            <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                                                class="width_px_025 height_px_025 border_bre-a_020">
                                        </div>
                                        <div class="flex_yc flv6"><?php echo htmlspecialchars($user_name); ?></div>
                                    </div>
                                    <div class="">｜</div>
                                    <div><?php echo htmlspecialchars($post_info['manual_category']); ?></div>
                                    <div>｜</div>
                                    <div><?php echo htmlspecialchars($post_info['manual_worker']); ?>명</div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>등록된 게시물이 없습니다.</p>
            <?php endif; ?>
            
        </div>
    </div>
</section>
<style>
    .hidetext {
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>