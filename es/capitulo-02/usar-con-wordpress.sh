## Crear directorio para proyectos
mkdir ~/Sites
cd ~/Sites

## "parkear" el directorio (todos los subdirectorios serán sitios)
valet park

## Crear sitio WordPress
wp core download --path=mi-sitio
cd mi-sitio
wp config create --dbname=misitio --dbuser=root --dbpass=root
wp db create
wp core install --url=http://mi-sitio.test --title="Mi Sitio" \
  --admin_user=admin --admin_password=contraseña_segura --admin_email=admin@mi-sitio.test

## Accede a http://mi-sitio.test
