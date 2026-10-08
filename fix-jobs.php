<?php
$jobs = file_get_contents('tora-tora/inc/jobs.php');
$jobs = str_replace(
    "return tora_tora_normalize_job_meta_separator(\$type_line . ' • ' . strtoupper(\$location));",
    "return tora_tora_normalize_job_meta_separator(\$type_line . ' <span class=\"careers-job-bullet\">•</span> ' . strtoupper(\$location));",
    $jobs
);
file_put_contents('tora-tora/inc/jobs.php', $jobs);
