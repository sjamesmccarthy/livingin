<?php

$data = require __DIR__ . '/data.php';
$siblingNeighborhoods = array_values(array_filter(require __DIR__ . '/../neighborhoods.php', fn($n) => $n['slug'] !== $data['slug']));
$pageTitle = 'Riverpark, Dayton NV Real Estate Guide | The McCarthy Group';
$pageDescription = "Explore Riverpark, one of Dayton's more recently built-out, budget-friendly communities, often grouped with Dayton Valley and Santa Maria Ranch as one of the area's core neighborhoods, with The McCarthy Group at Dickson Realty.";
$canonicalPath = '/dayton/riverpark';

require __DIR__ . '/../../includes/header.php';
require __DIR__ . '/../../includes/neighborhood-guide-template.php';
require __DIR__ . '/../../includes/footer.php';
