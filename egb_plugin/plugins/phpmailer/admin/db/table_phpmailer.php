<?php

function table_phpmailer(){

$query_db = "
CREATE TABLE egb_phpmailer(
no INT NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '순번',
phpmailer_uniq_id VARCHAR(255) COMMENT '고유식별자',
phpmailer_to VARCHAR(255) COMMENT '받는사람',
phpmailer_cc VARCHAR(255) COMMENT '침조',
phpmailer_bcc VARCHAR(255) COMMENT '숨은참조',
phpmailer_from VARCHAR(255) COMMENT '보낸사람',
phpmailer_title VARCHAR(255) COMMENT '메일제목',
phpmailer_contents LONGTEXT COMMENT '메일내용',
phpmailer_date VARCHAR(255) COMMENT '메일보낸시간'
);
";

return $query_db;

}

?>