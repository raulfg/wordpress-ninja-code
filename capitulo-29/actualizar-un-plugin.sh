# Actualizar un plugin específico
composer update wpackagist-plugin/advanced-custom-fields

# Revisar el diff del composer.lock para confirmar qué cambió
git diff composer.lock

# Probar en local
# Si todo funciona, commitear
git add composer.json composer.lock
git commit -m "chore: update Advanced Custom Fields to 6.2.8"

# Desplegar a staging para validar
cd ../trellis
trellis deploy staging

# Validar en staging, luego a producción
trellis deploy production
