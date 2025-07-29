<?php

function egb_page_seo_db_insert($seo_uniq_id, $seo_title, $seo_subject, $seo_description, $seo_keywords, $seo_robots, $seo_canonical, $seo_og_title, $seo_og_description, $seo_og_img, $seo_author, $seo_publish_date, $seo_last_modified_at){

$query = "INSERT INTO egb_seo (seo_uniq_id, seo_title, seo_subject, seo_description, seo_keywords, seo_robots, seo_canonical, seo_og_title, seo_og_description, seo_og_img, seo_author, seo_publish_date, seo_last_modified_at) VALUES (:seo_uniq_id, :seo_title, :seo_subject, :seo_description, :seo_keywords, :seo_robots, :seo_canonical, :seo_og_title, :seo_og_description, :seo_og_img, :seo_author, :seo_publish_date, :seo_last_modified_at)";
$param = [
	
	':seo_uniq_id' => $seo_uniq_id,
	':seo_title' => $seo_title,
	':seo_subject' => $seo_subject,
	':seo_description' => $seo_description,
	':seo_keywords' => $seo_keywords,
	':seo_robots' => $seo_robots,
	':seo_canonical' => $seo_canonical,
	':seo_og_title' => $seo_og_title,
	':seo_og_description' => $seo_og_description,
	':seo_og_img' => $seo_og_img,
	':seo_author' => $seo_author,
	':seo_publish_date' => $seo_publish_date,
	':seo_last_modified_at' => $seo_last_modified_at
	
	];

$binding = binding_sql(2, $query, $param);
$sql = egb_sql($binding);


return $sql[0];

}

?>