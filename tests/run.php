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
    'assets/fonts/avantgarde-400.woff2', 'assets/fonts/avantgarde-500.woff2',
    'assets/fonts/avantgarde-600.woff2', 'assets/fonts/avantgarde-700.woff2',
    'assets/fonts/raleway-latin-wght-normal.woff2', 'assets/fonts/raleway-latin-wght-italic.woff2',
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

file_contains($theme . '/assets/css/main.css', '.light-panel:not(.nav-open) .brand-link img', 'Light-panel logo invert is missing.');
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
file_contains($theme . '/front-page.php', "'cell' => 6", 'Gallery is missing the wide geometric tile.');
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
file_contains($theme . '/assets/css/main.css', "padding-bottom: calc(clamp(2.6rem, 5vh, 3.5rem) + .85rem);", 'About copy does not clear the speckle footer.');
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
file_contains($theme . '/assets/css/main.css', ".menu-rail-right::after {\n  content: \"\";\n  position: absolute;\n  top: 0;\n  right: 0;\n  bottom: 0;\n  width: 50%;\n  background: var(--tora-blue);\n}", 'Menu solid blue gutter does not match the Figma half-rail edge.');
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
