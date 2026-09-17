<?php
/**
 * WP Job Manager integration for the Careers panel.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Whether WP Job Manager (or a compatible job_listing CPT) is available.
 */
function tora_tora_jobs_available(): bool
{
    return post_type_exists('job_listing');
}

/**
 * Clean a panel title that may contain escaped/literal break tags from bad editor content.
 */
function tora_tora_clean_panel_title(string $title, string $fallback): string
{
    $plain = trim(html_entity_decode(wp_strip_all_tags($title), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $plain = preg_replace('/\s+/', ' ', $plain ?? '') ?? '';

    if ($plain === '' || preg_match('/^<?\s*\/?\s*br\s*\/?\s*>?$/i', $plain) || strcasecmp($plain, 'br') === 0) {
        return $fallback;
    }

    if (str_contains($plain, '<') || str_contains($plain, '>')) {
        return $fallback;
    }

    return $plain;
}

/**
 * Detect careers page HTML polluted by pasted CSS, shortcodes, or leftover theme copy.
 */
function tora_tora_careers_content_is_polluted(string $html): bool
{
    return (bool) preg_match(
        '/\[jobs\]|<style\b|\.job_listings|\.tora-careers|Perfect Sushi|True Recipes|Fresh Products Guaranteed/i',
        $html
    );
}

/**
 * Return safe careers intro HTML (never dumps raw CSS or unparsed shortcodes).
 */
function tora_tora_careers_content_html(string $raw, string $fallback_html): string
{
    if ($raw === '' || tora_tora_careers_content_is_polluted($raw)) {
        return $fallback_html;
    }

    $html = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $raw) ?? '';
    $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? '';
    $html = strip_shortcodes($html);
    $html = wp_kses_post($html);

    $text = trim(wp_strip_all_tags($html));
    if (strlen($text) < 40) {
        return $fallback_html;
    }

    return $html;
}

/**
 * @return array<int,WP_Post>
 */
function tora_tora_get_job_listings(int $limit = 12): array
{
    if (!tora_tora_jobs_available()) {
        return [];
    }

    $query = new WP_Query([
        'post_type'              => 'job_listing',
        'post_status'            => 'publish',
        'posts_per_page'         => $limit,
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => true,
        'update_post_term_cache' => true,
        'meta_query'             => [
            'relation' => 'OR',
            [
                'key'     => '_filled',
                'value'   => '1',
                'compare' => '!=',
            ],
            [
                'key'     => '_filled',
                'compare' => 'NOT EXISTS',
            ],
        ],
    ]);

    return $query->posts;
}

/**
 * Job type labels for a listing (e.g. Part Time).
 *
 * @return array<int,string>
 */
function tora_tora_job_type_labels(int $post_id): array
{
    if (!taxonomy_exists('job_listing_type')) {
        return [];
    }

    $terms = get_the_terms($post_id, 'job_listing_type');
    if (!is_array($terms) || is_wp_error($terms)) {
        return [];
    }

    $labels = [];
    foreach ($terms as $term) {
        $labels[] = $term->name;
    }

    return $labels;
}

/**
 * Location string for a listing.
 */
function tora_tora_job_location(int $post_id): string
{
    if (function_exists('get_the_job_location')) {
        $location = (string) get_the_job_location($post_id);
        if ($location !== '') {
            return $location;
        }
    }

    $meta = get_post_meta($post_id, '_job_location', true);
    return is_string($meta) ? $meta : '';
}

/**
 * Format job type + location the way the Figma careers list shows it.
 */
function tora_tora_job_meta_line(int $post_id): string
{
    $types = tora_tora_job_type_labels($post_id);
    $location = tora_tora_job_location($post_id);
    if ($location === '') {
        $location = 'Dubai Marina';
    }

    if ($types) {
        $type_line = implode(' / ', array_map('strtoupper', $types));
    } else {
        $type_line = 'FULL TIME';
    }

    return $type_line . ' — ' . strtoupper($location);
}

/**
 * Static Figma openings used when Job Manager has no published listings.
 *
 * @return array<int,array{title:string,meta:string,url:string,content:string}>
 */
function tora_tora_default_careers_jobs(): array
{
    return [
        [
            'title'   => 'Head Ramen Chef',
            'meta'    => 'FULL TIME — DUBAI MARINA',
            'url'     => '',
            'content' => '',
        ],
        [
            'title'   => 'Line Cook',
            'meta'    => 'FULL-TIME / PART-TIME — DUBAI MARINA',
            'url'     => '',
            'content' => '',
        ],
        [
            'title'   => 'Floor Staff / Server',
            'meta'    => 'FULL TIME — DUBAI MARINA',
            'url'     => '',
            'content' => '',
        ],
        [
            'title'   => 'Cashier',
            'meta'    => 'FULL TIME — DUBAI MARINA',
            'url'     => '',
            'content' => '',
        ],
        [
            'title'   => 'Kitchen Porter',
            'meta'    => 'FULL TIME — DUBAI MARINA',
            'url'     => '',
            'content' => '',
        ],
    ];
}

/**
 * Careers rows for the Figma accordion list.
 *
 * @return array<int,array{title:string,meta:string,url:string,content:string}>
 */
function tora_tora_careers_jobs_for_display(): array
{
    $listings = tora_tora_get_job_listings();

    if (!$listings) {
        return tora_tora_default_careers_jobs();
    }

    $jobs = [];
    foreach ($listings as $job) {
        $job_id = (int) $job->ID;
        $jobs[] = [
            'title'   => get_the_title($job),
            'meta'    => tora_tora_job_meta_line($job_id),
            'url'     => (string) (get_permalink($job_id) ?: ''),
            'content' => apply_filters('the_content', $job->post_content),
        ];
    }

    return $jobs;
}
