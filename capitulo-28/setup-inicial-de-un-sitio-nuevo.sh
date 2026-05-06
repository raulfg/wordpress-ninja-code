#!/bin/bash
# scripts/setup-new-site.sh
# Uso: ./scripts/setup-new-site.sh --url=https://cliente.com --title="Portfolio Cliente"

set -e

# Parsear argumentos
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
    echo "Uso: $0 --url=https://sitio.com --title='Nombre del sitio' --email=admin@sitio.com"
    exit 1
fi

ADMIN_EMAIL="${ADMIN_EMAIL:-admin@$(echo $SITE_URL | sed 's/https\?:\/\///')}"
ADMIN_PASS=$(openssl rand -base64 16)

echo "Instalando WordPress..."
wp core install \
    --url="$SITE_URL" \
    --title="$SITE_TITLE" \
    --admin_user=admin \
    --admin_password="$ADMIN_PASS" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email

echo "Configurando ajustes básicos..."
wp option update blogdescription ""
wp option update timezone_string "Europe/Madrid"
wp option update date_format "d/m/Y"
wp option update time_format "H:i"
wp option update default_comment_status closed
wp option update default_ping_status closed

echo "Eliminando contenido de ejemplo..."
wp post delete 1 2 --force 2>/dev/null || true
wp comment delete 1 --force 2>/dev/null || true

echo "Instalando y activando plugins..."
wp plugin install \
    query-monitor \
    redis-cache \
    wordfence \
    contact-form-7 \
    --activate

echo "Activando NinjaTheme..."
wp theme activate ninjatheme

echo "Generando estructura de páginas..."
wp post create \
    --post_type=page \
    --post_title="Portada" \
    --post_status=publish \
    --post_name=portada \
    --porcelain | xargs -I{} wp option update page_on_front {}

wp option update show_on_front page

echo ""
echo "✓ Instalación completada"
echo "  URL: $SITE_URL"
echo "  Admin: admin / $ADMIN_PASS"
echo "  Guarda la contraseña — no se volverá a mostrar."
