<?php
$css = file_get_contents('tora-tora/assets/css/main.css');

// Home Mask
$css = preg_replace('/-webkit-mask-image:\s*radial-gradient[^;]+;/', '', $css);
$css = preg_replace('/mask-image:\s*radial-gradient[^;]+;/', '', $css);

// About Sentence Case
$css = preg_replace(
    '/\.story-copy \.entry-content \{([^}]+)text-transform:\s*uppercase;\s*\}/s',
    '.story-copy .entry-content {$1}',
    $css
);
$css = preg_replace(
    '/\.story-copy \.entry-content p \{([^}]+)font-weight:\s*500;/s',
    '.story-copy .entry-content p {$1font-weight: 400;',
    $css
);

// Menu right rail overlay
$css = preg_replace('/\.menu-rail-right::after\s*\{[^}]+\}/s', '', $css);

// Delivery panel
$css = preg_replace(
    '/\.delivery-copy \.entry-content \{([^}]+)font-size:\s*\.72rem;\s*font-weight:\s*500;\s*line-height:\s*1\.45;/s',
    '.delivery-copy .entry-content {${1}font-size: .65rem; font-weight: 500; line-height: 1.35; letter-spacing: .04em;',
    $css
);
$css = preg_replace(
    '/\.delivery-order \{([^}]+)padding-top:\s*2\.35rem;/s',
    '.delivery-order {${1}padding-top: 3.5rem;',
    $css
);
$css = preg_replace(
    '/\.delivery-boxes \{\s*display: grid;\s*grid-template-columns: minmax\(0, 1\.15fr\) minmax\(0, 1fr\);/s',
    '.delivery-boxes { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));',
    $css
);

// Gallery Mosaic Grid
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
