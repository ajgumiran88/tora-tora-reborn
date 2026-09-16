<?php
declare(strict_types=1);

$root = dirname(__DIR__);
$theme = $root . '/tora-tora';
$failures = [];

function expect_true(bool $condition, string $message): void
{
    global $failures;
    if (!$condition) {
        $failures[] = $message;
    }
}

function file_contains(string $path, string $needle, string $message): void
{
    expect_true(is_file($path), "Missing file: {$path}");
    if (is_file($path)) {
        expect_true(str_contains((string) file_get_contents($path), $needle), $message);
    }
}

function file_does_not_contain(string $path, string $needle, string $message): void
{
    expect_true(is_file($path), "Missing file: {$path}");
    if (is_file($path)) {
        expect_true(!str_contains((string) file_get_contents($path), $needle), $message);
    }
}

$required = [
    'style.css', 'screenshot.png', 'functions.php', 'front-page.php', 'index.php', 'header.php', 'footer.php',
    'theme.json', 'assets/css/main.css', 'assets/js/site.js',
    'assets/images/tora-tora-logo.png', 'assets/images/tora-tora-pattern.jpg', 'assets/images/tiger-mark.png',
    'assets/images/tora-tora-pattern.png', 'assets/images/tora-tora-pattern.webp',
    'assets/images/delivery-talabat.svg', 'assets/images/delivery-noon.png', 'assets/images/delivery-deliveroo.svg',
    'inc/setup.php', 'inc/customizer.php', 'inc/menu-items.php', 'inc/jobs.php', 'inc/staging.php', 'inc/compatibility.php', 'inc/default-content.php',
    'single-job_listing.php',
];

foreach ($required as $file) {
    expect_true(is_file($theme . '/' . $file), "Required theme file missing: {$file}");
}

file_contains($theme . '/style.css', 'Theme Name: Tora Tora', 'Theme header is missing its name.');
file_contains($theme . '/inc/menu-items.php', "register_post_type('tora_menu_item'", 'Menu item post type is not registered.');
file_contains($theme . '/inc/menu-items.php', "register_taxonomy('tora_menu_category'", 'Menu category taxonomy is not registered.');
file_contains($theme . '/inc/menu-items.php', "register_post_meta('tora_menu_item', 'tora_price'", 'Menu price meta is not registered.');
file_contains($theme . '/inc/menu-items.php', "register_post_meta('tora_menu_item', 'tora_available'", 'Availability meta is not registered.');
file_contains($theme . '/inc/staging.php', 'wp_robots', 'Staging robots filter is missing.');
file_contains($theme . '/inc/staging.php', 'X-Robots-Tag', 'Staging HTTP robots header is missing.');
file_contains($theme . '/header.php', 'STAGING PREVIEW', 'Visible staging preview notice is missing.');
file_contains($theme . '/header.php', 'staging-only', 'Staging-only label above the preview notice is missing.');
file_contains($theme . '/header.php', 'skip-link', 'Skip link is missing.');
file_contains($theme . '/header.php', 'tora_tora_render_document_head', 'Safe head renderer is missing from header.php.');
file_contains($theme . '/inc/compatibility.php', 'tora_tora_use_safe_head', 'Host compatibility helper is missing.');
file_contains($theme . '/inc/compatibility.php', 'rank_math/frontend/disable', 'Rank Math staging guard is missing.');
file_does_not_contain($theme . '/inc/compatibility.php', "if (!did_action('wp_enqueue_scripts'))", 'The staging-safe head still fires third-party asset hooks.');
file_contains($theme . '/inc/compatibility.php', "'</title>' . PHP_EOL", 'The staging-safe document title is not closed.');
file_contains($theme . '/inc/compatibility.php', "includes_url('css/dashicons.min.css')", 'The staging-safe head does not restore the WordPress core icon font needed by the logged-in admin bar.');
file_contains($theme . '/inc/compatibility.php', "includes_url('css/admin-bar.min.css')", 'The staging-safe head does not restore the WordPress core admin-bar stylesheet for logged-in reviewers.');
file_contains($theme . '/inc/compatibility.php', "tora_tora_asset_version('assets/css/main.css')", 'The staging-safe head does not render the theme stylesheet directly.');
file_contains($theme . '/inc/compatibility.php', "tora_tora_asset_version('assets/js/site.js')", 'The staging-safe footer does not render the theme script directly.');
file_contains($theme . '/front-page.php', 'aria-modal="true"', 'Accessible modal semantics are missing.');
file_contains($theme . '/assets/js/site.js', 'history.pushState', 'Panel history support is missing.');
file_contains($theme . '/assets/js/site.js', 'prefers-reduced-motion', 'Reduced motion support is missing.');
file_contains($theme . '/assets/js/site.js', 'trapFocus', 'Modal focus containment is missing.');
file_contains($theme . '/assets/css/main.css', ':focus-visible', 'Visible keyboard focus styling is missing.');
file_contains($theme . '/assets/css/main.css', '@media (prefers-reduced-motion: reduce)', 'Reduced-motion CSS is missing.');
file_contains($theme . '/front-page.php', 'tora_get_menu_groups', 'Dynamic menu rendering is missing.');
file_contains($theme . '/assets/css/main.css', 'z-index: 250', 'Overlay navigation is not stacked above page panels.');
file_contains($theme . '/front-page.php', 'menu-item-placeholder', 'Menu image placeholders are missing.');

file_contains($theme . '/assets/css/main.css', '.light-panel:not(.nav-open) .brand-link img', 'Light-panel logo invert is missing.');
file_contains($theme . '/assets/css/main.css', '.pattern-panel:not(.nav-open) .nav-toggle', 'Pattern-panel hamburger contrast chip is missing.');
file_contains($theme . '/assets/css/main.css', '#0500F5', 'Brand blue #0500F5 is missing from CSS tokens.');
file_contains($theme . '/theme.json', '#0500F5', 'Brand blue #0500F5 is missing from theme.json.');
file_contains($theme . '/assets/css/main.css', '#FFFFFF', 'Brand white #FFFFFF is missing from CSS tokens.');
file_does_not_contain($theme . '/assets/css/main.css', '--tora-blue: #0b2cff', 'Legacy off-brand blue is still the primary token.');

file_contains($theme . '/inc/jobs.php', 'tora_tora_get_job_listings', 'Job Manager listing helper is missing.');
file_contains($theme . '/inc/jobs.php', 'tora_tora_careers_content_is_polluted', 'Careers pollution guard is missing.');
file_contains($theme . '/front-page.php', 'tora_tora_get_job_listings', 'Careers panel does not query Job Manager listings.');
file_contains($theme . '/front-page.php', 'careers-job-list', 'Careers job list markup is missing.');
file_contains($theme . '/front-page.php', 'View & apply', 'Careers apply CTA is missing.');
file_does_not_contain($theme . '/front-page.php', "echo esc_html(\$careers['title']);", 'Careers still prints unsanitized page titles.');
file_contains($theme . '/single-job_listing.php', 'job-application.php', 'Single job template does not load WP Job Manager apply UI.');
file_contains($theme . '/assets/css/main.css', '.careers-job-list', 'Careers job list styling is missing.');
file_contains($theme . '/functions.php', '/inc/jobs.php', 'jobs.php is not bootstrapped.');

file_contains($theme . '/header.php', 'About Tora Tora', 'Overlay is missing the About Tora Tora label.');
file_contains($theme . '/header.php', 'data-target="delivery"', 'Overlay is missing Delivery navigation.');
file_contains($theme . '/header.php', 'overlay-close', 'Overlay is missing the Figma close (X) control.');
file_does_not_contain($theme . '/header.php', 'overlay-aside', 'Overlay still includes the contact aside.');

file_contains($theme . '/front-page.php', 'id="delivery"', 'Order Delivery panel is missing.');
file_contains($theme . '/front-page.php', 'ORDER DELIVERY', 'Order Delivery heading is missing.');
file_contains($theme . '/front-page.php', 'Talabat', 'Talabat platform card is missing.');
file_contains($theme . '/front-page.php', 'Deliveroo', 'Deliveroo platform card is missing.');
file_contains($theme . '/front-page.php', 'Business Bay', 'Delivery zones are missing.');
file_contains($theme . '/inc/customizer.php', 'tora_talabat_url', 'Talabat URL Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_noon_url', 'Noon URL Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_deliveroo_url', 'Deliveroo URL Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_talabat_logo', 'Talabat logo Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_noon_logo', 'Noon Food logo Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_deliveroo_logo', 'Deliveroo logo Customizer setting is missing.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_platform_logo', 'Delivery platform logo helper is missing.');
file_contains($theme . '/front-page.php', 'class="delivery-logo"', 'Delivery cards do not render real logo images.');

file_contains($theme . '/front-page.php', 'menu-tabs', 'Tabbed menu navigation is missing.');
file_contains($theme . '/front-page.php', 'menu-tab-panels', 'Tabbed menu panels are missing.');
file_does_not_contain($theme . '/front-page.php', 'id="menu-modal"', 'The old menu modal should be removed.');
file_contains($theme . '/inc/default-content.php', 'Draft Food Menu', 'Draft Food Menu category is not seeded.');
file_contains($theme . '/inc/default-content.php', 'Beverage', 'Beverage category is not seeded.');
file_contains($theme . '/inc/menu-items.php', 'draft-food-menu', 'Menu group ordering does not include Draft Food Menu.');

file_contains($theme . '/front-page.php', 'id="about"', 'About panel is missing.');
file_does_not_contain($theme . '/front-page.php', 'story-figure-gold', 'Gold medallion should not appear on primary About surfaces.');
file_contains($theme . '/front-page.php', 'gallery-kicker', 'Gallery editorial kicker is missing.');
file_contains($theme . '/front-page.php', 'gallery-count', 'Gallery image count is missing.');
file_contains($theme . '/front-page.php', 'gallery-image-index', 'Gallery image index labels are missing.');
file_contains($theme . '/assets/css/main.css', '.gallery-link::after', 'Gallery tiles are missing a premium interaction overlay.');
file_contains($theme . '/assets/css/main.css', '.gallery-count', 'Gallery image count styling is missing.');
file_contains($theme . '/assets/css/main.css', '.gallery-link:focus-visible', 'Gallery tiles are missing a dedicated keyboard focus treatment.');

file_contains($theme . '/assets/css/main.css', '--tiger-mark:', 'The shared tiger watermark asset token is missing.');
file_contains($theme . '/assets/css/main.css', '.panel::before', 'Panels do not render the shared tiger watermark layer.');
file_contains($theme . '/assets/css/main.css', 'background-image: var(--tiger-mark)', 'The tiger watermark layer does not use the packaged tiger artwork.');
file_contains($theme . '/assets/css/main.css', '--tora-cream:', 'The premium warm surface token is missing.');
file_contains($theme . '/assets/css/main.css', '.delivery-card:hover', 'Delivery cards are missing a clear hover treatment.');
file_does_not_contain($theme . '/assets/css/main.css', 'filter: contrast(1.1)', 'The pattern still amplifies JPEG compression artifacts.');
file_does_not_contain($theme . '/assets/css/main.css', '.pattern-panel:not(.nav-open) .brand-link {', 'The white logo chip is still present on the patterned panel.');
file_contains($theme . '/assets/css/main.css', '--pattern: image-set(', 'The pattern token does not prefer modern high-resolution assets.');
file_contains($theme . '/assets/css/main.css', 'tora-tora-pattern.webp', 'The pattern token is missing its WebP source.');
file_contains($theme . '/assets/css/main.css', 'tora-tora-pattern.png', 'The pattern token is missing its PNG fallback.');
file_contains($theme . '/assets/css/main.css', '.delivery-logo', 'Delivery logo sizing styles are missing.');
file_contains($theme . '/inc/setup.php', "'standard-page-context'", 'Standard WordPress pages are missing their dedicated light-surface body class.');
file_contains($theme . '/inc/setup.php', "\$classes[] = 'light-panel';", 'Standard WordPress pages do not switch fixed chrome to the accessible blue-on-cream treatment.');

$pattern_dimensions = is_file($theme . '/assets/images/tora-tora-pattern.png')
    ? getimagesize($theme . '/assets/images/tora-tora-pattern.png')
    : false;
expect_true(
    is_array($pattern_dimensions) && $pattern_dimensions[0] >= 2560 && $pattern_dimensions[1] >= 2560,
    'The packaged pattern must be at least 2560 x 2560 pixels.'
);

if ($failures) {
    fwrite(STDERR, "Theme checks failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

fwrite(STDOUT, "All Tora Tora theme checks passed.\n");
