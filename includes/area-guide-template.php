<?php

/**
 * Ported from mccarthygrouprealty's components/sections/AreaGuideTemplate.tsx.
 * Expects $data (see /carsoncity/data.php for the shape) to be set before requiring this file.
 */

function slugify_heading(string $heading): string
{
    $slug = strtolower($heading);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

$cityName = $data['title'];
$suffix = ', Nevada Real Estate Guide';
if (str_ends_with($cityName, $suffix)) {
    $cityName = substr($cityName, 0, -strlen($suffix));
}

$allAreas = require __DIR__ . '/cities.php';
$nearbyAreas = array_values(array_filter($allAreas, fn($a) => $a['slug'] !== $data['slug']));

$navItems = array_map(fn($s) => ['id' => slugify_heading($s['heading']), 'label' => $s['heading']], $data['sections']);
$navItems[] = ['id' => 'nearby-areas', 'label' => 'Nearby Areas'];
if (!empty($data['faqs'])) {
    $navItems[] = ['id' => 'faqs', 'label' => 'Frequently Asked Questions'];
}
?>

<div class="header-band">
  <div class="container">
    <h1><?= htmlspecialchars($cityName) ?><br>Nevada Real Estate Guide</h1>
    <p><?= htmlspecialchars($data['intro']) ?></p>
  </div>
</div>

<iframe
  class="map-embed"
  title="Map of <?= htmlspecialchars($data['title']) ?>"
  loading="lazy"
  allowfullscreen
  referrerpolicy="no-referrer-when-downgrade"
  src="https://www.google.com/maps/embed/v1/search?key=<?= urlencode(GOOGLE_MAPS_KEY) ?>&q=<?= $data['mapQ'] ?>&zoom=11"
></iframe>

<div class="search-band">
  <div class="container">
    <h2>Search Nearby Listings</h2>
    <div style="display:flex; justify-content:center; width:100%;">
      <realscout-simple-search agent-encoded-id="<?= htmlspecialchars($data['agentEncodedId']) ?>"></realscout-simple-search>
    </div>
  </div>
</div>

<?php if (!empty($data['stats'])): $stats = $data['stats']; ?>
<div class="stats-strip">
  <div class="container">
    <div class="stats-row">
      <div class="stats-city">
        <div class="bar"></div>
        <div>
          <?php if (!empty($stats['state'])): ?>
            <p class="state"><?= htmlspecialchars($stats['state']) ?></p>
          <?php endif; ?>
          <h2><?= htmlspecialchars($cityName) ?></h2>
        </div>
      </div>
      <div class="stats-figures">
        <?php if (!empty($stats['averageSalesPrice'])): ?>
          <div>
            <p class="label">Average Sales Price</p>
            <p class="value"><?= htmlspecialchars($stats['averageSalesPrice']) ?></p>
          </div>
        <?php endif; ?>
        <?php if (!empty($stats['medianSalesPrice'])): ?>
          <div>
            <p class="label">Median Sales Price</p>
            <p class="value"><?= htmlspecialchars($stats['medianSalesPrice']) ?></p>
          </div>
        <?php endif; ?>
        <?php if (!empty($stats['population'])): ?>
          <div>
            <p class="label">Population</p>
            <p class="value"><?= htmlspecialchars($stats['population']) ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="content-band">
  <div class="container">
    <div class="content-layout">
      <div class="content-main">

        <?php foreach ($data['sections'] as $section): ?>
          <div id="<?= slugify_heading($section['heading']) ?>" class="guide-section">
            <h2><?= htmlspecialchars($section['heading']) ?></h2>
            <?php foreach ($section['paragraphs'] as $p): ?>
              <p><?= htmlspecialchars($p) ?></p>
            <?php endforeach; ?>
            <?php if (!empty($section['links'])): ?>
              <ul>
                <?php foreach ($section['links'] as $link): $external = !str_starts_with($link['href'], '/'); ?>
                  <li>
                    <a href="<?= htmlspecialchars($link['href']) ?>"<?= $external ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= htmlspecialchars($link['label']) ?></a><?= !empty($link['description']) ? ' &mdash; ' . htmlspecialchars($link['description']) : '' ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

        <div id="nearby-areas" class="guide-section">
          <h2>Nearby Areas</h2>
          <p>The McCarthy Group also serves these nearby Northern Nevada communities:</p>
          <ul style="display:flex; flex-wrap:wrap; gap:0 1.5rem;">
            <?php foreach ($nearbyAreas as $area): ?>
              <li><a href="<?= htmlspecialchars(city_guide_href($area['slug'])) ?>" style="text-decoration:underline;"><?= htmlspecialchars($area['name']) ?> Real Estate</a></li>
            <?php endforeach; ?>
          </ul>
          <p><a href="<?= htmlspecialchars(hub_href()) ?>" style="text-decoration:underline;">See all Northern Nevada city guides</a></p>
        </div>

        <?php if (!empty($data['faqs'])): ?>
          <div id="faqs" class="guide-section">
            <h2>Frequently Asked Questions</h2>
            <?php foreach ($data['faqs'] as $faq): ?>
              <div class="faq-item">
                <h3><?= htmlspecialchars($faq['question']) ?></h3>
                <p>
                  <?= htmlspecialchars($faq['answer']) ?>
                  <?php if (!empty($faq['linkHref'])): $ext = str_starts_with($faq['linkHref'], 'http'); ?>
                    <a href="<?= htmlspecialchars($faq['linkHref']) ?>"<?= $ext ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= htmlspecialchars($faq['linkText'] ?? $faq['linkHref']) ?></a>
                  <?php endif; ?>
                </p>
              </div>
            <?php endforeach; ?>
            <p>Have a question about <?= htmlspecialchars($cityName) ?> that isn't covered here?
              <a href="<?= htmlspecialchars(main_site_href('/#hero-search')) ?>">Search current listings</a> or
              <a href="<?= htmlspecialchars(main_site_href('/#home-valuation')) ?>">get a home valuation</a> to talk with The McCarthy Group directly.
            </p>
          </div>
        <?php endif; ?>

        <div class="contact-cta">
          <h2>Ready to Explore <?= htmlspecialchars($cityName) ?>?</h2>
          <p>Let's talk about what you're looking for in <?= htmlspecialchars($cityName) ?> and the surrounding area. No pressure &mdash; just a practical, honest conversation about what's possible.</p>
          <a class="btn" href="<?= htmlspecialchars(main_site_href('/#contact')) ?>">Get in Touch</a>
        </div>

      </div>

      <div class="content-sidebar">
        <div class="sidebar-sticky">
          <a href="#" id="rpr-report-areaguide" class="report-download">
            <svg class="icon-file-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
              <path d="M14 2v4a2 2 0 0 0 2 2h4" />
              <path d="M12 18v-6" />
              <path d="m9 15 3 3 3-3" />
            </svg>
            <span>Download<br>Market Report</span>
          </a>

          <span class="on-this-page-label">On This Page</span>
          <div class="on-this-page">
            <nav>
              <?php foreach ($navItems as $item): ?>
                <a href="#<?= $item['id'] ?>"><?= htmlspecialchars($item['label']) ?></a>
              <?php endforeach; ?>
            </nav>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php if (!empty($data['faqs'])): ?>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(fn($faq) => [
        '@type' => 'Question',
        'name' => $faq['question'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => isset($faq['linkHref']) ? $faq['answer'] . ' ' . $faq['linkHref'] : $faq['answer'],
        ],
    ], $data['faqs']),
], JSON_UNESCAPED_SLASHES) ?>
</script>
<?php endif; ?>

<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => SITE_URL . '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $cityName, 'item' => SITE_URL . '/' . $data['slug']],
    ],
], JSON_UNESCAPED_SLASHES) ?>
</script>

<script>
(function () {
  if (document.querySelector('script[src*="rpr-reports-embed.js"]')) return;
  var script = document.createElement('script');
  script.src = 'https://pub-6607a59d1d3b4ed18490937c995526d1.r2.dev/rpr-reports-embed.js';
  script.setAttribute('data-reports', <?= json_encode(json_encode([
      ['label' => 'Carson City', 'url' => 'https://www.narrpr.com/reports-v2/0e28e91c-03b3-4d03-af56-fde10f1327b6/pdf'],
      ['label' => 'Minden', 'url' => 'https://www.narrpr.com/properties/search?scid=283639700'],
      ['label' => 'Gardnerville', 'url' => 'https://www.narrpr.com/reports-v2/1b7b30dc-3a83-43d9-a802-8e2db460ffc3/pdf'],
      ['label' => 'Dayton', 'url' => 'https://www.narrpr.com/reports-v2/4d74147e-fbf6-470e-be9a-5ec7e6beb140/pdf'],
      ['label' => 'Reno', 'url' => 'https://www.narrpr.com/reports-v2/d2db3b98-8f82-44fd-8789-4edb425b86f3/pdf'],
      ['label' => 'Sparks', 'url' => 'https://www.narrpr.com/reports-v2/8814bf29-a2a7-4cfa-8044-fd7a3349bfe4/pdf'],
  ])) ?>);
  script.setAttribute('data-proxy', 'https://rpr-lead-proxy.reggie-c50.workers.dev/agt_XdDS5l7nDPYAT5yH');
  script.setAttribute('data-form-mode', 'full');
  script.setAttribute('data-agent-name', 'McCarthy Group');
  script.setAttribute('data-brokerage', 'Dickson Realty');
  script.setAttribute('data-logo-url', 'https://mccarthygrouprealty.com/mccarthy-group-logo-2048-gold.jpg');
  script.setAttribute('data-color-brand', '#16476a');
  script.setAttribute('data-headline', "What's happening in your neighborhood?");
  script.setAttribute('data-subheadline', 'Select your area and get a free local market report.');
  script.setAttribute('data-display-mode', 'modal');
  script.setAttribute('data-modal-trigger', '#rpr-report-areaguide');
  document.body.appendChild(script);

  document.getElementById('rpr-report-areaguide').addEventListener('click', function (e) {
    e.preventDefault();
    var overlay = document.querySelector('.rpr-r-overlay');
    if (overlay) overlay.classList.add('open');
  });
})();
</script>

<script src="https://em.realscout.com/widgets/realscout-web-components.umd.js" type="module"></script>
