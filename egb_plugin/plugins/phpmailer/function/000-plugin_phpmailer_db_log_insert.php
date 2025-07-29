<?php

function plugin_phpmailer_db_log_insert($to, $cc, $bcc, $from, $title, $contents){
	//처음 4자리를 제외한 아이디
	$uniq_id = substr(uniqid(), 4);
	$date = date('Y-m-d H:i:s');

$query = "INSERT INTO egb_phpmailer" . " (phpmailer_uniq_id, phpmailer_to, phpmailer_cc, phpmailer_bcc, phpmailer_from, phpmailer_title, phpmailer_contents, phpmailer_date) VALUES (:phpmailer_uniq_id, :phpmailer_to, :phpmailer_cc, :phpmailer_bcc, :phpmailer_from, :phpmailer_title, :phpmailer_contents, :phpmailer_date)";
$param = [
	
	':phpmailer_uniq_id' => $uniq_id,
	':phpmailer_to' => $to,
	':phpmailer_cc' => $cc,
	':phpmailer_bcc' => $bcc,
	':phpmailer_from' => $from,
	':phpmailer_title' => $title,
	':phpmailer_contents' => $contents,
	':phpmailer_date' => $date
	
	];

$binding = binding_sql(2, $query, $param);
$sql = egb_sql($binding);


return $sql[0];

}

?>