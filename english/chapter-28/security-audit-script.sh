#!/bin/bash
# scripts/security-audit.sh

set -e

WP_PATH="${WP_PATH:-/var/www/html}"
ISSUES=0

check() {
    local description="$1"
    local result="$2"
    local expected="$3"

    if [ "$result" = "$expected" ]; then
        echo "  ✓ $description"
    else
        echo "  ✗ $description (actual: $result, expected: $expected)"
        ISSUES=$((ISSUES + 1))
    fi
}

echo "=== NinjaTheme Security Audit ==="

# Check WordPress version
WP_VERSION=$(wp core version --path="$WP_PATH" --allow-root)
LATEST=$(wp core check-update --format=json --path="$WP_PATH" --allow-root 2>/dev/null | jq -r '.[0].version // "current"')
check "WordPress up to date ($WP_VERSION)" "$LATEST" "current"

# Check that debug is disabled in production
DEBUG=$(wp config get WP_DEBUG --path="$WP_PATH" --allow-root 2>/dev/null || echo "false")
check "WP_DEBUG disabled" "$DEBUG" "false"

# Check for plugins with pending updates
PLUGIN_UPDATES=$(wp plugin list --update=available --format=count --path="$WP_PATH" --allow-root)
check "Plugins up to date" "$PLUGIN_UPDATES" "0"

# Check that the users table has no administrators named 'admin'
ADMIN_USER=$(wp user list --login=admin --format=count --path="$WP_PATH" --allow-root 2>/dev/null || echo "0")
check "No 'admin' user exists" "$ADMIN_USER" "0"

# Check that wp-config.php is not accessible via the web
CONFIG_ACCESSIBLE=$(curl -s -o /dev/null -w "%{http_code}" "$(wp option get home --path="$WP_PATH" --allow-root)/wp-config.php")
check "wp-config.php not accessible via web" "$CONFIG_ACCESSIBLE" "403"

echo ""
if [ "$ISSUES" -gt 0 ]; then
    echo "Audit: $ISSUES issue(s) found."
    exit 1
else
    echo "Audit: no issues detected."
fi
