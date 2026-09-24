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
 * Seed for the About kitchen section. It states only what the client has confirmed,
 * so editors replace it with Chef Gouda's own story in WordPress.
 */
function tora_tora_default_kitchen_story(bool $blocks = false): string
{
    $heading = esc_html__('Chef Gouda\'s kitchen', 'tora-tora');
    $copy = esc_html__('Chef Gouda leads the Tora Tora kitchen, and every dish on our menu is made in-house.', 'tora-tora');

    if ($blocks) {
        return '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . $heading . '</h3><!-- /wp:heading -->'
            . '<!-- wp:paragraph --><p>' . $copy . '</p><!-- /wp:paragraph -->';
    }

    return '<h3>' . $heading . '</h3><p>' . $copy . '</p>';
}

function tora_tora_default_menu_intro(): string
{
    return __('Every dish is made in our own kitchen, led by Chef Gouda.', 'tora-tora');
}

/**
 * @return array<string,array{title:string,content:string}>
 */
function tora_tora_default_pages(): array
{
    return [
        'home' => [
            'title' => 'Authentic Japanese Ramen in Dubai',
            'content' => '<p>Roar into bold Japanese flavours at Tora Tora - a vibrant ramen joint bringing Japanese street culture and authentic comfort food to Dubai.</p>',
        ],
        'story' => [
            'title' => 'About Tora Tora',
            'content' => '<p>Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>. The tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\'s commitment to bold flavours and vibrant dining experiences.</p><p>Tora Tora brings a slice of Japanese culture to Dubai, offering a dining experience that\'s as dynamic and powerful as the tiger itself, perfectly blending <strong>tradition with contemporary flair</strong>.</p>' . tora_tora_default_kitchen_story(),
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
            'title' => 'Contact',
            'content' => '<p>Find us at First Avenue Mall, Jumeira, Dubai.</p>',
        ],
        'careers' => [
            'title' => 'JOIN THE TEAM',
            'content' => '<p>AT TORA TORA, WE MOVE FAST, COOK BOLD, AND CELEBRATE EVERYONE WHO BRINGS THE TIGER SPIRIT TO WORK. WE ARE BUILDING SOMETHING EXCEPTIONAL IN DUBAI AND WE WANT EXCEPTIONAL PEOPLE WITH US.</p>',
        ],
    ];
}

/**
 * @return array<string,array{slug:string,items:array<int,array{0:string,1:string,2:string,3?:string}>}>
 */
function tora_tora_default_menu(): array
{
    return [
        'Breakfast' => [
            'slug' => 'breakfast',
            'items' => [
                ['TAMAGO SANDO', '(Japanese Egg Sandwich)', ''],
                ['KATSU SANDO', '(Option of Beef, Chicken or Mushroom)', ''],
                ['TAMAGO KATSU SANDO', '', ''],
                ['BREAKFAST SANDO WITH EGG AND BEEF BACON', '', ''],
                ['SMOKED SALMON AND WASABI CREAM CHEESE SANDO', '', ''],
                ['AVOCADO & TOGARASHI SANDO', '', ''],
                ['KARAAGE SANDO', '', ''],
                ['SWEET POTATO & EGGPLANT MISO SANDO', '', ''],
                ['JAPANESE FRENCH TOAST SANDO', '', ''],
            ],
        ],
        'Appetizers' => [
            'slug' => 'appetizers',
            'items' => [
                ['HANDMADE GYOZA', '', ''],
                ['KARAAGE', '', ''],
                ['MEAT SUSHI', '', ''],
                ['KATSU SANDO', '', ''],
                ['OMURICE', '', ''],
                ['KIMCHI', '', ''],
                ['TAKOYAKI', '', ''],
                ['EDAMAME', '', ''],
            ],
        ],
        'Draft Food Menu' => [
            'slug' => 'draft-food-menu',
            'items' => [
                // RAMEN
                ['CHICKEN PAITAN RAMEN', '', '', 'RAMEN'],
                ['SHOYU', '', '', 'RAMEN'],
                ['SHIO', '', '', 'RAMEN'],
                ['TANTANMEN', '', '', 'RAMEN'],
                ['TSUKEMEN CHICKEN PAITAN', '', '', 'RAMEN'],
                ['TSUKEMEN SHOYU', '', '', 'RAMEN'],
                ['TSUKEMEN SHIO', '', '', 'RAMEN'],
                ['MAZE-SOBA CLASSIC', '', '', 'RAMEN'],
                ['TAIWANESE MAZE SOBA', '', '', 'RAMEN'],
                ['VEGAN RAMEN MISO', '', '', 'RAMEN'],
                ['VEGAN RAMEN SPICY MISO', '', '', 'RAMEN'],
                ['HIYASHI CHUKA (COLD RAMEN)', '', '', 'RAMEN'],
                ['COLD TSUKEMEN', '', '', 'RAMEN'],
            ],
        ],
        'Desserts' => [
            'slug' => 'desserts',
            'items' => [
                // DESSERTS
                ['JAPANESE SWISS ROLLS', '', '', 'DESSERTS'],
                ['JAPANESE CHEESECAKE', '', '', 'DESSERTS'],
                ['SOFT SERVE ICE CREAM', '', '', 'DESSERTS'],
            ],
        ],
        'Beverages' => [
            'slug' => 'beverages',
            'items' => [
                // JAPANESE INSPIRED
                ['SIGNATURE', 'COLOR CHANGING CREAM SODA', '', 'JAPANESE INSPIRED'],
                ['ICED MATCHA LATTE', '', '', 'JAPANESE INSPIRED'],
                ['HOT MATCHA LATTE', '', '', 'JAPANESE INSPIRED'],
                ['MATCHA LEMONADE', '', '', 'JAPANESE INSPIRED'],
                ['HOJICHA LATTE', '', '', 'JAPANESE INSPIRED'],
                ['GENMAICHA', '', '', 'JAPANESE INSPIRED'],
                ['SENCHA GREEN TEA', '', '', 'JAPANESE INSPIRED'],
                // MOCKTAILS
                ['CUCUMBER MINT COOLER', '', '', 'MOCKTAILS'],
                ['SHISO & LIME SPRITZER', '', '', 'MOCKTAILS'],
                ['WATERMELON YUZU FIZZ', '', '', 'MOCKTAILS'],
                ['GINGER LEMONGRASS ICED TEA', '', '', 'MOCKTAILS'],
                // SPECIALTY COLD DRINKS
                ['YUZU LEMONADE / YUZU ICED TEA', '', '', 'SPECIALTY COLD DRINKS'],
                ['JAPANESE PLUM SODA (UME)', '', '', 'SPECIALTY COLD DRINKS'],
                ['RAMUNE BOTTLES', '(Classic Japanese Soda)', '', 'SPECIALTY COLD DRINKS'],
                ['SEASONAL COLD BREW TEAS', '', '', 'SPECIALTY COLD DRINKS'],
                // COFFEE
                ['Espresso, Americano, Latte, Cappuccino', '', '', 'COFFEE'],
                // WATER & SOFT DRINKS
                ['Still, Sparkling, Coke, Sprite, Fanta', '', '', 'WATER & SOFT DRINKS'],
                // FRESH JUICES
                ['Orange, Watermelon, Apple', '', '', 'FRESH JUICES'],
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

        foreach ($group['items'] as $order => $item_data) {
            $name = $item_data[0];
            $description = $item_data[1];
            $price = $item_data[2];
            $subgroup = $item_data[3] ?? '';

            if (tora_tora_find_menu_item_in_category($name, $term_id) instanceof WP_Post) {
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
                update_post_meta($item_id, 'tora_subgroup', $subgroup);
                update_post_meta($item_id, 'tora_available', '1');
            }
        }
    }
}

/**
 * WordPress stores bare "&" in titles as "&amp;", so title lookups must try both forms.
 */
function tora_tora_menu_title_candidates(string $name): array
{
    $decoded = html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return array_values(array_unique(array_filter([
        $name,
        $decoded,
        str_replace('&', '&amp;', $decoded),
        htmlspecialchars($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8', false),
    ])));
}

function tora_tora_find_menu_item_in_category(string $name, int $term_id): ?WP_Post
{
    foreach (tora_tora_menu_title_candidates($name) as $candidate) {
        $query = new WP_Query([
            'post_type'              => 'tora_menu_item',
            'title'                  => $candidate,
            'post_status'            => 'any',
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'tax_query'              => [
                [
                    'taxonomy' => 'tora_menu_category',
                    'field'    => 'term_id',
                    'terms'    => [$term_id],
                ],
            ],
        ]);
        $existing = $query->have_posts() ? $query->posts[0] : null;
        wp_reset_postdata();
        if ($existing instanceof WP_Post) {
            return $existing;
        }
    }

    return null;
}

/**
 * Remove duplicate menu items created when "&" titles failed exact-title matching.
 */
function tora_tora_upgrade_menu_dedupe_1_3_10(): void
{
    $terms = get_terms([
        'taxonomy'   => 'tora_menu_category',
        'hide_empty' => false,
    ]);
    if (is_wp_error($terms) || !$terms) {
        return;
    }

    foreach ($terms as $term) {
        if (!$term instanceof WP_Term) {
            continue;
        }
        $query = new WP_Query([
            'post_type'              => 'tora_menu_item',
            'post_status'            => 'any',
            'posts_per_page'         => -1,
            'orderby'                => ['menu_order' => 'ASC', 'ID' => 'ASC'],
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'tax_query'              => [
                [
                    'taxonomy' => 'tora_menu_category',
                    'field'    => 'term_id',
                    'terms'    => [(int) $term->term_id],
                ],
            ],
        ]);
        $seen = [];
        foreach ($query->posts as $item) {
            if (!$item instanceof WP_Post) {
                continue;
            }
            $key = strtoupper(html_entity_decode((string) $item->post_title, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if (isset($seen[$key])) {
                wp_delete_post((int) $item->ID, true);
                continue;
            }
            $seen[$key] = true;
        }
        wp_reset_postdata();
    }

    tora_tora_ensure_menu_terms_and_items();
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

    $swiss_query = new WP_Query([
        'post_type'              => 'tora_menu_item',
        'title'                  => 'Japanese Swiss Roll',
        'post_status'            => 'any',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);
    $swiss = $swiss_query->have_posts() ? $swiss_query->posts[0] : null;
    wp_reset_postdata();
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

/**
 * Legacy page seeds used to detect untouched starter copy before a Figma alignment upgrade.
 *
 * @return array<string,array{title:string,content:string}>
 */
function tora_tora_legacy_page_seeds(): array
{
    return [
        'home' => [
            'title' => 'Authentic Japanese Ramen in Dubai',
            'content' => '<p>Roar into bold Japanese flavours at Tora Tora - a vibrant ramen joint bringing Japanese street culture and authentic comfort food to Dubai.</p>',
        ],
        'story' => [
            'title' => 'The Spirit of the Tiger',
            'content' => '<p>Tora Tora takes its name from the Japanese word for tiger — a powerful creature deeply rooted in mythology and symbolism.</p><p>Representing strength, courage and protection, the tiger reflects the spirit behind our restaurant and the bold character of our cuisine.</p>',
        ],
    ];
}

function tora_tora_upgrade_page_if_unedited(string $slug): void
{
    $defaults = tora_tora_default_pages();
    $legacy = tora_tora_legacy_page_seeds();
    if (!isset($defaults[$slug])) {
        return;
    }

    $page = get_page_by_path($slug, OBJECT, 'page');
    if (!$page instanceof WP_Post) {
        return;
    }

    $current_title = trim((string) $page->post_title);
    $current_content = trim((string) $page->post_content);
    $legacy_title = isset($legacy[$slug]) ? trim($legacy[$slug]['title']) : '';
    $legacy_content = isset($legacy[$slug]) ? trim($legacy[$slug]['content']) : '';
    $default_title = trim($defaults[$slug]['title']);
    $default_content = trim($defaults[$slug]['content']);

    $title_matches_legacy = $legacy_title !== '' && strcasecmp($current_title, $legacy_title) === 0;
    $title_matches_default = strcasecmp($current_title, $default_title) === 0;
    $content_matches_legacy = $legacy_content !== '' && $current_content === $legacy_content;
    $content_matches_default = $current_content === $default_content;

    if (!$title_matches_legacy && !$title_matches_default && !$content_matches_legacy && !$content_matches_default) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_title'   => $defaults[$slug]['title'],
        'post_content' => $defaults[$slug]['content'],
    ]);
}

function tora_tora_upgrade_to_1_2_0(): void
{
    foreach (array_keys(tora_tora_default_pages()) as $slug) {
        tora_tora_upgrade_page_if_unedited($slug);
    }
}

function tora_tora_maybe_upgrade_content(): void
{
    $current = (string) get_option('tora_tora_seeded_version', '');
    if ('' === $current) {
        return;
    }

    if (version_compare($current, '1.1.0', '<')) {
        tora_tora_upgrade_to_1_1_0();
        $current = '1.1.0';
        update_option('tora_tora_seeded_version', $current, false);
        flush_rewrite_rules();
    }

    if (version_compare($current, '1.2.0', '<')) {
        tora_tora_upgrade_to_1_2_0();
        $current = '1.2.0';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.2.1', '<')) {
        tora_tora_upgrade_home_intro_1_2_1();
        $current = '1.2.1';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.2', '<')) {
        tora_tora_upgrade_about_copy_1_3_2();
        $current = '1.3.2';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.4', '<')) {
        tora_tora_upgrade_about_copy_1_3_4();
        $current = '1.3.4';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.5', '<')) {
        tora_tora_upgrade_menu_1_3_5();
        $current = '1.3.5';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.6', '<')) {
        tora_tora_upgrade_about_copy_1_3_6();
        $current = '1.3.6';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.8', '<')) {
        tora_tora_upgrade_menu_signature_1_3_8();
        $current = '1.3.8';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.9', '<')) {
        tora_tora_ensure_menu_terms_and_items();
        $current = '1.3.9';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.10', '<')) {
        tora_tora_upgrade_menu_dedupe_1_3_10();
        $current = '1.3.10';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.15', '<')) {
        tora_tora_upgrade_about_copy_1_3_15();
        $current = '1.3.15';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.3.39', '<')) {
        tora_tora_upgrade_about_copy_1_3_39();
        $current = '1.3.39';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.4.2', '<')) {
        tora_tora_upgrade_social_handles_1_4_2();
        $current = '1.4.2';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.4.3', '<')) {
        tora_tora_upgrade_social_handles_1_4_3();
        $current = '1.4.3';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.4.4', '<')) {
        tora_tora_upgrade_instagram_url_1_4_4();
        $current = '1.4.4';
        update_option('tora_tora_seeded_version', $current, false);
    }

    if (version_compare($current, '1.5.0', '<')) {
        tora_tora_upgrade_about_kitchen_1_5_0();
        $current = '1.5.0';
        update_option('tora_tora_seeded_version', $current, false);
    }
}

function tora_tora_upgrade_menu_1_3_5(): void
{
    tora_tora_ensure_menu_terms_and_items();
}

/**
 * Split the Signature cream soda title so Figma can italicize the flavour name.
 * Rename Beverage → Beverages to match the Figma tab label.
 */
function tora_tora_upgrade_menu_signature_1_3_8(): void
{
    $query = new WP_Query([
        'post_type'              => 'tora_menu_item',
        'title'                  => 'SIGNATURE - COLOR CHANGING CREAM SODA',
        'post_status'            => 'any',
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);
    $item = $query->have_posts() ? $query->posts[0] : null;
    wp_reset_postdata();
    if ($item instanceof WP_Post) {
        wp_update_post([
            'ID'           => (int) $item->ID,
            'post_title'   => 'SIGNATURE',
            'post_content' => 'COLOR CHANGING CREAM SODA',
        ]);
    }

    $beverages = get_term_by('slug', 'beverages', 'tora_menu_category');
    if ($beverages instanceof WP_Term) {
        wp_update_term((int) $beverages->term_id, 'tora_menu_category', [
            'name' => 'Beverages',
            'slug' => 'beverages',
        ]);
    }
}

function tora_tora_upgrade_home_intro_1_2_1(): void
{
    $defaults = tora_tora_default_pages();
    $page = get_page_by_path('home', OBJECT, 'page');
    if (!$page instanceof WP_Post || !isset($defaults['home'])) {
        return;
    }

    $current = trim((string) $page->post_content);
    if ($current !== '' && $current !== '<p></p>') {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_content' => $defaults['home']['content'],
    ]);
}

function tora_tora_upgrade_about_copy_1_3_2(): void
{
    $defaults = tora_tora_default_pages();
    $page = get_page_by_path('story', OBJECT, 'page');
    if (!$page instanceof WP_Post || !isset($defaults['story'])) {
        return;
    }

    $old_copies = [
        trim((string) (tora_tora_legacy_page_seeds()['story']['content'] ?? '')),
        '<p>Tora Tora takes its name from the Japanese word for tiger — a powerful creature deeply rooted in mythology and symbolism.</p><p>Representing strength, courage and protection, the tiger reflects the spirit behind our restaurant and the bold character of our cuisine.</p><p>At Tora Tora, we bring authentic Japanese ramen and street-food culture to Dubai with bold flavours, vibrant energy, and a dining experience inspired by the roar of the tiger.</p>',
    ];

    $current = trim((string) $page->post_content);
    $title = trim((string) $page->post_title);
    $title_ok = $title === '' || strcasecmp($title, 'About Tora Tora') === 0 || strcasecmp($title, 'The Spirit of the Tiger') === 0;
    if (!$title_ok || !in_array($current, $old_copies, true)) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_title'   => $defaults['story']['title'],
        'post_content' => $defaults['story']['content'],
    ]);
}

function tora_tora_upgrade_about_copy_1_3_4(): void
{
    $defaults = tora_tora_default_pages();
    $page = get_page_by_path('story', OBJECT, 'page');
    if (!$page instanceof WP_Post || !isset($defaults['story'])) {
        return;
    }

    $old_copies = [
        trim((string) (tora_tora_legacy_page_seeds()['story']['content'] ?? '')),
        '<p>Tora Tora takes its name from the Japanese word for tiger — a powerful creature deeply rooted in mythology and symbolism.</p><p>Representing strength, courage and protection, the tiger reflects the spirit behind our restaurant and the bold character of our cuisine.</p><p>At Tora Tora, we bring authentic Japanese ramen and street-food culture to Dubai with bold flavours, vibrant energy, and a dining experience inspired by the roar of the tiger.</p>',
        '<p>Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\'s commitment to bold flavours and vibrant dining experiences.</p><p>Tora Tora brings a slice of Japanese culture to Dubai, offering a dining experience that\'s as dynamic and powerful as the tiger itself, perfectly blending tradition with contemporary flair.</p>',
    ];

    $current = trim((string) $page->post_content);
    $title = trim((string) $page->post_title);
    $title_ok = $title === '' || strcasecmp($title, 'About Tora Tora') === 0 || strcasecmp($title, 'The Spirit of the Tiger') === 0;
    if (!$title_ok || !in_array($current, $old_copies, true)) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_title'   => $defaults['story']['title'],
        'post_content' => $defaults['story']['content'],
    ]);
}
/**
 * Upgrade untouched About starter copy to the final Figma emphasis treatment.
 */
function tora_tora_upgrade_about_copy_1_3_6(): void
{
    $defaults = tora_tora_default_pages();
    $page = get_page_by_path('story', OBJECT, 'page');
    if (!$page instanceof WP_Post || !isset($defaults['story'])) {
        return;
    }

    $previous_default = '<p>Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\'s commitment to <strong>bold flavours and vibrant dining experiences</strong>.</p><p><strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>, offering a dining experience that\'s as <strong>dynamic and powerful as the tiger itself</strong>, perfectly blending tradition with contemporary flair.</p>';
    $current = trim((string) $page->post_content);
    $title = trim((string) $page->post_title);
    $title_ok = $title === '' || strcasecmp($title, 'About Tora Tora') === 0 || strcasecmp($title, 'The Spirit of the Tiger') === 0;

    if (!$title_ok || $current !== $previous_default) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_title'   => $defaults['story']['title'],
        'post_content' => $defaults['story']['content'],
    ]);
}

/**
 * Align untouched About copy with Figma node 29-14: all-caps poster, two italic phrases.
 */
function tora_tora_upgrade_about_copy_1_3_15(): void
{
    $defaults = tora_tora_default_pages();
    $page = get_page_by_path('story', OBJECT, 'page');
    if (!$page instanceof WP_Post || !isset($defaults['story'])) {
        return;
    }

    $old_copies = [
        trim((string) (tora_tora_legacy_page_seeds()['story']['content'] ?? '')),
        '<p>Tora Tora takes its name from the Japanese word for tiger — a powerful creature deeply rooted in mythology and symbolism.</p><p>Representing strength, courage and protection, the tiger reflects the spirit behind our restaurant and the bold character of our cuisine.</p><p>At Tora Tora, we bring authentic Japanese ramen and street-food culture to Dubai with bold flavours, vibrant energy, and a dining experience inspired by the roar of the tiger.</p>',
        '<p>Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\'s commitment to bold flavours and vibrant dining experiences.</p><p>Tora Tora brings a slice of Japanese culture to Dubai, offering a dining experience that\'s as dynamic and powerful as the tiger itself, perfectly blending tradition with contemporary flair.</p>',
        '<p>Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing <em>protection and good fortune</em>. This name reflects our brand\'s commitment to <strong>bold flavours and vibrant dining experiences</strong>.</p><p><strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>, offering a dining experience that\'s as <strong>dynamic and powerful as the tiger itself</strong>, perfectly blending tradition with contemporary flair.</p>',
        '<p>Tora Tora, derived from the Japanese word for <em>\'tiger\'</em>, captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing <em>protection and good fortune</em>. This name reflects our brand\'s commitment to <strong>bold flavours and vibrant dining experiences</strong>.</p><p><strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>, offering a dining experience that\'s as <strong>dynamic and powerful as the tiger itself</strong>, perfectly blending <em>tradition with contemporary flair</em>.</p>',
    ];

    $current = trim((string) $page->post_content);
    $title = trim((string) $page->post_title);
    $title_ok = $title === '' || strcasecmp($title, 'About Tora Tora') === 0 || strcasecmp($title, 'The Spirit of the Tiger') === 0;
    if (!$title_ok || !in_array($current, $old_copies, true)) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_title'   => $defaults['story']['title'],
        'post_content' => $defaults['story']['content'],
    ]);
}

/**
 * Staging still has the 1.3.15 italic About phrases; local renders them bold.
 */
function tora_tora_upgrade_about_copy_1_3_39(): void
{
    $page = get_page_by_path('story', OBJECT, 'page');
    if (!$page instanceof WP_Post) {
        return;
    }

    $current = (string) $page->post_content;
    $updated = str_replace(
        [
            '<em>courage, strength and indomitable spirit</em>',
            '<em>tradition with contemporary flair</em>',
        ],
        [
            '<strong>courage, strength and indomitable spirit</strong>',
            '<strong>tradition with contemporary flair</strong>',
        ],
        $current
    );

    if ($updated === $current) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_content' => $updated,
    ]);
}

/**
 * Point saved Contact social links at the live toratora.ae profiles.
 */
function tora_tora_upgrade_social_handles_1_4_2(): void
{
    $replacements = [
        'tora_instagram_handle' => ['@toratora.dxb', '@toratora.ae'],
        'tora_instagram_url' => ['https://www.instagram.com/toratora.dxb', 'https://www.instagram.com/toratora.ae'],
        'tora_tiktok_handle' => ['@toratora.dxb', '@toratora.ae'],
        'tora_tiktok_url' => ['https://www.tiktok.com/@toratora.dxb', 'https://www.tiktok.com/@toratora.ae'],
    ];

    foreach ($replacements as $mod => [$old, $new]) {
        $current = (string) get_theme_mod($mod, $old);
        if ($current === '' || $current === $old) {
            set_theme_mod($mod, $new);
        }
    }
}

function tora_tora_upgrade_social_handles_1_4_3(): void
{
    set_theme_mod('tora_instagram_handle', '@toratora.ae');
    set_theme_mod('tora_instagram_url', 'https://www.instagram.com/toratora.ae');
    set_theme_mod('tora_tiktok_handle', '@toratora.ae');
    set_theme_mod('tora_tiktok_url', 'https://www.tiktok.com/@toratora.ae');
}

function tora_tora_upgrade_instagram_url_1_4_4(): void
{
    set_theme_mod('tora_instagram_url', 'https://www.instagram.com/toratora.ae');
}

/**
 * Give the existing About page its kitchen section once. A page that already has a
 * heading is left alone, since that heading is where the kitchen section starts.
 */
function tora_tora_upgrade_about_kitchen_1_5_0(): void
{
    $page = get_page_by_path('story', OBJECT, 'page');
    if (!$page instanceof WP_Post) {
        return;
    }

    $current = (string) $page->post_content;
    if (preg_match('/<h[2-4]\b/i', $current)) {
        return;
    }

    wp_update_post([
        'ID'           => (int) $page->ID,
        'post_content' => rtrim($current) . tora_tora_default_kitchen_story(str_contains($current, '<!-- wp:')),
    ]);
}

add_action('init', 'tora_tora_maybe_upgrade_content', 30);
