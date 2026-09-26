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
    'assets/images/contact-dubai-map.png',
    'assets/images/tora-tora-pattern.png', 'assets/images/tora-tora-pattern.webp',
    'assets/images/delivery-talabat.svg', 'assets/images/delivery-noon.png', 'assets/images/delivery-deliveroo.svg',
    'assets/fonts/itc-avant-garde-pro-bold.woff2',
    'assets/fonts/raleway-latin-wght-normal.woff2', 'assets/fonts/raleway-latin-wght-italic.woff2',
    'assets/images/story-kitchen-ramen-sm.jpg', 'assets/images/story-kitchen-ramen-lg.jpg',
    'inc/setup.php', 'inc/customizer.php', 'inc/menu-items.php', 'inc/jobs.php', 'inc/staging.php', 'inc/compatibility.php', 'inc/default-content.php', 'inc/editor.php',
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
file_does_not_contain($theme . '/front-page.php', 'menu-item-placeholder', 'Menu still renders circular dish placeholders.');
file_does_not_contain($theme . '/front-page.php', 'hero-art', 'Home still renders the removed ramen hero artwork.');
file_does_not_contain($theme . '/front-page.php', 'hero-ramen.png', 'Home still requests the removed ramen asset.');
file_does_not_contain($theme . '/front-page.php', 'hero-chopsticks', 'Home still renders the removed chopsticks overlay.');
file_does_not_contain($theme . '/assets/css/main.css', '.hero-art', 'Home still ships ramen hero artwork CSS.');
file_does_not_contain($theme . '/assets/css/main.css', '.hero-bowl', 'Home still ships ramen bowl CSS.');
file_does_not_contain($theme . '/assets/css/main.css', '.hero-chopsticks', 'Home still ships chopsticks CSS.');
file_contains($theme . '/assets/css/main.css', '.home-pattern::before', 'Home pattern is missing the right-edge gutter.');
file_does_not_contain($theme . '/assets/css/main.css', '-webkit-mask-image: radial-gradient', 'Home pattern still uses a concave cutout mask.');
file_does_not_contain($theme . '/assets/css/main.css', 'mask-image: radial-gradient', 'Home pattern still uses a concave cutout mask.');
file_contains($theme . '/front-page.php', 'delivery-partners', 'Delivery partner logos are not grouped on the first screen.');
file_contains($theme . '/assets/css/main.css', '.delivery-primary', 'Delivery first-screen partner block is missing.');
file_contains($theme . '/assets/css/main.css', '.delivery-boxes {', 'Delivery zone and hours boxes are missing.');
file_contains($theme . '/assets/css/main.css', '.delivery-box {', 'Delivery info cards are missing equal box styling.');
file_contains($theme . '/front-page.php', 'delivery-boxes', 'Delivery panel is missing the zones and hours info boxes.');
file_contains($theme . '/assets/css/main.css', "--panel-title: clamp(2.25rem, 4.6vw, 3.75rem);", 'Shared panel display title token is missing.');
file_contains($theme . '/assets/css/main.css', "--panel-top: calc(var(--staging) + var(--brand-mark) + var(--panel-top-gap));", 'Shared panel top clearance under the fixed brand logo is missing.');
file_contains($theme . '/assets/css/main.css', "--brand-mark: clamp(4.5rem, 8vw, 7rem);", 'Brand mark size token is missing.');
file_contains($theme . '/assets/css/main.css', "--panel-top-gap: clamp(2.15rem, 4vh, 2.75rem);", 'Panel top gap token is missing.');
file_contains($theme . '/assets/css/main.css', "body {\n  --panel-top: calc(var(--staging) + var(--brand-mark) + var(--panel-top-gap));\n}", 'Panel top clearance must resolve on body so staging chrome is included.');
file_contains($theme . '/assets/css/main.css', 'padding-top: var(--panel-top);', 'Panel scroll areas do not clear the fixed brand logo.');
file_does_not_contain($theme . '/assets/css/main.css', 'padding-top: calc(var(--header) * .35 + var(--staging));', 'Gallery/Careers/Contact still use the pre-logo tight top inset.');
file_does_not_contain($theme . '/assets/css/main.css', 'top: calc(var(--staging) + clamp(3.4rem, 7.5vh, 5.25rem));', 'About copy still starts under the fixed brand logo.');
file_contains($theme . '/assets/css/main.css', ".gallery-heading {\n  display: flex;\n  align-items: baseline;\n  justify-content: space-between;\n  flex-shrink: 0;", 'Gallery heading can still be crushed by the mosaic grid.');
file_contains($theme . '/assets/css/main.css', ".story-panel #about-title,\n.menu-layout h2,\n.delivery-panel #delivery-title,\n.gallery-heading h2,\n.careers-panel #careers-title,\n.contact-heading h2 {", 'Panel titles do not share one display type rule.');
file_contains($theme . '/assets/css/main.css', 'font-size: var(--panel-title);', 'Panel titles do not use the shared display size token.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(3.25rem, 7vw, 6.8rem);', 'Menu title still uses an oversized one-off display size.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(3rem, 7vw, 6rem);', 'Contact title still uses an oversized one-off display size.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(2.8rem, 6.2vw, 5.4rem);', 'Gallery title still uses an oversized one-off display size.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(1.7rem, 3.6vw, 3.2rem);', 'Careers title still uses a smaller one-off display size.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(2.6rem, 5.2vw, 3.9rem);', 'Delivery title still uses a one-off display size.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(2.2rem, 3.9vw, 3.2rem);', 'About title still uses a one-off display size.');
file_does_not_contain($theme . '/assets/css/main.css', 'font-size: clamp(3.1rem, 18vw, 5rem);', 'Menu mobile title still uses an oversized one-off display size.');
file_contains($theme . '/front-page.php', '<h2 id="delivery-title"><?php esc_html_e(\'ORDER DELIVERY\', \'tora-tora\'); ?></h2>', 'Delivery title is not a single ORDER DELIVERY line.');
file_does_not_contain($theme . '/front-page.php', 'delivery-title-line', 'Delivery title is still split across two lines.');
file_contains($theme . '/assets/css/main.css', ".delivery-panel #delivery-title {\n  width: max-content;\n  max-inline-size: 100%;\n  white-space: nowrap;", 'Delivery ORDER DELIVERY is not locked as a single non-wrapping line.');
file_contains($theme . '/front-page.php', 'delivery-rail', 'Delivery panel is missing the Figma right-edge rail.');
file_contains($theme . '/assets/js/site.js', 'delivery-view', 'Delivery view body class is missing.');
file_contains($theme . '/assets/css/main.css', '.delivery-view:not(.nav-open) .footer-strip', 'Delivery still shows the footer credit over the hours column.');
file_does_not_contain($theme . '/assets/css/main.css', 'min-height: calc(100svh - var(--header) - var(--staging) - 1.15rem)', 'Delivery still forces a second full-screen block.');

file_does_not_contain($theme . '/assets/css/main.css', '.light-panel:not(.nav-open) .brand-link img', 'Light panels still recolour the Tora Blue logo, which shows purple on some displays.');
file_does_not_contain($theme . '/assets/css/main.css', 'hue-rotate(', 'A hue-rotate filter still recolours brand artwork.');
file_contains($theme . '/assets/css/main.css', ".blue-panel:not(.nav-open) .brand-link img,\n.gallery-view:not(.nav-open) .brand-link img,\n.contact-view:not(.nav-open) .brand-link img {\n  filter: brightness(0) invert(1);\n}", 'Gallery/Contact brand logo is not forced white on the blue background.');
file_does_not_contain($theme . '/assets/css/main.css', '.about-panel:not(.nav-open) .brand-link { visibility: hidden; }', 'About still hides the home branding logo.');
file_does_not_contain($theme . '/assets/css/main.css', '.menu-view:not(.nav-open) .brand-link { visibility: hidden; }', 'Menu still hides the home branding logo.');
file_does_not_contain($theme . '/assets/css/main.css', '.careers-view:not(.nav-open) .brand-link { visibility: hidden; }', 'Careers still hides the home branding logo.');
file_does_not_contain($theme . '/assets/css/main.css', '.gallery-view:not(.nav-open) .brand-link { visibility: hidden; }', 'Gallery still hides the home branding logo.');
file_does_not_contain($theme . '/assets/css/main.css', '.contact-view:not(.nav-open) .brand-link { visibility: hidden; }', 'Contact still hides the home branding logo.');
file_contains($theme . '/header.php', 'class="brand-link nav-link"', 'Global header branding logo link is missing.');
file_contains($theme . '/assets/css/main.css', ".site-header {\n  position: fixed;", 'Site chrome must stay viewport-fixed, not CSS sticky.');
file_does_not_contain($theme . '/assets/css/main.css', '.site-header {\n  position: sticky', 'Site chrome must not use CSS sticky inside panel scrollers.');
file_contains($theme . '/assets/css/main.css', 'min-height: var(--header);', 'Resting header size should match the original chrome, not a taller stuck bar.');
file_does_not_contain($theme . '/assets/css/main.css', "\n.light-panel:not(.nav-open):not(.pattern-panel):not(.about-panel) .site-header {\n  background: #FFFFFF;", 'Opaque header must not apply before the page is scrolled.');
file_does_not_contain($theme . '/assets/css/main.css', ".gallery-view:not(.nav-open) .site-header,\n.contact-view:not(.nav-open) .site-header {\n  background: var(--tora-blue);", 'Gallery/Contact header must stay transparent until scrolled.');
file_does_not_contain($theme . '/assets/css/main.css', 'position: absolute;\n  top: .35rem;\n  right: clamp(.9rem, 2vw, 1.25rem);', 'About hamburger should not be relocated by the sticky-header experiment.');
file_contains($theme . '/assets/js/site.js', 'header-stuck', 'Header stuck class is not toggled on panel scroll.');
file_does_not_contain($theme . '/assets/css/main.css', ".header-stuck.light-panel:not(.nav-open):not(.pattern-panel):not(.about-panel) .site-header {\n  background: #FFFFFF;", 'Scrolled header must stay transparent so it does not hide page objects.');
file_does_not_contain($theme . '/assets/css/main.css', ".header-stuck.gallery-view:not(.nav-open) .site-header,\n.header-stuck.contact-view:not(.nav-open) .site-header {\n  background: var(--tora-blue);", 'Scrolled blue header must stay transparent so it does not hide page objects.');
file_contains($theme . '/assets/css/main.css', '.pattern-panel:not(.nav-open) .nav-toggle', 'Pattern-panel hamburger contrast chip is missing.');
file_contains($theme . '/assets/css/main.css', '--font-display', 'Brand Book Typeface 01 token is missing.');
file_contains($theme . '/assets/css/main.css', 'font-family: "ITC Avant Garde Gothic"', 'ITC Avant Garde Gothic @font-face is missing.');
file_contains($theme . '/assets/css/main.css', 'font-family: var(--font-display)', 'Headings do not use the Brand Book display typeface.');
file_contains($theme . '/assets/css/main.css', '#0500F5', 'Brand blue #0500F5 is missing from CSS tokens.');
file_contains($theme . '/theme.json', '#0500F5', 'Brand blue #0500F5 is missing from theme.json.');
file_contains($theme . '/assets/css/main.css', '#FFFFFF', 'Brand white #FFFFFF is missing from CSS tokens.');
file_does_not_contain($theme . '/assets/css/main.css', '--tora-blue: #0b2cff', 'Legacy off-brand blue is still the primary token.');

file_contains($theme . '/inc/jobs.php', 'tora_tora_get_job_listings', 'Job Manager listing helper is missing.');
file_contains($theme . '/inc/jobs.php', 'tora_tora_careers_jobs_for_display', 'Careers display job helper is missing.');
file_contains($theme . '/inc/jobs.php', 'tora_tora_careers_content_is_polluted', 'Careers pollution guard is missing.');
file_contains($theme . '/inc/jobs.php', "'_job_expires'", 'Job listings do not filter WPJM expiry metadata.');
file_contains($theme . '/inc/jobs.php', "'menu_order' => 'ASC'", 'Job listings do not honor menu order.');
file_contains($theme . '/inc/jobs.php', 'tora_tora_job_is_active', 'Job listings do not apply the filled/expiry safety guard.');
file_contains($theme . '/inc/jobs.php', "'_application'", 'Job application metadata mapping is missing.');
file_contains($theme . '/inc/jobs.php', 'tora_tora_default_careers_jobs', 'Static careers fallback is missing.');
file_contains($theme . '/assets/css/main.css', '.careers-job-description ul', 'WP HTML list styling is missing from careers descriptions.');
file_contains($theme . '/README.txt', 'WP Job Manager is required', 'WP Job Manager editor documentation is missing.');
file_contains($theme . '/front-page.php', 'tora_tora_careers_jobs_for_display', 'Careers panel does not load display jobs.');
file_contains($theme . '/front-page.php', 'careers-job-list', 'Careers job list markup is missing.');
file_contains($theme . '/front-page.php', 'careers-roles-badge', 'Careers roles badge is missing.');
file_contains($theme . '/front-page.php', 'careers-rule', 'Careers vertical rule is missing.');
file_does_not_contain($theme . '/front-page.php', 'careers-art', 'Careers panel still renders bottom decorative artwork.');
file_contains($theme . '/front-page.php', '<h2 id="careers-title">JOIN THE TEAM</h2>', 'Careers title is not a single JOIN THE TEAM line.');
file_contains($theme . '/front-page.php', 'View & apply', 'Careers apply CTA is missing.');
file_does_not_contain($theme . '/front-page.php', "echo esc_html(\$careers['title']);", 'Careers still prints unsanitized page titles.');
file_contains($theme . '/single-job_listing.php', 'job-application.php', 'Single job template does not load WP Job Manager apply UI.');
file_contains($theme . '/assets/css/main.css', '.careers-job-list', 'Careers job list styling is missing.');
file_contains($theme . '/assets/css/main.css', '.careers-view:not(.nav-open)', 'Careers chrome body class styling is missing.');
file_contains($theme . '/assets/js/site.js', 'careers-view', 'Careers chrome body class toggle is missing.');
file_contains($theme . '/functions.php', '/inc/jobs.php', 'jobs.php is not bootstrapped.');

file_contains($theme . '/inc/setup.php', 'tora_tora_maps_embed_url', 'Google Maps embed helper is missing.');
file_contains($theme . '/inc/setup.php', 'tora_tora_maps_url', 'Google Maps place URL helper is missing.');
file_contains($theme . '/inc/setup.php', 'maps.app.goo.gl/e8q15vCemqi5rcZX7', 'First Avenue Mall Google Maps URL is missing.');
file_contains($theme . '/inc/setup.php', '25.2104867,55.2478384', 'First Avenue Mall map pin coordinates are missing.');
file_contains($theme . '/inc/setup.php', 'First Avenue Mall Jumeira', 'First Avenue Mall embed query is missing.');
file_contains($theme . '/front-page.php', 'contact-map-art', 'Contact panel is missing the map embed.');
file_contains($theme . '/front-page.php', '<iframe', 'Contact panel is missing a live Google Maps iframe.');
file_contains($theme . '/front-page.php', 'tora_tora_maps_embed_url', 'Contact map does not use the Google Maps embed helper.');
file_contains($theme . '/front-page.php', 'tora_tora_maps_url', 'Contact map does not use the Google Maps place URL helper.');
file_contains($theme . '/inc/customizer.php', 'tora_maps_url', 'Google Maps URL Customizer setting is missing.');
file_does_not_contain($theme . '/front-page.php', 'contact-dubai-map.png', 'Contact panel still uses the sample Dubai map artwork.');
file_contains($theme . '/front-page.php', 'contact-logo', 'Contact panel is missing the Figma wordmark.');
file_contains($theme . '/front-page.php', 'Get in touch', 'Contact panel is missing the Figma Get in touch block.');
file_contains($theme . '/front-page.php', 'Opening hours', 'Contact panel is missing the Figma opening hours block.');
file_contains($theme . '/front-page.php', 'Follow us', 'Contact panel is missing the Figma Follow us block.');
file_does_not_contain($theme . '/front-page.php', 'contact-card media-reveal', 'Contact panel still uses the interior photo instead of a map.');
file_contains($theme . '/assets/css/main.css', '.contact-map-art', 'Contact map artwork styling is missing.');
file_contains($theme . '/assets/js/site.js', 'contact-view', 'Contact chrome body class toggle is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_reservation_email', 'Reservation email Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', 'tora_instagram_url', 'Instagram URL Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', "'https://www.instagram.com/toratora.ae'", 'Instagram URL default is not the live toratora.ae profile.');
file_contains($theme . '/inc/customizer.php', "'https://www.tiktok.com/@toratora.ae'", 'TikTok URL default is not the live toratora.ae profile.');
file_contains($theme . '/inc/setup.php', "'@toratora.ae'", 'Contact social handles do not default to @toratora.ae.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_social_handles_1_4_2', 'Saved staging social links will stay on the old .dxb handles.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_instagram_url', 'Instagram URL helper is missing, so Contact can keep a stale Customizer link.');
file_contains($theme . '/inc/setup.php', "'https://www.instagram.com/toratora.ae'", 'Instagram helper does not canonicalize to the live toratora.ae profile.');
file_contains($theme . '/inc/setup.php', "'https://www.tiktok.com/@toratora.ae'", 'TikTok helper does not canonicalize to the live toratora.ae profile.');
file_contains($theme . '/front-page.php', 'tora_tora_instagram_url()', 'Contact Instagram link does not use the canonical helper.');
file_contains($theme . '/front-page.php', 'tora_tora_tiktok_url()', 'Contact TikTok link does not use the canonical helper.');
file_contains($theme . '/inc/setup.php', 'contact-social-icon', 'Follow us rows are missing social icons.');
file_contains($theme . '/assets/css/main.css', '.contact-social-icon {', 'Social icons have no blue-theme sizing.');
file_contains($theme . '/assets/css/main.css', '.contact-social-handle {', 'Follow us handles have no dedicated styling.');
file_contains($theme . '/assets/css/main.css', "letter-spacing: .04em;\n  text-transform: none;", 'Social handles are still forced to @TORATORA.AE instead of the live @toratora.ae username.');
file_contains($theme . '/inc/setup.php', "return '@toratora.ae';", 'Social handle helpers do not canonicalize to @toratora.ae.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_social_handles_1_4_3', 'Stale Instagram Customizer values will not be overwritten.');
file_does_not_contain($theme . '/front-page.php', "get_theme_mod('tora_instagram_url'", 'Contact Instagram still reads a stale Customizer URL.');
file_does_not_contain($theme . '/front-page.php', 'instagram.com/toratora.dxb', 'Contact still links to https://www.instagram.com/toratora.dxb.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_instagram_url_1_4_4', 'Saved Instagram Customizer values can stay on toratora.dxb after deploy.');

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
file_contains($theme . '/front-page.php', 'menu-items--columns', 'Draft Food Menu is missing the Figma two-column ramen layout.');
file_contains($theme . '/front-page.php', 'menu-item-note', 'Menu item notes are not rendered inline with Figma italic emphasis.');
file_contains($theme . '/front-page.php', 'menu-item--plain', 'Beverage plain sections are missing the no-bullet treatment.');
file_contains($theme . '/assets/css/main.css', '.menu-items--columns', 'Menu two-column CSS is missing.');
file_contains($theme . '/inc/default-content.php', "['SIGNATURE', 'COLOR CHANGING CREAM SODA'", 'Signature cream soda is missing Figma title/note split.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_menu_signature_1_3_8', 'Signature cream soda upgrade is missing.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_menu_title_candidates', 'Menu seeding must tolerate WordPress encoding & as &amp; in titles.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_menu_dedupe_1_3_10', 'Menu dedupe upgrade is missing.');
file_contains($theme . '/front-page.php', 'menu-tiger-mark', 'Menu tiger mark is missing.');
file_contains($theme . '/front-page.php', 'menu-heading', 'Menu heading layout wrapper is missing.');
file_does_not_contain($theme . '/front-page.php', 'id="menu-modal"', 'The old menu modal should be removed.');
file_contains($theme . '/inc/default-content.php', 'Draft Food Menu', 'Draft Food Menu category is not seeded.');
file_contains($theme . '/inc/default-content.php', 'Beverage', 'Beverage category is not seeded.');
file_contains($theme . '/inc/menu-items.php', 'draft-food-menu', 'Menu group ordering does not include Draft Food Menu.');
file_contains($theme . '/inc/menu-items.php', "'breakfast'", 'Breakfast category order is missing.');
file_contains($theme . '/inc/menu-items.php', "'appetizers'", 'Appetizers category order is missing.');
file_contains($theme . '/inc/menu-items.php', "'desserts'", 'Desserts category order is missing.');
file_contains($theme . '/inc/menu-items.php', "'beverage'", 'Beverage category order is missing.');
file_contains($theme . '/inc/menu-items.php', "'hide_empty' => false", 'Empty menu categories should remain visible.');
file_contains($theme . '/inc/menu-items.php', "'beverages'", 'Beverage category alias is missing.');

file_contains($theme . '/front-page.php', 'id="about"', 'About panel is missing.');
file_does_not_contain($theme . '/front-page.php', 'story-figure-gold', 'Gold medallion should not appear on primary About surfaces.');
file_contains($theme . '/front-page.php', 'gallery-blog', 'Gallery is missing the Figma /BLOG label.');
file_contains($theme . '/front-page.php', 'gallery-label', 'Gallery is missing the Figma section labels.');
file_contains($theme . '/front-page.php', "'slug' => '01'", 'Gallery is missing the Figma 01 FOOD label.');
file_contains($theme . '/front-page.php', "'slug' => '02'", 'Gallery is missing the Figma 02 INTERIOR label.');
file_contains($theme . '/front-page.php', "'slug' => '03'", 'Gallery is missing the Figma 03 FOOD label.');
file_contains($theme . '/front-page.php', 'gallery-ticker-track', 'Gallery ticker is missing the scrolling marquee track.');
file_contains($theme . '/assets/css/main.css', '@keyframes gallery-ticker-scroll', 'Gallery ticker marquee animation is missing.');
file_contains($theme . '/assets/css/main.css', 'overflow-y: auto;', 'Gallery panel scroll is missing.');
file_contains($theme . '/inc/setup.php', "'cell' => 6", 'Gallery is missing the wide geometric tile.');
file_contains($theme . '/assets/css/main.css', 'grid-template-areas:', 'Gallery mosaic is missing the Figma grid-template-areas pattern.');
file_contains($theme . '/assets/css/main.css', '"c1 c2 l1 c3"', 'Gallery row 1 pattern is missing.');
file_contains($theme . '/assets/css/main.css', '"l2 l2 c4 c5"', 'Gallery row 2 pattern is missing.');
file_contains($theme . '/assets/css/main.css', '"c6 c6 c7 l3"', 'Gallery row 3 wide interior pattern is missing.');
file_contains($theme . '/assets/css/main.css', '.gallery-cell-4 { grid-area: c4; }', 'Gallery row-2 tile is not assigned to area c4.');
file_contains($theme . '/assets/css/main.css', '.gallery-cell-6 { grid-area: c6; }', 'Gallery wide interior tile is not assigned to area c6.');
file_contains($theme . '/assets/css/main.css', 'container-type: inline-size;', 'Gallery mosaic is missing container-query row sizing.');
file_contains($theme . '/assets/css/main.css', '--gallery-col:', 'Gallery mosaic is missing proportional tile sizing.');
file_does_not_contain($theme . '/front-page.php', 'gallery-pattern-tile', 'Gallery still uses collage-style pattern tiles instead of empty geometric cells.');
file_contains($theme . '/front-page.php', "esc_html_e('GALLERY', 'tora-tora')", 'Gallery heading does not use the Figma title.');
file_does_not_contain($theme . '/front-page.php', 'gallery-mark', 'Gallery still overlays numbers on photo tiles instead of Figma gap labels.');
file_does_not_contain($theme . '/front-page.php', 'gallery-count', 'Gallery still renders the image count chrome.');
file_contains($theme . '/assets/js/site.js', 'gallery-view', 'Gallery chrome body class toggle is missing.');
file_contains($theme . '/assets/css/main.css', '.gallery-link:focus-visible', 'Gallery tiles are missing a dedicated keyboard focus treatment.');
file_contains($theme . '/assets/css/main.css', 'background: var(--tora-white)', 'Light panels do not use the Figma white surface.');
file_does_not_contain($theme . '/assets/css/main.css', '.panel::before', 'Panels still render the tiger watermark layer.');
file_does_not_contain($theme . '/assets/css/main.css', '.standard-page::before', 'Standard pages still render the tiger watermark layer.');
file_contains($theme . '/assets/css/main.css', '--tora-cream:', 'The staging cream token is missing.');
file_contains($theme . '/inc/setup.php', "tora_tora_uri() . '/assets/css/main.css'", 'Theme stylesheet enqueue is missing.');
file_does_not_contain($theme . '/inc/setup.php', 'fonts.googleapis.com', 'Raleway must be self-hosted so staging does not depend on Google Fonts.');
file_does_not_contain($theme . '/inc/compatibility.php', 'fonts.googleapis.com', 'Safe-head still loads Google Fonts instead of the bundled Raleway files.');
file_contains($theme . '/front-page.php', 'story-scroll-inner', 'About is missing the Figma poster wrapper.');
file_contains($theme . '/front-page.php', 'class="panel-scroll story-scroll-inner"', 'About scroller is not a panel-scroll, so cut copy cannot scroll.');
file_contains($theme . '/assets/css/main.css', ".story-scroll-inner {\n  position: relative;\n  height: 100%;\n  min-height: 100%;\n  overflow-x: hidden;\n  overflow-y: auto;", 'About panel still clips the last copy instead of scrolling.');
file_contains($theme . '/assets/css/main.css', "width: min(52rem, calc(100% - var(--panel-left) - 5.5rem));", 'About copy is still too narrow to fit the poster on one screen.');
file_contains($theme . '/assets/css/main.css', '--story-footer: clamp(2.6rem, 5vh, 3.5rem);', 'About speckle footer height token is missing.');
file_contains($theme . '/assets/css/main.css', "padding-bottom: calc(var(--story-footer) + .85rem);", 'About copy does not clear the speckle footer.');
file_contains($theme . '/front-page.php', 'story-pattern-disc', 'About is missing the Figma speckle disc.');
file_contains($theme . '/front-page.php', 'story-tiger-disc', 'About is missing the overlapping tiger badge.');
file_contains($theme . '/front-page.php', 'story-footer-pattern', 'About is missing the Figma speckle footer bar.');
file_does_not_contain($theme . '/front-page.php', 'story-ticker', 'About still renders the off-Figma TORA TORA ticker instead of the speckle footer.');
file_contains($theme . '/front-page.php', 'story-accent-arc', 'About is missing the top-right blue accent arc.');
file_contains($theme . '/front-page.php', 'about-brand-line', 'About title does not lock TORA TORA onto the second line.');
file_does_not_contain($theme . '/front-page.php', 'story-screen-secondary', 'About still has a second empty scroll screen.');
file_does_not_contain($theme . '/assets/css/main.css', 'height: 200%', 'About is still locked to a two-viewport scroller.');
file_contains($theme . '/assets/js/site.js', 'about-panel', 'About panel body class toggle is missing.');
file_contains($theme . '/inc/default-content.php', '<strong>courage, strength and indomitable spirit</strong>. The tiger has a storied presence', 'About emphasis is not the local bold spirit line.');
file_contains($theme . '/inc/default-content.php', '<strong>tradition with contemporary flair</strong>', 'About closing emphasis is not the local bold flair line.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_about_copy_1_3_15', 'About Figma poster copy upgrade is missing.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_about_copy_1_3_39', 'About bold-emphasis upgrade is missing, so staging keeps italic copy.');
file_contains($theme . '/inc/default-content.php', '<strong>', 'About default copy is missing bold emphasis.');
file_does_not_contain($theme . '/front-page.php', "word for <em>", 'About fallback copy still italicizes tiger beyond the Figma poster.');
file_contains($theme . '/front-page.php', "'strong' => []", 'About fallback sanitization does not allow bold emphasis.');
file_contains($theme . '/assets/css/main.css', '.story-copy .entry-content p:empty', 'About still lets an empty paragraph push copy under the speckle footer.');
file_contains($theme . '/assets/css/main.css', '.story-copy .entry-content br + br', 'About double line-breaks still push the last copy under the speckle footer.');
file_contains($theme . '/assets/css/main.css', ".story-copy .entry-content em {\n  font-style: normal;\n  font-weight: 700;\n}", 'Staging italic About markup is not forced to the local bold weight.');
file_contains($theme . '/assets/css/main.css', 'url("../fonts/raleway-latin-wght-normal.woff2")', 'Bundled Raleway roman files are missing, so staging bold weight cannot load.');
file_contains($theme . '/assets/css/main.css', 'url("../fonts/raleway-latin-wght-italic.woff2")', 'Bundled Raleway italic files are missing.');
file_contains($theme . '/assets/css/main.css', '.story-art {', 'About art positioning block is missing.');
file_contains($theme . '/front-page.php', 'story-copy-body', 'About copy is missing the Figma rule wrapper.');
file_contains($theme . '/assets/css/main.css', ".story-copy .entry-content {\n  position: relative;\n  max-width: none;\n  margin-top: 1.55rem;\n  font-family: var(--font-main);\n  letter-spacing: .02em;\n  text-transform: uppercase;", 'About story copy is not rendered in Figma all-caps.');
file_contains($theme . '/assets/css/main.css', '.story-copy .entry-content p {
  font-size: clamp(1.02rem, 1.38vw, 1.22rem);
  font-weight: 500;
  letter-spacing: .045em;
  line-height: 1.5;', 'About body type does not match the Figma poster measure.');
file_contains($theme . '/assets/css/main.css', '.story-footer-pattern {', 'About speckle footer styling is missing.');
file_contains($theme . '/assets/css/main.css', '.story-panel #about-title', 'About title is missing its Avant Garde display size.');
file_contains($theme . '/front-page.php', 'home-split', 'Home is missing the Figma split layout wrapper.');
file_contains($theme . '/assets/css/main.css', ".home-panel {\n  padding: 0;", 'Home panel still has inset padding instead of a full-bleed Figma split.');
file_contains($theme . '/assets/css/main.css', 'grid-template-columns: minmax(0, 58%) minmax(0, 42%)', 'Home split columns do not match the Figma 58/42 proportion.');
file_contains($theme . '/assets/css/main.css', ".home-content h1 {\n  max-width: 11ch;\n  white-space: normal;", 'Home headline still clips as a forced single line.');
file_contains($theme . '/assets/css/main.css', '.menu-rail {', 'Menu full-height rail styling is missing.');
file_contains($theme . '/assets/css/main.css', 'align-self: stretch;', 'Menu rail is not explicitly stretched to panel height.');
file_contains($theme . '/assets/css/main.css', '.delivery-zones li {
  display: flex;
  align-items: center;
  justify-content: center;
  grid-column: span 4;
  min-height: 2.95rem;', 'Delivery zone chips are not on the aligned Figma grid.');
file_contains($theme . '/assets/css/main.css', '.gallery-cell-1 { grid-area: c1; }', 'Gallery geometric placement is missing.');
file_contains($theme . '/assets/css/main.css', 'position: absolute;', 'Menu rail is not pinned to the full viewport edge.');
file_contains($theme . '/assets/css/main.css', '.menu-rail-right::after', 'Menu rail is missing the solid blue hamburger gutter.');
file_contains($theme . '/assets/css/main.css', ".menu-rail-right::after {\n  content: \"\";\n  position: absolute;\n  top: 0;\n  right: 0;\n  bottom: 0;\n  width: var(--menu-solid);\n  background: var(--tora-blue);\n}", 'Menu solid blue gutter is not sized from the shared rail token.');
file_contains($theme . '/assets/css/main.css', '--menu-solid: max(calc(var(--menu-rail) / 2), calc(var(--toggle-size) + .5rem));', 'Menu solid gutter is not the Figma half rail, or can shrink below the menu icon.');
file_contains($theme . '/assets/css/main.css', 'right: calc((var(--menu-solid) - var(--toggle-size)) / 2);', 'Menu icon is not centred in the solid blue gutter, so it can spill off the right edge on phones.');
file_does_not_contain($theme . '/assets/css/main.css', 'min-height: 36rem;', 'The site frame is taller than landscape phone screens, which cuts off the bottom of every panel.');
file_does_not_contain($theme . '/assets/css/main.css', '.site-shell { min-height: 30rem; }', 'The phone site frame is taller than landscape screens, which cuts off the bottom of every panel.');
file_contains($theme . '/assets/css/main.css', "@media (max-height: 560px) {\n  .home-content {", 'Home copy is cut off on short landscape screens.');
file_contains($theme . '/assets/js/site.js', 'menu-view', 'Menu chrome body class toggle is missing.');
file_contains($theme . '/front-page.php', 'careers-job-bullet', 'Careers job meta is missing a visible bullet separator.');
file_contains($theme . '/front-page.php', 'class="careers-job-bullet" aria-hidden="true">•</span>', 'Careers job meta does not render a bullet character in place of the em dash.');
file_contains($theme . '/assets/css/main.css', '.careers-job-bullet', 'Careers bullet styling is missing.');
file_contains($theme . '/assets/css/main.css', "--panel-left: clamp(4.5rem, 12.5vw, 10.25rem);", 'Shared About/Careers/Menu left inset token is missing.');
file_contains($theme . '/assets/css/main.css', 'left: var(--panel-left);', 'About copy does not use the shared left inset.');
file_contains($theme . '/assets/css/main.css', 'padding-left: var(--panel-left);', 'Careers does not share the About left inset.');
file_contains($theme . '/assets/css/main.css', ".menu-layout {\n  display: flex;\n  flex-direction: column;\n  width: 100%;\n  max-width: none;\n  margin: 0;", 'Menu layout is still centered instead of sharing the About left inset.');
file_contains($theme . '/assets/css/main.css', "padding-bottom: clamp(3rem, 5vh, 4.5rem);\n  padding-left: var(--panel-left);", 'Menu does not share the About left inset.');
file_contains($theme . '/assets/css/main.css', ".careers-panel #careers-title {\n  width: max-content;\n  white-space: nowrap;", 'Careers JOIN THE TEAM is not locked as a single non-wrapping line.');
file_does_not_contain($theme . '/front-page.php', 'careers-team-line', 'Careers title is still split across two lines.');
file_contains($theme . '/assets/css/main.css', 'grid-template-areas:', 'Gallery mobile mosaic is missing a structured grid pattern.');
file_does_not_contain($theme . '/assets/css/main.css', 'grid-auto-flow: row dense;', 'Gallery mobile mosaic should not use dense packing that collapses the Figma pattern.');
file_contains($theme . '/inc/jobs.php', 'tora_tora_normalize_job_meta_separator', 'Careers metadata does not normalize dash separators into bullets.');
file_contains($theme . '/inc/jobs.php', ' • ', 'Careers metadata does not use the Figma bullet separator.');
file_does_not_contain($theme . '/inc/jobs.php', ' — ', 'Careers metadata still uses an em dash separator.');
file_contains($theme . '/assets/css/main.css', '.delivery-order {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  margin-top: auto;', 'Delivery card CTA is not pinned to the bottom of each card.');
file_contains($theme . '/assets/css/main.css', '.contact-logo {
  flex: 0 0 auto;
  width: clamp(6.75rem, 11vw, 9rem);', 'Contact wordmark is not sized to the right column.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_menu_is_coming_soon(): bool', 'Menu coming-soon switch helper is missing.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_delivery_enabled(): bool', 'Delivery visibility switch helper is missing.');
file_contains($theme . '/inc/customizer.php', "add_setting('tora_menu_coming_soon'", 'Menu coming-soon Customizer setting is missing.');
file_contains($theme . '/inc/customizer.php', "add_setting('tora_delivery_enabled'", 'Delivery visibility Customizer setting is missing.');
file_contains($theme . '/front-page.php', 'tora_tora_menu_is_coming_soon()', 'Menu panel does not honour the coming-soon switch.');
file_contains($theme . '/front-page.php', 'menu-coming-soon', 'Menu coming-soon notice is missing.');
file_contains($theme . '/front-page.php', 'tora_tora_delivery_enabled()', 'Delivery panel is not gated behind the visibility switch.');
file_contains($theme . '/header.php', 'tora_tora_delivery_enabled()', 'Delivery navigation link is not gated behind the visibility switch.');
file_contains($theme . '/assets/css/main.css', '.menu-coming-soon {', 'Menu coming-soon notice has no styling.');
file_contains($theme . '/inc/setup.php', 'tora_tora_format_address_lines', 'Contact address line formatting helper is missing.');
file_contains($theme . '/front-page.php', 'contact-location-line', 'Contact address is not rendered as two lines.');
file_contains($theme . '/assets/css/main.css', 'overflow-wrap: anywhere;', 'Long custom Contact addresses can overflow on mobile.');
file_contains($theme . '/front-page.php', 'tora_tora_logo_url()', 'Contact does not use the full Tora Tora wordmark.');
file_contains($theme . '/inc/setup.php', "tora_tora_asset('images/tora-tora-logo.png')", 'Front-end brand mark does not use the packaged header logo.');
file_contains($theme . '/inc/setup.php', "tora_tora_asset_version('assets/images/tora-tora-logo.png')", 'Packaged logo is not cache-busted, so staging can keep serving the old circular mark.');
file_does_not_contain($theme . '/inc/setup.php', "get_theme_mod('custom_logo'", 'Site Identity custom logo still overrides the packaged header mark on staging.');
file_does_not_contain($theme . '/inc/default-content.php', 'wp_delete_post($item->ID, true);', 'The 1.3.5 migration can delete editor-created menu items.');
file_does_not_contain($theme . '/assets/css/main.css', 'outline: 3px solid var(--tora-tiger)', 'Home hamburger still uses the off-Figma yellow ring.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_home_intro_1_2_1', 'Home intro restoration upgrade is missing.');
file_contains($theme . '/inc/default-content.php', 'JOIN THE TEAM', 'Careers default content does not match the Figma copy.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_to_1_2_0', 'Figma content upgrade hook is missing.');
file_contains($theme . '/assets/css/main.css', '.delivery-card:hover', 'Delivery cards are missing a clear hover treatment.');
file_does_not_contain($theme . '/assets/css/main.css', 'filter: contrast(1.1)', 'The pattern still amplifies JPEG compression artifacts.');
file_does_not_contain($theme . '/assets/css/main.css', '.pattern-panel:not(.nav-open) .brand-link {', 'The white logo chip is still present on the patterned panel.');
file_contains($theme . '/assets/css/main.css', '--pattern: image-set(', 'The pattern token does not prefer modern high-resolution assets.');
file_contains($theme . '/assets/css/main.css', 'tora-tora-pattern.webp', 'The pattern token is missing its WebP source.');
file_contains($theme . '/assets/css/main.css', 'tora-tora-pattern.png', 'The pattern token is missing its PNG fallback.');
file_contains($theme . '/assets/css/main.css', '.delivery-logo', 'Delivery logo sizing styles are missing.');
file_contains($theme . '/inc/setup.php', "'standard-page-context'", 'Standard WordPress pages are missing their dedicated light-surface body class.');
file_contains($theme . '/inc/setup.php', "\$classes[] = 'light-panel';", 'Standard WordPress pages do not switch fixed chrome to the accessible blue-on-white treatment.');

file_contains($theme . '/functions.php', '/inc/editor.php', 'Panel editor helpers are not bootstrapped.');
file_contains($theme . '/inc/editor.php', 'function tora_tora_panel_edit_targets', 'Panel edit-target map is missing.');
file_contains($theme . '/inc/editor.php', "'about' => 'story'", 'About panel is not mapped to the Story page editors actually need.');
file_contains($theme . '/inc/editor.php', 'tora_tora_admin_bar_panel_edits', 'Admin bar does not expose per-panel edit links.');
file_contains($theme . '/inc/editor.php', "parent' => 'edit'", 'Admin bar Edit Page is missing a dropdown of homepage panels.');
file_contains($theme . '/inc/editor.php', 'display_post_states', 'Pages list does not label Home/About panel sources.');
file_contains($theme . '/inc/editor.php', 'tora_tora_panel_editor_notice', 'Block editor is missing a notice that Home is not the About panel.');
file_contains($theme . '/inc/editor.php', 'Edit About', 'Homepage editor does not send editors to the About page.');
file_contains($theme . '/footer.php', 'tora-tora-panel-edits', 'Logged-in front page does not expose panel edit URLs to JavaScript.');
file_contains($theme . '/assets/js/site.js', 'updateAdminBarEdit', 'Admin bar Edit Page link is not updated for the active panel.');
file_contains($theme . '/assets/js/site.js', 'wp-admin-bar-edit', 'Admin bar Edit Page node is not retargeted when switching panels.');
file_contains($theme . '/inc/setup.php', 'tora_tora_find_panel_page', 'Panel page lookup helper is missing.');

// Website comments PDF (1.5.0).
file_does_not_contain($theme . '/front-page.php', 'home-indicators', 'Home still renders the fake carousel dots.');
file_does_not_contain($theme . '/assets/css/main.css', '.home-indicators', 'Home still ships the fake carousel dot styles.');
file_does_not_contain($theme . '/front-page.php', "get_template_part('template-parts/panel', 'back')", 'Homepage panels still render a back arrow next to the header menu.');
expect_true(!is_file($theme . '/template-parts/panel-back.php'), 'The unused panel back-arrow template part is still shipped.');
file_contains($theme . '/single-job_listing.php', 'Back to careers', 'Single job pages lost their return link to careers.');
file_contains($theme . '/assets/css/main.css', '--home-gutter: calc(var(--side) + 5.25rem);', 'Home gutter width token is missing.');
file_contains($theme . '/assets/css/main.css', ".home-pattern::after {\n  content: \"\";\n  position: absolute;\n  top: 0;\n  right: 0;\n  bottom: 0;\n  width: var(--home-gutter);\n  background: var(--tora-white);", 'Home white gutter is not painted over the speckle, so a blue sliver can show at the seam.');
file_contains($theme . '/assets/css/main.css', ".home-pattern::before {\n  content: \"\";\n  position: absolute;\n  inset: 0;\n  background-image: var(--pattern);", 'Home speckle does not fill its column, or still has a fill colour that bleeds at the seam.');
file_contains($theme . '/assets/css/main.css', 'padding-right: calc((var(--home-gutter) - var(--toggle-size)) / 2);', 'Home menu icon is not centred in the white gutter.');
file_contains($theme . '/assets/css/main.css', ".overlay-menu {\n  position: fixed;\n  inset: -1px;", 'Nav overlay does not bleed past every edge, so the homepage can show through.');
file_contains($theme . '/assets/css/main.css', 'min-height: calc(100lvh + 2px);', 'Nav overlay can end above the bottom of a mobile viewport.');
file_does_not_contain($theme . '/assets/css/main.css', 'inset: var(--staging) 0 0;', 'Nav overlay still starts at --staging, which leaves a gap when the chrome is shorter.');
file_contains($theme . '/assets/css/main.css', "--chrome-line: calc(var(--staging) + var(--header-pad) + var(--brand-mark) + .75rem);", 'Shared logo-row bottom edge token is missing.');
file_contains($theme . '/assets/css/main.css', '--panel-gap: calc(var(--panel-top) - var(--chrome-line));', 'Scroll areas do not keep the original title position below the logo row.');
foreach (['menu', 'delivery', 'gallery', 'careers', 'contact'] as $scroll_panel) {
    file_contains($theme . '/assets/css/main.css', ".{$scroll_panel}-panel {\n", "The {$scroll_panel} panel block is missing.");
}
expect_true(
    substr_count((string) file_get_contents($theme . '/assets/css/main.css'), 'padding: var(--chrome-line) 0 0;') >= 5,
    'Menu, Delivery, Gallery, Careers and Contact scroll areas do not all start below the fixed logo row.'
);
file_does_not_contain($theme . '/assets/css/main.css', '.panel { padding-bottom: 3.5rem; overflow: auto; }', 'Phones still scroll the whole panel under the fixed logo and menu icon.');
file_does_not_contain($theme . '/assets/css/main.css', '.panel-scroll { height: auto; min-height: 100%; overflow: visible; }', 'Phones still switch off the inner panel scroller.');
file_contains($theme . '/front-page.php', 'story-chrome-guard', 'About copy can still scroll under the fixed logo.');
file_contains($theme . '/assets/css/main.css', ".story-chrome-guard {\n  position: sticky;\n  top: 0;", 'About chrome guard is not pinned under the logo row.');
$front_page_source = (string) file_get_contents($theme . '/front-page.php');
$about_arc_at = strpos($front_page_source, '<span class="story-accent-arc" aria-hidden="true"></span>');
$about_scroller_at = strpos($front_page_source, '<div class="panel-scroll story-scroll-inner">');
expect_true($about_arc_at !== false && $about_scroller_at !== false && $about_arc_at < $about_scroller_at, 'About corner disc still scrolls away from the menu icon.');
file_contains($theme . '/assets/css/main.css', 'hypot(var(--side) + var(--toggle-size) / 2, var(--toggle-dy))', 'About corner disc is not sized from the menu icon position.');
file_contains($theme . '/assets/css/main.css', 'top: calc(var(--toggle-dy) - var(--toggle-size) / 2);', 'Menu panel icon is not on the logo row.');
file_does_not_contain($theme . '/assets/css/main.css', 'top: calc(var(--staging) + .55rem);', 'Menu panel icon still double-counts the staging chrome.');
file_contains($theme . '/assets/css/main.css', "bottom: -1px;\n  z-index: 5;\n  height: calc(var(--story-footer) + 1px);", 'About speckle footer is not flush to the panel bottom.');
file_contains($theme . '/front-page.php', "</div>\n        </div>\n        <div class=\"gallery-ticker\" aria-hidden=\"true\">", 'Gallery ticker still sits inside the padded scroller, so it stops short of the edges.');
file_contains($theme . '/assets/css/main.css', ".gallery-ticker {\n  position: absolute;\n  right: 0;\n  bottom: 0;\n  left: 0;", 'Gallery ticker is not pinned full width to the bottom of the panel.');
file_does_not_contain($theme . '/assets/css/main.css', 'margin: 0 calc(var(--side) * -1) 0;', 'Gallery ticker still only cancels the right padding.');
file_contains($theme . '/front-page.php', 'careers-title-row', 'Careers roles badge is not on the title row.');
file_contains($theme . '/assets/css/main.css', "padding-right: var(--panel-left);\n  padding-bottom: clamp(2rem, 4vh, 3rem);\n  padding-left: var(--panel-left);", 'Careers column still has unequal side insets.');
file_does_not_contain($theme . '/assets/css/main.css', 'padding-right: clamp(4.5rem, 8vw, 7rem);', 'Careers still uses the tighter right inset that pushes the column left.');

file_contains($theme . '/theme.json', '"slug": "avant-garde"', 'theme.json does not register ITC Avant Garde Gothic.');
file_contains($theme . '/theme.json', 'file:./assets/fonts/itc-avant-garde-pro-bold.woff2', 'theme.json does not self-host the supplied Avant Garde file.');
file_contains($theme . '/theme.json', '"heading": { "typography": { "fontFamily": "var(--wp--preset--font-family--avant-garde)", "fontWeight": "700"', 'Editor headings are not Avant Garde at 700.');
file_does_not_contain($theme . '/theme.json', '"800"', 'theme.json still asks for an Avant Garde weight that was not supplied.');
file_does_not_contain($theme . '/assets/css/editor.css', 'font-weight: 800', 'Editor headings still ask for weight 800.');
file_contains($theme . '/assets/css/editor.css', '"ITC Avant Garde Gothic"', 'Editor headings do not use the display face.');
file_contains($theme . '/assets/css/main.css', ".menu-item h4 {\n  margin: 0;\n  color: var(--tora-blue);\n  font-size:", 'Menu dish names still override the display face with Raleway.');
file_contains($theme . '/assets/css/main.css', ".menu-item-note {\n  font-family: var(--font-main);", 'Menu notes are not kept on Raleway.');

file_contains($theme . '/front-page.php', 'tora_tora_split_story_sections', 'About does not split the kitchen section from the tiger story.');
file_contains($theme . '/front-page.php', 'class="story-kitchen-copy entry-content"', 'About is missing the Chef Gouda kitchen block.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_split_story_sections', 'Story section split helper is missing.');
file_contains($theme . '/inc/default-content.php', 'function tora_tora_default_kitchen_story', 'Kitchen seed copy helper is missing.');
file_contains($theme . '/inc/default-content.php', 'Chef Gouda leads the Tora Tora kitchen, where every dish on our menu is made from start to finish.', 'Kitchen seed does not stick to the confirmed facts.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_about_kitchen_1_5_0', 'Existing About pages do not receive the kitchen section.');
file_contains($theme . '/assets/css/main.css', '.story-kitchen-copy h3', 'Kitchen heading has no display styling.');
file_contains($theme . '/front-page.php', 'menu-intro', 'Menu is missing the line tying the dishes to the kitchen.');
file_contains($theme . '/inc/customizer.php', 'tora_menu_intro', 'Menu intro line is not editable in the Customizer.');
file_contains($theme . '/functions.php', "define('TORA_TORA_VERSION', '1.5.1');", 'Theme version was not bumped, so the kitchen upgrades will not run.');

file_contains($theme . '/inc/customizer.php', 'Placeholder. Confirm before launch.', 'Placeholder contact details are not flagged in the Customizer.');
file_contains($theme . '/inc/customizer.php', "'tora_phone',", 'Placeholder phone is not flagged for launch.');
file_contains($theme . '/inc/customizer.php', 'Replace it with photography of the restaurant when available.', 'Brand Book and concept-render gallery images are not flagged in the Customizer.');
file_contains($theme . '/inc/customizer.php', "add_setting('tora_staging_mode', ['default' => true", 'Staging mode must stay on by default while placeholders remain.');
file_contains($root . '/docs/design-guides.md', '## 4. Launch checklist', 'Design guide is missing the launch checklist.');
file_contains($root . '/docs/design-guides.md', 'Gallery photos.', 'Launch checklist does not cover the gallery photos.');

// Brand Guideline folder (1.5.1).
foreach (['avantgarde-400', 'avantgarde-500', 'avantgarde-600', 'avantgarde-700'] as $unsupplied_cut) {
    expect_true(!is_file($theme . "/assets/fonts/{$unsupplied_cut}.woff2"), "Avant Garde cut {$unsupplied_cut} is not in the client's brand kit but still ships.");
    file_does_not_contain($theme . '/assets/css/main.css', $unsupplied_cut, "main.css still loads {$unsupplied_cut}.");
    file_does_not_contain($theme . '/theme.json', $unsupplied_cut, "theme.json still registers {$unsupplied_cut}.");
}
file_contains($theme . '/assets/css/main.css', 'url("../fonts/itc-avant-garde-pro-bold.woff2")', 'Headings do not use the ITC Avant Garde Gothic Pro Bold file the client supplied.');
file_contains($theme . '/header.php', 'fonts/itc-avant-garde-pro-bold.woff2', 'The display font is not preloaded, so headings flash in the fallback face.');
if (function_exists('imagecreatefromjpeg') && is_file($theme . '/assets/images/tora-tora-pattern.jpg')) {
    $pattern_image = imagecreatefromjpeg($theme . '/assets/images/tora-tora-pattern.jpg');
    $off_brand_blue = 0;
    for ($pattern_y = 0; $pattern_y < imagesy($pattern_image); $pattern_y += 8) {
        for ($pattern_x = 0; $pattern_x < imagesx($pattern_image); $pattern_x += 8) {
            $pattern_rgb = imagecolorat($pattern_image, $pattern_x, $pattern_y);
            // The supplied artwork was #002AF2. Tora Blue #0500F5 has no green.
            if ((($pattern_rgb >> 16) & 0xFF) < 20 && (($pattern_rgb >> 8) & 0xFF) > 25 && ($pattern_rgb & 0xFF) > 200) {
                $off_brand_blue++;
            }
        }
    }
    expect_true($off_brand_blue === 0, "The speckle pattern still uses the off-palette #002AF2 blue ({$off_brand_blue} sampled pixels).");
}
foreach (['ramen-noodles', 'ramen-tableware', 'ramen-to-go', 'interior-counter', 'interior-booths', 'interior-shibori', 'interior-bar', 'brand-cups', 'brand-sign', 'brand-bag', 'brand-hoarding'] as $gallery_stem) {
    foreach (['sm', 'lg'] as $gallery_size) {
        expect_true(is_file($theme . "/assets/images/gallery-{$gallery_stem}-{$gallery_size}.jpg"), "Brand gallery image gallery-{$gallery_stem}-{$gallery_size}.jpg is missing.");
    }
    file_contains($theme . '/inc/setup.php', "'stem' => 'gallery-{$gallery_stem}'", "Gallery tile gallery-{$gallery_stem} is not wired into the mosaic.");
}
expect_true(!is_file($theme . '/assets/images/gallery-1.jpg'), 'The generic stock gallery photos still ship.');
file_contains($theme . '/front-page.php', 'srcset=', 'Gallery and kitchen images are not responsive.');
file_does_not_contain($theme . '/front-page.php', 'Tora Tora gallery image %d', 'Gallery tiles still use numbered alt text instead of describing the image.');
file_contains($theme . '/assets/css/main.css', "mix-blend-mode: screen;", 'Gallery tiles are missing the Tora Blue duotone.');
file_contains($theme . '/assets/css/main.css', "@media (hover: hover) {\n  .gallery-link:hover img", 'Duotone lifts on touch taps instead of only on pointer hover.');
file_contains($theme . '/assets/css/main.css', '.gallery-link:focus-visible img { filter: none;', 'Keyboard focus does not reveal the gallery photo in colour.');
file_contains($theme . '/front-page.php', "__('ROAR RAMEN JOINT', 'tora-tora')", 'Gallery ticker does not carry the Roar Ramen Joint line.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_panel_kicker', 'Panel chapter marker helper is missing.');
file_contains($theme . '/front-page.php', 'tora_tora_panel_kicker(++$panel_number', 'Panel chapter numbers are hard-coded instead of counting the panels actually shown.');
file_does_not_contain($theme . '/inc/setup.php', 'function tora_tora_panel_rail', 'The left-edge brand rail is still rendered.');
file_does_not_contain($theme . '/front-page.php', 'tora_tora_panel_rail', 'A panel still prints the left-edge brand rail.');
file_does_not_contain($theme . '/assets/css/main.css', '.panel-rail', 'Left-edge brand rail styles are still in the stylesheet.');
file_contains($theme . '/front-page.php', 'The myth of the Japanese tiger', 'About is missing the Brand Book chapter title.');
file_contains($theme . '/front-page.php', 'story-kitchen-figure', 'About kitchen story has no image.');
file_contains($theme . '/inc/customizer.php', "'tora_kitchen_image'", 'About kitchen image cannot be replaced in the Customizer.');
file_contains($theme . '/inc/default-content.php', 'tora_tora_upgrade_about_kitchen_1_5_1', 'Sites that ran 1.5.0 keep the one-line kitchen seed.');
file_does_not_contain($theme . '/assets/css/main.css', '.menu-item::before', 'Menu rows still use bullets instead of the Brand Book ruled list.');
file_contains($theme . '/assets/css/main.css', 'font-variant-numeric: tabular-nums;', 'Menu prices do not line up.');
file_contains($theme . '/assets/css/main.css', '.overlay-menu li { transition-delay: 0s !important; }', 'Menu link stagger ignores reduced motion.');

// Home motion: entrance on first visit, short settle on return, slow speckle drift at rest.
file_contains($theme . '/front-page.php', 'data-home-motion="intro"', 'Home does not start its entrance from first paint.');
file_contains($theme . '/front-page.php', 'tora_tora_home_title_words($home[\'title\'])', 'Home headline words are not wrapped for the cascade.');
file_contains($theme . '/inc/setup.php', 'function tora_tora_home_title_words', 'Home headline word wrapper is missing.');
file_contains($theme . '/inc/setup.php', 'home-title-word-inner', 'Home headline words have no inner span to slide.');
file_contains($theme . '/front-page.php', '<h1 id="home-title" aria-label="<?php echo esc_attr($home[\'title\']); ?>">', 'Screen readers can read the split Home headline one word at a time.');
file_contains($theme . '/inc/setup.php', '<span class="home-title-word" aria-hidden="true"', 'Home headline word spans are exposed to screen readers alongside the heading label.');
file_contains($theme . '/assets/css/main.css', '@media (prefers-reduced-motion: no-preference)', 'Home motion is not gated on reduced-motion preference.');
file_contains($theme . '/assets/css/main.css', '@keyframes home-pattern-drift', 'Home speckle has no idle drift.');
file_contains($theme . '/assets/css/main.css', '.home-panel[data-home-motion="idle"] .home-pattern::before', 'Home drift is not limited to the idle state.');
file_does_not_contain($theme . '/assets/css/main.css', '@keyframes home-title-in', 'Home headline fades from invisible, which delays the largest paint.');
file_contains($theme . '/assets/js/site.js', 'function setHomeMotion', 'site.js does not move Home between motion states.');
file_contains($theme . '/assets/js/site.js', 'homeHasPlayedIntro', 'Returning to Home would replay the full entrance.');

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
