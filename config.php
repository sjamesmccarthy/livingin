<?php

define('GOOGLE_MAPS_KEY', getenv('GOOGLE_MAPS_KEY') ?: 'AIzaSyASLw97pVdtt25GHtSBmVwwRdbrzsF-_y0');
define('SITE_URL', 'http://127.0.0.1:8001');
define('AGENT_ENCODED_ID', 'QWdlbnQtMjgwNDEw');
define('MAIN_SITE_URL', 'https://mccarthygrouprealty.com');

// City slugs whose pages live in this repo; header/footer links to them stay
// root-relative instead of resolving to their own domain.
$localCitySlugs = ['dayton', 'washoe-valley', 'incline-village', 'spanish-springs', 'verdi', 'fernley', 'yerington', 'smith-valley'];
