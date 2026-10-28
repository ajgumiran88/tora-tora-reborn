<?php
/** Exercise the real renderers without a WordPress install or third-party plugins. */
define('ABSPATH', __DIR__ . '/');
$compatibility = ['staging' => false, 'job' => false, 'override' => null, 'broken_hooks' => true, 'head' => 0, 'footer' => 0];

function get_theme_mod($name, $default = false)
{
    return 'tora_staging_mode' === $name ? $GLOBALS['compatibility']['staging'] : $default;
}
function is_singular($type): bool
{
    return 'job_listing' === $type && $GLOBALS['compatibility']['job'];
}
function apply_filters($name, $value)
{
    return 'tora_tora_use_safe_head' === $name ? ($GLOBALS['compatibility']['override'] ?? $value) : $value;
}
function add_filter(...$args): void {}
function add_action(...$args): void {}
function tora_tora_uri(): string { return 'https://example.test/theme'; }
function tora_tora_asset_version($path): string { return 'test'; }
function esc_html($value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
function esc_url($value): string { return (string) $value; }
function get_bloginfo($name): string { return 'Tora Tora'; }
function is_admin_bar_showing(): bool { return false; }
function wp_head(): void
{
    $GLOBALS['compatibility']['head']++;
    if ($GLOBALS['compatibility']['broken_hooks']) {
        throw new Error('Simulated lte-ext Fontello asset failure.');
    }
}
function wp_footer(): void
{
    $GLOBALS['compatibility']['footer']++;
    if ($GLOBALS['compatibility']['broken_hooks']) {
        throw new Error('Simulated third-party footer asset failure.');
    }
}

require $theme . '/inc/staging.php';
require $theme . '/inc/compatibility.php';

expect_true(tora_tora_use_safe_head(), 'Going live must retain host compatibility independently of staging mode.');
ob_start();
try {
    tora_tora_render_document_head();
    tora_tora_render_document_footer();
} catch (Error $error) {
    expect_true(false, 'Live rendering re-entered broken plugin hooks: ' . $error->getMessage());
}
$live_html = (string) ob_get_clean();
expect_true(str_contains($live_html, '/assets/css/main.css?ver=test'), 'Live safe head must load the theme stylesheet.');
expect_true(str_contains($live_html, '/assets/js/site.js?ver=test'), 'Live safe footer must load the theme script.');
expect_true(0 === $compatibility['head'] && 0 === $compatibility['footer'], 'Live safe renderers must bypass third-party asset hooks.');

// Also exercise indexing with safe mode explicitly forced on.
$compatibility['override'] = true;
ob_start();
tora_tora_render_document_head();
$live_html = (string) ob_get_clean();
expect_true(!str_contains($live_html, 'noindex'), 'The live safe head must not emit a staging noindex directive.');
expect_true(['index' => true] === tora_tora_staging_robots(['index' => true]), 'Live robots directives must remain unchanged.');

$compatibility['staging'] = true;
ob_start();
tora_tora_render_document_head();
$staging_html = (string) ob_get_clean();
expect_true(str_contains($staging_html, 'noindex,nofollow'), 'Staging safe head must retain search-engine protection.');
expect_true(['noindex' => true, 'nofollow' => true] === tora_tora_staging_robots(['index' => true]), 'Staging robots filter must retain noindex/nofollow.');

$compatibility['override'] = null;
$compatibility['job'] = true;
expect_true(!tora_tora_use_safe_head(), 'Job application pages must retain the normal WordPress asset pipeline.');
$compatibility['override'] = true;
expect_true(tora_tora_use_safe_head(), 'The safe-head filter must still override the job-page exception.');
$compatibility['job'] = false;
$compatibility['override'] = false;
$compatibility['broken_hooks'] = false;
ob_start();
tora_tora_render_document_head();
tora_tora_render_document_footer();
ob_end_clean();
expect_true(1 === $compatibility['head'] && 1 === $compatibility['footer'], 'The safe-head filter must still allow the normal WordPress pipeline.');
