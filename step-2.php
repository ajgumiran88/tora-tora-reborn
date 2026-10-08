<?php
$css = file_get_contents('tora-tora/assets/css/main.css');
$front = file_get_contents('tora-tora/front-page.php');

// 1. Home Page Panel
// Remove .home-pattern::before -webkit-mask-image
$css = preg_replace('/-webkit-mask-image:\s*radial-gradient[^;]+;/', '', $css);
$css = preg_replace('/mask-image:\s*radial-gradient[^;]+;/', '', $css);

// 2. About Page Panel
// Title formatting is already good in front-page.php, but let's double check.
// "Replace the bottom static speckle bar with the repeating TORA TORA typography ticker."
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

// 3. Menu Panel
// Remove .menu-rail-right::after { background: var(--tora-blue); }
$css = preg_replace('/\.menu-rail-right::after\s*\{[^}]+\}/s', '', $css);
// Make rail full height - it already is (height: 100%; min-height: 100%;)

// 4. Delivery Panel
$css = preg_replace(
    '/\.delivery-copy \.entry-content \{([^}]+)font-size:\s*\.72rem;\s*font-weight:\s*500;\s*line-height:\s*1\.45;/s',
    '.delivery-copy .entry-content {${1}font-size: .65rem; font-weight: 500; line-height: 1.35; letter-spacing: .04em;',
    $css
);
// In .delivery-card, increase breathing room
$css = preg_replace(
    '/\.delivery-order \{([^}]+)padding-top:\s*2\.35rem;/s',
    '.delivery-order {${1}padding-top: 3.5rem;',
    $css
);

// Refactor delivery zones and delivery hours containers into 3 equal structured cards
$front = preg_replace(
    '/<div class="delivery-boxes">.*?<\/div>\s*<\/div>\s*<\/div>/s',
    '<div class="delivery-boxes">
                    <section class="delivery-card delivery-box delivery-zones-block" aria-labelledby="delivery-zones-title">
                        <p class="delivery-label" id="delivery-zones-title"><?php esc_html_e(\'Delivery zones\', \'tora-tora\'); ?></p>
                        <ul class="delivery-zones">
                            <?php foreach ($delivery_zones as $zone) : ?>
                                <li<?php echo strcasecmp($zone, $featured_zone) === 0 ? \' class="is-featured"\' : \'\'; ?>><?php echo esc_html($zone); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                    <section class="delivery-card delivery-box delivery-hours-block" aria-labelledby="delivery-hours-title">
                        <p class="delivery-label" id="delivery-hours-title"><?php esc_html_e(\'Delivery hours\', \'tora-tora\'); ?></p>
                        <dl class="delivery-hours">
                            <div><dt><?php esc_html_e(\'Monday - Friday\', \'tora-tora\'); ?></dt><dd><?php echo esc_html((string) get_theme_mod(\'tora_hours_weekday\', \'11:00 - 22:30\')); ?></dd></div>
                            <div><dt><?php esc_html_e(\'Saturday\', \'tora-tora\'); ?></dt><dd><?php echo esc_html((string) get_theme_mod(\'tora_hours_saturday\', \'10:00 - 23:00\')); ?></dd></div>
                            <div><dt><?php esc_html_e(\'Sunday\', \'tora-tora\'); ?></dt><dd><?php echo esc_html((string) get_theme_mod(\'tora_hours_sunday\', \'10:00 - 23:00\')); ?></dd></div>
                        </dl>
                    </section>
                </div>
            </div>
        </div>',
    $front
);

$css = preg_replace(
    '/\.delivery-boxes \{\s*display: grid;\s*grid-template-columns: minmax\(0, 1\.15fr\) minmax\(0, 1fr\);/s',
    '.delivery-boxes { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));',
    $css
);

file_put_contents('tora-tora/assets/css/main.css', $css);
file_put_contents('tora-tora/front-page.php', $front);
echo "Step 2 done.\n";
