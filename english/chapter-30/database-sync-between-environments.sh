#!/bin/bash
# scripts/pull-db.sh — Sync production database to development

set -e

PROD_HOST="${PROD_HOST:-prod.domain.com}"
PROD_USER="${PROD_SSH_USER:-deploy}"
DUMP_FILE="/tmp/prod-dump-$(date +%Y%m%d-%H%M%S).sql"
LOCAL_URL="http://localhost:8080"
PROD_URL="https://domain.com"

echo "Exporting production database..."
ssh "${PROD_USER}@${PROD_HOST}" \
    "wp db export - --allow-root" > "${DUMP_FILE}"

echo "Importing locally..."
wp db import "${DUMP_FILE}"

echo "Replacing URLs..."
wp search-replace "${PROD_URL}" "${LOCAL_URL}" --all-tables

echo "Cleaning up..."
rm "${DUMP_FILE}"
wp cache flush

echo "Sync complete."
