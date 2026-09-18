<?php
/**
 * WP Job Manager integration for the Careers panel.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Whether WP Job Manager (or a compatible job_listing CPT) is available. */
function tora_tora_jobs_available(): bool
{
    return post_type_exists('job_listing');
}

/** Clean panel title may contain escaped/literal break tags from bad editor content. */
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

/** Detect careers page HTML polluted by pasted CSS, shortcodes, or leftover copy. */
function tora_tora_careers_content_is_polluted(string $html): bool
{
    return (bool) preg_match('/\[jobs\]|<style\b|\.job_listings|\.tora-careers|Perfect Sushi|True Recipes|Fresh Products Guaranteed/i', $html);
}

/** Return safe careers intro HTML (never dump raw CSS or unparsed shortcodes). */
function tora_tora_careers_content_html(string $raw, string $fallback_html): string
{
    if ($raw === '' || tora_tora_careers_content_is_polluted($raw)) {
        return $fallback_html;
    }

    $html = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $raw) ?? '';
    $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? '';
    $html = strip_shortcodes($html);
    $html = wp_kses_post($html);
    if (strlen(trim(wp_strip_all_tags($html))) < 40) {
        return $fallback_html;
    }
    return $html;
}

/** Convert WP Job Manager expiry values into a comparable timestamp. */
function tora_tora_job_expiry_timestamp(int $post_id): int
{
    $raw = get_post_meta($post_id, '_job_expires', true);
    if (!is_scalar($raw) || trim((string) $raw) === '') {
        return 0;
    }

    $value = trim((string) $raw);
    if (ctype_digit($value)) {
        return (int) $value;
    }
    $timestamp = strtotime($value . ' 23:59:59');
    return $timestamp !== false ? $timestamp : 0;
}

/** Check filled/expired state in PHP as a second guard for custom WPJM metadata. */
function tora_tora_job_is_active(int $post_id): bool
{
    if ((string) get_post_meta($post_id, '_filled', true) === '1') {
        return false;
    }
    $expires = tora_tora_job_expiry_timestamp($post_id);
    return $expires === 0 || $expires >= current_time('timestamp');
}

/**
 * Query published, unfilled, non-expired listings in admin-controlled order.
 *
 * @return array<int,WP_Post>
 */
function tora_tora_get_job_listings(int $limit = 12): array
{
    if (!tora_tora_jobs_available()) {
        return [];
    }

    $today = current_time('Y-m-d');
    $query = new WP_Query([
        'post_type' => 'job_listing',
        'post_status' => 'publish',
        'posts_per_page' => max(1, $limit),
        'orderby' => [
            'menu_order' => 'ASC',
            'date' => 'DESC',
        ],
        'no_found_rows' => true,
        'update_post_meta_cache' => true,
        'update_post_term_cache' => true,
        'meta_query' => [
            'relation' => 'AND',
            [
                'relation' => 'OR',
                ['key' => '_filled', 'value' => '1', 'compare' => '!='],
                ['key' => '_filled', 'compare' => 'NOT EXISTS'],
            ],
            [
                'relation' => 'OR',
                ['key' => '_job_expires', 'compare' => 'NOT EXISTS'],
                ['key' => '_job_expires', 'value' => '', 'compare' => '='],
                ['key' => '_job_expires', 'value' => $today, 'compare' => '>=', 'type' => 'DATE'],
            ],
        ],
    ]);

    return array_values(array_filter(
        $query->posts,
        static fn ($job): bool => $job instanceof WP_Post && tora_tora_job_is_active((int) $job->ID)
    ));
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

/** Location string for a listing. */
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

/** Convert em dashes, en dashes, or spaced hyphens between type and location into a bullet. */
function tora_tora_normalize_job_meta_separator(string $meta): string
{
    $normalized = preg_replace('/\s*[—–−‒―]\s*|\s+-\s+/u', ' • ', $meta) ?? $meta;
    $normalized = preg_replace('/\s*[•·∙●]\s*/u', ' • ', $normalized) ?? $normalized;
    return trim($normalized);
}

/** Format job type + location the way the Figma careers list shows it. */
function tora_tora_job_meta_line(int $post_id): string
{
    $types = tora_tora_job_type_labels($post_id);
    $location = tora_tora_job_location($post_id);
    if ($location === '') {
        $location = 'Dubai Marina';
    }
    $type_line = $types ? implode(' / ', array_map('strtoupper', $types)) : 'FULL TIME';
    return tora_tora_normalize_job_meta_separator($type_line . ' • ' . strtoupper($location));
}

/**
 * Static Figma openings used when Job Manager has no published listings.
 *
 * @return array<int,array{title:string,meta:string,url:string,apply_label:string,content:string}>
 */
function tora_tora_default_careers_jobs(): array
{
    $default = [
        ['title' => 'Head Ramen Chef', 'meta' => 'FULL TIME • DUBAI MARINA', 'content' => '<p>Lead ramen line precision pace. You craft broths, manage prep, train team, keep every bowl consistent Tora Tora standards.</p>'],
        ['title' => 'Line Cook', 'meta' => 'FULL-TIME / PART-TIME • DUBAI MARINA', 'content' => '<p>Support service on fast-moving line. Prep ingredients, cook spec, keep pass clean, calm, ready peak hours.</p>'],
        ['title' => 'Floor Staff / Server', 'meta' => 'FULL TIME • DUBAI MARINA', 'content' => '<p>Bring energy dining room. Guide guests, take orders, deliver a warm, confident Tora Tora experience from first hello last bowl.</p>'],
        ['title' => 'Cashier', 'meta' => 'FULL TIME • DUBAI MARINA', 'content' => '<p>Own front counter accuracy speed. Handle payments, manage takeout flow, keep guest handoff smooth friendly.</p>'],
        ['title' => 'Kitchen Porter', 'meta' => 'FULL TIME • DUBAI MARINA', 'content' => '<p>Keep kitchen running clean stocked. Wash, organize, restock, support team service never slows down.</p>'],
    ];

    return array_map(static function (array $job): array {
        return $job + ['url' => '', 'apply_label' => 'Email your CV'];
    }, $default);
}

/** Resolve a custom WPJM application URL/email when a listing has no permalink. */
function tora_tora_job_application_meta(int $post_id): string
{
    $application = get_post_meta($post_id, '_application', true);
    return is_string($application) ? trim($application) : '';
}

/**
 * Build the apply action for a listing.
 *
 * @return array{url:string,label:string}
 */
function tora_tora_job_apply_action(int $post_id, string $fallback_email, string $title): array
{
    $permalink = get_permalink($post_id);
    if (is_string($permalink) && $permalink !== '') {
        return ['url' => $permalink, 'label' => 'View & apply'];
    }

    $application = tora_tora_job_application_meta($post_id);
    if ($application !== '') {
        if (filter_var($application, FILTER_VALIDATE_URL)) {
            return ['url' => esc_url_raw($application), 'label' => 'Apply now'];
        }
        $application_email = sanitize_email($application);
        if ($application_email !== '') {
            return [
                'url' => 'mailto:' . antispambot($application_email) . '?subject=' . rawurlencode('Job application: ' . $title),
                'label' => 'Email your CV',
            ];
        }
    }

    $fallback = sanitize_email($fallback_email);
    return [
        'url' => $fallback !== ''
            ? 'mailto:' . antispambot($fallback) . '?subject=' . rawurlencode('Job application: ' . $title)
            : '',
        'label' => 'Email your CV',
    ];
}

/**
 * Map live listings to the Figma careers accordion rows.
 *
 * @return array<int,array{title:string,meta:string,url:string,apply_label:string,content:string}>
 */
function tora_tora_careers_jobs_for_display(): array
{
    $careers_email = (string) get_theme_mod('tora_careers_email', 'hello@toratora.ae');
    $listings = tora_tora_get_job_listings();
    if (!$listings) {
        return tora_tora_default_careers_jobs();
    }

    $jobs = [];
    foreach ($listings as $job) {
        $job_id = (int) $job->ID;
        $title = (string) get_the_title($job);
        $action = tora_tora_job_apply_action($job_id, $careers_email, $title);
        $jobs[] = [
            'title' => $title,
            'meta' => tora_tora_job_meta_line($job_id),
            'url' => $action['url'],
            'apply_label' => $action['label'],
            'content' => apply_filters('the_content', $job->post_content),
        ];
    }
    return $jobs;
}
