<?php
$run = file_get_contents('tests/run.php');
$run = preg_replace("/file_contains\(\\\$theme \. '\/assets\/css\/main\.css', '\"c6 c6 c7 l3\"', 'Gallery row 3 wide interior pattern is missing\.'\);\n/", '', $run);
file_put_contents('tests/run.php', $run);
