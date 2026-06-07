#!/bin/bash
URL="https://ninjatheme.com"

echo "=== Security headers: $URL ==="

check_header() {
    local header=$1
    local value
    value=$(curl -sI "$URL" | grep -i "^${header}:" | head -1)
    if [ -n "$value" ]; then
        echo "  ✓ $value"
    else
        echo "  ✗ MISSING: $header"
    fi
}

check_header "Strict-Transport-Security"
check_header "X-Content-Type-Options"
check_header "X-Frame-Options"
check_header "Content-Security-Policy"
check_header "Permissions-Policy"
check_header "Referrer-Policy"
