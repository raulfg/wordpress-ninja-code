#!/bin/bash
set -euo pipefail

WP="wp --path=/var/www/html"
BACKUP_DIR="/var/backups/wordpress"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo "Starting deploy..."

# 1. Database backup before any changes
$WP db export "${BACKUP_DIR}/pre-deploy-${TIMESTAMP}.sql"
echo "Backup saved to ${BACKUP_DIR}/pre-deploy-${TIMESTAMP}.sql"

# 2. Enable maintenance mode
$WP maintenance-mode activate

# 3. Update core and plugins
$WP core update
$WP plugin update --all

# 4. Flush and regenerate
$WP rewrite flush
$WP cache flush
$WP transient delete --all

# 5. Disable maintenance mode
$WP maintenance-mode deactivate

echo "Deploy completed."
