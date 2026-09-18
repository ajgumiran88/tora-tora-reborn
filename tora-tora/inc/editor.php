<?php
/**
 * Make one-page panel copy reachable from WordPress Admin.
 *
 * The site is a single front-page template. Core "Edit Page" always opens the
 * Home page, so About / Delivery copy looked uneditable from #about.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @return array<string,string> panel id => page slug
 */
function tora_tora_panel_page_slugs(): array
{
    return [
        'home' => 'home',
        'about' => 'story',
        'delivery' => 'delivery',
        'gallery' => 'gallery',
        'careers' => 'careers',
        'contact' => 'contact',
    ];
}

function tora_tora_panel_edit_label(string $panel): string
{
    $labels = [
        'home'     => __('Edit Home', 'tora-tora'),
        'about'    => __('Edit About', 'tora-tora'),
        'menu'     => __('Edit Menu', 'tora-tora'),
        'delivery' => __('Edit Delivery', 'tora-tora'),
        'gallery'  => __('Edit Gallery', 'tora-tora'),
        'careers'  => __('Edit Careers', 'tora-tora'),
        'contact'  => __('Edit Contact details', 'tora-tora'),
    ];

    return $labels[$panel] ?? sprintf(
        /* translators: %s: panel name */
        __('Edit %s', 'tora-tora'),
        $panel
    );
}

function tora_tora_panel_state_label(string $panel): string
{
    $labels = [
        'home'     => __('Home panel', 'tora-tora'),
        'about'    => __('About panel', 'tora-tora'),
        'delivery' => __('Delivery panel', 'tora-tora'),
        'gallery'  => __('Gallery panel', 'tora-tora'),
        'careers'  => __('Careers panel', 'tora-tora'),
        'contact'  => __('Contact panel', 'tora-tora'),
    ];

    return $labels[$panel] ?? '';
}

/**
 * @return array<string,array{label:string,url:string,page_id:int}>
 */
function tora_tora_panel_edit_targets(): array
{
    $targets = [];

    foreach (tora_tora_panel_page_slugs() as $panel => $slug) {
        $page = tora_tora_find_panel_page($slug);
        if (!$page instanceof WP_Post) {
            continue;
        }
        $url = get_edit_post_link((int) $page->ID, 'raw');
        if (!is_string($url) || $url === '') {
            continue;
        }
        $targets[$panel] = [
            'label'   => tora_tora_panel_edit_label($panel),
            'url'     => $url,
            'page_id' => (int) $page->ID,
        ];
    }

    if (current_user_can('edit_posts')) {
        $targets['menu'] = [
            'label'   => tora_tora_panel_edit_label('menu'),
            'url'     => admin_url('edit.php?post_type=tora_menu_item'),
            'page_id' => 0,
        ];
    }

    if (post_type_exists('job_listing') && current_user_can('edit_posts')) {
        $targets['careers'] = [
            'label'   => __('Edit Jobs', 'tora-tora'),
            'url'     => admin_url('edit.php?post_type=job_listing'),
            'page_id' => (int) ($targets['careers']['page_id'] ?? 0),
        ];
    }

    if (current_user_can('edit_theme_options')) {
        $contact_id = (int) ($targets['contact']['page_id'] ?? 0);
        $targets['contact'] = [
            'label'   => tora_tora_panel_edit_label('contact'),
            'url'     => admin_url('customize.php?autofocus[section]=tora_tora_details'),
            'page_id' => $contact_id,
        ];
    }

    return $targets;
}

function tora_tora_admin_bar_panel_edits(WP_Admin_Bar $wp_admin_bar): void
{
    if (is_admin() || !is_front_page() || !$wp_admin_bar->get_node('edit')) {
        return;
    }

    foreach (tora_tora_panel_edit_targets() as $panel => $target) {
        $wp_admin_bar->add_node([
            'id'     => 'tora-edit-' . sanitize_key($panel),
            'parent' => 'edit',
            'title'  => $target['label'],
            'href'   => $target['url'],
        ]);
    }
}
add_action('admin_bar_menu', 'tora_tora_admin_bar_panel_edits', 90);

/**
 * @param array<string,string> $states
 * @return array<string,string>
 */
function tora_tora_panel_post_states($states, $post)
{
    if (!is_array($states) || !$post instanceof WP_Post || $post->post_type !== 'page') {
        return is_array($states) ? $states : [];
    }

    foreach (tora_tora_panel_page_slugs() as $panel => $slug) {
        $page = tora_tora_find_panel_page($slug);
        if (!$page instanceof WP_Post || (int) $page->ID !== (int) $post->ID) {
            continue;
        }
        $label = tora_tora_panel_state_label($panel);
        if ($label !== '') {
            $states['tora_panel_' . $panel] = $label;
        }
    }

    return $states;
}
add_filter('display_post_states', 'tora_tora_panel_post_states', 10, 2);

function tora_tora_panel_editor_notice(): void
{
    if (!function_exists('get_current_screen')) {
        return;
    }
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }

    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    if ($post_id < 1) {
        return;
    }

    $targets = tora_tora_panel_edit_targets();
    $current_panel = '';
    foreach ($targets as $panel => $target) {
        if ((int) ($target['page_id'] ?? 0) === $post_id) {
            $current_panel = $panel;
            break;
        }
    }
    if ($current_panel === '') {
        return;
    }

    $about_url = (string) ($targets['about']['url'] ?? '');
    echo '<div class="notice notice-info"><p>';
    if ($current_panel === 'home' && $about_url !== '') {
        echo esc_html__('This page is the Home panel only. About Tora Tora copy is edited on the About page.', 'tora-tora');
        echo ' <a href="' . esc_url($about_url) . '">' . esc_html__('Edit About', 'tora-tora') . '</a>';
    } elseif ($current_panel === 'about') {
        echo esc_html__('This page is the About panel on the homepage. Change the paragraphs here to update the live About copy.', 'tora-tora');
    } else {
        echo esc_html(
            sprintf(
                /* translators: %s: panel label such as Delivery panel */
                __('This page supplies copy for the %s on the homepage.', 'tora-tora'),
                tora_tora_panel_state_label($current_panel)
            )
        );
    }
    echo '</p></div>';
}
add_action('admin_notices', 'tora_tora_panel_editor_notice');

function tora_tora_register_panel_meta_box(): void
{
    add_meta_box(
        'tora-tora-panel',
        __('Tora Tora panel', 'tora-tora'),
        'tora_tora_render_panel_meta_box',
        'page',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'tora_tora_register_panel_meta_box');

function tora_tora_render_panel_meta_box(WP_Post $post): void
{
    $targets = tora_tora_panel_edit_targets();
    $current_panel = '';
    foreach ($targets as $panel => $target) {
        if ((int) ($target['page_id'] ?? 0) === (int) $post->ID) {
            $current_panel = $panel;
            break;
        }
    }

    if ($current_panel === '') {
        echo '<p>' . esc_html__('This page is not used as a homepage panel.', 'tora-tora') . '</p>';
        return;
    }

    echo '<p>' . esc_html(
        sprintf(
            /* translators: %s: panel label such as About panel */
            __('This page is the %s on the live homepage.', 'tora-tora'),
            tora_tora_panel_state_label($current_panel)
        )
    ) . '</p>';

    $about_url = (string) ($targets['about']['url'] ?? '');
    if ($current_panel === 'home' && $about_url !== '') {
        echo '<p><a href="' . esc_url($about_url) . '">' . esc_html__('Edit About', 'tora-tora') . '</a></p>';
    }
}
