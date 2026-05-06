# 1. Hacer backup de la BD en producción antes de tocar nada
ssh usuario@servidor "cd /var/www/html && wp db export ../backup-$(date +%Y%m%d-%H%M).sql --allow-root"

# 2. Subir el código al servidor
rsync -avz --delete \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='*.sql' \
  ./wp-content/themes/mi-tema/ \
  usuario@servidor:/var/www/html/wp-content/themes/mi-tema/

# 3. Instalar dependencias PHP en el servidor si hay composer.json
ssh usuario@servidor "cd /var/www/html && composer install --no-dev --optimize-autoloader"

# 4. Ejecutar actualizaciones de BD y limpiar caché
ssh usuario@servidor "cd /var/www/html && wp core update-db --allow-root && wp cache flush --allow-root"
