<?php

require __DIR__ . '/../libs/parse_results.php';
require __DIR__ . '/../libs/build_table.php';
$bm_name=$argv[1]??'orm';
$results = parse_results(__DIR__ . "/../output/results.$bm_name.log");

echo build_table($results);
