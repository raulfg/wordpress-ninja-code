#!/usr/bin/env bash
# /usr/local/bin/wp-backup.sh

set -euo pipefail

SITE_PATH="/var/www/html"
BACKUP_DIR="/var/backups/wordpress"
REMOTE_BUCKET="s3://tu-bucket/backups/wordpress"
DATE=$(date +%Y%m%d-%H%M%S)
DB_FILE="${BACKUP_DIR}/db-${DATE}.sql.gz"
FILES_FILE="${BACKUP_DIR}/uploads-${DATE}.tar.gz"

mkdir -p "${BACKUP_DIR}"

# Backup de la base de datos
wp --path="${SITE_PATH}" db export - | gzip > "${DB_FILE}"
echo "Base de datos exportada: ${DB_FILE}"

# Backup de uploads (solo si es domingo o primer día del mes)
if [ "$(date +%u)" -eq 7 ] || [ "$(date +%d)" -eq 1 ]; then
    tar -czf "${FILES_FILE}" \
        -C "${SITE_PATH}/wp-content" uploads/
    echo "Archivos comprimidos: ${FILES_FILE}"
    aws s3 cp "${FILES_FILE}" "${REMOTE_BUCKET}/files/"
fi

# Subir base de datos a S3
aws s3 cp "${DB_FILE}" "${REMOTE_BUCKET}/database/"

# Eliminar backups locales con más de 7 días
find "${BACKUP_DIR}" -name "*.gz" -mtime +7 -delete

echo "Backup completado: ${DATE}"
