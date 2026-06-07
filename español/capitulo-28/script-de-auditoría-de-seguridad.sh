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
        echo "  ✗ $description (actual: $result, esperado: $expected)"
        ISSUES=$((ISSUES + 1))
    fi
}

echo "=== Auditoría de seguridad NinjaTheme ==="

# Verificar versión de WordPress
WP_VERSION=$(wp core version --path="$WP_PATH" --allow-root)
LATEST=$(wp core check-update --format=json --path="$WP_PATH" --allow-root 2>/dev/null | jq -r '.[0].version // "current"')
check "WordPress actualizado ($WP_VERSION)" "$LATEST" "current"

# Verificar que debug está desactivado en producción
DEBUG=$(wp config get WP_DEBUG --path="$WP_PATH" --allow-root 2>/dev/null || echo "false")
check "WP_DEBUG desactivado" "$DEBUG" "false"

# Verificar plugins con actualizaciones pendientes
PLUGIN_UPDATES=$(wp plugin list --update=available --format=count --path="$WP_PATH" --allow-root)
check "Plugins actualizados" "$PLUGIN_UPDATES" "0"

# Verificar que la tabla de usuarios no tiene administradores con nombre 'admin'
ADMIN_USER=$(wp user list --login=admin --format=count --path="$WP_PATH" --allow-root 2>/dev/null || echo "0")
check "No existe usuario 'admin'" "$ADMIN_USER" "0"

# Verificar que el directorio wp-config.php no es accesible vía web
CONFIG_ACCESSIBLE=$(curl -s -o /dev/null -w "%{http_code}" "$(wp option get home --path="$WP_PATH" --allow-root)/wp-config.php")
check "wp-config.php no accesible vía web" "$CONFIG_ACCESSIBLE" "403"

echo ""
if [ "$ISSUES" -gt 0 ]; then
    echo "Auditoría: $ISSUES problema(s) encontrado(s)."
    exit 1
else
    echo "Auditoría: sin problemas detectados."
fi
