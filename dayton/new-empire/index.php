<?php

$data = require __DIR__ . '/data.php';
$siblingNeighborhoods = array_values(array_filter(require __DIR__ . '/../neighborhoods.php', fn($n) => $n['slug'] !== $data['slug']));
$pageTitle = 'New Empire, Dayton NV Real Estate Guide | The McCarthy Group';
$pageDescription = "Explore New Empire, an established Dayton neighborhood bridging the Carson City area near Empire Ranch Golf Course, with mostly single-family detached homes, with The McCarthy Group at Dickson Realty.";
$canonicalPath = '/dayton/new-empire';

require __DIR__ . '/../../includes/header.php';
require __DIR__ . '/../../includes/neighborhood-guide-template.php';
require __DIR__ . '/../../includes/footer.php';
