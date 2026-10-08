<?php
$file = 'tora-tora/inc/default-content.php';
$content = file_get_contents($file);

$old_story = "'content' => '<p>Tora Tora, derived from the Japanese word for \\\'tiger\\\', captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>. The tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\\\'s commitment to bold flavours and vibrant dining experiences.</p><p>Tora Tora brings a slice of Japanese culture to Dubai, offering a dining experience that\\\'s as dynamic and powerful as the tiger itself, perfectly blending <strong>tradition with contemporary flair</strong>.</p>' . tora_tora_default_kitchen_story(),";
$new_story = "'content' => '<p>Tora Tora, derived from the Japanese word for <em>\\\'tiger\\\'</em>, captures the essence of the powerful and majestic animal revered in Japanese mythology.</p><p>A symbol of <strong>courage, strength and indomitable spirit</strong>. The tiger has a storied presence in folklore, often representing <em>protection and good fortune</em>. This name reflects our brand\\\'s commitment to <strong>bold flavours and vibrant dining experiences</strong>.</p><p><strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>, offering a dining experience that\\\'s as <strong>dynamic and powerful as the tiger itself</strong>, perfectly blending <em>tradition with contemporary flair</em>.</p>' . tora_tora_default_kitchen_story(),";

$content = str_replace($old_story, $new_story, $content);

// Add the migration function
$migration = <<<MIGRATE

function tora_tora_upgrade_about_copy_1_6_0(): void
{
    \$page = get_page_by_path('story', OBJECT, 'page');
    if (!\$page instanceof WP_Post) {
        return;
    }

    \$defaults = tora_tora_default_pages();
    \$expected = \$defaults['story']['content'];

    wp_update_post([
        'ID'           => (int) \$page->ID,
        'post_content' => \$expected,
    ]);
}
MIGRATE;

$content = str_replace("function tora_tora_upgrade_about_kitchen_1_5_1", $migration . "\n\nfunction tora_tora_upgrade_about_kitchen_1_5_1", $content);

// Hook it in tora_tora_maybe_upgrade_content
$hook = <<<HOOK
    if (version_compare(\$current, '1.6.0', '<')) {
        tora_tora_upgrade_about_copy_1_6_0();
        \$current = '1.6.0';
        update_option('tora_tora_seeded_version', \$current, false);
    }
HOOK;

$content = str_replace(
    "if (version_compare(\$current, '1.5.1', '<')) {",
    \$hook . "\n\n    if (version_compare(\$current, '1.5.1', '<')) {",
    $content
);

file_put_contents($file, $content);
echo "Step 6 done.\\n";
