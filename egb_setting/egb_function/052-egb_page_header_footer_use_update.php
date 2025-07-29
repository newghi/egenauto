<?php
function egb_page_header_footer_use_update($page_name, $header_use = 0, $footer_use = 0) {
    $query = "
    UPDATE egb_page
    SET 
        setting_header_use = :header_use,
        setting_footer_use = :footer_use
    WHERE page_name = :page_name
    ";
    $params = [
        ':header_use' => $header_use,
        ':footer_use' => $footer_use,
        ':page_name' => $page_name
    ];
    $binding = binding_sql(2, $query, $params);
    return egb_sql($binding);
}
?>
