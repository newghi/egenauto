<?php

function egb_update_htaccess_font_rules()
{
    $fontMapPath = ROOT . THEMES_PATH . DS . 'font.php';
    $htaccessPath = ROOT . DS . '.htaccess';
    $proxy_prefix = 'proxy/font';
    $font_dir = 'egb_font';

    if (!file_exists($fontMapPath)) {
        echo "❌ font.php가 존재하지 않습니다: {$fontMapPath}\n";
        return false;
    }

    if (!file_exists($htaccessPath)) {
        echo "❌ .htaccess 파일이 존재하지 않습니다: {$htaccessPath}\n";
        return false;
    }

    $fonts = require $fontMapPath;
    if (!is_array($fonts)) {
        echo "❌ font.php는 배열을 반환해야 합니다.\n";
        return false;
    }

    $rules = [];
    foreach ($fonts as $key => $filename) {
        $key = preg_replace('/[^a-zA-Z0-9_\-]/', '', $key);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $rules[] = "RewriteRule ^{$proxy_prefix}/{$key}\\.{$ext}$ {$font_dir}/{$filename} [L]";
    }

    $generatedBlock = "# ==== FONT REWRITE START ====\n";
    $generatedBlock .= "# 자동 생성됨. 이 블록은 수정하지 마세요.\n";
    $generatedBlock .= implode("\n", $rules) . "\n";
    $generatedBlock .= "# ==== FONT REWRITE END ====";

    $original = file_get_contents($htaccessPath);

    // 기존 블록 대체 또는 추가
    if (preg_match('/# ==== FONT REWRITE START ====.*?# ==== FONT REWRITE END ====/s', $original)) {
        $updated = preg_replace(
            '/# ==== FONT REWRITE START ====.*?# ==== FONT REWRITE END ====/s',
            $generatedBlock,
            $original
        );
    } else {
        $updated = $original . "\n\n" . $generatedBlock;
    }

    file_put_contents($htaccessPath, $updated);

    echo "✅ .htaccess가 성공적으로 업데이트 되었습니다.\n";
    return true;
}


?>
