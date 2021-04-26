FROM php:8.0-fpm-alpine
# TODO: Add supervisord for laravel queue:work
LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# Ensure the container is up-to-date
RUN apk update && apk upgrade

# Prepare BUILD dependencies
RUN apk add --no-cache --update --virtual buildDeps autoconf gcc musl-dev make

# Prepare PHP dependencies
RUN apk add --no-cache bzip2-dev postgresql-dev oniguruma-dev libzip-dev

# Install PHP exentions
RUN docker-php-ext-install pgsql pdo_pgsql bcmath zip bz2 opcache

# Install PECL exentions
RUN pecl install redis-5.3.3 \
    && docker-php-ext-enable redis

# Install composer
RUN apk add --no-cache composer

# Cleanup build dependencies
RUN apk del buildDeps

# Deploy php.ini
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-ezgames.ini

# Install node
RUN apk add --no-cache --update nodejs yarn npm

# Install SupervisorD
RUN apk add --no-cache --update supervisor

# Deploy SupervisorD configuration
RUN mkdir /etc/supervisor && mkdir /etc/supervisor/conf.d && mkdir /var/log/supervisor
COPY docker/php/supervisord.conf /etc/supervisor
COPY docker/php/supervisor.d/* /etc/supervisor/conf.d

CMD yarn install && composer install --no-dev && php artisan key:generate --no-interaction && php artisan migrate --force && /usr/bin/supervisord -c /etc/supervisor/supervisord.conf && chown -R www-data:www-data ./ && chmod -R 755 ./storage
