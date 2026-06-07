## Update WordPress core
wp core update

## Update all plugins
wp plugin update --all

## Update all themes
wp theme update --all

## Search and replace in database (useful for migrations)
wp search-replace 'http://old-site.com' 'https://new-site.com'

## Generate test posts
wp post generate --count=50

## Export/import database
wp db export backup-$(date +%Y%m%d).sql
wp db import backup.sql

## Regenerate thumbnails after changing sizes
wp media regenerate --yes

## List users
wp user list

## Create admin user
wp user create newadmin admin@site.com --role=administrator --user_pass=strongpass

## Flush cache
wp cache flush
wp transient delete --all

## Show system information
wp cli info
