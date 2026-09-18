<?php
/**
 * Tora Tora theme bootstrap.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TORA_TORA_VERSION', '1.4.2');

/**
 * Theme directory (resolved at call time so WP Pusher / switched themes stay correct).
 */
function tora_tora_dir(): string
{
    return get_template_directory();
}

/**
 * Theme URI (resolved at call time).
 */
function tora_tora_uri(): string
{
    return get_template_directory_uri();
}

// Back-compat constants for older includes; prefer tora_tora_dir()/tora_tora_uri().
if (!defined('TORA_TORA_DIR')) {
    define('TORA_TORA_DIR', tora_tora_dir());
}
if (!defined('TORA_TORA_URI')) {
    define('TORA_TORA_URI', tora_tora_uri());
}

require_once tora_tora_dir() . '/inc/setup.php';
require_once tora_tora_dir() . '/inc/customizer.php';
require_once tora_tora_dir() . '/inc/menu-items.php';
require_once tora_tora_dir() . '/inc/jobs.php';
require_once tora_tora_dir() . '/inc/staging.php';
require_once tora_tora_dir() . '/inc/compatibility.php';
require_once tora_tora_dir() . '/inc/default-content.php';
require_once tora_tora_dir() . '/inc/editor.php';
