# En el servidor de origen: exportar la base de datos
wp db export origen-backup.sql --allow-root

# Copiar los archivos al destino
rsync -avz --exclude='wp-config.php' \
  /var/www/html/wp-content/ \
  usuario@destino:/var/www/html/wp-content/

# Copiar el archivo SQL al destino
scp origen-backup.sql usuario@destino:/tmp/

# En el servidor de destino: importar la base de datos
wp db import /tmp/origen-backup.sql --allow-root

# Actualizar las URLs en toda la base de datos
wp search-replace 'https://origen.com' 'https://destino.com' --allow-root

# Limpiar la caché y regenerar permalinks
wp cache flush --allow-root
wp rewrite flush --allow-root
