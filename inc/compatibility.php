<?php
/**
 * Host / plugin compatibility (SiteGround, Rank Math, optimizers).
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Whether to bypass wp_head/wp_footer plugin output.
 *
 * Default: on while staging mode is enabled (review stacks often fatal inside wp_head).
 */
function tora_tora_use_safe_head(): bool
{
    $default = function_exists('tora_tora_staging_enabled') && tora_tora_staging_enabled();
    return (bool) apply_filters('tora_tora_use_safe_head', $default);
}

function tora_tora_bootstrap_host_compatibility(): void
{
    if (!tora_tora_use_safe_head()) {
        return;
    }

    add_filter('rank_math/frontend/disable', '__return_true', 0);
    add_filter('rank_math/json_ld', '__return_empty_array', 99);

    if (function_exists('add_filter')) {
        add_filter('sgo_html_minify_disable', '__return_true');
        add_filter('sgo_js_minify_disable', '__return_true');
        add_filter('sgo_css_minify_disable', '__return_true');
    }
}
add_action('after_setup_theme', 'tora_tora_bootstrap_host_compatibility', 0);

function tora_tora_render_document_head(): void
{
    if (!tora_tora_use_safe_head()) {
        wp_head();
        return;
    }

    if (!did_action('wp_enqueue_scripts')) {
        wp_enqueue_scripts();
    }

    echo '<title>' . esc_html(wp_get_document_title()) . '</title>' . "\n";
    echo '<meta name="robots" content="noindex,nofollow" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
    echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;800&amp;display=swap" />' . "\n";

    wp_print_styles();
    if (function_exists('wp_print_head_scripts')) {
        wp_print_head_scripts();
    }
}

function tora_tora_render_document_footer(): void
{
    if (!tora_tora_use_safe_head()) {
        wp_footer();
        return;
    }

    wp_print_footer_scripts();
}
