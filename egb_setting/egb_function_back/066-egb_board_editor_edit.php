<?php

function egb_board_editoer_edit($board_name) {
	
    $query4 = "SELECT * FROM egb_board_mangement WHERE board_mangement_table_board_name = :board_mangement_table_board_name";
    $param4 = [':board_mangement_table_board_name' => 'egb_board_'.$board_name];
    $binding4 = binding_sql(1, $query4, $param4);
    $sql4 = egb_sql($binding4);
	
	$_POST['editore_board_name'] = $board_name;
	$_POST['board_mangement_board_write_after_page'] = $sql4[0]['board_mangement_board_write_after_page'];
	
	if(isset($sql4[0]['board_mangement_board_editor'])){
		require_once ROOT.'/egb_setting/egb_board/editor/'.$sql4[0]['board_mangement_board_editor'].'/egb_board_editoer_edit.php';
	}else{
		require_once ROOT.'/egb_setting/egb_board/editor/smarteditor2/egb_board_editoer_edit.php';
	}
}
?>
