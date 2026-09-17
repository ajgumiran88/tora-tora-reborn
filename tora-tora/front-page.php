<?php
/**
 * Immersive one-page front-end.
 *
 * @package Tora_Tora
 */

get_header();

$home = tora_tora_panel_page(
    'home',
    __('Authentic Japanese Ramen in Dubai', 'tora-tora'),
    __('Roar into bold Japanese flavours at Tora Tora — a vibrant ramen joint bringing Japanese street culture and authentic comfort food to Dubai.', 'tora-tora'),
    'hero-ramen.png'
);
$about = tora_tora_panel_page(
    'story',
    __('About Tora Tora', 'tora-tora'),
    '<p>' . esc_html__('Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.', 'tora-tora') . '</p><p>' . wp_kses(__('A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\'s commitment to <strong>bold flavours and vibrant dining experiences</strong>.', 'tora-tora'), ['strong' => []]) . '</p><p>' . wp_kses(__('<strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>, offering a dining experience that\'s as <strong>dynamic and powerful as the tiger itself</strong>, perfectly blending tradition with contemporary flair.', 'tora-tora'), ['strong' => []]) . '</p>',
    'tiger-mark.png'
);
$delivery = tora_tora_panel_page(
    'delivery',
    __('ORDER DELIVERY', 'tora-tora'),
    __('Roar into your home. Order authentic Tora Tora ramen through your favourite delivery platform and get it delivered hot to your door.', 'tora-tora')
);
$gallery = tora_tora_panel_page(
    'gallery',
    __('The Tora Tora Experience', 'tora-tora'),
    __('Bold design, steaming bowls of ramen and lively moments in a compact image-led scene.', 'tora-tora')
);
$contact = tora_tora_panel_page(
    'contact',
    __('Reach Us At', 'tora-tora'),
    __('Find us on Al Wasl Road in Umm Suqeim 1, Dubai.', 'tora-tora'),
    'gallery-1.jpg'
);
$careers_jobs = tora_tora_careers_jobs_for_display();
$careers_roles_label = sprintf(
    /* translators: %d: number of open roles */
    _n('%d Role Open', '%d Roles Open', count($careers_jobs), 'tora-tora'),
    count($careers_jobs)
);
$menu_groups = tora_get_menu_groups();
$gallery_images = [];
for ($gallery_index = 1; $gallery_index <= 5; $gallery_index++) {
    $gallery_images[] = tora_tora_image_setting('tora_gallery_' . $gallery_index, 'gallery-' . $gallery_index . '.jpg');
}
$gallery_tiles = [
    ['label' => '', 'mark' => ''],
    ['label' => '', 'mark' => ''],
    ['label' => __('Food', 'tora-tora'), 'mark' => ''],
    ['label' => '', 'mark' => '02'],
    ['label' => __('Interior', 'tora-tora'), 'mark' => ''],
    ['label' => '', 'mark' => ''],
    ['label' => '', 'mark' => ''],
    ['label' => '', 'mark' => ''],
    ['label' => __('Food', 'tora-tora'), 'mark' => '03'],
];
$gallery_image_total = count($gallery_tiles);
$address = (string) get_theme_mod('tora_address', 'Al Wasl Road, Umm Suqeim 1 - Dubai, UAE');
$phone = (string) get_theme_mod('tora_phone', '+971 4 000 0000');
$email = (string) get_theme_mod('tora_email', 'hello@toratora.ae');
$reservation_email = (string) get_theme_mod('tora_reservation_email', 'reserve@toratora.ae');
$careers_email = (string) get_theme_mod('tora_careers_email', 'hello@toratora.ae');
$instagram_handle = (string) get_theme_mod('tora_instagram_handle', '@toratora.dxb');
$instagram_url = (string) get_theme_mod('tora_instagram_url', 'https://www.instagram.com/toratora.dxb');
$tiktok_handle = (string) get_theme_mod('tora_tiktok_handle', '@toratora.dxb');
$tiktok_url = (string) get_theme_mod('tora_tiktok_url', 'https://www.tiktok.com/@toratora.dxb');
$hours_sun_thu = (string) get_theme_mod('tora_hours_sun_thu', '08:00 - 23:00');
$hours_fri_sat = (string) get_theme_mod('tora_hours_fri_sat', '08:00 - 00:00');
$contact_map = tora_tora_image_setting('tora_contact_map', 'contact-dubai-map.png');
$featured_zone = (string) get_theme_mod('tora_featured_zone', 'Business Bay');
$platforms = [
    [
        'name' => __('Talabat', 'tora-tora'),
        'copy' => __('Order via Talabat for fast delivery across Dubai.', 'tora-tora'),
        'url'  => (string) get_theme_mod('tora_talabat_url', 'https://www.talabat.com'),
        'logo' => tora_tora_platform_logo('talabat', 'delivery-talabat.svg'),
        'width' => 224,
        'height' => 76,
    ],
    [
        'name' => __('Noon Food', 'tora-tora'),
        'copy' => __('Available on Noon Food — quick & reliable.', 'tora-tora'),
        'url'  => (string) get_theme_mod('tora_noon_url', 'https://food.noon.com'),
        'logo' => tora_tora_platform_logo('noon', 'delivery-noon.png'),
        'width' => 338,
        'height' => 46,
    ],
    [
        'name' => __('Deliveroo', 'tora-tora'),
        'copy' => __('Get Tora Tora delivered through Deliveroo.', 'tora-tora'),
        'url'  => (string) get_theme_mod('tora_deliveroo_url', 'https://deliveroo.ae'),
        'logo' => tora_tora_platform_logo('deliveroo', 'delivery-deliveroo.svg'),
        'width' => 300,
        'height' => 80,
    ],
];
?>
<main id="main-content" tabindex="-1">
    <section class="panel home-panel is-active" id="home" data-theme="pattern" aria-labelledby="home-title">
        <div class="home-split">
            <div class="home-content panel-copy">
                <h1 id="home-title"><?php echo esc_html($home['title']); ?></h1>
                <?php if (trim((string) $home['content']) !== '') : ?>
                    <div class="entry-content"><?php echo wp_kses_post($home['content']); ?></div>
                <?php endif; ?>
                <div class="home-indicators" aria-hidden="true">
                    <span class="is-active"></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="home-pattern" aria-hidden="true"></div>
        </div>
        <div class="hero-art">
            <figure class="hero-bowl">
                <img
                    class="hero-bowl-photo"
                    src="<?php echo esc_url($home['image']); ?>"
                    alt="<?php esc_attr_e('Tora Tora ramen bowl', 'tora-tora'); ?>"
                    width="1280"
                    height="1280"
                    decoding="async"
                >
                <img
                    class="hero-chopsticks"
                    src="<?php echo esc_url(tora_tora_uri() . '/assets/images/hero-chopsticks.png'); ?>"
                    alt=""
                    width="814"
                    height="818"
                    decoding="async"
                    aria-hidden="true"
                >
            </figure>
        </div>
    </section>

    <section class="panel story-panel" id="about" data-theme="light" aria-labelledby="about-title" aria-hidden="true">
        <div class="story-scroll-inner">
            <div class="story-art" aria-hidden="true">
                <span class="story-pattern-disc"></span>
                <figure class="story-tiger-disc">
                    <img src="<?php echo esc_url($about['image']); ?>" alt="" width="512" height="512" loading="lazy" decoding="async">
                </figure>
            </div>
            <div class="story-copy panel-copy">
                <?php get_template_part('template-parts/panel', 'back'); ?>
                <h2 id="about-title"><?php echo esc_html($about['title']); ?></h2>
                <div class="story-copy-body">
                    <div class="entry-content"><?php echo wp_kses_post($about['content']); ?></div>
                    <span class="story-rule" aria-hidden="true"></span>
                </div>
            </div>
            <div class="story-band" aria-hidden="true"></div>
        </div>
    </section>

    <section class="panel menu-panel" id="menu" data-theme="light" aria-labelledby="menu-title" aria-hidden="true">
        <div class="panel-scroll menu-layout">
            <div class="menu-heading">
                <div class="menu-heading-copy">
                    <?php get_template_part('template-parts/panel', 'back'); ?>
                    <h2 id="menu-title"><?php esc_html_e('MENU', 'tora-tora'); ?></h2>
                </div>
                <img class="menu-tiger-mark" src="<?php echo esc_url(tora_tora_asset('images/tiger-mark.png')); ?>" alt="" width="512" height="512" loading="lazy" decoding="async">
            </div>
            <?php if ($menu_groups) : ?>
                <div class="menu-tabs" role="tablist" aria-label="<?php esc_attr_e('Menu categories', 'tora-tora'); ?>">
                    <?php foreach ($menu_groups as $index => $group) : ?>
                        <button
                            class="menu-tab<?php echo 0 === $index ? ' is-active' : ''; ?>"
                            type="button"
                            id="menu-tab-<?php echo esc_attr($group['term']->slug); ?>"
                            role="tab"
                            aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
                            aria-controls="menu-panel-<?php echo esc_attr($group['term']->slug); ?>"
                            data-menu-slug="<?php echo esc_attr($group['term']->slug); ?>"
                        >
                            <?php echo esc_html($group['term']->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="menu-tab-panels">
                    <?php foreach ($menu_groups as $index => $group) : ?>
                        <div
                            class="menu-tab-panel<?php echo 0 === $index ? ' is-active' : ''; ?>"
                            id="menu-panel-<?php echo esc_attr($group['term']->slug); ?>"
                            role="tabpanel"
                            aria-labelledby="menu-tab-<?php echo esc_attr($group['term']->slug); ?>"
                            data-menu-slug="<?php echo esc_attr($group['term']->slug); ?>"
                            <?php echo 0 === $index ? '' : 'hidden'; ?>
                        >
                            <?php 
                                $current_subgroup = false;
                                foreach ($group['items'] as $item) : 
                                    $item_subgroup = trim((string) get_post_meta($item->ID, 'tora_subgroup', true));
                                    if ($item_subgroup && $item_subgroup !== $current_subgroup) {
                                        $current_subgroup = $item_subgroup;
                                        echo '<h3>' . esc_html($current_subgroup) . '</h3>';
                                    } elseif ($current_subgroup === false && !$item_subgroup) {
                                        // Only show the term name as a heading if there are no subgroups defined at the start
                                        $current_subgroup = '';
                                        echo '<h3>' . esc_html($group['term']->name) . '</h3>';
                                    }
                            ?>
                                <article class="menu-item">
                                    <div class="menu-item-copy">
                                        <h4><?php echo esc_html(get_the_title($item)); ?></h4>
                                        <?php if (trim($item->post_content)) : ?><div><?php echo wp_kses_post(apply_filters('the_content', $item->post_content)); ?></div><?php endif; ?>
                                    </div>
                                    <strong class="menu-item-price"><?php echo esc_html((string) get_post_meta($item->ID, 'tora_price', true)); ?></strong>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="menu-empty"><?php esc_html_e('Menu items will appear here when they are added in WordPress Admin.', 'tora-tora'); ?></p>
            <?php endif; ?>
        </div>
        <div class="menu-rail menu-rail-right" aria-hidden="true"></div>
    </section>

    <section class="panel delivery-panel" id="delivery" data-theme="light" aria-labelledby="delivery-title" aria-hidden="true">
        <div class="delivery-band" aria-hidden="true"></div>
        <div class="panel-scroll delivery-layout">
            <div class="delivery-primary">
                <?php get_template_part('template-parts/panel', 'back'); ?>
                <div class="delivery-copy panel-copy">
                    <h2 id="delivery-title"><?php echo esc_html($delivery['title']); ?></h2>
                    <div class="entry-content"><?php echo wp_kses_post($delivery['content']); ?></div>
                </div>
                <div class="delivery-partners">
                    <p class="delivery-label"><?php esc_html_e('Order on', 'tora-tora'); ?></p>
                    <div class="delivery-platforms">
                        <?php foreach ($platforms as $platform) : ?>
                            <a
                                class="delivery-card"
                                href="<?php echo esc_url($platform['url']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="<?php echo esc_attr(sprintf(__('Order Tora Tora on %s', 'tora-tora'), $platform['name'])); ?>"
                            >
                                <img
                                    class="delivery-logo"
                                    src="<?php echo esc_url($platform['logo']); ?>"
                                    alt="<?php echo esc_attr($platform['name']); ?>"
                                    width="<?php echo esc_attr((string) $platform['width']); ?>"
                                    height="<?php echo esc_attr((string) $platform['height']); ?>"
                                    decoding="async"
                                >
                                <p><?php echo esc_html($platform['copy']); ?></p>
                                <span class="delivery-order" aria-hidden="true">
                                    <?php esc_html_e('Order now', 'tora-tora'); ?>
                                    <span aria-hidden="true">→</span>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="delivery-secondary">
                <div class="delivery-meta">
                    <div class="delivery-zones-block">
                        <p class="delivery-label"><?php esc_html_e('Delivery zones', 'tora-tora'); ?></p>
                        <ul class="delivery-zones">
                            <?php foreach (tora_tora_delivery_zones() as $zone) : ?>
                                <li<?php echo strcasecmp($zone, $featured_zone) === 0 ? ' class="is-featured"' : ''; ?>><?php echo esc_html($zone); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="delivery-hours-block">
                        <p class="delivery-label"><?php esc_html_e('Delivery hours', 'tora-tora'); ?></p>
                        <dl class="delivery-hours">
                            <div><dt><?php esc_html_e('Monday - Friday', 'tora-tora'); ?></dt><dd><?php echo esc_html((string) get_theme_mod('tora_hours_weekday', '11:00 - 22:30')); ?></dd></div>
                            <div><dt><?php esc_html_e('Saturday', 'tora-tora'); ?></dt><dd><?php echo esc_html((string) get_theme_mod('tora_hours_saturday', '10:00 - 23:00')); ?></dd></div>
                            <div><dt><?php esc_html_e('Sunday', 'tora-tora'); ?></dt><dd><?php echo esc_html((string) get_theme_mod('tora_hours_sunday', '10:00 - 23:00')); ?></dd></div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="delivery-footer" aria-hidden="true"></div>
    </section>

    <section class="panel gallery-panel" id="gallery" data-theme="blue" aria-labelledby="gallery-title" aria-hidden="true">
        <div class="panel-scroll gallery-scroll">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <header class="gallery-heading">
                <h2 id="gallery-title"><?php esc_html_e('Gallery', 'tora-tora'); ?></h2>
                <p class="gallery-blog"><?php esc_html_e('/Blog', 'tora-tora'); ?></p>
            </header>
            <div class="gallery-mosaic">
                <?php foreach ($gallery_tiles as $index => $tile) : ?>
                    <?php
                    $gallery_image = $gallery_images[$index % count($gallery_images)];
                    $tile_label = (string) $tile['label'];
                    $tile_mark = (string) $tile['mark'];
                    $tile_alt = $tile_label !== ''
                        ? sprintf(__('Tora Tora %1$s gallery image %2$d', 'tora-tora'), strtolower($tile_label), $index + 1)
                        : sprintf(__('Tora Tora gallery image %d', 'tora-tora'), $index + 1);
                    ?>
                    <button class="gallery-link" type="button" data-image="<?php echo esc_url($gallery_image); ?>" aria-controls="gallery-modal" aria-haspopup="dialog" aria-label="<?php echo esc_attr(sprintf(__('Open gallery image %1$d of %2$d', 'tora-tora'), $index + 1, $gallery_image_total)); ?>">
                        <img src="<?php echo esc_url($gallery_image); ?>" alt="<?php echo esc_attr($tile_alt); ?>" width="736" height="736" loading="lazy">
                        <?php if ($tile_mark !== '') : ?>
                            <span class="gallery-mark" aria-hidden="true"><?php echo esc_html($tile_mark); ?></span>
                        <?php endif; ?>
                        <?php if ($tile_label !== '') : ?>
                            <span class="gallery-tag" aria-hidden="true"><?php echo esc_html($tile_label); ?></span>
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <p class="gallery-ticker" aria-hidden="true">
                <span>Tora Tora</span><span>Tora Tora</span><span>Tora Tora</span><span>Tora Tora</span><span>Tora Tora</span><span>Tora Tora</span><span>Tora Tora</span><span>Tora Tora</span>
            </p>
        </div>
    </section>

    <section class="panel careers-panel" id="careers" data-theme="light" aria-labelledby="careers-title" aria-hidden="true">
        <div class="panel-scroll careers-scroll">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <div class="careers-layout">
                <header class="careers-header">
                    <div class="careers-intro-block">
                        <h2 id="careers-title"><?php esc_html_e('JOIN THE TEAM', 'tora-tora'); ?></h2>
                        <p class="careers-intro"><?php esc_html_e('AT TORA TORA, WE MOVE FAST, COOK BOLD, AND CELEBRATE EVERYONE WHO BRINGS THE TIGER SPIRIT TO WORK. WE ARE BUILDING SOMETHING EXCEPTIONAL IN DUBAI AND WE WANT EXCEPTIONAL PEOPLE WITH US.', 'tora-tora'); ?></p>
                    </div>
                    <p class="careers-roles-badge"><?php echo esc_html($careers_roles_label); ?></p>
                </header>
                <div class="careers-list-wrap">
                    <ul class="careers-job-list">
                        <?php foreach ($careers_jobs as $careers_job) : ?>
                            <?php
                            $job_title = (string) $careers_job['title'];
                            $job_meta = (string) $careers_job['meta'];
                            $job_url = (string) $careers_job['url'];
                            $job_content = (string) $careers_job['content'];
                            $job_apply_label = (string) ($careers_job['apply_label'] ?? ($job_url !== '' ? __('View & apply', 'tora-tora') : __('Email your CV', 'tora-tora')));
                            $job_apply_href = $job_url !== ''
                                ? $job_url
                                : 'mailto:' . antispambot($careers_email) . '?subject=' . rawurlencode('Job application: ' . $job_title);
                            ?>
                            <li class="careers-job-item">
                                <details class="careers-job-details">
                                    <summary class="careers-job-summary">
                                        <span class="careers-job-copy">
                                            <span class="careers-job-title"><?php echo esc_html($job_title); ?></span>
                                            <span class="careers-job-meta"><?php echo esc_html($job_meta); ?></span>
                                        </span>
                                        <span class="careers-job-toggle" aria-hidden="true">+</span>
                                    </summary>
                                    <div class="careers-job-body">
                                        <?php if ($job_content !== '') : ?>
                                            <div class="careers-job-description entry-content"><?php echo wp_kses_post($job_content); ?></div>
                                        <?php else : ?>
                                            <p class="careers-job-description"><?php esc_html_e('Bring the tiger spirit to Tora Tora. Email your CV and tell us why you belong on the team.', 'tora-tora'); ?></p>
                                        <?php endif; ?>
                                        <a class="careers-job-apply" href="<?php echo esc_url($job_apply_href); ?>">
                                            <?php echo esc_html($job_apply_label); ?>
                                        </a>
                                    </div>
                                </details>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <span class="careers-rule" aria-hidden="true"></span>
                </div>
            </div>
        </div>
    </section>

    <section class="panel contact-panel" id="contact" data-theme="blue" aria-labelledby="contact-title" aria-hidden="true">
        <div class="panel-scroll contact-scroll">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <header class="contact-heading">
                <h2 id="contact-title"><?php esc_html_e('Contact', 'tora-tora'); ?></h2>
                <figure class="contact-tiger" aria-hidden="true">
                    <img src="<?php echo esc_url(tora_tora_asset('images/tiger-mark.png')); ?>" alt="" width="512" height="512" loading="lazy" decoding="async">
                </figure>
            </header>
            <div class="contact-layout">
                <div class="contact-col contact-col-left">
                    <section class="contact-block" aria-labelledby="contact-location-title">
                        <h3 id="contact-location-title"><?php esc_html_e('Location', 'tora-tora'); ?></h3>
                        <p class="contact-location"><?php echo esc_html($address); ?></p>
                    </section>
                    <section class="contact-block" aria-labelledby="contact-touch-title">
                        <h3 id="contact-touch-title"><?php esc_html_e('Get in touch', 'tora-tora'); ?></h3>
                        <dl class="contact-rows">
                            <div>
                                <dt><?php esc_html_e('Phone', 'tora-tora'); ?></dt>
                                <dd><a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></dd>
                            </div>
                            <div>
                                <dt><?php esc_html_e('Email', 'tora-tora'); ?></dt>
                                <dd><a href="mailto:<?php echo esc_attr(antispambot($email)); ?>"><?php echo esc_html(antispambot($email)); ?></a></dd>
                            </div>
                            <div>
                                <dt><?php esc_html_e('Reservation', 'tora-tora'); ?></dt>
                                <dd><a href="mailto:<?php echo esc_attr(antispambot($reservation_email)); ?>"><?php echo esc_html(antispambot($reservation_email)); ?></a></dd>
                            </div>
                        </dl>
                    </section>
                </div>
                <div class="contact-col contact-col-right">
                    <section class="contact-block" aria-labelledby="contact-hours-title">
                        <h3 id="contact-hours-title"><?php esc_html_e('Opening hours', 'tora-tora'); ?></h3>
                        <dl class="contact-rows contact-hours">
                            <div>
                                <dt><?php esc_html_e('Sunday - Thursday', 'tora-tora'); ?></dt>
                                <dd><?php echo esc_html($hours_sun_thu); ?></dd>
                            </div>
                            <div>
                                <dt><?php esc_html_e('Friday - Saturday', 'tora-tora'); ?></dt>
                                <dd><?php echo esc_html($hours_fri_sat); ?></dd>
                            </div>
                        </dl>
                    </section>
                    <section class="contact-block" aria-labelledby="contact-follow-title">
                        <h3 id="contact-follow-title"><?php esc_html_e('Follow us', 'tora-tora'); ?></h3>
                        <ul class="contact-social">
                            <li>
                                <a class="contact-social-link" href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer">
                                    <span><?php esc_html_e('Instagram', 'tora-tora'); ?></span>
                                    <span class="contact-social-handle"><?php echo esc_html($instagram_handle); ?><span aria-hidden="true">→</span></span>
                                </a>
                            </li>
                            <li>
                                <a class="contact-social-link" href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer">
                                    <span><?php esc_html_e('TikTok', 'tora-tora'); ?></span>
                                    <span class="contact-social-handle"><?php echo esc_html($tiktok_handle); ?><span aria-hidden="true">→</span></span>
                                </a>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
            <figure class="contact-map">
                <a
                    class="contact-map-link"
                    href="https://maps.google.com/?q=<?php echo rawurlencode($address); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="<?php echo esc_attr(sprintf(/* translators: %s: street address */ __('Open directions to Tora Tora at %s', 'tora-tora'), $address)); ?>"
                >
                    <img
                        class="contact-map-art"
                        src="<?php echo esc_url($contact_map); ?>"
                        alt="<?php echo esc_attr(sprintf(/* translators: %s: street address */ __('Illustrated map of Dubai near %s', 'tora-tora'), $address)); ?>"
                        width="1360"
                        height="440"
                        loading="lazy"
                        decoding="async"
                    >
                </a>
            </figure>
        </div>
    </section>
</main>

<div class="modal lightbox" id="gallery-modal" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title" aria-hidden="true">
    <div class="modal-dialog lightbox-dialog" role="document">
        <h2 class="screen-reader-text" id="gallery-modal-title"><?php esc_html_e('Image preview', 'tora-tora'); ?></h2>
        <button class="modal-close" type="button" data-modal-close aria-label="<?php esc_attr_e('Close image preview', 'tora-tora'); ?>">×</button>
        <img class="lightbox-image" src="" alt="">
    </div>
</div>
<?php get_footer(); ?>
