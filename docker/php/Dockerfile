FROM php:8.0-fpm-alpine

LABEL maintainer="Saber Nouira"

# Ensure the container is up-to-date
RUN apk update && apk upgrade

# Prepare PHP dependencies
RUN apk add --no-cache --update --virtual buildDeps bzip2-dev postgresql-dev oniguruma-dev libzip-dev autoconf gcc musl-dev make

# Install PHP exentions
RUN docker-php-ext-install pgsql pdo_pgsql bcmath zip bz2 opcache

# Install PECL exentions
RUN pecl install redis-5.3.3 \
    && docker-php-ext-enable redis

# Cleanup build dependencies
RUN apk del buildDeps

# Deploy php.ini
COPY php.ini $PHP_INI_DIR/conf.d/99-ezgames.ini

