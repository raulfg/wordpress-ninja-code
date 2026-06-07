# On the source server: export the database
wp db export source-backup.sql --allow-root

# Copy files to the destination
rsync -avz --exclude='wp-config.php' \
  /var/www/html/wp-content/ \
  user@destination:/var/www/html/wp-content/

# Copy the SQL file to the destination
scp source-backup.sql user@destination:/tmp/

# On the destination server: import the database
wp db import /tmp/source-backup.sql --allow-root

# Update URLs throughout the database
wp search-replace 'https://source.com' 'https://destination.com' --allow-root

# Clear cache and regenerate permalinks
wp cache flush --allow-root
wp rewrite flush --allow-root
