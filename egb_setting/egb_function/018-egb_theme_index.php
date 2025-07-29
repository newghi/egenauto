<?php

function egb_theme_index() {
	// 중복 호출 방지
	static $theme_index_called = false;
	if ($theme_index_called) {
		return;
	}
	$theme_index_called = true;

    if (file_exists(ROOT . THEMES_PATH . DS . 'schema' . DS . PAGE . '.php')) {
        require_once ROOT . THEMES_PATH . DS . 'schema' . DS . PAGE . '.php';
    }

	echo '<div id="egb_body">';
	if (defined('PAGE')) {
		if (PAGE_HEADER_USE == 1 && PAGE_FOOTER_USE == 1) {
			// 헤더와 푸터 모두 사용
            require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'header.php';
			if (defined('PAGE_TYPE')) {
                echo '<div id="egb_contents_fade_box">';
				echo '<main id="egb_contents">';
				if (PAGE_TYPE == "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE== "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE== "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</main>';
                echo '</div>';
			}
            require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'footer.php';
		} elseif (PAGE_HEADER_USE == 1) {
			// 헤더만 사용
            require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'header.php';
			if (defined('PAGE_TYPE')) {
                echo '<div id="egb_contents_fade_box">';
				echo '<main id="egb_contents">';
				if (PAGE_TYPE == "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE == "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE == "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</main>';
                echo '</div>';
			}
		} elseif (PAGE_FOOTER_USE == 1) {
			// 푸터만 사용
			if (defined('PAGE_TYPE')) {
                echo '<div id="egb_contents_fade_box">';
				echo '<main id="egb_contents">';
				if (PAGE_TYPE == "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE == "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE == "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</main>';
                echo '</div>';
			}
            require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'footer.php';
		}else{
			// 둘 다 사용하지 않음
			if (defined('PAGE_TYPE')) {
                echo '<div id="egb_contents_fade_box">';
				echo '<main id="egb_contents">';
				if (PAGE_TYPE == "html"){echo PAGE_CONTENT;}
				if (PAGE_TYPE == "php"){eval(PAGE_CONTENT);}
				if (PAGE_TYPE == "path"){require_once ROOT . PAGE_CONTENT;}
				echo '</main>';
                echo '</div>';
			}			
		}
	}else{
			
		require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'header.php';
        echo '<div id="egb_contents_fade_box">';
		echo '<main id="egb_contents">';
		require_once ROOT . THEMES_PATH . DS . 'page' . DS . 'main.php';
		echo '</main>';
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