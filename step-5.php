<?php
// Fix About page emphasis in front-page.php
$front = file_get_contents('tora-tora/front-page.php');

$old_about = 'wp_kses(__(\'Tora Tora, derived from the Japanese word for \\\'tiger\\\', captures the essence of the powerful and majestic animal revered in Japanese mythology.\', \'tora-tora\'), []) . \'</p><p>\' . wp_kses(__(\'A symbol of <strong>courage, strength and indomitable spirit</strong>. The tiger has a storied presence in folklore, often representing protection and good fortune. This name reflects our brand\\\'s commitment to bold flavours and vibrant dining experiences.\', \'tora-tora\'), [\'strong\' => []]) . \'</p><p>\' . wp_kses(__(\'Tora Tora brings a slice of Japanese culture to Dubai, offering a dining experience that\\\'s as dynamic and powerful as the tiger itself, perfectly blending <strong>tradition with contemporary flair</strong>.\', \'tora-tora\'), [\'strong\' => []])';

$new_about = 'wp_kses(__(\'Tora Tora, derived from the Japanese word for <em>\\\'tiger\\\'</em>, captures the essence of the powerful and majestic animal revered in Japanese mythology.\', \'tora-tora\'), [\'em\' => []]) . \'</p><p>\' . wp_kses(__(\'A symbol of <strong>courage, strength and indomitable spirit</strong>. The tiger has a storied presence in folklore, often representing <em>protection and good fortune</em>. This name reflects our brand\\\'s commitment to <strong>bold flavours and vibrant dining experiences</strong>.\', \'tora-tora\'), [\'strong\' => [], \'em\' => []]) . \'</p><p>\' . wp_kses(__(\'<strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>, offering a dining experience that\\\'s as <strong>dynamic and powerful as the tiger itself</strong>, perfectly blending <em>tradition with contemporary flair</em>.\', \'tora-tora\'), [\'strong\' => [], \'em\' => []])';

$front = str_replace($old_about, $new_about, $front);

// Fix Careers Title
$front = str_replace(
    '<h2 id="careers-title">JOIN THE TEAM</h2>',
    '<h2 id="careers-title"><span>JOIN</span><br><span class="careers-team-line">THE TEAM</span></h2>',
    $front
);

file_put_contents('tora-tora/front-page.php', $front);

// Fix jobs.php bullet separator
$jobs = file_get_contents('tora-tora/inc/jobs.php');
$jobs = preg_replace(
    "/return tora_tora_normalize_job_meta_separator\(\\$type_line \. ' • ' \. strtoupper\(\\$location\)\);/",
    "return tora_tora_normalize_job_meta_separator(\$type_line . ' <span class=\"careers-job-bullet\">•</span> ' . strtoupper(\$location));",
    $jobs
);
file_put_contents('tora-tora/inc/jobs.php', $jobs);

// Fix CSS
$css = file_get_contents('tora-tora/assets/css/main.css');
// Gallery
$css = preg_replace(
    '/grid-template-areas:\s*"c1 c2 l1 c3"\s*"l2 l2 c4 c5"\s*"c6 c6 c7 l3"\s*"c8 c9 c10 c11";/',
    'grid-template-areas:
    "c1 c2 . c3"
    ". . c4 c5"
    "c6 c6 c7 ."
    "c8 c9 c10 c11";',
    $css
);
// Careers
$css .= "\n.careers-team-line {\n  white-space: nowrap;\n}\n";
file_put_contents('tora-tora/assets/css/main.css', $css);

echo "Step 5 done.\n";
