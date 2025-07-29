<?php
// 코어파일을 로드 할때 사용.
function egb_load($path){
	
	$root_path = ROOT . $path;
	
	if (file_exists($root_path)) {
		
		require_once $root_path;
		
		
	} else if (file_exists( ROOT . DS . 'egb_site-check.php')) {
		
		echo '세팅에 필요한 '.$root_path.' 파일이 없습니다.';
		
		
	} else if (!file_exists( ROOT . DS . 'egb_site-check.php')) {
		
		$path = DS;
		$name = 'egb_site-check.php';
		$contents = '<?php define(\'SITE_CHECK\', \'0\'); ?>';
		egb_upload($path, $name, $contents);
		
		redirect(DOMAIN);
		
	}
}//egb_load($path);

?>