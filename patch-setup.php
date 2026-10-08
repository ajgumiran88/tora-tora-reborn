<?php
$setup = file_get_contents('tora-tora/inc/setup.php');

// The implementation plan says:
// Refactor tora_tora_format_address_lines() in setup.php ... so the address is cleanly rendered on exactly two lines
// The test says: file_contains($theme . '/inc/setup.php', 'array_slice($parts, 0, $split_at)', 'Contact location not split into two lines.');

// Wait, the current implementation in setup.php ALREADY does:
// $split_at = (int) ceil(count($parts) / 2);
// $first_line = implode(', ', array_slice($parts, 0, $split_at)) . ',';

// Let's check if there is anything I need to change? The plan says "exactly two lines: Line 1: First Avenue Mall, Jumeira, Line 2: Dubai, UAE".
