# Stage 1: compile frontend assets
FROM node:20-alpine AS build-assets

WORKDIR /build

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY src/ ./src/
COPY webpack.config.js tsconfig.json .babelrc* ./
RUN npm run build

# Stage 2: production image
FROM wordpress:6.4-php8.2-fpm-alpine

# Remove the debug configuration that comes with the base image
ENV WORDPRESS_DEBUG=0

# Copy only the compiled assets from the previous stage
COPY --from=build-assets /build/dist \
     /var/www/html/wp-content/themes/ninjatheme/dist

# Copy the theme PHP code
COPY --chown=www-data:www-data \
     wp-content/themes/ninjatheme/ \
     /var/www/html/wp-content/themes/ninjatheme/

# Copy the project plugin if it exists
COPY --chown=www-data:www-data \
     wp-content/plugins/ninja-portfolio-enhancer/ \
     /var/www/html/wp-content/plugins/ninja-portfolio-enhancer/

# Install PHP extensions required for production
RUN docker-php-ext-install opcache && \
    docker-php-ext-enable opcache

# OPcache configuration for production
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
