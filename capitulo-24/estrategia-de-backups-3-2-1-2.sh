#!/bin/bash
# Restaurar el backup de ayer en un entorno de staging y verificar

YESTERDAY=$(date -d "yesterday" +%Y%m%d)
STAGING_PATH="/var/www/staging"

echo "Verificando backup del ${YESTERDAY}..."

# Restaurar la base de datos en staging
wp db import "/var/backups/wordpress/db-${YESTERDAY}.sql" \
    --path="$STAGING_PATH" --allow-root

# Verificar que staging responde correctamente
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://staging.ninjatheme.com/)

if [ "$HTTP_CODE" = "200" ]; then
    echo "✓ Backup verificado correctamente."
else
    echo "✗ Error: staging devuelve código $HTTP_CODE tras restaurar el backup."
    # Notificar al equipo
    curl -X POST "$SLACK_WEBHOOK_URL" \
        -H "Content-Type: application/json" \
        --data "{\"text\": \"[AVISO] Verificación de backup fallida. Código HTTP: $HTTP_CODE\"}"
fi
