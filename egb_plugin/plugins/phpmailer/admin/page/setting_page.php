<?php
$plugin_name = $_GET['admin'] ?? null;
?>
<form id="plgin_phpmailer" class="padding_pe-y_010" name="plgin_phpmailer" action="<?php echo DOMAIN . '/?post=plugin_phpmailer_constant_input'; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="plugin_name" value="<?php echo $plugin_name; ?>" />
	<div class="padding_pe-y_005">이메일</div>
	<?php
	if (defined('PLUGIN_PHPMAILER_EMAIL')){

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="email" name="PLUGIN_PHPMAILER_EMAIL" value="' . PLUGIN_PHPMAILER_EMAIL . '" placeholder="이메일 주소를 입력 하세요." required>';

	}else{

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="email" name="PLUGIN_PHPMAILER_EMAIL" value="" placeholder="이메일 주소를 입력 하세요." required>';

		}
	?>
	<div class="padding_pe-y_005">이메일 비밀번호</div>
	<?php
	if (defined('PLUGIN_PHPMAILER_EMAIL_PASSWORD')){

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="password" name="PLUGIN_PHPMAILER_EMAIL_PASSWORD" value="' . PLUGIN_PHPMAILER_EMAIL_PASSWORD . '" placeholder="이메일 비밀번호를 입력 하세요." required>';

	}else{

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="password" name="PLUGIN_PHPMAILER_EMAIL_PASSWORD" value="" placeholder="이메일 비밀번호를 입력 하세요." required>';

		}
	?>
	<div class="padding_pe-y_005">호스트</div>
	<?php
	if (defined('PLUGIN_PHPMAILER_HOST')){

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="text" name="PLUGIN_PHPMAILER_HOST" value="' . PLUGIN_PHPMAILER_HOST . '" placeholder="이메일 호스트를 입력 하세요." required>';

	}else{

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="text" name="PLUGIN_PHPMAILER_HOST" value="" placeholder="이메일 호스트를 입력 하세요." required>';

		}
	?>
	<div class="padding_pe-y_005">SMTP유형</div>
	<?php
	if (defined('PLUGIN_PHPMAILER_SMTP_SECURE')){
		
		if (defined('PLUGIN_PHPMAILER_SMTP_SECURE') and (PLUGIN_PHPMAILER_SMTP_SECURE === 'ssl')){$ssl = 'selected';}else{$ssl = '';}
		if (defined('PLUGIN_PHPMAILER_SMTP_SECURE') and (PLUGIN_PHPMAILER_SMTP_SECURE === 'tls')){$tls = 'selected';}else{$tls = '';}
		
		echo '<select class="padding_pe-a_005 width_box box_sizing" name="PLUGIN_PHPMAILER_SMTP_SECURE" required>';
		echo '<option value="ssl" '.$ssl.'>ssl</option>';
		echo '<option value="tls" '.$tls.'>tls</option>';
		echo '</select>';

	}else{
		
		echo '<select class="padding_pe-a_005 width_box box_sizing" name="PLUGIN_PHPMAILER_SMTP_SECURE" required>';
		echo '<option value="ssl">ssl</option>';
		echo '<option value="tls">tls</option>';
		echo '</select>';

		}
	?>
	<div class="padding_pe-y_005">포트</div>
	<?php
	if (defined('PLUGIN_PHPMAILER_PORT')){

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="text" name="PLUGIN_PHPMAILER_PORT" value="' . PLUGIN_PHPMAILER_PORT . '" placeholder="이메일 포트 번호를 입력 하세요." required>';

	}else{

		echo '<input class="padding_pe-a_005 width_box box_sizing px_height_030" type="text" name="PLUGIN_PHPMAILER_PORT" value="" placeholder="이메일 포트 번호를 입력 하세요." required>';

		}
	?>
	<br><br>
	<input class="font_fe_012" type="submit" value="설정하기" />
</form>