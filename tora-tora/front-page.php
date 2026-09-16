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
    '<p>' . esc_html__('Tora Tora, derived from the Japanese word for \'tiger\', captures the essence of the powerful and majestic animal revered in Japanese mythology.', 'tora-tora') . '</p><p>' . wp_kses(__('A symbol of <strong>courage, strength and indomitable spirit</strong>, the tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\'s commitment to bold flavours and vibrant dining experiences.', 'tora-tora'), ['strong' => []]) . '</p><p>' . esc_html__('Tora Tora brings a slice of Japanese culture to Dubai, offering a dining experience that\'s as dynamic and powerful as the tiger itself, perfectly blending tradition with contemporary flair.', 'tora-tora') . '</p>',
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
$careers_fallback_title = __('Join the Tora Tora Team', 'tora-tora');
$careers_fallback_content = '<p>' . esc_html__('Tora Tora is built on passion for food, hospitality, and creativity. We’re always looking for talented individuals who share our energy for Japanese cuisine and exceptional service.', 'tora-tora') . '</p><h3>' . esc_html__('Why Work With Us', 'tora-tora') . '</h3><p>' . esc_html__('At Tora Tora, we value dedication, hospitality, teamwork, and a shared love for authentic Japanese cuisine. We are always looking for individuals who are passionate about creating memorable dining experiences.', 'tora-tora') . '</p><h3>' . esc_html__('What We’re Looking For', 'tora-tora') . '</h3><p>' . esc_html__('From kitchen professionals to front-of-house staff, we welcome talented people who bring energy, professionalism, and commitment to excellence.', 'tora-tora') . '</p>';
$careers = tora_tora_panel_page(
    'careers',
    $careers_fallback_title,
    $careers_fallback_content
);
$careers_title = tora_tora_clean_panel_title((string) $careers['title'], $careers_fallback_title);
$careers_content = tora_tora_careers_content_html((string) $careers['content'], $careers_fallback_content);
$job_listings = tora_tora_get_job_listings();
$menu_groups = tora_get_menu_groups();
$gallery_images = [];
for ($gallery_index = 1; $gallery_index <= 5; $gallery_index++) {
    $gallery_images[] = tora_tora_image_setting('tora_gallery_' . $gallery_index, 'gallery-' . $gallery_index . '.jpg');
}
$gallery_image_total = count($gallery_images);
$address = (string) get_theme_mod('tora_address', 'Al Wasl Road, Umm Suqeim 1, Dubai, UAE');
$phone = (string) get_theme_mod('tora_phone', '+9-500-025-200');
$email = (string) get_theme_mod('tora_email', 'support@toratora.ae');
$careers_email = (string) get_theme_mod('tora_careers_email', 'hello@toratora.ae');
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
            </div>
            <div class="home-pattern" aria-hidden="true"></div>
        </div>
        <div class="hero-art">
            <figure class="hero-bowl">
                <img
                    src="<?php echo esc_url($home['image']); ?>"
                    alt="<?php esc_attr_e('Tora Tora ramen bowl', 'tora-tora'); ?>"
                    width="1280"
                    height="1280"
                    decoding="async"
                >
            </figure>
        </div>
    </section>

    <section class="panel story-panel" id="about" data-theme="light" aria-labelledby="about-title" aria-hidden="true">
        <div class="panel-scroll">
            <div class="story-scroll-inner">
                <div class="story-screen story-screen-primary">
                    <?php get_template_part('template-parts/panel', 'back'); ?>
                    <div class="story-layout">
                        <div class="story-copy panel-copy">
                            <h2 id="about-title"><?php echo esc_html($about['title']); ?></h2>
                            <div class="entry-content"><?php echo wp_kses_post($about['content']); ?></div>
                        </div>
                        <div class="story-art" aria-hidden="true">
                            <span class="story-pattern-disc"></span>
                            <figure class="story-tiger-disc">
                                <img src="<?php echo esc_url($about['image']); ?>" alt="" width="512" height="512" loading="lazy" decoding="async">
                            </figure>
                            <span class="story-rule"></span>
                        </div>
                    </div>
                    <div class="story-band" aria-hidden="true"></div>
                </div>
                <div class="story-screen story-screen-secondary" aria-hidden="true">
                    <div class="story-band story-band-tail"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="panel menu-panel" id="menu" data-theme="light" aria-labelledby="menu-title" aria-hidden="true">
        <div class="menu-rail menu-rail-left" aria-hidden="true"></div>
        <div class="panel-scroll menu-layout">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <h2 id="menu-title"><?php esc_html_e('MENU', 'tora-tora'); ?></h2>
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
                            <h3><?php echo esc_html($group['term']->name); ?></h3>
                            <?php foreach ($group['items'] as $item) : ?>
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
                <div>
                    <p class="delivery-label"><?php esc_html_e('Delivery zones', 'tora-tora'); ?></p>
                    <ul class="delivery-zones">
                        <?php foreach (tora_tora_delivery_zones() as $zone) : ?>
                            <li<?php echo strcasecmp($zone, $featured_zone) === 0 ? ' class="is-featured"' : ''; ?>><?php echo esc_html($zone); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div>
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
        <div class="panel-scroll">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <div class="gallery-layout">
                <div class="gallery-copy panel-copy">
                    <h2 id="gallery-title"><?php echo esc_html($gallery['title']); ?></h2>
                    <div class="entry-content"><?php echo wp_kses_post($gallery['content']); ?></div>
                </div>
                <div class="gallery-mosaic">
                    <?php foreach ($gallery_images as $index => $gallery_image) : ?>
                        <button class="gallery-link<?php echo 0 === $index ? ' gallery-feature' : ''; ?>" type="button" data-image="<?php echo esc_url($gallery_image); ?>" aria-controls="gallery-modal" aria-haspopup="dialog" aria-label="<?php echo esc_attr(sprintf(__('Open gallery image %1$d of %2$d', 'tora-tora'), $index + 1, $gallery_image_total)); ?>">
                            <img src="<?php echo esc_url($gallery_image); ?>" alt="<?php echo esc_attr(sprintf(__('Tora Tora gallery image %d', 'tora-tora'), $index + 1)); ?>" width="736" height="736" loading="lazy">
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="panel careers-panel" id="careers" data-theme="light" aria-labelledby="careers-title" aria-hidden="true">
        <div class="panel-scroll">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <div class="careers-layout">
                <div class="careers-copy panel-copy">
                    <h2 id="careers-title"><?php echo esc_html($careers_title); ?></h2>
                    <div class="entry-content"><?php echo wp_kses_post($careers_content); ?></div>
                    <div class="button-row">
                        <a class="button nav-link" href="#contact" data-target="contact"><?php esc_html_e('Apply Now', 'tora-tora'); ?></a>
                        <a class="button button-outline" href="mailto:<?php echo esc_attr(antispambot($careers_email)); ?>?subject=<?php echo rawurlencode('Job application'); ?>"><?php esc_html_e('Email Us', 'tora-tora'); ?></a>
                    </div>
                </div>
                <section class="careers-openings" aria-labelledby="careers-openings-title">
                    <h3 id="careers-openings-title"><?php esc_html_e('Current openings', 'tora-tora'); ?></h3>
                    <?php if ($job_listings) : ?>
                        <ul class="careers-job-list">
                            <?php foreach ($job_listings as $job) : ?>
                                <?php
                                $job_id = (int) $job->ID;
                                $job_location = tora_tora_job_location($job_id);
                                $job_types = tora_tora_job_type_labels($job_id);
                                $job_url = get_permalink($job_id);
                                ?>
                                <li class="careers-job-item">
                                    <a class="careers-job-link" href="<?php echo esc_url($job_url ?: home_url('/#careers')); ?>">
                                        <span class="careers-job-title"><?php echo esc_html(get_the_title($job)); ?></span>
                                        <?php if ($job_location !== '' || $job_types) : ?>
                                            <span class="careers-job-meta">
                                                <?php if ($job_location !== '') : ?>
                                                    <span class="careers-job-location"><?php echo esc_html($job_location); ?></span>
                                                <?php endif; ?>
                                                <?php foreach ($job_types as $job_type) : ?>
                                                    <span class="job-type-badge"><?php echo esc_html($job_type); ?></span>
                                                <?php endforeach; ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="careers-job-cta"><?php esc_html_e('View & apply', 'tora-tora'); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="careers-empty"><?php esc_html_e('No vacancies at the moment. We still welcome introductions from people who care deeply about food and hospitality.', 'tora-tora'); ?></p>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </section>

    <section class="panel contact-panel" id="contact" data-theme="blue" aria-labelledby="contact-title" aria-hidden="true">
        <div class="panel-scroll">
            <?php get_template_part('template-parts/panel', 'back'); ?>
            <div class="contact-layout">
                <div class="contact-info panel-copy">
                    <h2 id="contact-title"><?php echo esc_html($contact['title']); ?></h2>
                    <div class="entry-content contact-intro"><?php echo wp_kses_post($contact['content']); ?></div>
                    <dl class="contact-list">
                        <div><dt><?php esc_html_e('Address', 'tora-tora'); ?></dt><dd><?php echo esc_html($address); ?></dd></div>
                        <div><dt><?php esc_html_e('Phone', 'tora-tora'); ?></dt><dd><a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></dd></div>
                        <div><dt><?php esc_html_e('Email', 'tora-tora'); ?></dt><dd><a href="mailto:<?php echo esc_attr(antispambot($email)); ?>"><?php echo esc_html(antispambot($email)); ?></a></dd></div>
                        <div><dt><?php esc_html_e('Social', 'tora-tora'); ?></dt><dd><?php echo esc_html(get_theme_mod('tora_social', 'Facebook / TikTok / Instagram / WhatsApp')); ?></dd></div>
                    </dl>
                    <a class="button button-inverse" href="https://maps.google.com/?q=<?php echo rawurlencode($address); ?>" target="_blank" rel="noopener"><?php esc_html_e('Directions', 'tora-tora'); ?></a>
                </div>
                <figure class="contact-card contact-map" aria-label="<?php echo esc_attr(sprintf(/* translators: %s: street address */ __('Map of Tora Tora at %s', 'tora-tora'), $address)); ?>">
                    <iframe
                        class="contact-map-frame"
                        title="<?php echo esc_attr(sprintf(/* translators: %s: street address */ __('Google Map showing %s', 'tora-tora'), $address)); ?>"
                        src="<?php echo esc_url(tora_tora_maps_embed_url($address)); ?>"
                        width="736"
                        height="920"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                </figure>
            </div>
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
