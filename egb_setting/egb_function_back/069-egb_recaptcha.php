<?php 
if (!defined('EGB_RECAPTCHA_USE')) {define('EGB_RECAPTCHA_USE', 'off');}
if (!defined('EGB_RECAPTCHA_VERSION')) {define('EGB_RECAPTCHA_VERSION', 'v3');}

function egb_recaptcha($version = EGB_RECAPTCHA_VERSION) {
	if (EGB_RECAPTCHA_USE === 'off') {
		echo json_encode(['success' => true]);
		exit;
	}
	
	if (!defined('EGB_RECAPTCHA_SECRET_KEY')) {
		echo json_encode(['success' => false]);
		exit;
	}
	
	$secretKey = EGB_RECAPTCHA_SECRET_KEY;
	if (!isset($_POST['g-recaptcha-response'])) {
		echo json_encode(['success' => false]);
		exit;
	}
	
	$token = $_POST['g-recaptcha-response'];
	$url = "https://www.google.com/recaptcha/api/siteverify";
	$ip = egb_ip();
	$data = [
		'secret' => $secretKey,
		'response' => $token,
		'remoteip' => $ip
	];
	
	$options = [
		CURLOPT_URL => $url,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query($data),
		CURLOPT_RETURNTRANSFER => true
	];
	
	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	
	if (curl_errno($ch)) {
		curl_close($ch);
		echo json_encode(['success' => false]);
		exit;
	}
	
	curl_close($ch);
	$responseKeys = json_decode($response, true);
	
	if ($version === 'v3') {
		echo json_encode(['success' => ($responseKeys["success"] && isset($responseKeys["score"]) && $responseKeys["score"] > 0.5)]);
	} elseif ($version === 'v2') {
		echo json_encode(['success' => isset($responseKeys["success"]) && $responseKeys["success"]]);
	} else {
		echo json_encode(['success' => false]);
	}
}
?>
