<?php
$css = file_get_contents('tora-tora/assets/css/main.css');
$css = preg_replace(
    '/\.story-copy \.entry-content \{([^}]+)text-transform:\s*uppercase;\s*\}/s',
    '.story-copy .entry-content {$1}',
    $css
);
$css = preg_replace(
    '/\.story-copy \.entry-content p \{([^}]+)font-weight:\s*500;/s',
    '.story-copy .entry-content p {$1font-weight: 400;',
    $css
);
file_put_contents('tora-tora/assets/css/main.css', $css);

$front = file_get_contents('tora-tora/front-page.php');
// Replace the bottom static speckle bar with the repeating TORA TORA typography ticker.
$front = str_replace(
    '<div class="story-footer-pattern" aria-hidden="true"></div>',
    '<div class="gallery-ticker" aria-hidden="true">
            <div class="gallery-ticker-track">
                <?php for ($gallery_ticker_repeat = 0; $gallery_ticker_repeat < 2; $gallery_ticker_repeat++) : ?>
                    <span class="gallery-ticker-group">
                        <?php for ($gallery_ticker_item = 0; $gallery_ticker_item < 8; $gallery_ticker_item++) : ?>
                            <span class="gallery-ticker-word"><?php echo esc_html($gallery_ticker_words[$gallery_ticker_item % 2]); ?></span><span class="gallery-ticker-dot" aria-hidden="true">.</span>
                        <?php endfor; ?>
                    </span>
                <?php endfor; ?>
            </div>
        </div>',
    $front
);
file_put_contents('tora-tora/front-page.php', $front);
