<?php
$css = file_get_contents('tora-tora/assets/css/main.css');
$css = preg_replace('/-webkit-mask-image:\s*radial-gradient[^;]+;/', '', $css);
$css = preg_replace('/mask-image:\s*radial-gradient[^;]+;/', '', $css);
file_put_contents('tora-tora/assets/css/main.css', $css);
