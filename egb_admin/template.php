<?php

$template_id = egb('id');
$template_path = egb('path');
$template_path = preg_replace('/^[\/\\\\]/', '', $template_path);

echo '<template id='.$template_id.'>';

if (file_exists(ROOT.DS.'egb_admin'.DS.$template_path.'.php')){

	require_once ROOT.DS.'egb_admin'.DS.$template_path.'.php';

}

echo '</template>';

exit;
?>