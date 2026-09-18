<?php
/**
 * Global document header.
 *
 * @package Tora_Tora
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0500F5">
    <?php tora_tora_render_document_head(); ?>
    <!-- tora-tora:<?php echo esc_html(TORA_TORA_VERSION); ?> safe-head=<?php echo tora_tora_use_safe_head() ? '1' : '0'; ?> -->
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e('Skip to content', 'tora-tora'); ?></a>
<?php if (tora_tora_staging_enabled()) : ?>
    <div class="staging-chrome" role="status">
        <div class="staging-only"><?php esc_html_e('Staging only', 'tora-tora'); ?></div>
        <div class="staging-notice">STAGING PREVIEW — <?php esc_html_e('This website is for review only.', 'tora-tora'); ?></div>
    </div>
<?php endif; ?>
<div class="site-shell">
    <header class="site-header">
        <a class="brand-link nav-link" href="<?php echo esc_url(home_url('/#home')); ?>" data-target="home" aria-label="<?php esc_attr_e('Tora Tora home', 'tora-tora'); ?>">
            <img src="<?php echo esc_url(tora_tora_logo_url()); ?>" alt="<?php esc_attr_e('Tora Tora Dubai', 'tora-tora'); ?>" width="300" height="152">
        </a>
        <button class="nav-toggle" type="button" aria-label="<?php esc_attr_e('Open menu', 'tora-tora'); ?>" aria-expanded="false" aria-controls="site-navigation">
            <span></span><span></span><span></span>
        </button>
    </header>

    <nav class="overlay-menu" id="site-navigation" aria-label="<?php esc_attr_e('Primary navigation', 'tora-tora'); ?>" aria-hidden="true">
        <div class="overlay-pattern" aria-hidden="true"></div>
        <button class="overlay-close" type="button" aria-label="<?php esc_attr_e('Close menu', 'tora-tora'); ?>">×</button>
        <ul>
            <li><a class="nav-link is-active" href="<?php echo esc_url(home_url('/#home')); ?>" data-target="home"><?php esc_html_e('Home', 'tora-tora'); ?></a></li>
            <li><a class="nav-link" href="<?php echo esc_url(home_url('/#about')); ?>" data-target="about"><?php esc_html_e('About Tora Tora', 'tora-tora'); ?></a></li>
            <li><a class="nav-link" href="<?php echo esc_url(home_url('/#menu')); ?>" data-target="menu"><?php esc_html_e('Menu', 'tora-tora'); ?></a></li>
            <?php if (tora_tora_delivery_enabled()) : ?>
                <li><a class="nav-link" href="<?php echo esc_url(home_url('/#delivery')); ?>" data-target="delivery"><?php esc_html_e('Delivery', 'tora-tora'); ?></a></li>
            <?php endif; ?>
            <li><a class="nav-link" href="<?php echo esc_url(home_url('/#gallery')); ?>" data-target="gallery"><?php esc_html_e('Gallery', 'tora-tora'); ?></a></li>
            <li><a class="nav-link" href="<?php echo esc_url(home_url('/#careers')); ?>" data-target="careers"><?php esc_html_e('Careers', 'tora-tora'); ?></a></li>
            <li><a class="nav-link" href="<?php echo esc_url(home_url('/#contact')); ?>" data-target="contact"><?php esc_html_e('Contact', 'tora-tora'); ?></a></li>
        </ul>
    </nav>
