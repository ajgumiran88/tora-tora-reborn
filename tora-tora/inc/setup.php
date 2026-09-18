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
    load_theme_textdomain('tora-tora', tora_tora_dir() . '/languages');
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

/**
 * Filemtime-based cache buster that never warns/fatals on missing files (SiteGround).
 */
function tora_tora_asset_version(string $relative_path): string
{
    $path = tora_tora_dir() . '/' . ltrim($relative_path, '/');
    if (is_readable($path)) {
        $mtime = @filemtime($path);
        if (false !== $mtime) {
            return TORA_TORA_VERSION . '.' . $mtime;
        }
    }
    return TORA_TORA_VERSION;
}

function tora_tora_enqueue_assets(): void
{
    wp_enqueue_style('tora-tora-style', get_stylesheet_uri(), [], TORA_TORA_VERSION);
    wp_enqueue_style(
        'tora-tora-main',
        tora_tora_uri() . '/assets/css/main.css',
        ['tora-tora-style'],
        tora_tora_asset_version('assets/css/main.css')
    );
    wp_enqueue_script(
        'tora-tora-site',
        tora_tora_uri() . '/assets/js/site.js',
        [],
        tora_tora_asset_version('assets/js/site.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'tora_tora_enqueue_assets');

function tora_tora_asset(string $relative_path): string
{
    return tora_tora_uri() . '/assets/' . ltrim($relative_path, '/');
}

/**
 * Locate a homepage panel page, accepting the About aliases story / about.
 */
function tora_tora_find_panel_page(string $slug): ?WP_Post
{
    $candidates = [$slug];
    if ($slug === 'story') {
        $candidates[] = 'about';
    } elseif ($slug === 'about') {
        $candidates[] = 'story';
    }

    foreach (array_unique($candidates) as $candidate) {
        $page = get_page_by_path($candidate, OBJECT, 'page');
        if ($page instanceof WP_Post) {
            return $page;
        }
    }

    if ($slug === 'home') {
        $front_id = (int) get_option('page_on_front');
        if ($front_id > 0) {
            $front = get_post($front_id);
            if ($front instanceof WP_Post && $front->post_type === 'page') {
                return $front;
            }
        }
    }

    return null;
}

/**
 * Return page content with a safe seeded fallback.
 * Does not run `the_content` filters before `wp_head` ( Rank Math / optimizers / TEC ).
 *
 * @return array{title:string,content:string,id:int,image:string}
 */
function tora_tora_panel_page(string $slug, string $title, string $content, string $fallback_image = ''): array
{
    $page = tora_tora_find_panel_page($slug);
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
    $raw = (string) $page->post_content;

    // Prefer stored HTML; only autop plain text. Avoid apply_filters('the_content') before get_header().
    $html = $raw;
    if ($html !== '' && !preg_match('/<\s*\w+/', $html)) {
        $html = wpautop($html);
    }

    return [
        'title'   => get_the_title($page),
        'content' => $html !== '' ? $html : wpautop($content),
        'id'      => (int) $page->ID,
        'image'   => $featured ?: $image,
    ];
}

/**
 * Menu and Delivery are staged behind switches so the client can launch without them
 * and turn each one on later. Neither panel's content is removed when it is off:
 * the menu items, the Delivery page and its Customizer settings all stay in place.
 */
function tora_tora_menu_is_coming_soon(): bool
{
    return (bool) get_theme_mod('tora_menu_coming_soon', true);
}

function tora_tora_delivery_enabled(): bool
{
    return (bool) get_theme_mod('tora_delivery_enabled', false);
}

function tora_tora_logo_url(): string
{
    $url = tora_tora_asset('images/tora-tora-logo.png');
    return add_query_arg('ver', tora_tora_asset_version('assets/images/tora-tora-logo.png'), $url);
}

function tora_tora_instagram_url(): string
{
    return 'https://www.instagram.com/toratora.ae';
}

function tora_tora_tiktok_url(): string
{
    return 'https://www.tiktok.com/@toratora.ae';
}

function tora_tora_instagram_handle(): string
{
    return '@toratora.ae';
}

function tora_tora_tiktok_handle(): string
{
    return '@toratora.ae';
}

function tora_tora_social_icon(string $network): string
{
    $icons = [
        'instagram' => '<path d="M7.75 2.5h8.5A5.25 5.25 0 0 1 21.5 7.75v8.5a5.25 5.25 0 0 1-5.25 5.25h-8.5A5.25 5.25 0 0 1 2.5 16.25v-8.5A5.25 5.25 0 0 1 7.75 2.5Zm0 1.75A3.5 3.5 0 0 0 4.25 7.75v8.5a3.5 3.5 0 0 0 3.5 3.5h8.5a3.5 3.5 0 0 0 3.5-3.5v-8.5a3.5 3.5 0 0 0-3.5-3.5h-8.5Zm9.38 1.4a1.15 1.15 0 1 1 0 2.3 1.15 1.15 0 0 1 0-2.3ZM12 7.25A4.75 4.75 0 1 1 7.25 12 4.75 4.75 0 0 1 12 7.25Zm0 1.75A3 3 0 1 0 15 12a3 3 0 0 0-3-3Z"/>',
        'tiktok' => '<path d="M14.7 3.2c.5 2.4 2.1 4.2 4.5 4.7v2.5a7.1 7.1 0 0 1-4.5-1.5v6.6a5.7 5.7 0 1 1-5.7-5.7c.3 0 .6 0 .9.1v2.6a3.1 3.1 0 1 0 2.2 3v-13Z"/>',
    ];

    if (!isset($icons[$network])) {
        return '';
    }

    return '<svg class="contact-social-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . $icons[$network] . '</svg>';
}

/**
 * Split a postal address into one or two display lines without changing its content.
 *
 * The final half of a comma-separated address is kept together so common city and
 * country suffixes read naturally. Addresses without commas remain on one line.
 *
 * @return array<int,string>
 */
function tora_tora_format_address_lines(string $address): array
{
    $address = trim($address);
    if ($address === '') {
        return [];
    }

    $parts = preg_split('/\s*,\s*/', $address, -1, PREG_SPLIT_NO_EMPTY);
    if (!is_array($parts) || count($parts) < 2) {
        return [$address];
    }

    $split_at = (int) ceil(count($parts) / 2);
    $first_line = implode(', ', array_slice($parts, 0, $split_at)) . ',';
    $second_line = implode(', ', array_slice($parts, $split_at));

    return array_values(array_filter([$first_line, $second_line], static fn(string $line): bool => $line !== ''));
}

/**
 * Google Maps embed URL for First Avenue Mall Jumeira (no API key required).
 *
 * Always pins https://maps.app.goo.gl/e8q15vCemqi5rcZX7 regardless of address text.
 *
 * @param string $address Unused; kept for call-site compatibility.
 */
function tora_tora_maps_embed_url(string $address = ''): string
{
    unset($address);

    return add_query_arg(
        [
            'q'      => 'First Avenue Mall Jumeira@25.2104867,55.2478384',
            'hl'     => 'en',
            'z'      => '16',
            'output' => 'embed',
        ],
        'https://www.google.com/maps'
    );
}

/**
 * Public Google Maps directions / place URL for the contact map.
 */
function tora_tora_maps_url(): string
{
    $url = (string) get_theme_mod('tora_maps_url', 'https://maps.app.goo.gl/e8q15vCemqi5rcZX7');
    return $url !== '' ? $url : 'https://maps.app.goo.gl/e8q15vCemqi5rcZX7';
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

/**
 * @param string[] $classes
 * @return string[]
 */
function tora_tora_body_classes($classes)
{
    if (!is_array($classes)) {
        $classes = [];
    }
    $classes[] = 'tora-tora-site';
    if (is_front_page()) {
        $classes[] = 'dark-panel';
    } else {
        $classes[] = 'light-panel';
        $classes[] = 'standard-page-context';
    }
    if (function_exists('tora_tora_staging_enabled') && tora_tora_staging_enabled()) {
        $classes[] = 'tora-staging';
    }
    return $classes;
}
add_filter('body_class', 'tora_tora_body_classes');
