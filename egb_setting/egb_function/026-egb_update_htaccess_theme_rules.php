<?php

function egb_update_htaccess_theme_rules(): bool
{
    $htaccessPath = ROOT . DS . '.htaccess';
    $theme = defined('THEMES_NAME') ? THEMES_NAME : 'eungabi';
    $theme_path = ROOT . DS . 'egb_themes' . DS . $theme;

    if (!is_dir($theme_path)) {
        echo "❌ 테마 폴더가 존재하지 않습니다: {$theme_path}\n";
        return false;
    }

    $rules = [];

    // font2 → 개별 처리
    $font_dir = $theme_path . DS . 'font';
    if (is_dir($font_dir)) {
        foreach (glob($font_dir . DS . '*.{woff2,woff,ttf,otf,eot}', GLOB_BRACE) as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $rules[] = "RewriteRule ^proxy/font2/{$name}\\.{$ext}$ egb_themes/{$theme}/font/{$name}.{$ext} [L]";
        }
    }

    // img2 → 확장자 통합 Rule
    $rules[] = "RewriteRule ^proxy/img2/(.*)\.(webp|jpg|jpeg|png|gif|svg)$ egb_themes/{$theme}/img/\$1.\$2 [L]";

    // video2 → 확장자 통합 Rule
    $rules[] = "RewriteRule ^proxy/video2/(.*)\.(mp4|webm|ogg)$ egb_themes/{$theme}/video/\$1.\$2 [L]";

    // audio2 → 확장자 통합 Rule
    $rules[] = "RewriteRule ^proxy/audio2/(.*)\.(mp3|wav|ogg|aac|flac)$ egb_themes/{$theme}/audio/\$1.\$2 [L]";

    $block = "# ===== THEME REWRITE START =====\n";
    $block .= "# 자동 생성됨. 이 블록은 수정하지 마세요.\n";
    $block .= implode("\n", $rules) . "\n";
    $block .= "# ===== THEME REWRITE END =====";

    if (!file_exists($htaccessPath)) {
        echo "❌ .htaccess 파일이 없습니다.\n";
        return false;
    }

    $original = file_get_contents($htaccessPath);

    if (preg_match('/# ===== THEME REWRITE START =====.*?# ===== THEME REWRITE END =====/s', $original)) {
        $updated = preg_replace(
            '/# ===== THEME REWRITE START =====.*?# ===== THEME REWRITE END =====/s',
            $block,
            $original
        );
    } else {
        $updated = $original . "\n\n" . $block;
    }

    file_put_contents($htaccessPath, $updated);
    echo "✅ 테마 RewriteRule 갱신 완료 (테마: {$theme})\n";
    return true;
}


?>
