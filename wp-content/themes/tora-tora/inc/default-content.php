<?php
/**
 * One-time starter content for a useful first install.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @return array<string,array{title:string,content:string}>
 */
function tora_tora_default_pages(): array
{
    return [
        'home' => [
            'title' => 'Authentic Japanese Ramen in Dubai',
            'content' => '<p>Roar into bold Japanese flavours at Tora Tora — a vibrant ramen joint bringing Japanese street culture and authentic comfort food to Dubai.</p>',
        ],
        'story' => [
            'title' => 'The Spirit of the Tiger',
            'content' => '<p>Tora Tora takes its name from the Japanese word for tiger — a powerful creature deeply rooted in mythology and symbolism.</p><p>Representing strength, courage and protection, the tiger reflects the spirit behind our restaurant and the bold character of our cuisine.</p>',
        ],
        'delivery' => [
            'title' => 'ORDER DELIVERY',
            'content' => '<p>Roar into your home. Order authentic Tora Tora ramen through your favourite delivery platform and get it delivered hot to your door.</p>',
        ],
        'gallery' => [
            'title' => 'The Tora Tora Experience',
            'content' => '<p>Bold design, steaming bowls of ramen and lively moments in a compact image-led scene.</p>',
        ],
        'contact' => [
            'title' => 'Reach Us At',
            'content' => '<p>Find us on Al Wasl Road in Umm Suqeim 1, Dubai.</p>',
        ],
        'careers' => [
            'title' => 'Great food starts with great people.',
            'content' => '<p>Our doors are open for passionate, hard-working and curious people. If you are interested in joining the team, email your CV and include the role in the subject line.</p>',
        ],
    ];
}

/**
 * @return array<string,array{slug:string,items:array<int,array{0:string,1:string,2:string}>}>
 */
function tora_tora_default_menu(): array
{
    return [
        'Breakfast' => [
            'slug' => 'breakfast',
            'items' => [
                ['Tamago Sando', 'Japanese egg sandwich', 'AED 34'],
                ['Katsu Sando', 'Choice of beef, chicken or mushroom', 'AED 42'],
                ['Avocado & Togarashi Sando', 'Avocado, togarashi and milk bread', 'AED 38'],
                ['Japanese French Toast Sando', 'Soft milk bread with a sweet finish', 'AED 36'],
            ],
        ],
        'Appetizers' => [
            'slug' => 'appetizers',
            'items' => [
                ['Handmade Gyoza', 'Pan-seared dumplings with house dipping sauce', 'AED 32'],
                ['Karaage', 'Crisp Japanese fried chicken', 'AED 36'],
                ['Takoyaki', 'Octopus bites, bonito and signature sauce', 'AED 34'],
                ['Edamame', 'Sea salt or spicy togarashi', 'AED 24'],
            ],
        ],
        'Draft Food Menu' => [
            'slug' => 'draft-food-menu',
            'items' => [
                ['Chicken Paitan Ramen', 'Rich chicken broth, noodles, egg and seasonal garnish', 'AED 58'],
                ['Shoyu', 'Clear soy broth with springy noodles and aromatics', 'AED 54'],
                ['Tantanmen', 'Creamy sesame broth with a warming chilli finish', 'AED 59'],
                ['Vegan Ramen Miso', 'Plant-based miso broth with seasonal vegetables', 'AED 52'],
            ],
        ],
        'Desserts' => [
            'slug' => 'desserts',
            'items' => [
                ['Japanese Swiss Rolls', 'Light sponge with seasonal cream', 'AED 30'],
                ['Japanese Cheesecake', 'Airy, gently sweet baked cheesecake', 'AED 32'],
                ['Soft Serve Ice Cream', 'Ask about today’s flavour', 'AED 26'],
            ],
        ],
        'Beverage' => [
            'slug' => 'beverage',
            'items' => [
                ['House Green Tea', 'Hot or iced Japanese green tea', 'AED 18'],
                ['Yuzu Soda', 'Citrus soda with yuzu', 'AED 22'],
                ['Matcha Latte', 'Ceremonial-grade matcha with milk', 'AED 26'],
                ['Japanese Beer', 'Ask about today’s pour', 'AED 32'],
            ],
        ],
    ];
}

function tora_tora_ensure_pages(): void
{
    $page_ids = [];
    foreach (tora_tora_default_pages() as $slug => $page_data) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing instanceof WP_Post) {
            $page_ids[$slug] = $existing->ID;
            continue;
        }

        $page_ids[$slug] = wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_name'    => $slug,
            'post_title'   => $page_data['title'],
            'post_content' => $page_data['content'],
        ]);
    }

    if (!empty($page_ids['home']) && !is_wp_error($page_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', (int) $page_ids['home']);
    }
}

function tora_tora_ensure_menu_terms_and_items(): void
{
    foreach (tora_tora_default_menu() as $category => $group) {
        $term = term_exists($category, 'tora_menu_category');
        if (!$term && $group['slug']) {
            $term = term_exists($group['slug'], 'tora_menu_category');
        }
        if (!$term) {
            $term = wp_insert_term($category, 'tora_menu_category', ['slug' => $group['slug']]);
        }
        if (is_wp_error($term)) {
            continue;
        }
        $term_id = (int) (is_array($term) ? $term['term_id'] : $term);
        wp_update_term($term_id, 'tora_menu_category', ['name' => $category, 'slug' => $group['slug']]);

        foreach ($group['items'] as $order => [$name, $description, $price]) {
            $existing = get_page_by_title($name, OBJECT, 'tora_menu_item');
            if ($existing instanceof WP_Post) {
                continue;
            }
            $item_id = wp_insert_post([
                'post_type'    => 'tora_menu_item',
                'post_status'  => 'publish',
                'post_title'   => $name,
                'post_content' => $description,
                'menu_order'   => $order,
            ]);
            if (!is_wp_error($item_id)) {
                wp_set_object_terms($item_id, [$term_id], 'tora_menu_category');
                update_post_meta($item_id, 'tora_price', $price);
                update_post_meta($item_id, 'tora_available', '1');
            }
        }
    }
}

function tora_tora_upgrade_to_1_1_0(): void
{
    tora_tora_register_menu_content();
    tora_tora_ensure_pages();

    $ramen = get_term_by('slug', 'ramen', 'tora_menu_category');
    if (!$ramen instanceof WP_Term) {
        $ramen = get_term_by('name', 'Ramen', 'tora_menu_category');
    }
    if ($ramen instanceof WP_Term) {
        wp_update_term(
            (int) $ramen->term_id,
            'tora_menu_category',
            ['name' => 'Draft Food Menu', 'slug' => 'draft-food-menu']
        );
    }

    $swiss = get_page_by_title('Japanese Swiss Roll', OBJECT, 'tora_menu_item');
    if ($swiss instanceof WP_Post) {
        wp_update_post([
            'ID'         => $swiss->ID,
            'post_title' => 'Japanese Swiss Rolls',
        ]);
    }

    tora_tora_ensure_menu_terms_and_items();
}

function tora_tora_seed_default_content(): void
{
    if (get_option('tora_tora_seeded_version')) {
        return;
    }

    tora_tora_register_menu_content();
    tora_tora_ensure_pages();
    tora_tora_ensure_menu_terms_and_items();

    update_option('tora_tora_seeded_version', TORA_TORA_VERSION, false);
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'tora_tora_seed_default_content');

function tora_tora_maybe_upgrade_content(): void
{
    $current = (string) get_option('tora_tora_seeded_version', '');
    if ('' === $current) {
        return;
    }
    if (version_compare($current, '1.1.0', '>=')) {
        return;
    }

    tora_tora_upgrade_to_1_1_0();
    update_option('tora_tora_seeded_version', '1.1.0', false);
    flush_rewrite_rules();
}
add_action('init', 'tora_tora_maybe_upgrade_content', 30);
