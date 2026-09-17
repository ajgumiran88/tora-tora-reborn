<?php
/**
 * Admin-managed food menu.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

function tora_tora_register_menu_content(): void
{
    register_post_type('tora_menu_item', [
        'labels' => [
            'name'          => __('Menu Items', 'tora-tora'),
            'singular_name' => __('Menu Item', 'tora-tora'),
            'add_new_item'  => __('Add New Menu Item', 'tora-tora'),
            'edit_item'     => __('Edit Menu Item', 'tora-tora'),
            'menu_name'     => __('Food Menu', 'tora-tora'),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'food'],
        'menu_icon'    => 'dashicons-food',
        'supports'     => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'show_in_nav_menus' => false,
    ]);

    register_taxonomy('tora_menu_category', ['tora_menu_item'], [
        'labels' => [
            'name'          => __('Menu Categories', 'tora-tora'),
            'singular_name' => __('Menu Category', 'tora-tora'),
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'menu-category'],
    ]);

    register_post_meta('tora_menu_item', 'tora_price', [
        'type'              => 'string',
        'single'            => true,
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
        'auth_callback'     => static fn(): bool => current_user_can('edit_posts'),
    ]);

    register_post_meta('tora_menu_item', 'tora_subgroup', [
        'type'              => 'string',
        'single'            => true,
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
        'auth_callback'     => static fn(): bool => current_user_can('edit_posts'),
    ]);

    register_post_meta('tora_menu_item', 'tora_available', [
        'type'              => 'boolean',
        'single'            => true,
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'show_in_rest'      => true,
        'auth_callback'     => static fn(): bool => current_user_can('edit_posts'),
    ]);
}
add_action('init', 'tora_tora_register_menu_content');

function tora_tora_add_menu_meta_box(): void
{
    add_meta_box(
        'tora-menu-details',
        __('Menu details', 'tora-tora'),
        'tora_tora_render_menu_meta_box',
        'tora_menu_item',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'tora_tora_add_menu_meta_box');

function tora_tora_render_menu_meta_box(WP_Post $post): void
{
    wp_nonce_field('tora_save_menu_details', 'tora_menu_details_nonce');
    $price = (string) get_post_meta($post->ID, 'tora_price', true);
    $subgroup = (string) get_post_meta($post->ID, 'tora_subgroup', true);
    $available_meta = get_post_meta($post->ID, 'tora_available', true);
    $available = '' === $available_meta || (bool) $available_meta;
    ?>
    <p>
        <label for="tora_price"><strong><?php esc_html_e('Price string', 'tora-tora'); ?></strong></label><br>
        <input type="text" id="tora_price" name="tora_price" value="<?php echo esc_attr($price); ?>" class="widefat" placeholder="e.g. AED 58">
    </p>
    <p>
        <label for="tora_subgroup"><strong><?php esc_html_e('Subgroup heading', 'tora-tora'); ?></strong></label><br>
        <input type="text" id="tora_subgroup" name="tora_subgroup" value="<?php echo esc_attr($subgroup); ?>" class="widefat" placeholder="e.g. RAMEN or JAPANESE INSPIRED">
    </p>
        <label for="tora-price"><strong><?php esc_html_e('Price', 'tora-tora'); ?></strong></label><br>
        <input class="widefat" id="tora-price" name="tora_price" type="text" value="<?php echo esc_attr($price); ?>" placeholder="AED 48">
    </p>
    <p>
        <label>
            <input name="tora_available" type="checkbox" value="1" <?php checked($available); ?>>
            <?php esc_html_e('Available on the public menu', 'tora-tora'); ?>
        </label>
    </p>
    <p class="description"><?php esc_html_e('Use the Order field in Page Attributes to control this item’s position within its category.', 'tora-tora'); ?></p>
    <?php
}

function tora_tora_save_menu_details(int $post_id): void
{
    if (
        !isset($_POST['tora_menu_details_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tora_menu_details_nonce'])), 'tora_save_menu_details') ||
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    $price = isset($_POST['tora_price']) ? sanitize_text_field(wp_unslash($_POST['tora_price'])) : '';
    $subgroup = isset($_POST['tora_subgroup']) ? sanitize_text_field(wp_unslash($_POST['tora_subgroup'])) : '';
    update_post_meta($post_id, 'tora_price', $price);
    update_post_meta($post_id, 'tora_subgroup', $subgroup);
    update_post_meta($post_id, 'tora_available', isset($_POST['tora_available']) ? '1' : '0');
}
add_action('save_post_tora_menu_item', 'tora_tora_save_menu_details');

/**
 * Figma menu tab order.
 *
 * @return array<int,string>
 */
function tora_tora_menu_category_slugs(): array
{
    return [
        'breakfast',
        'appetizers',
        'draft-food-menu',
        'desserts',
        'beverage',
    ];
}

/**
 * Return available menu items grouped by category.
 *
 * @return array<int,array{term:object,items:array<int,WP_Post>}>
 */
function tora_get_menu_groups(): array
{
    $terms = get_terms([
        'taxonomy'   => 'tora_menu_category',
        'hide_empty' => false,
        'orderby'    => 'term_id',
        'order'      => 'ASC',
    ]);

    $preferred = tora_tora_menu_category_slugs();
    $terms = is_wp_error($terms) ? [] : (array) $terms;

    // Keep the five Figma categories visible even before an editor adds items.
    // This prevents the tab strip from changing shape as categories are filled.
    $category_aliases = [
        'beverage' => ['beverage', 'beverages'],
    ];
    $known_terms = [];
    foreach ($preferred as $slug) {
        $term = null;
        foreach ($category_aliases[$slug] ?? [$slug] as $alias) {
            $candidate = get_term_by('slug', $alias, 'tora_menu_category');
            if ($candidate instanceof WP_Term) {
                $term = $candidate;
                break;
            }
        }

        if (!$term) {
            $term = (object) [
                'term_id' => 0,
                'slug'    => $slug,
                'name'    => ucwords(str_replace('-', ' ', $slug)),
            ];
        }

        $known_terms[(string) $term->slug] = $term;
    }

    foreach ($terms as $term) {
        if ($term instanceof WP_Term) {
            if ('beverages' === $term->slug && isset($known_terms['beverage'])) {
                continue;
            }
            $known_terms[(string) $term->slug] = $term;
        }
    }

    $terms = array_values($known_terms);
    usort(
        $terms,
        static function ($left, $right) use ($preferred): int {
            $left_slug = is_object($left) && isset($left->slug) ? (string) $left->slug : '';
            $right_slug = is_object($right) && isset($right->slug) ? (string) $right->slug : '';
            $left_slug = 'beverages' === $left_slug ? 'beverage' : $left_slug;
            $right_slug = 'beverages' === $right_slug ? 'beverage' : $right_slug;
            $left_index = array_search($left_slug, $preferred, true);
            $right_index = array_search($right_slug, $preferred, true);
            $left_index = false === $left_index ? 100 : $left_index;
            $right_index = false === $right_index ? 100 : $right_index;
            if ($left_index === $right_index) {
                $left_id = is_object($left) && isset($left->term_id) ? (int) $left->term_id : 0;
                $right_id = is_object($right) && isset($right->term_id) ? (int) $right->term_id : 0;
                return $left_id <=> $right_id;
            }
            return $left_index <=> $right_index;
        }
    );

    $groups = [];
    foreach ($terms as $term) {
        $items = get_posts([
            'post_type'      => 'tora_menu_item',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => [[
                'taxonomy' => 'tora_menu_category',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ]],
            'meta_query' => [
                'relation' => 'OR',
                ['key' => 'tora_available', 'compare' => 'NOT EXISTS'],
                ['key' => 'tora_available', 'value' => '1', 'compare' => '='],
            ],
            'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
            'order'   => 'ASC',
        ]);

        if ($items) {
            $groups[] = ['term' => $term, 'items' => $items];
        }
    }
    return $groups;
}

function tora_tora_menu_admin_columns(array $columns): array
{
    $columns['tora_price'] = __('Price', 'tora-tora');
    $columns['tora_available'] = __('Available', 'tora-tora');
    $columns['menu_order'] = __('Order', 'tora-tora');
    return $columns;
}
add_filter('manage_tora_menu_item_posts_columns', 'tora_tora_menu_admin_columns');

function tora_tora_menu_admin_column(string $column, int $post_id): void
{
    if ('tora_price' === $column) {
        echo esc_html((string) get_post_meta($post_id, 'tora_price', true));
    } elseif ('tora_available' === $column) {
        echo get_post_meta($post_id, 'tora_available', true) !== '0' ? esc_html__('Yes', 'tora-tora') : esc_html__('No', 'tora-tora');
    } elseif ('menu_order' === $column) {
        echo esc_html((string) get_post_field('menu_order', $post_id));
    }
}
add_action('manage_tora_menu_item_posts_custom_column', 'tora_tora_menu_admin_column', 10, 2);
