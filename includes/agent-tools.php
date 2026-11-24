<?php

/**
 * Read-only agent tools shared by WebMCP (header.php) and the MCP endpoint (mcp.php).
 */

function agent_contact_info(): array
{
    return [
        'name' => 'McCarthy Group at Dickson Realty',
        'agents' => ['James McCarthy', 'Michele McCarthy'],
        'phone' => '+1-775-391-0565',
        'email' => 'mccarthygroup@mccarthygrouprealty.com',
        'address' => '308 N Curry St Ste 202, Carson City, NV 89703',
        'contactPage' => 'https://mccarthygrouprealty.com/contact',
    ];
}

function agent_city_guides(): array
{
    $cities = require __DIR__ . '/cities.php';
    $out = [];
    foreach ($cities as $c) {
        $out[] = ['name' => $c['name'], 'slug' => $c['slug'], 'url' => city_guide_href($c['slug'])];
    }
    return $out;
}

function agent_tool_definitions(): array
{
    return [
        ['name' => 'get_contact_info', 'description' => 'Get McCarthy Group phone, email and office address.', 'inputSchema' => ['type' => 'object', 'properties' => new stdClass()]],
        ['name' => 'list_city_guides', 'description' => 'List Northern Nevada city guides with URLs.', 'inputSchema' => ['type' => 'object', 'properties' => new stdClass()]],
    ];
}

function agent_tool_run(string $name)
{
    if ($name === 'get_contact_info') return agent_contact_info();
    if ($name === 'list_city_guides') return ['guides' => agent_city_guides()];
    return null;
}
