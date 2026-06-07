#!/bin/bash
set -euo pipefail

WP="wp --path=/var/www/html"
BACKUP_DIR="/var/backups/wordpress"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo "Iniciando deploy..."

# 1. Backup de la base de datos antes de cualquier cambio
$WP db export "${BACKUP_DIR}/pre-deploy-${TIMESTAMP}.sql"
echo "Backup guardado en ${BACKUP_DIR}/pre-deploy-${TIMESTAMP}.sql"

# 2. Activar modo mantenimiento
$WP maintenance-mode activate

# 3. Actualizar core y plugins
$WP core update
$WP plugin update --all

# 4. Limpiar y regenerar
$WP rewrite flush
$WP cache flush
$WP transient delete --all

# 5. Desactivar modo mantenimiento
$WP maintenance-mode deactivate

echo "Deploy completado."
