<?php
/**
 * Tora Tora theme bootstrap.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

define('TORA_TORA_VERSION', '1.1.0');
define('TORA_TORA_DIR', get_template_directory());
define('TORA_TORA_URI', get_template_directory_uri());

require_once TORA_TORA_DIR . '/inc/setup.php';
require_once TORA_TORA_DIR . '/inc/customizer.php';
require_once TORA_TORA_DIR . '/inc/menu-items.php';
require_once TORA_TORA_DIR . '/inc/staging.php';
require_once TORA_TORA_DIR . '/inc/default-content.php';
