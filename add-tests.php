<?php
$tests = <<<TESTS

// NEW TESTS FROM IMPLEMENTATION PLAN
// 1. Home pattern clean edge (no concave mask)
file_does_not_contain(\$theme . '/assets/css/main.css', 'mask-image: radial-gradient', 'Home pattern still uses a concave cutout mask.');

// 2. About sentence case copy and emphasis
file_contains(\$theme . '/inc/default-content.php', "<strong>courage, strength and indomitable spirit</strong>", 'About copy missing bold emphasis 1');
file_contains(\$theme . '/inc/default-content.php', "<strong>bold flavours and vibrant dining experiences</strong>", 'About copy missing bold emphasis 2');
file_contains(\$theme . '/inc/default-content.php', "<em>protection and good fortune</em>", 'About copy missing italic emphasis');
file_contains(\$theme . '/inc/default-content.php', "<strong>Tora Tora</strong> brings a slice of <strong>Japanese culture to Dubai</strong>", 'About copy missing bold emphasis 3');
file_contains(\$theme . '/inc/default-content.php', "<strong>dynamic and powerful as the tiger itself</strong>", 'About copy missing bold emphasis 4');

// 3. Menu rail full coverage without solid overlay
file_does_not_contain(\$theme . '/assets/css/main.css', '.menu-rail-right::after', 'Menu rail still has the solid blue hamburger gutter.');

// 4. Delivery card CTA spacing and zone boxes grid
// Already added check for 3 columns:
// file_contains(\$theme . '/assets/css/main.css', '.delivery-boxes { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));', 'Delivery boxes are not 3 equal structured cards.');
file_contains(\$theme . '/assets/css/main.css', 'padding-top: 3.5rem;', 'Delivery card CTA spacing not increased.');

// 5. Gallery 4x4 geometric pattern tiles
file_contains(\$theme . '/assets/css/main.css', '"c1 c2 . c3"', 'Gallery row 1 geometric pattern is missing.');
file_contains(\$theme . '/assets/css/main.css', '". . c4 c5"', 'Gallery row 2 geometric pattern is missing.');
file_contains(\$theme . '/assets/css/main.css', '"c6 c6 c7 ."', 'Gallery row 3 geometric pattern is missing.');
file_contains(\$theme . '/assets/css/main.css', '"c8 c9 c10 c11"', 'Gallery row 4 geometric pattern is missing.');

// 6. Careers two-line title with "THE TEAM" locked and bullet separator
file_contains(\$theme . '/front-page.php', '<span>JOIN</span><br><span class="careers-team-line">THE TEAM</span>', 'Careers title not two lines locked.');
file_contains(\$theme . '/assets/css/main.css', '.careers-team-line {', 'Careers title .careers-team-line missing.');
file_contains(\$theme . '/assets/css/main.css', 'white-space: nowrap;', 'Careers title .careers-team-line not nowrap.');
file_contains(\$theme . '/inc/jobs.php', '<span class="careers-job-bullet">•</span>', 'Careers separator bullet not styled with class.');

// 7. Contact two-line location and logo styling
file_contains(\$theme . '/inc/setup.php', 'array_slice(\$parts, 0, \$split_at)', 'Contact location not split into two lines.');

TESTS;

file_put_contents('tests/run.php', $tests, FILE_APPEND);
