<?php
function egb_short_url_insert($board_id, $short_url_table_board_name, $long_url, $short_url, $route_short_url, $number_url, $route_number_url, $slug_url, $route_slug_url) {
    $uniq_id = uniqid();
    $current_date = date('Y-m-d H:i:s');
    
    $query = "
    INSERT INTO egb_short_url (
        short_url_uniq_id, short_url_table_board_name, short_url_board_id, short_url_long_url, short_url_short_url, 
        short_url_route_short_url, short_url_number_url, short_url_route_number_url, 
        short_url_slug_url, short_url_route_slug_url, short_url_etc1, short_url_etc2, 
        short_url_etc3, short_url_etc4, short_url_etc5, short_url_etc6, short_url_etc7, 
        short_url_etc8, short_url_etc9, short_url_publish_date, short_url_last_modified_at
    ) VALUES (
        :short_url_uniq_id, :short_url_table_board_name, :short_url_board_id, :short_url_long_url, :short_url_short_url, 
        :short_url_route_short_url, :short_url_number_url, :short_url_route_number_url, 
        :short_url_slug_url, :short_url_route_slug_url, :short_url_etc1, :short_url_etc2, 
        :short_url_etc3, :short_url_etc4, :short_url_etc5, :short_url_etc6, :short_url_etc7, 
        :short_url_etc8, :short_url_etc9, :short_url_publish_date, :short_url_last_modified_at
    )";
    
    $params = [
        ':short_url_uniq_id' => $uniq_id,
		':short_url_table_board_name' => $short_url_table_board_name,
        ':short_url_board_id' => $board_id,
        ':short_url_long_url' => $long_url,
        ':short_url_short_url' => $short_url,
        ':short_url_route_short_url' => $route_short_url,
        ':short_url_number_url' => $number_url,
        ':short_url_route_number_url' => $route_number_url,
        ':short_url_slug_url' => $slug_url,
        ':short_url_route_slug_url' => $route_slug_url,
        ':short_url_etc1' => null,
        ':short_url_etc2' => null,
        ':short_url_etc3' => null,
        ':short_url_etc4' => null,
        ':short_url_etc5' => null,
        ':short_url_etc6' => null,
        ':short_url_etc7' => null,
        ':short_url_etc8' => null,
        ':short_url_etc9' => null,
        ':short_url_publish_date' => $current_date,
        ':short_url_last_modified_at' => $current_date
    ];

    $binding = binding_sql(2, $query, $params);
    $result = egb_sql($binding);

    return $result[0];
}
?>
