<?php

$data = require __DIR__ . '/data.php';
$siblingNeighborhoods = array_values(array_filter(require __DIR__ . '/../neighborhoods.php', fn($n) => $n['slug'] !== $data['slug']));
$pageTitle = 'Sutro Heights, Dayton NV Real Estate Guide | The McCarthy Group';
$pageDescription = "Explore Sutro Heights, a residential Dayton neighborhood popular for single-story homes and known as a more affordable, family-friendly pocket of town, with The McCarthy Group at Dickson Realty.";
$canonicalPath = '/dayton/sutro-heights';

require __DIR__ . '/../../includes/header.php';
require __DIR__ . '/../../includes/neighborhood-guide-template.php';
require __DIR__ . '/../../includes/footer.php';
