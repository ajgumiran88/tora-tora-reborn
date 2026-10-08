<?php
$run = file_get_contents('tests/run.php');

// Menu rail solid overlay check -> should NOT contain
$run = str_replace(
    "file_contains(\$theme . '/assets/css/main.css', '.menu-rail-right::after', 'Menu rail is missing the solid blue hamburger gutter.');",
    "file_does_not_contain(\$theme . '/assets/css/main.css', '.menu-rail-right::after', 'Menu rail still has the solid blue hamburger gutter.');",
    $run
);
$run = str_replace(
    "file_contains(\$theme . '/assets/css/main.css', \".menu-rail-right::after {\\n  content: \\\"\\\";\\n  position: absolute;\\n  top: 0;\\n  right: 0;\\n  bottom: 0;\\n  width: var(--menu-solid);\\n  background: var(--tora-blue);\\n}\", 'Menu solid blue gutter is not sized from the shared rail token.');",
    "",
    $run
);

// Delivery boxes
$run = str_replace(
    "file_contains(\$theme . '/assets/css/main.css', '.delivery-box {', 'Delivery info cards are missing equal box styling.');",
    "file_contains(\$theme . '/assets/css/main.css', '.delivery-boxes { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));', 'Delivery boxes are not 3 equal structured cards.');",
    $run
);

// Gallery 4x4 geometric pattern tiles
// Ensure that the CSS rules for c1 to c11 match the new 4x4 grid:
// Row 1: Item 1 (col 1), Item 2 (col 2), empty (col 3), Item 3 (col 4) -> c1 c2 . c3
// Row 2: empty (col 1), empty (col 2), Item 4 (col 3), Item 5 (col 4) -> . . c4 c5
// Row 3: Item 6 (cols 1 & 2), Item 7 (col 3), empty (col 4) -> c6 c6 c7 .
// Row 4: Item 8 (col 1), Item 9 (col 2), Item 10 (col 3), Item 11 (col 4) -> c8 c9 c10 c11

// Replace old gallery assertions
$run = preg_replace('/file_contains\(\$theme \. \'\/assets\/css\/main\.css\', \'"c1 c2 l1 c3"\', \'Gallery row 1 pattern is missing\.\'\);/', '', $run);
$run = preg_replace('/file_contains\(\$theme \. \'\/assets\/css\/main\.css\', \'"l2 l2 c4 c5"\', \'Gallery row 2 pattern is missing\.\'\);/', '', $run);
$run = preg_replace('/file_contains\(\$theme \. \'\/assets\/css\/main\.css\', \'"c6 c6 c7 l3"\', \'Gallery wide interior pattern is missing\.\'\);/', '', $run);

$run .= "\n" . "file_contains(\$theme . '/assets/css/main.css', '\"c1 c2 . c3\"', 'Gallery row 1 geometric pattern is missing.');";
$run .= "\n" . "file_contains(\$theme . '/assets/css/main.css', '\". . c4 c5\"', 'Gallery row 2 geometric pattern is missing.');";
$run .= "\n" . "file_contains(\$theme . '/assets/css/main.css', '\"c6 c6 c7 .\"', 'Gallery row 3 geometric pattern is missing.');";
$run .= "\n" . "file_contains(\$theme . '/assets/css/main.css', '\"c8 c9 c10 c11\"', 'Gallery row 4 geometric pattern is missing.');";

// Contact two-line location
$run .= "\n" . "file_contains(\$theme . '/inc/setup.php', 'array_slice(\$parts, 0, \$split_at)', 'Contact location is not split correctly.');";

file_put_contents('tests/run.php', $run);
echo "Step 3 tests updated.\n";
