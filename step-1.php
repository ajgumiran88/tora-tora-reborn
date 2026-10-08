<?php
// About Page: main.css updates
$css = file_get_contents('tora-tora/assets/css/main.css');

// 2. About Page Panel (#about)
// Remove text-transform: uppercase and set font-weight: 400
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

// Add top-right corner blue accent arc? Wait, .story-accent-arc already exists in main.css!
// Replace the bottom static speckle bar with the repeating TORA TORA typography ticker.
// We need to change the About panel bottom in front-page.php and main.css.

file_put_contents('tora-tora/assets/css/main.css', $css);
echo "Step 1 done.\n";
