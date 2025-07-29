<?php

function egb_member_sign_up($themes = 'default') {
	
	//로그인중인지 세션 체크
	if (isset($_SESSION['egb_member_uniq_id'])){
		//로그인 상태
		redirect(DOMAIN); exit;
	}else{
		//로그인이 아닌 상태
		if($themes != 'default'){
			require_once ROOT.'/egb_setting/egb_member/themes/'.$themes.'/egb_member_sign_up.php';
		}else{
			require_once ROOT.'/egb_setting/egb_member/themes/default/egb_member_sign_up.php';
		}
	}
}
?>
