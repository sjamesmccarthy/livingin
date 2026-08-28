<?php

/**
 * Shared footer, ported from mccarthygrouprealty's components/PublicFooter.tsx.
 */

require_once __DIR__ . '/site-links.php';

$footerAgents = [
    ['name' => 'James McCarthy', 'phone' => '(775) 495-7061', 'email' => 'jmccarthy@dicksonrealty.com', 'license' => 'NV S.204824'],
    ['name' => 'Michele McCarthy', 'phone' => '(775) 622-6061', 'email' => 'mmccarthy@dicksonrealty.com', 'license' => 'NV BS.014763'],
];

/*
 * Lucide doesn't ship brand/social icons (Facebook, Instagram, TikTok) —
 * the source site uses MUI's own brand icon set for those. Use letter
 * badges here consistently instead of mixing icon sets.
 */
$footerSocial = [
    ['label' => 'Facebook', 'href' => 'https://facebook.com/REALTORsoldnevada', 'abbr' => 'FB'],
    ['label' => 'Instagram', 'href' => 'https://instagram.com/REALTORsoldnevada', 'abbr' => 'IG'],
    ['label' => 'Google', 'href' => 'https://g.page/r/CXaCAoeDUVXzEAI/review', 'abbr' => 'G'],
    ['label' => 'TikTok', 'href' => 'https://tiktok.com/@soldnevada', 'abbr' => 'TT'],
];

$footerNavColumns = [
    [
        'heading' => 'Explore',
        'links' => [
            ['label' => 'Home', 'href' => main_site_href('/')],
            ['label' => 'Meet the Team', 'href' => main_site_href('/about-mccarthy-group')],
            ['label' => 'Blog', 'href' => main_site_href('/blog')],
            ['label' => 'Reviews', 'href' => main_site_href('/reviews')],
            ['label' => 'Leave a Review', 'href' => main_site_href('/leave-a-review')],
        ],
    ],
    [
        'heading' => 'Buy & Sell',
        'links' => [
            ['label' => 'Why Buy With Us', 'href' => main_site_href('/buy-a-home-northern-nevada')],
            ['label' => 'Why List With Us', 'href' => main_site_href('/sell-my-home-northern-nevada')],
            ['label' => 'Finance', 'href' => main_site_href('/financing')],
        ],
    ],
    [
        'heading' => 'City Guides',
        'links' => [
            ['label' => 'Reno', 'href' => city_guide_href('reno')],
            ['label' => 'Sparks', 'href' => city_guide_href('sparks')],
            ['label' => 'Carson City', 'href' => city_guide_href('carson-city')],
            ['label' => 'Dayton', 'href' => city_guide_href('dayton')],
            ['label' => 'Minden', 'href' => city_guide_href('minden')],
            ['label' => 'Gardnerville', 'href' => city_guide_href('gardnerville')],
            ['label' => 'Washoe Valley', 'href' => city_guide_href('washoe-valley')],
            ['label' => 'Incline Village', 'href' => city_guide_href('incline-village')],
            ['label' => 'Spanish Springs', 'href' => city_guide_href('spanish-springs')],
            ['label' => 'Verdi', 'href' => city_guide_href('verdi')],
            ['label' => 'Fernley', 'href' => city_guide_href('fernley')],
            ['label' => 'Yerington', 'href' => city_guide_href('yerington')],
            ['label' => 'Smith Valley', 'href' => city_guide_href('smith-valley')],
        ],
    ],
    [
        'heading' => 'Resources',
        'links' => [
            ['label' => 'Buyer & Seller FAQs', 'href' => main_site_href('/resources')],
            ['label' => 'Buying a House in Nevada', 'href' => main_site_href('/resources/buying-a-house-in-nevada-step-by-step')],
            ['label' => 'Selling Your Home in Nevada', 'href' => main_site_href('/resources/selling-your-home-in-nevada')],
            ['label' => 'Moving from California to NV', 'href' => main_site_href('/resources/moving-from-california-to-northern-nevada')],
            ['label' => 'Living in Northern Nevada', 'href' => main_site_href('/resources/living-in-northern-nevada')],
            ['label' => 'Find a Realtor', 'href' => main_site_href('/find-a-realtor-northern-nevada')],
            ['label' => 'Financing', 'href' => main_site_href('/financing')],
            ['label' => 'Conventional Mortgage Calculator', 'href' => 'https://www.omglending.com/conventional-mortgage-calculator/'],
            ['label' => 'VA Mortgage Calculator', 'href' => 'https://www.omglending.com/va-mortgage-calculator/'],
            ['label' => 'FHA Mortgage Calculator', 'href' => 'https://www.omglending.com/fha-mortgage-calculator/'],
        ],
    ],
    [
        'heading' => 'Other Sites',
        'links' => [
            ['label' => 'LivingInNorthernNevada.com', 'href' => main_site_href('/northern-nevada-city-guides')],
            ['label' => 'LivingInRenoSparks.com', 'href' => city_guide_href('reno')],
            ['label' => 'LivingInCarsonCity.com', 'href' => city_guide_href('carson-city')],
            ['label' => 'LivingInMinden.com', 'href' => city_guide_href('minden')],
            ['label' => 'LivingInGardnerville.com', 'href' => city_guide_href('gardnerville')],
            ['label' => 'BestRealtorInRenoSparks.com', 'href' => main_site_href('/about-mccarthy-group')],
            ['label' => 'BestRealtorInCarsonCity.com', 'href' => main_site_href('/about-mccarthy-group')],
            ['label' => 'SellingNevadaRealEstate.com', 'href' => main_site_href('/sell-my-home-northern-nevada')],
            ['label' => 'SoldNevada.com', 'href' => main_site_href('/buy-a-home-northern-nevada')],
            ['label' => 'HomeValuesInCarsonCity.com', 'href' => city_guide_href('carson-city')],
            ['label' => 'HomeValuesInRenoSparks.com', 'href' => city_guide_href('reno')],
            ['label' => 'HomeValuesInMinden.com', 'href' => city_guide_href('minden')],
            ['label' => 'HomeValuesInGardnerville.com', 'href' => city_guide_href('gardnerville')],
        ],
    ],
];

function footer_is_external(string $href): bool
{
    return str_starts_with($href, 'http://') || str_starts_with($href, 'https://');
}

$footerYear = date('Y');
?>
<footer class="site-footer">
  <div class="container">

    <div class="footer-top">
      <div class="footer-brand">
        <img src="/assets/images/mccarthy-group-logo-2048-gold.jpg" alt="The McCarthy Group">
        <div>
          <p class="name">The McCarthy Group</p>
          <p class="brokerage">Dickson Realty</p>
          <p class="address">308 N Curry St Ste 202<br>Carson City, NV 89703</p>
          <a class="phone" href="tel:+17758826300">(775) 882-6300</a>
        </div>
      </div>

      <div class="footer-agents">
        <?php foreach ($footerAgents as $agent): ?>
          <div>
            <p class="agent-name"><?= htmlspecialchars($agent['name']) ?></p>
            <a href="tel:<?= htmlspecialchars(preg_replace('/[^\d+]/', '', $agent['phone'])) ?>"><?= htmlspecialchars($agent['phone']) ?></a>
            <a href="mailto:<?= htmlspecialchars($agent['email']) ?>"><?= htmlspecialchars($agent['email']) ?></a>
            <p class="license"><?= htmlspecialchars($agent['license']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="footer-social">
        <?php foreach ($footerSocial as $social): ?>
          <a href="<?= htmlspecialchars($social['href']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= htmlspecialchars($social['label']) ?>"><?= htmlspecialchars($social['abbr']) ?></a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="footer-columns">
      <?php foreach ($footerNavColumns as $col): ?>
        <div>
          <h3><?= htmlspecialchars($col['heading']) ?></h3>
          <ul>
            <?php foreach ($col['links'] as $link): $ext = footer_is_external($link['href']); ?>
              <li><a href="<?= htmlspecialchars($link['href']) ?>"<?= $ext ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= htmlspecialchars($link['label']) ?><?php if ($ext): ?> <svg class="icon-external-link" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6" /><path d="M10 14 21 3" /><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" /></svg><?php endif; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="footer-legal">
      <div>
        <p>Information deemed reliable but not guaranteed. Equal Housing Opportunity.</p>
        <p>Copyright <?= htmlspecialchars($footerYear) ?> The McCarthy Group LLC at Dickson Realty. All rights reserved. <a href="<?= htmlspecialchars(main_site_href('/privacy')) ?>">Privacy Policy</a> | <a href="<?= htmlspecialchars(main_site_href('/terms')) ?>">Terms</a></p>
        <p class="powered-by">powered by <a href="https://leadlattecrm.com" target="_blank" rel="noopener noreferrer">Lead <svg class="icon-sprout" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 20h10" /><path d="M10 20c5.5-2.5.8-6.4 3-10" /><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z" /><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z" /></svg> Latte</a></p>
      </div>
      <div class="footer-mls">
        <img src="/assets/images/relator-mls-logo.png" alt="Realtor and MLS logos">
      </div>
    </div>

  </div>
</footer>
</body>
</html>
