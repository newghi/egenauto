<?php
function egb_constant_2_delete(){
	// 사이트 체크의 번호가 0 또는 1 인 경우에는 데이터 베이스 생성전 이므로 기초 파일을 초기화 시킨다.
	//폴더 경로
	$folder_path = ROOT . DS . 'egb_setting' . DS . 'egb_constant_2'; 
	// 경로 내 폴더가 있는지 확인
	if (file_exists($folder_path)){
		// 폴더 내 파일 목록을 가져옴
		$files = glob($folder_path . DS . '*');
		// 각 파일을 하나씩 삭제
		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
	}else{}
	//시작시 불필요한 파일들 삭제
	if (file_exists(ROOT . DS . 'robots.txt')){unlink(ROOT . DS . 'robots.txt');}else{}
	if (file_exists(ROOT . DS . 'sitemap.txt')){unlink(ROOT . DS . 'sitemap.txt');}else{}
	if (file_exists(ROOT . DS . 'sitemap.xml')){unlink(ROOT . DS . 'sitemap.xml');}else{}
	if (file_exists(ROOT . DS . 'egb_cron.log')){unlink(ROOT . DS . 'egb_cron.log');}else{}
	if (file_exists(ROOT . DS . 'egb_error.log')){unlink(ROOT . DS . 'egb_error.log');}else{}
	if (file_exists(ROOT . DS . 'unknown_devices.log')){unlink(ROOT . DS . 'unknown_devices.log');}else{}
	if (file_exists(ROOT . DS . 'egb_setting' . DS . 'egb_default' . DS . 'egb_head.php')){unlink(ROOT . DS . 'egb_setting' . DS . 'egb_default' . DS . 'egb_head.php');}else{}
	//폴더 경로
	$plugin_path = ROOT . DS . 'egb_plugin' . DS . 'plugins'; 
	// 경로 내 폴더가 있는지 확인
	if (file_exists($plugin_path)){
		// 폴더 내 플러그인 목록을 가져옴
		$folders = array_filter(glob($plugin_path . DS . '*'), 'is_dir');
		// 가져온 폴더 목록을 출력 또는 처리
		foreach ($folders as $folder) {
			$plugin_name = basename($folder);
			$plugin_path = ROOT . DS . 'egb_plugin' . DS . 'plugins' . DS . $plugin_name . DS . 'plugin_check.php';
			//$plugin_check 파일 삭제
			if (is_file($plugin_path)) {
				unlink($plugin_path);
			}
		}
		
	}else{}
	// 폴더 경로
	$plugin_constant_path = ROOT . DS . 'egb_plugin' . DS . 'plugins'; 
	// 경로 내 폴더가 있는지 확인
	if (file_exists($plugin_constant_path)){
		// 폴더 내 플러그인 목록을 가져옴
		$constant_folders = array_filter(glob($plugin_constant_path . DS . '*'), 'is_dir');
		// 가져온 폴더 목록을 출력 또는 처리
		foreach ($constant_folders as $constant_folder) {
			$plugin_constant_name = basename($constant_folder);
			$specific_constant_path = $constant_folder . DS . 'constant';
			// 'constant' 폴더 내의 모든 파일을 가져옴
			$constant_files = glob($specific_constant_path . DS . '*');
			// 각 파일을 순회하며 삭제
			foreach ($constant_files as $constant_file) {
				if (is_file($constant_file)) {
					unlink($constant_file);
				}
			}
		}
	}else{}
	// 폴더 경로
	$egb_download_path = ROOT . DS . 'egb_setting' . DS . 'egb_download';
	// 경로 내 폴더가 있는지 확인
	if (file_exists($egb_download_path)) {
		// 경로 내의 모든 파일과 폴더를 가져옴
		$items = array_filter(glob($egb_download_path . DS . '*'));
		
		// 모든 파일과 폴더를 순회하며 삭제
		foreach ($items as $item) {
			if (is_file($item)) {
				// 파일인 경우 삭제
				unlink($item);
			} elseif (is_dir($item)) {
				// 폴더인 경우 폴더 내의 모든 파일을 삭제
				$files = glob($item . DS . '*');
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}
				// 폴더 자체도 삭제
				rmdir($item);
			}
		}
	} else {}
	// 폴더 경로
	$egb_resource_path = ROOT . DS . 'egb_setting' . DS . 'egb_resource';
	// 경로 내 폴더가 있는지 확인
	if (file_exists($egb_resource_path)) {
		// 경로 내의 모든 파일과 폴더를 가져옴
		$items = array_filter(glob($egb_resource_path . DS . '*'));
		
		// 모든 파일과 폴더를 순회하며 삭제
		foreach ($items as $item) {
			if (is_file($item)) {
				// 파일인 경우 삭제
				unlink($item);
			} elseif (is_dir($item)) {
				// 폴더인 경우 폴더 내의 모든 파일을 삭제
				$files = glob($item . DS . '*');
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}
				// 폴더 자체도 삭제
				rmdir($item);
			}
		}
	} else {}
	// 폴더 경로
	$egb_cache_path = ROOT . DS . 'egb_cache';
	// 경로 내 폴더가 있는지 확인
	if (file_exists($egb_cache_path)) {
		// 경로 내의 모든 파일과 폴더를 가져옴
		$items = array_filter(glob($egb_cache_path . DS . '*'));
		
		// 모든 파일과 폴더를 순회하며 삭제
		foreach ($items as $item) {
			if (is_file($item)) {
				// 파일인 경우 삭제
				unlink($item);
			} elseif (is_dir($item)) {
				// 폴더인 경우 폴더 내의 모든 파일을 삭제
				$files = glob($item . DS . '*');
				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}
				// 폴더 자체도 삭제
				rmdir($item);
			}
		}
	} else {}
	// 폴더 경로
	$egb_sitemap_path = ROOT . DS . 'egb_sitemap';
	// 경로 내 폴더가 있는지 확인
	if (file_exists($egb_sitemap_path)) {
		// 경로 내의 모든 파일과 폴더를 가져옴
		$items = array_filter(glob($egb_sitemap_path . DS . '*'));
		
		// 모든 파일과 폴더를 순회하며 삭제
		foreach ($items as $item) {
			if (is_file($item)) {
				// 파일인 경우 삭제
				unlink($item);
			} elseif (is_dir($item)) {
				// 폴더인 경우 폴더와 그 내용을 재귀적으로 삭제
				$iterator = new RecursiveDirectoryIterator($item, RecursiveDirectoryIterator::SKIP_DOTS);
				$files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
				
				foreach($files as $file) {
					if ($file->isDir()) {
						rmdir($file->getRealPath());
					} else {
						unlink($file->getRealPath());
					}
				}
				// 빈 폴더 삭제
				rmdir($item);
			}
		}
	} else {}

	// 데이터베이스 삭제
	if (EGB_DEV_MODE == true && defined('DB_HOST') && defined('DB_USER') && defined('DB_PASSWORD') && defined('DB_NAME')) {
		try {
			$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			if (defined('CMS_TYPE') && CMS_TYPE === 'egb') {
				// egb CMS인 경우 전체 데이터베이스 삭제
				$pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASSWORD);
				$pdo->exec("DROP DATABASE IF EXISTS " . DB_NAME);
			} else if (defined('CMS_TYPE') && CMS_TYPE === 'wordpress') {
				// WordPress인 경우 egb_ 접두사 테이블만 삭제
				$tables = $pdo->query("SHOW TABLES LIKE 'egb_%'")->fetchAll(PDO::FETCH_COLUMN);
				foreach ($tables as $table) {
					$pdo->exec("DROP TABLE IF EXISTS `$table`");
				}
			}
		} catch (PDOException $e) {
			error_log("데이터베이스 삭제 중 오류 발생: " . $e->getMessage());
		}
	}
}
?>