#!/bin/bash
# scripts/maintenance.sh
# Ejecutar con crontab: 0 3 * * 0 /var/www/html/scripts/maintenance.sh >> /var/log/wp-maintenance.log 2>&1

set -e

WP_PATH="${WP_PATH:-/var/www/html}"
DATE=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$DATE] Iniciando mantenimiento..."

# Limpiar revisiones de posts (mantener últimas 3 por post)
wp post list \
    --post_type=any \
    --post_status=inherit \
    --format=ids \
    --path="$WP_PATH" \
    --allow-root | tr ' ' '\n' | while read -r id; do
    revisions=$(wp post list \
        --post_parent="$id" \
        --post_type=revision \
        --format=count \
        --path="$WP_PATH" \
        --allow-root 2>/dev/null || echo 0)
    
    if [ "$revisions" -gt 3 ]; then
        excess=$((revisions - 3))
        wp post list \
            --post_parent="$id" \
            --post_type=revision \
            --format=ids \
            --path="$WP_PATH" \
            --allow-root | tr ' ' '\n' | head -n "$excess" | \
            xargs -r wp post delete --force --path="$WP_PATH" --allow-root
    fi
done

# Limpiar comentarios spam y papelera
wp comment delete \
    $(wp comment list --status=spam --format=ids --path="$WP_PATH" --allow-root) \
    --force --path="$WP_PATH" --allow-root 2>/dev/null || true

# Optimizar base de datos
wp db optimize --path="$WP_PATH" --allow-root

# Limpiar transients expirados
wp transient delete --expired --path="$WP_PATH" --allow-root

# Limpiar caché del object cache
wp cache flush --path="$WP_PATH" --allow-root

echo "[$DATE] Mantenimiento completado."
