<?php

/**
 * Cross-repo link helpers shared by header.php and footer.php.
 *
 * Each repo's config.php defines $localCitySlugs: the city slugs whose pages
 * actually live in THIS repo, so links to them stay root-relative. Every
 * other city slug resolves to its own domain (falling back to
 * mccarthygrouprealty.com for cities that don't have one yet). Non-city
 * McCarthy Group pages always resolve to the absolute MAIN_SITE_URL.
 */

$cityDomains = [
    'reno' => 'https://livinginrenosparks.com',
    'sparks' => 'https://livinginrenosparks.com',
    'carson-city' => 'https://livingincarsoncity.com',
    'minden' => 'https://livinginminden.com',
    'gardnerville' => 'https://livingingardnerville.com',
];

function main_site_href(string $path): string
{
    return rtrim(MAIN_SITE_URL, '/') . $path;
}

function city_guide_href(string $citySlug, ?string $neighborhoodSlug = null): string
{
    global $cityDomains, $localCitySlugs;

    $path = '/' . $citySlug . ($neighborhoodSlug ? '/' . $neighborhoodSlug : '');

    if (in_array($citySlug, $localCitySlugs ?? [], true)) {
        return $path;
    }

    $domain = $cityDomains[$citySlug] ?? rtrim(MAIN_SITE_URL, '/');
    return rtrim($domain, '/') . $path;
}
