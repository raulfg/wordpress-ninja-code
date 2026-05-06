#!/bin/bash
# scripts/backup-3-2-1.sh
# Ejecutar desde cron: 0 2 * * * /var/www/html/scripts/backup-3-2-1.sh

set -e

DATE=$(date +%Y%m%d)
BACKUP_DIR="/var/backups/wordpress"
S3_BUCKET="s3://ninjatheme-backups"
SECONDARY_HOST="backup.empresa.com"

mkdir -p "$BACKUP_DIR"

# 1. Backup local (Copia 1)
echo "Creando backup local..."
wp db export "${BACKUP_DIR}/db-${DATE}.sql" --allow-root
tar -czf "${BACKUP_DIR}/uploads-${DATE}.tar.gz" wp-content/uploads/

# 2. Sincronizar al servidor secundario (Copia 2)
echo "Sincronizando al servidor secundario..."
rsync -avz --delete "${BACKUP_DIR}/" \
    "backup@${SECONDARY_HOST}:/var/backups/ninjatheme/"

# 3. Subir a S3 los backups de más de 7 días (Copia 3 - offsite)
# Solo los backups semanales van a S3 para optimizar costes
if [ "$(date +%u)" -eq 7 ]; then # Domingos
    echo "Subiendo backup semanal a S3..."
    aws s3 cp "${BACKUP_DIR}/db-${DATE}.sql" "${S3_BUCKET}/weekly/"
    aws s3 cp "${BACKUP_DIR}/uploads-${DATE}.tar.gz" "${S3_BUCKET}/weekly/"
fi

# Rotación local: mantener 14 días
find "${BACKUP_DIR}" -name "*.sql" -mtime +14 -delete
find "${BACKUP_DIR}" -name "*.tar.gz" -mtime +14 -delete

echo "Backup completado: ${DATE}"
