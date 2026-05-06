# Etapa 1: compilar assets de frontend
FROM node:20-alpine AS build-assets

WORKDIR /build

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY src/ ./src/
COPY webpack.config.js tsconfig.json .babelrc* ./
RUN npm run build

# Etapa 2: imagen de producción
FROM wordpress:6.4-php8.2-fpm-alpine

# Eliminar la configuración de debug que viene en la imagen base
ENV WORDPRESS_DEBUG=0

# Copiar solo los assets compilados de la etapa anterior
COPY --from=build-assets /build/dist \
     /var/www/html/wp-content/themes/ninjatheme/dist

# Copiar el código PHP del tema
COPY --chown=www-data:www-data \
     wp-content/themes/ninjatheme/ \
     /var/www/html/wp-content/themes/ninjatheme/

# Copiar el plugin del proyecto si existe
COPY --chown=www-data:www-data \
     wp-content/plugins/ninja-portfolio-enhancer/ \
     /var/www/html/wp-content/plugins/ninja-portfolio-enhancer/

# Instalar extensiones PHP necesarias para producción
RUN docker-php-ext-install opcache && \
    docker-php-ext-enable opcache

# Configuración de OPcache para producción
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
