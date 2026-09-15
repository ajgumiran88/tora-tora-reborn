<?php
/**
 * Theme setup, assets, and template helpers.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

function tora_tora_setup(): void
{
    load_theme_textdomain('tora-tora', TORA_TORA_DIR . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support(
        'html5',
        ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']
    );
    add_theme_support(
        'custom-logo',
        [
            'height'      => 220,
            'width'       => 330,
            'flex-height' => true,
            'flex-width'  => true,
        ]
    );

    register_nav_menus(
        [
            'primary' => __('Primary navigation', 'tora-tora'),
        ]
    );

    add_editor_style('assets/css/editor.css');
}
add_action('after_setup_theme', 'tora_tora_setup');

function tora_tora_enqueue_assets(): void
{
    $css_version = TORA_TORA_VERSION . '.' . (string) filemtime(TORA_TORA_DIR . '/assets/css/main.css');
    $js_version = TORA_TORA_VERSION . '.' . (string) filemtime(TORA_TORA_DIR . '/assets/js/site.js');

    wp_enqueue_style(
        'tora-tora-fonts',
        'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,400&display=swap',
        [],
        null
    );
    wp_enqueue_style('tora-tora-style', get_stylesheet_uri(), [], TORA_TORA_VERSION);
    wp_enqueue_style(
        'tora-tora-main',
        TORA_TORA_URI . '/assets/css/main.css',
        ['tora-tora-style'],
        $css_version
    );
    wp_enqueue_script(
        'tora-tora-site',
        TORA_TORA_URI . '/assets/js/site.js',
        [],
        $js_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'tora_tora_enqueue_assets');

function tora_tora_asset(string $relative_path): string
{
    return TORA_TORA_URI . '/assets/' . ltrim($relative_path, '/');
}

/**
 * Return page content with a safe seeded fallback.
 *
 * @return array{title:string,content:string,id:int,image:string}
 */
function tora_tora_panel_page(string $slug, string $title, string $content, string $fallback_image = ''): array
{
    $page = get_page_by_path($slug, OBJECT, 'page');
    $image = $fallback_image ? tora_tora_asset('images/' . $fallback_image) : '';

    if (!$page instanceof WP_Post) {
        return [
            'title'   => $title,
            'content' => wpautop($content),
            'id'      => 0,
            'image'   => $image,
        ];
    }

    $featured = get_the_post_thumbnail_url($page, 'full');

    return [
        'title'   => get_the_title($page),
        'content' => apply_filters('the_content', $page->post_content),
        'id'      => (int) $page->ID,
        'image'   => $featured ?: $image,
    ];
}

function tora_tora_logo_url(): string
{
    $custom_logo_id = (int) get_theme_mod('custom_logo', 0);
    $custom_logo = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : false;
    return $custom_logo ?: tora_tora_asset('images/tora-tora-logo.png');
}

function tora_tora_image_setting(string $setting, string $fallback): string
{
    $value = get_theme_mod($setting, '');
    return $value ? esc_url_raw($value) : tora_tora_asset('images/' . $fallback);
}

function tora_tora_platform_logo(string $slug, string $fallback): string
{
    return tora_tora_image_setting('tora_' . sanitize_key($slug) . '_logo', $fallback);
}

function tora_tora_body_classes(array $classes): array
{
    $classes[] = 'tora-tora-site';
    if (is_front_page()) {
        $classes[] = 'dark-panel';
    } else {
        $classes[] = 'light-panel';
        $classes[] = 'standard-page-context';
    }
    if (tora_tora_staging_enabled()) {
        $classes[] = 'tora-staging';
    }
    return $classes;
}
add_filter('body_class', 'tora_tora_body_classes');
