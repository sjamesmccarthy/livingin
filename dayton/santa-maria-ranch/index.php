<?php

$data = require __DIR__ . '/data.php';
$siblingNeighborhoods = array_values(array_filter(require __DIR__ . '/../neighborhoods.php', fn($n) => $n['slug'] !== $data['slug']));
$pageTitle = 'Santa Maria Ranch, Dayton NV Real Estate Guide | The McCarthy Group';
$pageDescription = "Explore Santa Maria Ranch, one of Dayton's priciest and most sought-after neighborhoods, known for larger lots and higher-end properties along the town's periphery, with The McCarthy Group at Dickson Realty.";
$canonicalPath = '/dayton/santa-maria-ranch';

require __DIR__ . '/../../includes/header.php';
require __DIR__ . '/../../includes/neighborhood-guide-template.php';
require __DIR__ . '/../../includes/footer.php';
