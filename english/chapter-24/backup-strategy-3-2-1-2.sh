#!/bin/bash
# Restore yesterday's backup to a staging environment and verify

YESTERDAY=$(date -d "yesterday" +%Y%m%d)
STAGING_PATH="/var/www/staging"

echo "Verifying backup from ${YESTERDAY}..."

# Restore the database to staging
wp db import "/var/backups/wordpress/db-${YESTERDAY}.sql" \
    --path="$STAGING_PATH" --allow-root

# Verify that staging responds correctly
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://staging.ninjatheme.com/)

if [ "$HTTP_CODE" = "200" ]; then
    echo "✓ Backup verified successfully."
else
    echo "✗ Error: staging returned code $HTTP_CODE after restoring the backup."
    # Notify the team
    curl -X POST "$SLACK_WEBHOOK_URL" \
        -H "Content-Type: application/json" \
        --data "{\"text\": \"[WARNING] Backup verification failed. HTTP code: $HTTP_CODE\"}"
fi
