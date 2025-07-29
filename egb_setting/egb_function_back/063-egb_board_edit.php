<?php

function egb_board_edit($board_name) {
	
    $query4 = "SELECT * FROM egb_board_mangement WHERE board_mangement_table_board_name = :board_mangement_table_board_name";
    $param4 = [':board_mangement_table_board_name' => 'egb_board_'.$board_name];
    $binding4 = binding_sql(1, $query4, $param4);
    $sql4 = egb_sql($binding4);
	
	if(isset($sql4[0]['board_mangement_board_themes'])){
		require_once ROOT.'/egb_setting/egb_board/themes/'.$sql4[0]['board_mangement_board_themes'].'/egb_board_edit.php';
	}else{
		require_once ROOT.'/egb_setting/egb_board/themes/default/egb_board_edit.php';
	}
}
?>
