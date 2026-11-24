<?php

/**
 * Shared header, ported from mccarthygrouprealty's components/Header.tsx.
 * Expects the including page to have set:
 *   $pageTitle, $pageDescription, $canonicalPath (e.g. "/carson-city")
 * before requiring this file.
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/site-links.php';

$cityGuideGroups = [
    [
        'city' => 'Reno', 'cityHref' => city_guide_href('reno'),
        'neighborhoods' => [
            ['label' => 'ArrowCreek', 'href' => city_guide_href('reno', 'arrowcreek')],
            ['label' => 'Caughlin Ranch', 'href' => city_guide_href('reno', 'caughlin-ranch')],
            ['label' => 'Damonte Ranch', 'href' => city_guide_href('reno', 'damonte-ranch')],
            ['label' => 'Galena', 'href' => city_guide_href('reno', 'galena')],
            ['label' => 'Lakeridge Shores', 'href' => city_guide_href('reno', 'lakeridge-shores')],
            ['label' => 'Midtown Reno', 'href' => city_guide_href('reno', 'midtown')],
            ['label' => 'Montreux', 'href' => city_guide_href('reno', 'montreux')],
            ['label' => 'Northwest Reno', 'href' => city_guide_href('reno', 'northwest-reno')],
            ['label' => 'Saddlehorn', 'href' => city_guide_href('reno', 'saddlehorn')],
            ['label' => 'South Meadows', 'href' => city_guide_href('reno', 'south-meadows')],
            ['label' => 'St. James Village', 'href' => city_guide_href('reno', 'st-james-village')],
        ],
    ],
    [
        'city' => 'Sparks', 'cityHref' => city_guide_href('sparks'),
        'neighborhoods' => [
            ['label' => 'Spanish Springs', 'href' => city_guide_href('sparks', 'spanish-springs')],
            ['label' => 'Wingfield Springs', 'href' => city_guide_href('sparks', 'wingfield-springs')],
            ['label' => 'Kiley Ranch', 'href' => city_guide_href('sparks', 'kiley-ranch')],
            ['label' => 'Sparks Marina', 'href' => city_guide_href('sparks', 'sparks-marina')],
            ['label' => 'Del Webb Sierra Canyon', 'href' => city_guide_href('sparks', 'del-webb-sierra-canyon')],
            ['label' => 'Sky Ranch', 'href' => city_guide_href('sparks', 'sky-ranch')],
            ['label' => 'Sparks Galleria', 'href' => city_guide_href('sparks', 'sparks-galleria')],
            ['label' => 'Greenbrae Terrace', 'href' => city_guide_href('sparks', 'greenbrae-terrace')],
            ['label' => 'Vista', 'href' => city_guide_href('sparks', 'vista')],
        ],
    ],
    [
        'city' => 'Carson City', 'cityHref' => city_guide_href('carson-city'),
        'neighborhoods' => [
            ['label' => 'Lakeview', 'href' => city_guide_href('carson-city', 'lakeview')],
            ['label' => 'West Side', 'href' => city_guide_href('carson-city', 'west-side')],
            ['label' => 'Silver Oak', 'href' => city_guide_href('carson-city', 'silver-oak')],
            ['label' => 'Riverview', 'href' => city_guide_href('carson-city', 'riverview')],
            ['label' => 'Kings Canyon', 'href' => city_guide_href('carson-city', 'kings-canyon')],
            ['label' => 'Empire Ranch / New Empire', 'href' => city_guide_href('carson-city', 'empire-ranch')],
            ['label' => 'Eagle Station at Schulz Ranch', 'href' => city_guide_href('carson-city', 'eagle-station-at-schulz-ranch')],
            ['label' => 'Stewart', 'href' => city_guide_href('carson-city', 'stewart')],
            ['label' => 'Colorado St', 'href' => city_guide_href('carson-city', 'colorado-st')],
            ['label' => 'C-Hill / North Carson / Downtown', 'href' => city_guide_href('carson-city', 'downtown')],
        ],
    ],
    [
        'city' => 'Dayton', 'cityHref' => city_guide_href('dayton'),
        'neighborhoods' => [
            ['label' => 'Dayton Valley (Country Club)', 'href' => city_guide_href('dayton', 'dayton-valley')],
            ['label' => 'Santa Maria Ranch', 'href' => city_guide_href('dayton', 'santa-maria-ranch')],
            ['label' => 'New Empire', 'href' => city_guide_href('dayton', 'new-empire')],
            ['label' => 'Sutro Heights', 'href' => city_guide_href('dayton', 'sutro-heights')],
            ['label' => 'Riverpark', 'href' => city_guide_href('dayton', 'riverpark')],
        ],
    ],
];

$otherCityGuideLinks = [
    ['label' => 'Minden', 'href' => city_guide_href('minden')],
    ['label' => 'Gardnerville', 'href' => city_guide_href('gardnerville')],
    ['label' => 'Washoe Valley', 'href' => city_guide_href('washoe-valley')],
    ['label' => 'Incline Village', 'href' => city_guide_href('incline-village')],
    ['label' => 'Spanish Springs', 'href' => city_guide_href('spanish-springs')],
    ['label' => 'Verdi', 'href' => city_guide_href('verdi')],
    ['label' => 'Fernley', 'href' => city_guide_href('fernley')],
    ['label' => 'Yerington', 'href' => city_guide_href('yerington')],
    ['label' => 'Smith Valley', 'href' => city_guide_href('smith-valley')],
];

$teamMembers = [
    ['name' => 'James McCarthy', 'href' => main_site_href('/james-mccarthy'), 'image' => main_site_href('/bio-james.jpg'), 'phone' => '(775) 495-7061', 'email' => 'jmccarthy@dicksonrealty.com'],
    ['name' => 'Michele McCarthy', 'href' => main_site_href('/michele-mccarthy'), 'image' => main_site_href('/bio-michele.jpg'), 'phone' => '(775) 622-6061', 'email' => 'mmccarthy@dicksonrealty.com'],
];

$pageTitle = $pageTitle ?? 'Northern Nevada City Guides | McCarthy Group';
$pageDescription = $pageDescription ?? 'Explore Northern Nevada city guides with McCarthy Group at Dickson Realty.';
$canonicalPath = $canonicalPath ?? '/';

header('Link: </sitemap.xml>; rel="sitemap", </llms.txt>; rel="describedby"; type="text/plain"', false);
header('Vary: Accept', false);
require_once __DIR__ . '/agent-tools.php';

$orgId = 'https://mccarthygrouprealty.com/#agent';
$jsonLd = [
    [
        '@context' => 'https://schema.org',
        '@type' => ['RealEstateAgent', 'LocalBusiness'],
        '@id' => $orgId,
        'name' => 'James & Michele McCarthy | McCarthy Group',
        'url' => 'https://mccarthygrouprealty.com',
        'telephone' => '+1-775-391-0565',
        'email' => 'mccarthygroup@mccarthygrouprealty.com',
        'image' => 'https://mccarthygrouprealty.com/mccarthy-group-logo-2048-gold.jpg',
        'logo' => 'https://mccarthygrouprealty.com/mccarthy-group-logo-2048-gold.jpg',
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => '308 N Curry St Ste 202', 'addressLocality' => 'Carson City', 'addressRegion' => 'NV', 'postalCode' => '89703', 'addressCountry' => 'US'],
        'parentOrganization' => ['@type' => 'Organization', 'name' => 'Dickson Realty'],
        'sameAs' => [
            'https://facebook.com/REALTORsoldnevada',
            'https://instagram.com/REALTORsoldnevada',
            'https://tiktok.com/@soldnevada',
            'https://youtube.com/@soldnevada',
            'https://x.com/SoldNevada',
            'https://mccarthygrouprealty.com',
        ],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => SITE_URL . '/#website',
        'name' => 'Living in Northern Nevada | McCarthy Group',
        'url' => SITE_URL,
        'publisher' => ['@id' => $orgId],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => SITE_URL . $canonicalPath . '#webpage',
        'url' => SITE_URL . $canonicalPath,
        'name' => $pageTitle,
        'description' => $pageDescription,
        'isPartOf' => ['@id' => SITE_URL . '/#website'],
        'about' => ['@id' => $orgId],
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
<link rel="canonical" href="<?= htmlspecialchars(SITE_URL . $canonicalPath) ?>">
<meta name="robots" content="index, follow">
<link rel="icon" href="<?= htmlspecialchars(main_site_href('/favicon.ico')) ?>">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="alternate" type="text/markdown" href="<?= htmlspecialchars(SITE_URL . $canonicalPath) ?>" title="Markdown (send Accept: text/markdown)">
<?php foreach ($jsonLd as $node): ?>
<script type="application/ld+json"><?= json_encode($node, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<?php endforeach; ?>
<script>
(function () {
  var mc = navigator.modelContext;
  if (!mc || !mc.registerTool) return;
  var contact = <?= json_encode(agent_contact_info(), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
  var guides = <?= json_encode(agent_city_guides(), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?>;
  function res(v) { return { content: [{ type: 'text', text: JSON.stringify(v) }] }; }
  try {
    mc.registerTool({ name: 'get_contact_info', description: 'Get McCarthy Group phone, email and office address.', inputSchema: { type: 'object', properties: {} }, execute: function () { return Promise.resolve(res(contact)); } });
    mc.registerTool({ name: 'list_city_guides', description: 'List Northern Nevada city guides with URLs.', inputSchema: { type: 'object', properties: {} }, execute: function () { return Promise.resolve(res({ guides: guides })); } });
    mc.registerTool({ name: 'open_city_guide', description: 'Navigate to a Northern Nevada city guide.', inputSchema: { type: 'object', properties: { slug: { type: 'string', enum: guides.map(function (g) { return g.slug; }) } }, required: ['slug'] }, execute: function (a) {
      var g = guides.filter(function (x) { return x.slug === (a && a.slug); })[0];
      if (!g) return Promise.resolve(res({ error: 'Unknown guide' }));
      window.location.assign(g.url); return Promise.resolve(res({ navigating: g.url }));
    } });
  } catch (e) {}
})();
</script>
</head>
<body>
<header class="site-header" id="site-header">
  <div class="container">
    <div class="logos">
      <a class="brand" href="<?= htmlspecialchars(main_site_href('/')) ?>">
        <img class="mccarthy-logo" src="/assets/images/mccarthy-group-logo-2048-gold.jpg" alt="McCarthy Group">
        <span class="brand-name">McCarthy Group</span>
      </a>
      <div class="divider"></div>
      <a href="<?= htmlspecialchars(main_site_href('/')) ?>">
        <img class="dickson-logo" src="/assets/images/dickson_logo.webp" alt="Dickson Realty">
      </a>
    </div>

    <nav class="site-nav">
      <a href="<?= htmlspecialchars(main_site_href('/buy-a-home-northern-nevada')) ?>">Buy With Us</a>
      <a href="<?= htmlspecialchars(main_site_href('/sell-my-home-northern-nevada')) ?>">List With Us</a>

      <div class="nav-dropdown">
        <span class="nav-dropdown-trigger">
          <a href="<?= htmlspecialchars(main_site_href('/about-mccarthy-group')) ?>">Meet The Team</a><button type="button" class="caret-toggle" aria-label="Toggle Meet The Team menu" aria-expanded="false" onclick="this.closest('.nav-dropdown').classList.toggle('open'); this.setAttribute('aria-expanded', this.closest('.nav-dropdown').classList.contains('open'));"><svg class="caret" viewBox="0 0 24 24" aria-hidden="true"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"></path></svg></button>
        </span>
        <div class="team-megamenu">
          <div class="container">
            <div class="team-grid">
              <?php foreach ($teamMembers as $member): ?>
                <a class="team-card" href="<?= htmlspecialchars($member['href']) ?>">
                  <img src="<?= htmlspecialchars($member['image']) ?>" alt="<?= htmlspecialchars($member['name']) ?>">
                  <div>
                    <p class="name"><?= htmlspecialchars($member['name']) ?></p>
                    <div class="contact"><?= htmlspecialchars($member['phone']) ?><br><?= htmlspecialchars($member['email']) ?></div>
                    <div class="view-profile">View Profile</div>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-dropdown">
        <span class="nav-dropdown-trigger">
          <a href="<?= htmlspecialchars(hub_href()) ?>">City Guides</a><button type="button" class="caret-toggle" aria-label="Toggle City Guides menu" aria-expanded="false" onclick="this.closest('.nav-dropdown').classList.toggle('open'); this.setAttribute('aria-expanded', this.closest('.nav-dropdown').classList.contains('open'));"><svg class="caret" viewBox="0 0 24 24" aria-hidden="true"><path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6z"></path></svg></button>
        </span>
        <div class="nav-megamenu">
          <div class="container megamenu-container">
            <div class="nav-megamenu-grid city-guides-grid">
              <?php foreach ($cityGuideGroups as $group): ?>
                <div class="nav-megamenu-col">
                  <a class="col-heading" href="<?= htmlspecialchars($group['cityHref']) ?>"><?= htmlspecialchars($group['city']) ?></a>
                  <div class="nav-megamenu-links">
                    <?php foreach ($group['neighborhoods'] as $n): ?>
                      <a href="<?= htmlspecialchars($n['href']) ?>"><?= htmlspecialchars($n['label']) ?></a>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="nav-megamenu-col">
                <span class="col-heading">Other Areas</span>
                <div class="nav-megamenu-links">
                  <?php foreach ($otherCityGuideLinks as $item): ?>
                    <a href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <a href="<?= htmlspecialchars(main_site_href('/#home-valuation')) ?>">Home Valuation</a>
      <a href="<?= htmlspecialchars(main_site_href('/blog')) ?>">Blog</a>
      <a href="<?= htmlspecialchars(main_site_href('/reviews')) ?>">Reviews</a>
      <a href="<?= htmlspecialchars(main_site_href('/financing')) ?>">Finance</a>
    </nav>

    <button type="button" class="mobile-menu-toggle" aria-label="Open navigation menu" onclick="document.getElementById('mobile-menu').classList.add('open')">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 18h18v-2H3zm0-5h18v-2H3zm0-7v2h18V6z"></path></svg>
    </button>
  </div>
</header>

<div id="mobile-menu" class="mobile-menu">
  <div class="mobile-menu-close">
    <button type="button" aria-label="Close navigation menu" onclick="document.getElementById('mobile-menu').classList.remove('open')"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 7.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg></button>
  </div>
  <a href="<?= htmlspecialchars(main_site_href('/buy-a-home-northern-nevada')) ?>">Buy With Us</a>
  <a href="<?= htmlspecialchars(main_site_href('/sell-my-home-northern-nevada')) ?>">List With Us</a>
  <a href="<?= htmlspecialchars(main_site_href('/about-mccarthy-group')) ?>">Meet The Team</a>
  <?php foreach ($teamMembers as $member): ?>
    <a href="<?= htmlspecialchars($member['href']) ?>" style="padding-left:2.25rem; font-size:0.9rem;"><?= htmlspecialchars($member['name']) ?></a>
  <?php endforeach; ?>

  <a href="<?= htmlspecialchars(hub_href()) ?>" class="mobile-menu-label">City Guides</a>
  <?php foreach ($cityGuideGroups as $group): ?>
    <div class="mobile-city"><a href="<?= htmlspecialchars($group['cityHref']) ?>"><?= htmlspecialchars($group['city']) ?></a></div>
    <?php foreach ($group['neighborhoods'] as $n): ?>
      <div class="mobile-neighborhood"><a href="<?= htmlspecialchars($n['href']) ?>"><?= htmlspecialchars($n['label']) ?></a></div>
    <?php endforeach; ?>
  <?php endforeach; ?>
  <?php foreach ($otherCityGuideLinks as $item): ?>
    <div class="mobile-city"><a href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a></div>
  <?php endforeach; ?>

  <a href="<?= htmlspecialchars(main_site_href('/#home-valuation')) ?>">Home Valuation</a>
  <a href="<?= htmlspecialchars(main_site_href('/blog')) ?>">Blog</a>
  <a href="<?= htmlspecialchars(main_site_href('/reviews')) ?>">Reviews</a>
  <a href="<?= htmlspecialchars(main_site_href('/financing')) ?>">Finance</a>
</div>

<script>
(function () {
  function closeAllDropdowns(except) {
    document.querySelectorAll('.nav-dropdown.open').forEach(function (dropdown) {
      if (dropdown === except) return;
      dropdown.classList.remove('open');
      var toggle = dropdown.querySelector('.caret-toggle');
      if (toggle) toggle.setAttribute('aria-expanded', 'false');
    });
  }

  document.addEventListener('click', function (e) {
    var openDropdown = e.target.closest('.nav-dropdown.open');
    var clickedToggle = e.target.closest('.caret-toggle');
    if (clickedToggle) {
      closeAllDropdowns(clickedToggle.closest('.nav-dropdown'));
      return;
    }
    if (!openDropdown) closeAllDropdowns();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeAllDropdowns();
  });
})();
</script>

