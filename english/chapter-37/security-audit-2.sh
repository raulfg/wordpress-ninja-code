#!/bin/bash
URL="https://ninjatheme.com"
ISSUES=0

check_url() {
    local path=$1
    local code
    code=$(curl -s -o /dev/null -w "%{http_code}" "${URL}${path}")

    if [ "$code" = "200" ]; then
        echo "  ✗ ACCESSIBLE: ${path} (code $code)"
        ISSUES=$((ISSUES + 1))
    else
        echo "  ✓ Blocked: ${path} ($code)"
    fi
}

echo "=== Sensitive file check ==="
check_url "/wp-config.php"
check_url "/.env"
check_url "/.git/config"
check_url "/xmlrpc.php"
check_url "/wp-json/wp/v2/users"  # User enumeration

echo ""
[ "$ISSUES" -gt 0 ] && echo "⚠ $ISSUES issue(s) found." || echo "✓ No issues detected."
