#!/usr/bin/env bash
# Starts local dev: PHP built-in server.
# Ctrl+C stops it.

set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")"

PHP_HOST="127.0.0.1"
PHP_PORT="8001"

cleanup() {
    echo
    echo "Stopping dev server..."
    kill "$PHP_PID" 2>/dev/null || true
    wait "$PHP_PID" 2>/dev/null || true
}
trap cleanup EXIT INT TERM

php -S "${PHP_HOST}:${PHP_PORT}" -t . router.php &
PHP_PID=$!

echo "PHP server: http://${PHP_HOST}:${PHP_PORT}"
echo "Press Ctrl+C to stop."

wait "$PHP_PID"
