<?php

/**
 * Ported from mccarthygrouprealty's components/sections/NeighborhoodGuideTemplate.tsx.
 * Expects $data and $siblingNeighborhoods to be set before requiring this file.
 * $data shape: title, slug, citySlug, cityName, intro, mapQ, agentEncodedId, sections[], faqs[]
 * $siblingNeighborhoods shape: [['name' => ..., 'slug' => ...], ...]
 */

if (!function_exists('slugify_heading')) {
    function slugify_heading(string $heading): string
    {
        $slug = strtolower($heading);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-');
    }
}

$navItems = array_map(fn($s) => ['id' => slugify_heading($s['heading']), 'label' => $s['heading']], $data['sections']);
if (!empty($siblingNeighborhoods)) {
    $navItems[] = ['id' => 'other-neighborhoods', 'label' => 'Other Neighborhoods in ' . $data['cityName']];
}
if (!empty($data['faqs'])) {
    $navItems[] = ['id' => 'faqs', 'label' => 'Frequently Asked Questions'];
}
?>

<div class="header-band">
  <div class="container">
    <p class="back-to-city-link"><a href="<?= htmlspecialchars(city_guide_href($data['citySlug'])) ?>"><?= htmlspecialchars($data['cityName']) ?> Real Estate</a></p>
    <h1><?= htmlspecialchars($data['title']) ?></h1>
    <p><?= htmlspecialchars($data['intro']) ?></p>
  </div>
</div>

<iframe
  class="map-embed"
  title="Map of <?= htmlspecialchars($data['title']) ?>"
  loading="lazy"
  allowfullscreen
  referrerpolicy="no-referrer-when-downgrade"
  src="https://www.google.com/maps/embed/v1/search?key=<?= urlencode(GOOGLE_MAPS_KEY) ?>&q=<?= $data['mapQ'] ?>&zoom=13"
></iframe>

<div class="search-band">
  <div class="container">
    <h2>Search Nearby Listings</h2>
    <div style="display:flex; justify-content:center; width:100%;">
      <realscout-simple-search agent-encoded-id="<?= htmlspecialchars($data['agentEncodedId']) ?>"></realscout-simple-search>
    </div>
  </div>
</div>

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
                <?php foreach ($section['links'] as $link): ?>
                  <li>
                    <a href="<?= htmlspecialchars($link['href']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($link['label']) ?></a><?= !empty($link['description']) ? ' &mdash; ' . htmlspecialchars($link['description']) : '' ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

        <?php if (!empty($siblingNeighborhoods)): ?>
          <div id="other-neighborhoods" class="guide-section">
            <h2>Other Neighborhoods in <?= htmlspecialchars($data['cityName']) ?></h2>
            <p>The McCarthy Group also covers these <?= htmlspecialchars($data['cityName']) ?> neighborhoods:</p>
            <ul style="display:flex; flex-wrap:wrap; gap:0 1.5rem;">
              <?php foreach ($siblingNeighborhoods as $n): ?>
                <li><a href="<?= htmlspecialchars(city_guide_href($data['citySlug'], $n['slug'])) ?>" style="text-decoration:underline;"><?= htmlspecialchars($n['name']) ?></a></li>
              <?php endforeach; ?>
            </ul>
            <p><a href="<?= htmlspecialchars(city_guide_href($data['citySlug'])) ?>" style="text-decoration:underline;">See the full <?= htmlspecialchars($data['cityName']) ?> real estate guide</a></p>
          </div>
        <?php endif; ?>

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
            <p>Have a question about <?= htmlspecialchars($data['title']) ?> that isn't covered here?
              <a href="<?= htmlspecialchars(main_site_href('/#hero-search')) ?>">Search current listings</a> or
              <a href="<?= htmlspecialchars(main_site_href('/#home-valuation')) ?>">get a home valuation</a> to talk with The McCarthy Group directly.
            </p>
          </div>
        <?php endif; ?>

        <div class="contact-cta">
          <h2>Ready to Explore <?= htmlspecialchars($data['title']) ?>?</h2>
          <p>Let's talk about what you're looking for in <?= htmlspecialchars($data['title']) ?> and the surrounding area. No pressure &mdash; just a practical, honest conversation about what's possible.</p>
          <a class="btn" href="<?= htmlspecialchars(main_site_href('/#contact')) ?>">Get in Touch</a>
        </div>

      </div>

      <div class="content-sidebar">
        <div class="sidebar-sticky">
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
        ['@type' => 'ListItem', 'position' => 2, 'name' => $data['cityName'], 'item' => SITE_URL . '/' . $data['citySlug']],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $data['title'], 'item' => SITE_URL . '/' . $data['citySlug'] . '/' . $data['slug']],
    ],
], JSON_UNESCAPED_SLASHES) ?>
</script>

<script src="https://em.realscout.com/widgets/realscout-web-components.umd.js" type="module"></script>
