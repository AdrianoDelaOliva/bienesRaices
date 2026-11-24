
FROM node:22-bookworm AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_pgsql gd \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
COPY --from=frontend /app/public/build ./public/build

# Habilitar las rutas de Apache
RUN a2enmod rewrite

# Configurar el directorio publico
RUN printf '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
        DirectoryIndex index.php\n\
    </Directory>\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

# Instalar dependencias PHP
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN composer dump-autoload --optimize --no-dev

RUN test -f /var/www/html/vendor/autoload.php

# Configurar permisos
RUN mkdir -p /var/www/html/public/imagenes \
    && chown -R www-data:www-data /var/www/html/public/imagenes \
    && chmod -R a+rX /var/www/html

# Verificar archivos necesarios
RUN test -f /var/www/html/public/index.php
RUN test -f /var/www/html/public/.htaccess
RUN apache2ctl configtest

# Configurar PHP para produccion
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

EXPOSE 80

CMD ["apache2-foreground"]
