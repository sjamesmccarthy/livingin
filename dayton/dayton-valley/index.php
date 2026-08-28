<?php

$data = require __DIR__ . '/data.php';
$siblingNeighborhoods = array_values(array_filter(require __DIR__ . '/../neighborhoods.php', fn($n) => $n['slug'] !== $data['slug']));
$pageTitle = 'Dayton Valley (Country Club), Dayton NV Real Estate Guide | The McCarthy Group';
$pageDescription = "Explore Dayton Valley (Country Club), a golf-course community centered on the Arnold Palmer-designed Dayton Valley Golf & Country Club in central Dayton, with The McCarthy Group at Dickson Realty.";
$canonicalPath = '/dayton/dayton-valley';

require __DIR__ . '/../../includes/header.php';
require __DIR__ . '/../../includes/neighborhood-guide-template.php';
require __DIR__ . '/../../includes/footer.php';
