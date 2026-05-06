#!/bin/bash
# scripts/pull-db.sh — Sincronizar base de datos de producción a desarrollo

set -e

PROD_HOST="${PROD_HOST:-prod.dominio.com}"
PROD_USER="${PROD_SSH_USER:-deploy}"
DUMP_FILE="/tmp/prod-dump-$(date +%Y%m%d-%H%M%S).sql"
LOCAL_URL="http://localhost:8080"
PROD_URL="https://dominio.com"

echo "Exportando base de datos de producción..."
ssh "${PROD_USER}@${PROD_HOST}" \
    "wp db export - --allow-root" > "${DUMP_FILE}"

echo "Importando en local..."
wp db import "${DUMP_FILE}"

echo "Sustituyendo URLs..."
wp search-replace "${PROD_URL}" "${LOCAL_URL}" --all-tables

echo "Limpiando..."
rm "${DUMP_FILE}"
wp cache flush

echo "Sincronización completada."
