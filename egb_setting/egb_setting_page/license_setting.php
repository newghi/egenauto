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
$msg = egb('msg');

if ($msg) {
    if (is_string($msg)) {
        if ($msg !== "비정상적인 라이선스 키 입니다." && $msg !== "도메인이 일치하지 않습니다.") {
            $msg = "정상적인 접근이 아닙니다.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang='ko'>
	<head>
		<!-- 기본 메타 -->
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta name='Title' content='Admin setting'>
		<meta name='Subject' content='Admin setting'>
		<meta name='description' content='Admin setting'>
		<meta name='author' content='Eungabi'>
		<meta name='Publisher' content='Eungabi'>
		<meta name='robots' content='none'>
		<meta name='keyword' content='Admin, setting'>
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
		<script nonce="<?php echo NONCE; ?>">
		document.addEventListener('DOMContentLoaded', function() {
			document.getElementById('check-btn').addEventListener('click', function() {
				const license_key = document.getElementById('license_key').value;
				const domain = document.getElementById('domain').value;
				
				console.log('라이선스 키:', license_key);
				console.log('도메인:', domain);
				
				fetch('https://lii.kr/license.php', {
					method: 'POST', 
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: `license_key=${encodeURIComponent(license_key)}&domain=${encodeURIComponent(domain)}`
				})
				.then(response => response.text())
				.then(result => {
					console.log('인증 결과:', result);
					
					const statusMsg = document.getElementById('status-msg');
					const submitBtn = document.getElementById('submit-btn');
					const checkBtn = document.getElementById('check-btn');
					const licenseInput = document.getElementById('license_key');
					const domainInput = document.getElementById('domain');

					if (result === '인증성공') {
						console.log('인증 성공 처리');
						statusMsg.textContent = '인증성공';
						submitBtn.style.display = 'block';
						checkBtn.style.display = 'none';
						licenseInput.readOnly = true;
						domainInput.readOnly = true;
					} else {
						console.log('인증 실패 처리');
						statusMsg.textContent = '인증실패. 다시 확인 후 시도 해주세요.';
						submitBtn.style.display = 'none';
					}
				})
				.catch(error => {
					console.error('에러 발생:', error);
					document.getElementById('status-msg').textContent = '오류 발생: ' + error;
					document.getElementById('submit-btn').style.display = 'none';
				});
			});
		});
		</script>
		<title>License setting</title>
	</head>
	<body style=" display: flex; align-items: center;">
		<div>
			<h1>1단계 - License setting</h1>
			<p>라이선스 인증을 합니다.</p>
			<p>이메일로 발송된 라이선스를 입력 해주세요.</p>
			<p>보안에 위협이 되는 일부 특수 기호나 단어는 사용 할 수 없습니다.</p>
			<form method ='POST' action = '<?php echo DOMAIN; ?>/?setting=license_input'>
				<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
				<label for="license_key">라이선스 키</label>
				<input type='text' id='license_key' name='license_key' placeholder='xxxx-xxxx-xxxx-xxxx-xxxx' required='required' />
				<label for="domain">도메인</label>
				<input type='text' id='domain' name='domain' placeholder='라이선스가 등록될 도메인' value='<?php echo DOMAIN; ?>' required='required' />
				<div>
					<button type='button' id='check-btn'>확인하기</button>
					<button type='submit' id='submit-btn'>등록하기</button>
				</div>
			</form>
			<p id='status-msg'><?php echo $msg; ?></p>
		</div>
	</body>
