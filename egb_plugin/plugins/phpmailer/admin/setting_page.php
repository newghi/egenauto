<?php
$plugin_name = $_GET['admin'] ?? null;

//데이터베이스 테이블에 egb_board 가 존재하는지 확인
$sql = "SELECT * FROM egb_phpmailer LIMIT 1";
$binding = binding_sql(0, $sql);
$result = egb_sql($binding);

// 아래 조건문을 통해 결과값이 false가 아니라면 있는 것으로 간주하고 데이터베이스 연결관련 폼은 출력 하지 않는다.
?>
<div class="margin_x_auto max_width_1900 height_box">
	
	<?php if ($result !== false){}else{ ?>
	
	<div class="min_height_100 margin_me-a_010">
		<div class="width_box border_be-l_005 border_bre-ly_005 shadow1" data-bd-l-color="#ffa500">
			<div class="padding_pe-x_010">
				<div class="flex_ font_fe_016 flv6 padding_pe-y_010">
					<div>데이터베이스 연동</div>
					<div class="tip_box flex_xc_yc padding_pe-x_010 pointer">
						<div class="tip">플러그인을 사용하기 위해서 데이터베이스 연동을 해야 합니다.</div>
						<svg class="px_width_020 px_height_020" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000">
							<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							<path d="M9 9c0-3.5 5.5-3.5 5.5 0 0 2.5-2.5 2-2.5 5M12 18.01l.01-.011" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
					</div>
				</div>
				<form id="site_plugin_db" class="padding_pe-y_010"  name="site_plugin_db" action="<?php echo DOMAIN . '/?post=' . $plugin_name . '_input'; ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="plugin_name" value="<?php echo $plugin_name; ?>" />
					<input class="font_fe_012" type="submit" value="연동하기" />
				</form>
			</div>
		</div>
	</div>
	<?php exit;} ?>
	
	<div class="min_height_100 margin_me-a_010">
		<div class="width_box border_be-l_005 border_bre-ly_005 shadow1" data-bd-l-color="#ffa500">
			<div class="padding_pe-x_010">
				<div class="flex_ font_fe_016 flv6 padding_pe-y_010">
					<div>이메일 관리</div>
					<div class="tip_box flex_xc_yc padding_pe-x_010 pointer">
						<div class="tip">이메일을 관리 합니다. 플러그인을 킨 상태에서 이용 해주세요.</div>
						<svg class="px_width_020 px_height_020" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000">
							<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							<path d="M9 9c0-3.5 5.5-3.5 5.5 0 0 2.5-2.5 2-2.5 5M12 18.01l.01-.011" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
					</div>
				</div>
				<?php
				$cleaned_name = str_replace("plugin_", "", $plugin_name);
					require_once ROOT . SITE_PLUGIN . DS . "plugins" . DS . $cleaned_name . DS . "admin" . DS . "page" . DS . "setting_page.php";
				
				?>
			</div>
		</div>
	</div>
</div>
