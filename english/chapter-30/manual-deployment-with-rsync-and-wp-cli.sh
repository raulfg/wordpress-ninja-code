# 1. Back up the database on production before touching anything
ssh user@server "cd /var/www/html && wp db export ../backup-$(date +%Y%m%d-%H%M).sql --allow-root"

# 2. Upload the code to the server
rsync -avz --delete \
  --exclude='.git' \
  --exclude='node_modules' \
  --exclude='*.sql' \
  ./wp-content/themes/my-theme/ \
  user@server:/var/www/html/wp-content/themes/my-theme/

# 3. Install PHP dependencies on the server if there is a composer.json
ssh user@server "cd /var/www/html && composer install --no-dev --optimize-autoloader"

# 4. Run database updates and clear cache
ssh user@server "cd /var/www/html && wp core update-db --allow-root && wp cache flush --allow-root"
