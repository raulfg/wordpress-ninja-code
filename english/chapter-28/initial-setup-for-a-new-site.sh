#!/bin/bash
# scripts/setup-new-site.sh
# Usage: ./scripts/setup-new-site.sh --url=https://client.com --title="Client Portfolio"

set -e

# Parse arguments
SITE_URL=""
SITE_TITLE=""
ADMIN_EMAIL=""

for arg in "$@"; do
    case $arg in
        --url=*)  SITE_URL="${arg#*=}" ;;
        --title=*) SITE_TITLE="${arg#*=}" ;;
        --email=*) ADMIN_EMAIL="${arg#*=}" ;;
    esac
done

if [ -z "$SITE_URL" ] || [ -z "$SITE_TITLE" ]; then
    echo "Usage: $0 --url=https://site.com --title='Site Name' --email=admin@site.com"
    exit 1
fi

ADMIN_EMAIL="${ADMIN_EMAIL:-admin@$(echo $SITE_URL | sed 's/https\?:\/\///')}"
ADMIN_PASS=$(openssl rand -base64 16)

echo "Installing WordPress..."
wp core install \
    --url="$SITE_URL" \
    --title="$SITE_TITLE" \
    --admin_user=admin \
    --admin_password="$ADMIN_PASS" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email

echo "Configuring basic settings..."
wp option update blogdescription ""
wp option update timezone_string "Europe/Madrid"
wp option update date_format "d/m/Y"
wp option update time_format "H:i"
wp option update default_comment_status closed
wp option update default_ping_status closed

echo "Removing sample content..."
wp post delete 1 2 --force 2>/dev/null || true
wp comment delete 1 --force 2>/dev/null || true

echo "Installing and activating plugins..."
wp plugin install \
    query-monitor \
    redis-cache \
    wordfence \
    contact-form-7 \
    --activate

echo "Activating NinjaTheme..."
wp theme activate ninjatheme

echo "Generating page structure..."
wp post create \
    --post_type=page \
    --post_title="Home" \
    --post_status=publish \
    --post_name=home \
    --porcelain | xargs -I{} wp option update page_on_front {}

wp option update show_on_front page

echo ""
echo "✓ Installation completed"
echo "  URL: $SITE_URL"
echo "  Admin: admin / $ADMIN_PASS"
echo "  Save the password — it will not be shown again."
