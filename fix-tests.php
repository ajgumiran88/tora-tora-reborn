<?php
$run = file_get_contents('tests/run.php');

// Remove the old exit logic
$run = preg_replace('/if \(\$failures\) \{.*?exit\(1\);\s*\}/s', '', $run);
$run = preg_replace('/fwrite\(STDOUT, "All Tora Tora theme checks passed\.\\\\n"\);/s', '', $run);

// Add it to the very end
$run .= <<<EXIT
if (\$failures) {
    fwrite(STDERR, "Theme checks failed:\\n- " . implode("\\n- ", \$failures) . "\\n");
    exit(1);
}
fwrite(STDOUT, "All Tora Tora theme checks passed.\\n");
EXIT;

file_put_contents('tests/run.php', $run);
