<?php

// 플러그인 파일 로드
function egb_plugin_file_load(){
	
// 플러그인 폴더 경로
$plugin_path = ROOT . SITE_PLUGIN . DS . 'plugins';

// 폴더가 존재하는지 확인
if (is_dir($plugin_path)) {
	// 폴더가 존재하는 경우.
	$plugin_folders = glob($plugin_path . DS . '*', GLOB_ONLYDIR); // 폴더만 가져오기

	foreach ($plugin_folders as $folder) {
		// 각 폴더명을 가져와서 사용하거나 처리합니다.
		$plugin_name = basename($folder);
		
		if (file_exists($plugin_path . DS . $plugin_name . DS . "index.php")){
			
			require_once $plugin_path . DS . $plugin_name . DS . "index.php";
			
		}else{
			
			// 플러그인 index.php 파일이 없는 경우
			$path = DS . SITE_PLUGIN . DS . "plugins" . DS . $plugin_name . DS;
			$name = "index.php";
			$contents = '
<?php

// 현재 실행 중인 스크립트 파일의 디렉토리 경로를 가져옴
$current_folder = __DIR__;

// 폴더명만 가져옴
$plugin_name = basename($current_folder);

if (file_exists(ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/plugin_check.php")){
	
	$plugin_check = file_get_contents(ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/plugin_check.php");
	
	if ($plugin_check and $plugin_check === "4"){
		
		// 사용인 경우
		if (file_exists(ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/" . $plugin_name . "_function.php")){
			
			// function 파일을 로드 한다.
			require_once ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/" . $plugin_name . "_function.php";
			
		}else{
			
			// function 파일이 없는 경우
		}
		
		
	}else{
		
		// 사용하지 않는 경우
	}
	
	if ($plugin_check and $plugin_check === "2"){
		
		// 사용인 경우
		if (file_exists(ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/admin/db/table_" . $plugin_name . ".php")){
			
			// function 파일을 로드 한다.
			require_once ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/admin/db/table_" . $plugin_name . ".php";
			
		}else{
			
			// function 파일이 없는 경우
		}
		
	}else{
		
		// 사용하지 않는 경우
	}
	
	if ($plugin_check and $plugin_check === "5"){
		
		// 사용인 경우
		if (file_exists(ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/" . $plugin_name . "_setting.php")){
			
			// function 파일을 로드 한다.
			require_once ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/" . $plugin_name . "_setting.php";
			
		}else{
			
			// function 파일이 없는 경우
		}
		
	}else{
		
		// 사용하지 않는 경우
	}
	
	if ($plugin_check and $plugin_check === "1"){
		
		
		// 사용인 경우
		if (file_exists(ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/admin/db/table_" . $plugin_name . ".php")){
			
			// function 파일을 로드 한다.
			require_once ROOT . SITE_PLUGIN . "/plugins/" . $plugin_name . "/admin/db/table_" . $plugin_name . ".php";
			
		}else{
			
			// function 파일이 없는 경우
		}
		
	}else{
		
		// 사용하지 않는 경우
	}
	
}else{
	// 파일이 존재 하지 않는 경우
	// 1 : 미설치 2: 연동 3: 꺼짐상태 3: 켜진상태
	$path = "/" . SITE_PLUGIN . "/plugins/" . $plugin_name . "/";
	$name = "plugin_check.php";
	$contents = "1";

	egb_upload($path, $name, $contents); 
}

?>';
			
			egb_upload($path, $name, $contents); 
		}
		
	}
} else {
	// 폴더가 존재하지 않는 경우. 이 주석 아래에서 처리
}

}

?>