## Actualizar WordPress core
wp core update

## Actualizar todos los plugins
wp plugin update --all

## Actualizar todos los temas
wp theme update --all

## Buscar y reemplazar en bd (útil para migraciones)
wp search-replace 'http://old-site.com' 'https://new-site.com'

## Generar posts de prueba
wp post generate --count=50

## Exportar/importar base de datos
wp db export backup-$(date +%Y%m%d).sql
wp db import backup.sql

## Regenerar thumbnails después de cambiar tamaños
wp media regenerate --yes

## Listar usuarios
wp user list

## Crear usuario admin
wp user create newadmin admin@site.com --role=administrator --user_pass=strongpass

## Vaciar caché
wp cache flush
wp transient delete --all

## Ver información del sistema
wp cli info
