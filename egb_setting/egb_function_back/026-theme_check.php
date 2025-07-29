<?php

function theme_check(){

$check = "theme_".THEMES_NAME;

$query = "SELECT * FROM egb_page WHERE page_source = :page_source LIMIT 1";
$param = [':page_source' => $check];
$binding = binding_sql(1, $query, $param);

$sql = egb_sql($binding);

if (isset($sql[0]['page_source'])){return true;}else{return false;}

}

?>