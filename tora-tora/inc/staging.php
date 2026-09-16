<?php
/**
 * Staging-mode notice and search-engine protection.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

function tora_tora_staging_enabled(): bool
{
    return (bool) get_theme_mod('tora_staging_mode', true);
}

/**
 * @param array<string,bool|string> $robots
 * @return array<string,bool|string>
 */
function tora_tora_staging_robots($robots)
{
    if (!is_array($robots)) {
        $robots = [];
    }
    if (!tora_tora_staging_enabled()) {
        return $robots;
    }

    $robots['noindex'] = true;
    $robots['nofollow'] = true;
    unset($robots['index'], $robots['follow'], $robots['max-image-preview']);
    return $robots;
}
add_filter('wp_robots', 'tora_tora_staging_robots', 100);

function tora_tora_staging_header(): void
{
    if (tora_tora_staging_enabled() && !headers_sent()) {
        header('X-Robots-Tag: noindex, nofollow', true);
    }
}
add_action('send_headers', 'tora_tora_staging_header');

