#!/usr/bin/env bash
# /usr/local/bin/wp-backup.sh

set -euo pipefail

SITE_PATH="/var/www/html"
BACKUP_DIR="/var/backups/wordpress"
REMOTE_BUCKET="s3://your-bucket/backups/wordpress"
DATE=$(date +%Y%m%d-%H%M%S)
DB_FILE="${BACKUP_DIR}/db-${DATE}.sql.gz"
FILES_FILE="${BACKUP_DIR}/uploads-${DATE}.tar.gz"

mkdir -p "${BACKUP_DIR}"

# Database backup
wp --path="${SITE_PATH}" db export - | gzip > "${DB_FILE}"
echo "Database exported: ${DB_FILE}"

# Uploads backup (only on Sundays or the first day of the month)
if [ "$(date +%u)" -eq 7 ] || [ "$(date +%d)" -eq 1 ]; then
    tar -czf "${FILES_FILE}" \
        -C "${SITE_PATH}/wp-content" uploads/
    echo "Files compressed: ${FILES_FILE}"
    aws s3 cp "${FILES_FILE}" "${REMOTE_BUCKET}/files/"
fi

# Upload database to S3
aws s3 cp "${DB_FILE}" "${REMOTE_BUCKET}/database/"

# Delete local backups older than 7 days
find "${BACKUP_DIR}" -name "*.gz" -mtime +7 -delete

echo "Backup complete: ${DATE}"
