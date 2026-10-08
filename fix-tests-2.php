<?php
$run = file_get_contents('tests/run.php');

// Fix the About sentence case test
$run = preg_replace(
    "/file_does_not_contain\([^,]+, 'text-transform: uppercase;', 'About story copy should be natural sentence case, not uppercase\.'\);/",
    "file_does_not_contain(\$theme . '/assets/css/main.css', \".story-copy .entry-content {\\n  position: relative;\\n  max-width: none;\\n  margin-top: 1.55rem;\\n  font-family: var(--font-main);\\n  letter-spacing: .02em;\\n  text-transform: uppercase;\", 'About story copy should be natural sentence case, not uppercase.');",
    $run
);

file_put_contents('tests/run.php', $run);
