<?php
/**
 * Native WordPress Customizer settings.
 *
 * @package Tora_Tora
 */

if (!defined('ABSPATH')) {
    exit;
}

function tora_tora_default_delivery_zones(): string
{
    return implode("\n", [
        'Dubai Marina',
        'Jumeirah Beach Residence',
        'Downtown Dubai',
        'Business Bay',
        'DFC',
        'Palm Jumeirah',
        'Al Barsha',
        'Jumeirah',
    ]);
}

function tora_tora_customize_register(WP_Customize_Manager $customize): void
{
    $customize->add_section(
        'tora_tora_details',
        [
            'title'       => __('Tora Tora details', 'tora-tora'),
            'description' => __('Contact details, delivery platforms, staging safeguards, and gallery images.', 'tora-tora'),
            'priority'    => 30,
        ]
    );

    $text_settings = [
        'tora_address' => [__('Address', 'tora-tora'), 'First Avenue Mall, Jumeira, Dubai, UAE'],
        'tora_phone'   => [__('Phone', 'tora-tora'), '+971 4 000 0000'],
        'tora_email'   => [__('Contact email', 'tora-tora'), 'hello@toratora.ae'],
        'tora_reservation_email' => [__('Reservation email', 'tora-tora'), 'reserve@toratora.ae'],
        'tora_careers_email' => [__('Careers email', 'tora-tora'), 'hello@toratora.ae'],
        'tora_instagram_handle' => [__('Instagram handle', 'tora-tora'), '@toratora.dxb'],
        'tora_instagram_url' => [__('Instagram URL', 'tora-tora'), 'https://www.instagram.com/toratora.dxb'],
        'tora_tiktok_handle' => [__('TikTok handle', 'tora-tora'), '@toratora.dxb'],
        'tora_tiktok_url' => [__('TikTok URL', 'tora-tora'), 'https://www.tiktok.com/@toratora.dxb'],
        'tora_maps_url' => [__('Google Maps URL', 'tora-tora'), 'https://maps.app.goo.gl/e8q15vCemqi5rcZX7'],
        'tora_social'  => [__('Social label', 'tora-tora'), 'Facebook / TikTok / Instagram / WhatsApp'],
        'tora_footer'  => [__('Footer text', 'tora-tora'), 'Reborn Consultancy © ' . gmdate('Y')],
        'tora_talabat_url' => [__('Talabat URL', 'tora-tora'), 'https://www.talabat.com'],
        'tora_noon_url' => [__('Noon Food URL', 'tora-tora'), 'https://food.noon.com'],
        'tora_deliveroo_url' => [__('Deliveroo URL', 'tora-tora'), 'https://deliveroo.ae'],
        'tora_hours_weekday' => [__('Hours Monday–Friday', 'tora-tora'), '11:00 - 22:30'],
        'tora_hours_saturday' => [__('Hours Saturday', 'tora-tora'), '10:00 - 23:00'],
        'tora_hours_sunday' => [__('Hours Sunday', 'tora-tora'), '10:00 - 23:00'],
        'tora_hours_sun_thu' => [__('Contact hours Sunday–Thursday', 'tora-tora'), '08:00 - 23:00'],
        'tora_hours_fri_sat' => [__('Contact hours Friday–Saturday', 'tora-tora'), '08:00 - 00:00'],
        'tora_featured_zone' => [__('Highlighted delivery zone', 'tora-tora'), 'Business Bay'],
    ];

    foreach ($text_settings as $id => [$label, $default]) {
        $sanitize = (str_contains($id, 'email') && !str_contains($id, 'url'))
            ? 'sanitize_email'
            : (str_contains($id, 'url') ? 'esc_url_raw' : 'sanitize_text_field');
        $customize->add_setting($id, ['default' => $default, 'sanitize_callback' => $sanitize]);
        $customize->add_control($id, ['section' => 'tora_tora_details', 'label' => $label, 'type' => 'text']);
    }

    $customize->add_setting(
        'tora_delivery_zones',
        [
            'default'           => tora_tora_default_delivery_zones(),
            'sanitize_callback' => 'sanitize_textarea_field',
        ]
    );
    $customize->add_control(
        'tora_delivery_zones',
        [
            'section'     => 'tora_tora_details',
            'label'       => __('Delivery zones', 'tora-tora'),
            'description' => __('One neighbourhood per line.', 'tora-tora'),
            'type'        => 'textarea',
        ]
    );

    $customize->add_setting('tora_staging_mode', ['default' => true, 'sanitize_callback' => 'tora_tora_sanitize_checkbox']);
    $customize->add_control(
        'tora_staging_mode',
        [
            'section'     => 'tora_tora_details',
            'label'       => __('Enable staging preview notice and noindex', 'tora-tora'),
            'description' => __('Turn this off only when the website is approved for launch.', 'tora-tora'),
            'type'        => 'checkbox',
        ]
    );

    $image_settings = [
        'tora_talabat_logo' => [__('Talabat logo', 'tora-tora'), 'delivery-talabat.svg'],
        'tora_noon_logo' => [__('Noon Food logo', 'tora-tora'), 'delivery-noon.png'],
        'tora_deliveroo_logo' => [__('Deliveroo logo', 'tora-tora'), 'delivery-deliveroo.svg'],
        'tora_gallery_1' => [__('Gallery image 1', 'tora-tora'), 'gallery-1.jpg'],
        'tora_gallery_2' => [__('Gallery image 2', 'tora-tora'), 'gallery-2.jpg'],
        'tora_gallery_3' => [__('Gallery image 3', 'tora-tora'), 'gallery-3.jpg'],
        'tora_gallery_4' => [__('Gallery image 4', 'tora-tora'), 'gallery-4.jpg'],
        'tora_gallery_5' => [__('Gallery image 5', 'tora-tora'), 'gallery-5.jpg'],
        'tora_contact_map' => [__('Contact Dubai map', 'tora-tora'), 'contact-dubai-map.png'],
    ];

    foreach ($image_settings as $id => [$label, $fallback]) {
        $customize->add_setting($id, ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
        $customize->add_control(
            new WP_Customize_Image_Control(
                $customize,
                $id,
                [
                    'section'     => 'tora_tora_details',
                    'label'       => $label,
                    'description' => sprintf(__('Packaged fallback: %s', 'tora-tora'), $fallback),
                ]
            )
        );
    }
}
add_action('customize_register', 'tora_tora_customize_register');

function tora_tora_sanitize_checkbox($checked): bool
{
    return (bool) $checked;
}

/**
 * @return array<int,string>
 */
function tora_tora_delivery_zones(): array
{
    $raw = (string) get_theme_mod('tora_delivery_zones', tora_tora_default_delivery_zones());
    return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw) ?: [])));
}
