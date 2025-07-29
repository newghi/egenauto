<?php

// 개별 페이지 직접 접근 차단
if (!defined('_EUNGABI_')) {

    // 프로토콜 상수 설정
    if (!defined('PROTOCOL')) {
        $isHttps = (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        );
        define('PROTOCOL', $isHttps ? 'https://' : 'http://');
    }

    // 리디렉션 방식 (조용히 루트로 이동)
    header("Location: " . PROTOCOL . $_SERVER['HTTP_HOST']);
    exit;

    // 또는 403 Forbidden 방식
    // http_response_code(403);
    // exit;
}
//if (!isset($_SESSION['setting_ip'])) {echo "사이트 세팅 중입니다."; exit;}// 라이선스 인증한 ip만 다음 스텝에 올 수 있음

?>
<!DOCTYPE html>
<html lang='ko' style=" height: 100%; display: grid; ">
	<head>
		<!-- 기본 메타 -->
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta name='Title' content=">Head setting">
		<meta name='Subject' content=">Head setting">
		<meta name='description' content=">Head setting">
		<meta name='author' content="Eungabi">
		<meta name='Publisher' content='Eungabi'>
		<meta name='robots' content='none'>
		<meta name='keyword' content="Head, setting">
		<link rel='icon' href='<?php echo DOMAIN.'/favicon.ico'; ?>' sizes='32x32'>
		<style>
		  @charset "UTF-8";

		  html {
		    height: 100%;
		    display: grid;
		  }

		  body {
		    margin: auto;
		    padding: 0;
		    background-color: #f5f5f5;
		    font-family: Arial, sans-serif;
		  }

		  .container {
		    width: 100%;
		    max-width: 600px;
		    margin: 0 auto;
		    padding: 20px;
		    background-color: #fff;
		    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
		  }

		  h1 {
		    margin: 0;
		    font-size: 28px;
		    font-weight: bold;
		    text-align: center;
		  }

		  p {
		    margin: 10px 0;
		    font-size: 16px;
		    line-height: 1.5;
		  }

		  form {
		    margin: 20px 0;
		    padding: 20px;
		    background-color: #f5f5f5;
		    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		  }

		  label {
		    display: block;
		    font-size: 16px;
		    font-weight: bold;
		    margin-bottom: 5px;
		  }

		  input[type="text"],
		  input[type="password"] {
		    display: block;
		    width: 100%;
		    max-width: 500px;
		    height: 40px;
		    padding: 5px 10px;
		    font-size: 16px;
		    border: 2px solid #ccc;
		    border-radius: 4px;
		    box-sizing: border-box;
		    margin-bottom: 10px;
		  }

		  button {
		    display: inline-block;
		    padding: 10px 20px;
		    width: 100%;
		    font-size: 16px;
		    font-weight: bold;
		    color: #fff;
		    background-color: #006060;
		    border: none;
		    border-radius: 4px;
		    cursor: pointer;
		    transition: background-color 0.3s ease;
		  }

		  button:hover {
		    background-color: #005B9E;
		  }

		  #submit-btn {
		    display: none;
		  }

		  #status-msg {
		    margin-top: 20px;
		    font-size: 16px;
		    color: red;
		  }

		  #overlay {
		    position: fixed;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		    background-color: rgba(0, 0, 0, 0.5);
		    display: none;
		  }

		  #overlay .message {
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    transform: translate(-50%, -50%);
		    color: white;
		    font-size: 24px;
		  }

		  .progress {
		    width: 100%;
		    height: 10px;
		    background-color: #ddd;
		  }

		  .progress-bar {
		    height: 100%;
		    background-color: #006060;
		    width: 0%;
		  }
		</style>
		<title>Head setting</title>
	</head>
	<body style=" display: flex; align-items: center;">
		<div>
			<h1>3단계 - Head setting</h1>
			<p>head에 들어가는 메타정보는 SEO에서 중요한 정보 입니다.</p>
			<p>해당 세팅은 기본값이되며, 세팅 후에는 동적으로 작동 합니다.</p>
			<p>메타정보 - 키워드의 구분은 스페이스바로 합니다.</p>
			<p>보안에 위협이 되는 일부 특수 기호나 단어는 사용 할 수 없습니다.</p>
			<form method="post" action = '<?php echo DOMAIN; ?>/?setting=head_input'>
				<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
				<div>메타정보 - 제목</div><div><input type="text" name="seo_title" placeholder="사이트의 메타정보에 표시될 기본 제목" required='required' /></div>
				<div>메타정보 - 주제</div><div><input type="text" name="seo_subject" placeholder="사이트의 메타정보에 표시될 기본 주제" required='required' /></div>
				<div>메타정보 - 설명</div><div><input type="text" name="seo_description" placeholder="사이트의 메타정보에 표시될 기본 설명" required='required' /></div>
				<div>메타정보 - 작성자</div><div><input type="text" name="seo_author" placeholder="사이트의 메타정보에 표시될 기본 작성자" required='required' /></div>
				<div>메타정보 - 키워드</div><div><input type="text" name="seo_keywords" placeholder="사이트의 메타정보에 표시될 기본 키워드" required='required' /></div>
				<div>사이트명</div><div><input type="text" name="page_title" placeholder="사이트를 대표하는 사이트명" required='required' /></div>
				<div><button type='submit' id='submit-setting'>세팅하기</button></div>
			</form>
		</div>
	</body>
