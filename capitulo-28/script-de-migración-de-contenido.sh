#!/bin/bash
# scripts/import-portfolio.sh
# Uso: ./scripts/import-portfolio.sh data/proyectos.json

set -e

JSON_FILE="${1:-data/proyectos.json}"

if [ ! -f "$JSON_FILE" ]; then
    echo "Error: No se encuentra el archivo $JSON_FILE"
    exit 1
fi

TOTAL=$(jq length "$JSON_FILE")
CREATED=0
ERRORS=0

echo "Importando $TOTAL proyectos desde $JSON_FILE..."

jq -c '.[]' "$JSON_FILE" | while IFS= read -r proyecto; do
    TITLE=$(echo "$proyecto" | jq -r '.title')
    CLIENT=$(echo "$proyecto" | jq -r '.client // empty')
    YEAR=$(echo "$proyecto" | jq -r '.year // empty')
    FEATURED=$(echo "$proyecto" | jq -r '.featured // false')
    DESCRIPTION=$(echo "$proyecto" | jq -r '.description // empty')

    # Crear el post
    POST_ID=$(wp post create \
        --post_type=portfolio \
        --post_title="$TITLE" \
        --post_content="$DESCRIPTION" \
        --post_status=publish \
        --porcelain 2>/dev/null)

    if [ -z "$POST_ID" ]; then
        echo "  ✗ Error al crear: $TITLE"
        ERRORS=$((ERRORS + 1))
        continue
    fi

    # Añadir metadatos
    [ -n "$CLIENT" ]   && wp post meta set "$POST_ID" _npe_client_name "$CLIENT"
    [ -n "$YEAR" ]     && wp post meta set "$POST_ID" _npe_year "$YEAR"
    [ "$FEATURED" = "true" ] && wp post meta set "$POST_ID" _npe_is_featured "1"

    echo "  ✓ $TITLE (ID: $POST_ID)"
    CREATED=$((CREATED + 1))
done

echo ""
echo "Importación completada: $CREATED creados, $ERRORS errores."
