<?php
function egb_video(){
//post 파라미터에 대한 페이지 출력 form에서 전달되는 경우에만 반응 하도록 한다.
$video = gpos_var('video');
	if (isset($video)){
		$query = "SELECT * FROM egb_video WHERE page_name = :page_name";
		$param = [':page_name' => $video];
		$binding = binding_sql(0, $query, $param);
		
		$sql = egb_sql($binding);
		
		if (isset($sql[0])){
		
		//같은 이름이 여러개인 경우 일 수도.
		foreach ($sql[0] as $row) {
			
			// 테마에 따라 적용되는 이미지
			if ($row['page_source'] === 'theme_'.THEMES_NAME){
				
				if (isset($row['page_use']) and $row['page_use'] === "사용"){
					
					if (isset($row['page_type']) and $row['page_type'] === "html"){echo $row['page_path'];}
					if (isset($row['page_type']) and $row['page_type'] === "php"){eval($row['page_path']);}
					if (isset($row['page_type']) and $row['page_type'] === "path"){
						
						$video_path = ROOT . $row['page_path'];
						
						// 파일이 존재하는지 확인
						if (!file_exists($video_path)){
							
							echo "파일을 찾을 수 없습니다: "; exit;
							
						}
						
							if (pathinfo($video_path, PATHINFO_EXTENSION) === "mp4") {
								
								// Content-Type 헤더 설정
								header("Cache-Control: max-age=36000");
								header("Content-Type: video/mp4");
								
							}else{echo "유효한 동영상 파일이 아닙니다: "; exit;}

						
						// 이미지 데이터 출력
						readfile($video_path); exit;
						
					}else{}
					
				}else{echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>'; exit;}
				
			}else{
				
				if (isset($row['page_use']) and $row['page_use'] === "사용"){
					
					if (isset($row['page_type']) and $row['page_type'] === "html"){echo $row['page_path'];}
					if (isset($row['page_type']) and $row['page_type'] === "php"){eval($row['page_path']);}
					if (isset($row['page_type']) and $row['page_type'] === "path"){
						
						$video_path = ROOT . $row['page_path'];
						
						// 파일이 존재하는지 확인
						if (!file_exists($video_path)){
							
							echo "파일을 찾을 수 없습니다: "; exit;
							
						}
						
							if (pathinfo($video_path, PATHINFO_EXTENSION) === "mp4") {
								
								// Content-Type 헤더 설정
								header("Cache-Control: max-age=36000");
								header("Content-Type: video/mp4");
								
							}else{echo "유효한 이미지 파일이 아닙니다zz: "; exit;}
							
						
						// 비디오 데이터 출력
						readfile($video_path); exit;
						
					}else{}
					
				}else{echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>'; exit;}
			}
			
		}
		
		}else{echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 올바른 경로가 아니거나, 없는 페이지 입니다.</div>'; exit;}
		
	}else{
		
	}
	
}

?>