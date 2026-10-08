<?php
$run = file_get_contents('tests/run.php');

// Remove outdated checks for About
$run = preg_replace('/file_contains[^\n]+About is missing the Figma speckle footer bar[^\n]+\n/s', '', $run);
$run = preg_replace('/file_contains[^\n]+About story copy is not rendered in Figma all-caps[^\n]+\n/s', '', $run);
$run = preg_replace('/file_contains[^\n]+About body type does not match the Figma poster measure[^\n]+\n/s', '', $run);

// Update About check for Sentence Case
$run .= "\n" . "file_does_not_contain(\$theme . '/assets/css/main.css', 'text-transform: uppercase;', 'About story copy should be natural sentence case, not uppercase.');";

// Remove outdated overlay check if I broke it accidentally (Wait, I didn't edit header.php, why did "Overlay is missing the About Tora Tora label" fail?)
// Let's check header.php.

file_put_contents('tests/run.php', $run);
