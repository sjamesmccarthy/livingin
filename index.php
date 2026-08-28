<?php

$pageTitle = 'Northern Nevada City Guides | The McCarthy Group';
$pageDescription = 'James and Michele McCarthy of The McCarthy Group at Dickson Realty serve buyers and sellers across Northern Nevada. Pick a community for neighborhood-level pricing, lifestyle, and buying guidance.';
$canonicalPath = '/northern-nevada-city-guides';

require __DIR__ . '/includes/header.php';

$allCities = [
    ['name' => 'Reno', 'slug' => 'reno', 'img' => '/assets/images/city-guide-reno.jpg', 'teaser' => 'Walkable Midtown and Downtown residences, foothill communities like Somersett and Caughlin Ranch, and luxury estates in ArrowCreek and Montrêux.'],
    ['name' => 'Sparks', 'slug' => 'sparks', 'img' => '/assets/images/city-guide-sparks.jpg', 'teaser' => 'Older in-town neighborhoods, walkable Victorian Square, Sparks Marina living, and newer master-planned communities in Wingfield Springs and Spanish Springs.'],
    ['name' => 'Carson City', 'slug' => 'carson-city', 'img' => '/assets/images/city-guide-carson-city.jpg', 'teaser' => "Historic west-side homes, established neighborhoods, newer construction, and foothill properties with views or acreage in Nevada's capital city."],
    ['name' => 'Dayton', 'slug' => 'dayton', 'img' => '/assets/images/city-guide-dayton.jpg', 'teaser' => 'Golf-course living in Dayton Valley, master-planned Santa Maria Ranch, and established resale homes in Riverpark and Sutro along the US-50 corridor.'],
    ['name' => 'Minden', 'slug' => 'minden', 'img' => '/assets/images/city-guide-minden-gardnerville.jpg', 'teaser' => 'In-town homes near Main Street, newer subdivisions near Highway 395, and acreage or equestrian properties in the Carson Valley.'],
    ['name' => 'Gardnerville', 'slug' => 'gardnerville', 'img' => '/assets/images/city-guide-garnerville.jpg', 'teaser' => "The Carson Valley's commercial and agricultural anchor, with in-town homes, newer subdivisions, and acreage toward Ruhenstroth."],
    ['name' => 'Washoe Valley', 'slug' => 'washoe-valley', 'img' => '/assets/images/city-guide-washoe-valley.webp', 'teaser' => 'Custom homes, rural residences, luxury estates, and horse properties on larger acreage parcels along U.S. 395 between Reno and Carson City.'],
    ['name' => 'Incline Village', 'slug' => 'incline-village', 'img' => '/assets/images/city-guide-incline-village.jpg', 'teaser' => "Lake Tahoe's North Shore, combining private beaches, ski access, and luxury mountain and lakefront homes on the Nevada side of the lake."],
    ['name' => 'Spanish Springs', 'slug' => 'spanish-springs', 'img' => '/assets/images/city-guide-spanish-springs.jpg', 'teaser' => 'A fast-growing master-planned corridor northeast of Sparks, known for newer construction, larger lots, and family-friendly suburban living.'],
    ['name' => 'Verdi', 'slug' => 'verdi', 'img' => '/assets/images/city-guide-verdi.jpg', 'teaser' => "A small Truckee River community on Reno's western edge, offering a quieter, wooded setting close to the Sierra and the California state line."],
    ['name' => 'Fernley', 'slug' => 'fernley', 'img' => '/assets/images/city-guide-fernley.jpg', 'teaser' => 'An affordable, fast-growing Lyon County city along I-80, popular with buyers seeking newer construction and easy access to Reno-Sparks employment.'],
    ['name' => 'Yerington', 'slug' => 'yerington', 'img' => '/assets/images/city-guide-yerington.jpg', 'teaser' => "The Lyon County seat and Mason Valley's agricultural hub, offering small-town living, larger lots, and a lower cost of entry."],
    ['name' => 'Smith Valley', 'slug' => 'smith-valley', 'img' => '/assets/images/city-guide-smith-valley.jpg', 'teaser' => 'A rural, agricultural valley in Lyon County, known for ranch and acreage properties, open space, and a quiet, small-community lifestyle.'],
];
?>

<div class="header-band">
  <div class="container">
    <h1>Northern Nevada City Guides</h1>
    <p>James and Michele McCarthy of The McCarthy Group at Dickson Realty serve buyers and sellers across Northern Nevada. Pick a community below for neighborhood-level pricing, lifestyle, and buying guidance.</p>
  </div>
</div>

<div class="content-band">
  <div class="container">
    <div class="city-grid">
      <?php foreach ($allCities as $city): ?>
        <a class="city-card" href="<?= htmlspecialchars(city_guide_href($city['slug'])) ?>">
          <div class="thumb" style="background-image:url('<?= htmlspecialchars($city['img']) ?>');"></div>
          <div class="body">
            <h2><?= htmlspecialchars($city['name']) ?></h2>
            <p class="teaser"><?= htmlspecialchars($city['teaser']) ?></p>
            <p class="cta">View <?= htmlspecialchars($city['name']) ?> guide &rarr;</p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <p>Have a question that applies across the whole region? Visit our
      <a href="<?= htmlspecialchars(main_site_href('/resources')) ?>" style="text-decoration:underline;">Northern Nevada resources hub</a>
      for market timing, financing, and relocation guides.
    </p>

    <div class="contact-cta">
      <h2>Not sure which community fits you best?</h2>
      <p>Tell us what matters most &mdash; commute, schools, acreage, views, or walkability &mdash; and we'll point you toward the right Northern Nevada neighborhoods.</p>
      <a class="btn" href="<?= htmlspecialchars(main_site_href('/#contact')) ?>">Get in Touch</a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
