#!/bin/bash
# scripts/backup-verify.sh

set -e

BACKUP_DIR="/var/backups/wordpress"
DATE=$(date +%Y%m%d)
DB_BACKUP="${BACKUP_DIR}/db-${DATE}.sql.gz"
UPLOADS_BACKUP="${BACKUP_DIR}/uploads-${DATE}.tar.gz"

# Database backup
wp db export - --allow-root | gzip > "${DB_BACKUP}"

# Uploads backup
tar -czf "${UPLOADS_BACKUP}" wp-content/uploads/

# Verification: the compressed SQL file must be larger than 10KB
DB_SIZE=$(stat -c%s "${DB_BACKUP}")
if [ "${DB_SIZE}" -lt 10240 ]; then
    echo "ERROR: Database backup too small (${DB_SIZE} bytes)"
    exit 1
fi

# Verification: tar integrity check
if ! tar -tzf "${UPLOADS_BACKUP}" > /dev/null 2>&1; then
    echo "ERROR: Uploads backup is corrupt"
    exit 1
fi

echo "Backup verified: DB=${DB_SIZE} bytes, uploads OK"

# Rotation: keep only the last 14 days
find "${BACKUP_DIR}" -name "*.gz" -mtime +14 -delete
