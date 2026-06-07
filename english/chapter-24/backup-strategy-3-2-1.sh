#!/bin/bash
# scripts/backup-3-2-1.sh
# Run from cron: 0 2 * * * /var/www/html/scripts/backup-3-2-1.sh

set -e

DATE=$(date +%Y%m%d)
BACKUP_DIR="/var/backups/wordpress"
S3_BUCKET="s3://ninjatheme-backups"
SECONDARY_HOST="backup.empresa.com"

mkdir -p "$BACKUP_DIR"

# 1. Local backup (Copy 1)
echo "Creating local backup..."
wp db export "${BACKUP_DIR}/db-${DATE}.sql" --allow-root
tar -czf "${BACKUP_DIR}/uploads-${DATE}.tar.gz" wp-content/uploads/

# 2. Sync to secondary server (Copy 2)
echo "Syncing to secondary server..."
rsync -avz --delete "${BACKUP_DIR}/" \
    "backup@${SECONDARY_HOST}:/var/backups/ninjatheme/"

# 3. Upload to S3 backups older than 7 days (Copy 3 - offsite)
# Only weekly backups go to S3 to optimise costs
if [ "$(date +%u)" -eq 7 ]; then # Sundays
    echo "Uploading weekly backup to S3..."
    aws s3 cp "${BACKUP_DIR}/db-${DATE}.sql" "${S3_BUCKET}/weekly/"
    aws s3 cp "${BACKUP_DIR}/uploads-${DATE}.tar.gz" "${S3_BUCKET}/weekly/"
fi

# Local rotation: keep 14 days
find "${BACKUP_DIR}" -name "*.sql" -mtime +14 -delete
find "${BACKUP_DIR}" -name "*.tar.gz" -mtime +14 -delete

echo "Backup completed: ${DATE}"
