#!/bin/bash
# scripts/maintenance.sh
# Run with crontab: 0 3 * * 0 /var/www/html/scripts/maintenance.sh >> /var/log/wp-maintenance.log 2>&1

set -e

WP_PATH="${WP_PATH:-/var/www/html}"
DATE=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$DATE] Starting maintenance..."

# Clean up post revisions (keep last 3 per post)
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

# Clean up spam comments and trash
wp comment delete \
    $(wp comment list --status=spam --format=ids --path="$WP_PATH" --allow-root) \
    --force --path="$WP_PATH" --allow-root 2>/dev/null || true

# Optimize database
wp db optimize --path="$WP_PATH" --allow-root

# Delete expired transients
wp transient delete --expired --path="$WP_PATH" --allow-root

# Flush object cache
wp cache flush --path="$WP_PATH" --allow-root

echo "[$DATE] Maintenance completed."
