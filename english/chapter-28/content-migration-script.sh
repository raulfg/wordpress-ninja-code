#!/bin/bash
# scripts/import-portfolio.sh
# Usage: ./scripts/import-portfolio.sh data/projects.json

set -e

JSON_FILE="${1:-data/proyectos.json}"

if [ ! -f "$JSON_FILE" ]; then
    echo "Error: File not found: $JSON_FILE"
    exit 1
fi

TOTAL=$(jq length "$JSON_FILE")
CREATED=0
ERRORS=0

echo "Importing $TOTAL projects from $JSON_FILE..."

jq -c '.[]' "$JSON_FILE" | while IFS= read -r project; do
    TITLE=$(echo "$project" | jq -r '.title')
    CLIENT=$(echo "$project" | jq -r '.client // empty')
    YEAR=$(echo "$project" | jq -r '.year // empty')
    FEATURED=$(echo "$project" | jq -r '.featured // false')
    DESCRIPTION=$(echo "$project" | jq -r '.description // empty')

    # Create the post
    POST_ID=$(wp post create \
        --post_type=portfolio \
        --post_title="$TITLE" \
        --post_content="$DESCRIPTION" \
        --post_status=publish \
        --porcelain 2>/dev/null)

    if [ -z "$POST_ID" ]; then
        echo "  ✗ Error creating: $TITLE"
        ERRORS=$((ERRORS + 1))
        continue
    fi

    # Add metadata
    [ -n "$CLIENT" ]   && wp post meta set "$POST_ID" _npe_client_name "$CLIENT"
    [ -n "$YEAR" ]     && wp post meta set "$POST_ID" _npe_year "$YEAR"
    [ "$FEATURED" = "true" ] && wp post meta set "$POST_ID" _npe_is_featured "1"

    echo "  ✓ $TITLE (ID: $POST_ID)"
    CREATED=$((CREATED + 1))
done

echo ""
echo "Import completed: $CREATED created, $ERRORS errors."
