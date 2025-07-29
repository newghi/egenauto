<?php

function egb_theme_index($header = [], $footer = []) {

$constant_path = ROOT . THEMES_PATH . DS . 'constant';
if (is_dir($constant_path)) {
	$constant = glob($constant_path . DS . '*.php');
	sort($constant);
	foreach ($constant as $constant_file) { require_once $constant_file;}
}

$config_path = ROOT . THEMES_PATH . DS . 'config';
if (is_dir($config_path)) {
	$config = glob($config_path . DS . '*.php');
	sort($config);
	foreach ($config as $config_file) { require_once $config_file;}
}

$function_path = ROOT . THEMES_PATH . DS . 'function';
if (is_dir($function_path)) {
	$function = glob($function_path . DS . '*.php');
	sort($function);
	foreach ($function as $function_file) { require_once $function_file;}
}

$js_path = ROOT . THEMES_PATH . DS . 'js';
if (is_dir($js_path)) {
	$js = glob($js_path . DS . '*.php');
	sort($js);
	foreach ($js as $js_file) { require_once $js_file;}
}

$db_path = ROOT . THEMES_PATH . DS . 'db';
if (is_dir($db_path)) {
	$db = glob($db_path . DS . '*.php');
	sort($db);
	foreach ($db as $db_file) { require_once $db_file;}
}

	echo '<div id="egb_body">';
	if (defined('PAGE')) {
		if (in_array(PAGE, $header) && in_array(PAGE, $footer)) {
			// PAGE가 $header와 $footer 배열에 모두 있는 경우
			// 처리할 코드를 여기에 작성합니다.
			if (defined('PAGE_TYPE')) {
				echo '<div id="egb_contents">';
				if (PAGE_TYPE === "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE=== "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE=== "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</div>';
			}
		} elseif (in_array(PAGE, $header)) {
			// PAGE가 $header 배열에 있는 경우
			// 처리할 코드를 여기에 작성합니다.
			if (defined('PAGE_TYPE')) {
				echo '<div id="egb_contents">';
				if (PAGE_TYPE === "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE === "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE === "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</div>';
			}
			require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'footer.php';
		} elseif (in_array(PAGE, $footer)) {
			// PAGE가 $footer 배열에 있는 경우
			// 처리할 코드를 여기에 작성합니다.
			
			require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'header.php';
			if (defined('PAGE_TYPE')) {
				echo '<div id="egb_contents">';
				if (PAGE_TYPE === "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE === "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE === "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</div>';
			}
		}else{
			
			require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'header.php';
			if (defined('PAGE_TYPE')) {
				echo '<div id="egb_contents">';
				if (PAGE_TYPE === "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE === "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE === "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</div>';
			}
			require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'footer.php';
			
		}
	}else{
			
		require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'header.php';
		echo '<div id="egb_contents">';
		require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'main.php';
		echo '</div>';
		require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'footer.php';
			
	}
	echo '</div>';	
	
    // AJAX 코드 파일 로드
    $ajaxFiles = [
        'egbsuccessCode.js',
        'egbFailureCode.js',
        'egbErrorCode.js',
        'egbCompleteCode.js',
    ];
	echo '<script id="egb_code_msg" nonce="'.NONCE.'">';
    foreach ($ajaxFiles as $file) {
        require_once (ROOT . THEMES_PATH . DS . 'ajax' . DS . $file);
    }
	echo '</script>';
	$loading = <<<'LOADING'
<div class="display_off" egb:style="
    .loading_spinner {-webkit-animation: rotator 1.4s linear infinite; animation: rotator 1.4s linear infinite;}
    .loading_path {stroke-dasharray: 187; stroke-dashoffset: 0; transform-origin: center; -webkit-animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite; animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;}
">
</div>
<div id="egb_form_loading" class="position3 flex_xc_yc width_box main_box z-index_99999 display_off"
    data-bg-color="#00000040" data-top="0%" data-left="0%">
    <svg class="loading_spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
        <circle class="loading_path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30">
        </circle>
    </svg>
</div>
<style>
    @-webkit-keyframes rotator {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(270deg);
        }
    }

    @keyframes rotator {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(270deg);
        }
    }

    @-webkit-keyframes colors {
        0% {
            stroke: #4285F4;
        }

        25% {
            stroke: #DE3E35;
        }

        50% {
            stroke: #F7C223;
        }

        75% {
            stroke: #1B9A59;
        }

        100% {
            stroke: #4285F4;
        }
    }

    @keyframes colors {
        0% {
            stroke: #4285F4;
        }

        25% {
            stroke: #DE3E35;
        }

        50% {
            stroke: #F7C223;
        }

        75% {
            stroke: #1B9A59;
        }

        100% {
            stroke: #4285F4;
        }
    }

    @-webkit-keyframes dash {
        0% {
            stroke-dashoffset: 187;
        }

        50% {
            stroke-dashoffset: 46.75;
            transform: rotate(135deg);
        }

        100% {
            stroke-dashoffset: 187;
            transform: rotate(450deg);
        }
    }

    @keyframes dash {
        0% {
            stroke-dashoffset: 187;
        }

        50% {
            stroke-dashoffset: 46.75;
            transform: rotate(135deg);
        }

        100% {
            stroke-dashoffset: 187;
            transform: rotate(450deg);
        }
    }
</style>
LOADING;
	echo $loading;

}

?>