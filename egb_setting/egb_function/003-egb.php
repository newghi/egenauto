<?php

function egb($key, $failureCode = null) {
    static $initialized = false;

    if (! $initialized) {

        $get  = $_GET  ?? [];
        $post = $_POST ?? [];
        $json = [];

        if (! empty($_SERVER['CONTENT_TYPE']) &&
            stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== false
        ) {
            $raw  = file_get_contents('php://input');
            $json = json_decode($raw, true);
            if (! is_array($json)) $json = [];
        }

        $merged = array_merge($get, $post, $json);
        $clean  = function($val) use (&$clean) {
            if (is_array($val)) {
                return array_map($clean, $val);
            }
            $val = str_replace(['../', './'], '', trim($val));
            return htmlspecialchars($val, ENT_QUOTES | ENT_HTML5, (defined('DEFAULT_CHARSET') ? DEFAULT_CHARSET : 'UTF-8'));
        };

        $GLOBALS['_EGB'] = array_map($clean, $merged);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $GLOBALS['_EGB']['csrf_token'] ?? '';
            $sessionToken = $_SESSION['csrf_token'] ?? '';

            if ($token == '' || $sessionToken == '' || !hash_equals($sessionToken, $token)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => false, 'failureCode' => 0]);
                exit;
            }
        }

        $_GET = $_POST = $_REQUEST = ['__BLOCKED__' => true];
        $initialized = true;
    }

    // 🔄 배열 key 처리용: target_grades[] → target_grades
    $adjustedKey = rtrim($key, '[]');

    if ($failureCode !== null) {
        if (! isset($GLOBALS['_EGB'][$adjustedKey]) || $GLOBALS['_EGB'][$adjustedKey] == '' || $GLOBALS['_EGB'][$adjustedKey] == []) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'failureCode' => $failureCode]);
            exit;
        }
        return $GLOBALS['_EGB'][$adjustedKey];
    }

    return $GLOBALS['_EGB'][$adjustedKey] ?? '';
}
?>
