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
<html lang='ko'>
	<head>
		<!-- 기본 메타 -->
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta name='Title' content=">DB setting">
		<meta name='Subject' content=">DB setting">
		<meta name='description' content=">DB setting">
		<meta name='author' content="Eungabi">
		<meta name='Publisher' content='Eungabi'>
		<meta name='robots' content='none'>
		<meta name='keyword' content="DB, setting">
		<link rel='icon' href='<?php echo DOMAIN.'/favicon.ico'; ?>' sizes='32x32' defer>
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
		<script nonce="<?php echo NONCE; ?>">
		function showLoading() {
			var overlay = document.getElementById('overlay');
			overlay.style.display = 'block';
			var progressBar = document.querySelector('.progress-bar');
			var width = 0;
			var interval = setInterval(function() {
				if (width >= 100) {
					clearInterval(interval);
				} else {
					width += 10;
					progressBar.style.width = width + '%';
				}
			}, 500);
		}

		document.addEventListener('DOMContentLoaded', function() {
			var form = document.querySelector('form');
			form.addEventListener('submit', function(e) {
				e.preventDefault();
				showLoading();
				form.submit();
			});
		});
		</script>
		<title>DB setting</title>
	</head>
	<body class="flex_xc_yc">
		<div>
			<h1>2단계 - DB setting</h1>
			<p>DB정보는 호스팅사를 통해 확인 해주세요.</p>
			<p>DB_NAME은 영어나 숫자로만 입력 해주세요.</p>
			<p>보안에 위협이 되는 일부 특수 기호나 단어는 사용 할 수 없습니다.</p>
			<form method="post" action='<?php echo DOMAIN; ?>/?setting=db_input'>
				<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
				<div>DB_HOST</div>
				<div>
					<input type="text" name="db_host" placeholder="localhost 또는 DB의 host ip 주소" required='required' 
						value="<?php echo (CMS_TYPE === 'wordpress') ? DB_HOST : ''; ?>" />
				</div>
				<div>DB_USER</div>
				<div>
					<input type="text" name="db_user" placeholder="DB에 접속 아이디" required='required'
						value="<?php echo (CMS_TYPE === 'wordpress') ? DB_USER : ''; ?>" />
				</div>
				<div>DB_PASSWORD</div>
				<div>
					<input type="password" name="db_password" placeholder="DB에 접속 비밀번호" required='required'
						value="<?php echo (CMS_TYPE === 'wordpress') ? DB_PASSWORD : ''; ?>" />
				</div>
				<div>DB_NAME</div>
				<div>
					<input type="text" name="db_name" placeholder="DB에 사용할 이름" required='required'
						value="<?php echo (CMS_TYPE === 'wordpress') ? DB_NAME : ''; ?>" />
				</div>
				<br>
				<p>세팅하기 버튼을 누른 후 DB가 세팅되는 시간을 기다려 주세요.</p>
				<p>세팅이 완료되면 다음 화면으로 넘어 갑니다.</p>
				<div><button type='submit' id='submit-setting'>세팅하기</button></div>
			</form>
		</div>
		<div id="overlay">
			<div class="message">데이터베이스 생성 중입니다...</div>
			<div class="progress">
				<div class="progress-bar"></div>
			</div>
		</div>
	</body>
