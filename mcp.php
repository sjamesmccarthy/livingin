<?php

// Minimal stateless MCP server (Streamable HTTP, JSON responses). Read-only.
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/site-links.php';
require_once __DIR__ . '/includes/agent-tools.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept, Mcp-Session-Id, MCP-Protocol-Version');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); header('Allow: POST, OPTIONS'); exit; }

function rpc_ok($id, $result) { return ['jsonrpc' => '2.0', 'id' => $id, 'result' => $result]; }
function rpc_err($id, int $code, string $msg) { return ['jsonrpc' => '2.0', 'id' => $id, 'error' => ['code' => $code, 'message' => $msg]]; }

function rpc_handle(array $m)
{
    $id = $m['id'];
    switch ($m['method'] ?? '') {
        case 'initialize':
            return rpc_ok($id, ['protocolVersion' => '2025-06-18', 'capabilities' => ['tools' => new stdClass()], 'serverInfo' => ['name' => 'livinginnorthernnevada', 'version' => '1.0.0']]);
        case 'ping':
            return rpc_ok($id, new stdClass());
        case 'tools/list':
            return rpc_ok($id, ['tools' => agent_tool_definitions()]);
        case 'tools/call':
            $result = agent_tool_run((string)($m['params']['name'] ?? ''));
            if ($result === null) return rpc_err($id, -32602, 'Unknown tool');
            return rpc_ok($id, ['content' => [['type' => 'text', 'text' => json_encode($result, JSON_UNESCAPED_SLASHES)]]]);
        default:
            return rpc_err($id, -32601, 'Method not found');
    }
}

header('Content-Type: application/json');
$body = json_decode(file_get_contents('php://input'), true);
if (!is_array($body)) { http_response_code(400); echo json_encode(rpc_err(null, -32700, 'Parse error')); exit; }

$isBatch = array_is_list($body);
$msgs = $isBatch ? $body : [$body];
$out = [];
foreach ($msgs as $m) {
    if (is_array($m) && array_key_exists('id', $m) && isset($m['method'])) $out[] = rpc_handle($m);
}
if (!$out) { http_response_code(202); exit; }
echo json_encode($isBatch ? $out : $out[0], JSON_UNESCAPED_SLASHES);
