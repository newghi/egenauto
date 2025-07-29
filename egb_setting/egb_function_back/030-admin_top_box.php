<?php
function admin_top_box(){
	if (ADMIN_TOP_BOX === true and isset($_SESSION['admin_login']) and $_SESSION['admin_login'] === 'Y') {
		// 어드민박스 출력
		echo '<div class="admin-box" style="width: 100%; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; align-items: center; position: fixed; bottom: 0; gap: 50px; background-color: #a9a9a999; height: 30px;
 z-index: 9999;"><div><a class="pointer" style="color: inherit;text-decoration: none;" href="' .DOMAIN . '">홈 페이지</a></div><div><a class="pointer" style="color: inherit;text-decoration: none;" href="' .DOMAIN . '/admin/page">관리자 페이지</a></div></div>';
	}
}

?>