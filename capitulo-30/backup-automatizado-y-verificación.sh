#!/bin/bash
# scripts/backup-verify.sh

set -e

BACKUP_DIR="/var/backups/wordpress"
DATE=$(date +%Y%m%d)
DB_BACKUP="${BACKUP_DIR}/db-${DATE}.sql.gz"
UPLOADS_BACKUP="${BACKUP_DIR}/uploads-${DATE}.tar.gz"

# Backup de base de datos
wp db export - --allow-root | gzip > "${DB_BACKUP}"

# Backup de uploads
tar -czf "${UPLOADS_BACKUP}" wp-content/uploads/

# Verificación: el SQL comprimido debe tener más de 10KB
DB_SIZE=$(stat -c%s "${DB_BACKUP}")
if [ "${DB_SIZE}" -lt 10240 ]; then
    echo "ERROR: Backup de base de datos demasiado pequeño (${DB_SIZE} bytes)"
    exit 1
fi

# Verificación: integridad del tar
if ! tar -tzf "${UPLOADS_BACKUP}" > /dev/null 2>&1; then
    echo "ERROR: Backup de uploads corrupto"
    exit 1
fi

echo "Backup verificado: DB=${DB_SIZE} bytes, uploads OK"

# Rotación: mantener solo los últimos 14 días
find "${BACKUP_DIR}" -name "*.gz" -mtime +14 -delete
