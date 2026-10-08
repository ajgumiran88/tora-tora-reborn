<?php
$front = file_get_contents('tora-tora/front-page.php');

// Replace About bottom speckle bar with ticker
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

// Delivery Zones
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

// Careers title
$front = str_replace(
    '<h2 id="careers-title">JOIN THE TEAM</h2>',
    '<h2 id="careers-title"><span>JOIN</span><br><span class="careers-team-line">THE TEAM</span></h2>',
    $front
);

file_put_contents('tora-tora/front-page.php', $front);
