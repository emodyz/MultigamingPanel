FROM php:8.0.1-fpm-buster

LABEL maintainer="Léo Hubert"

## Prepare PHP dependencies
RUN apt-get update && apt-get install -y git libbz2-dev libxml2-dev libpq-dev libonig-dev

RUN curl -sL https://deb.nodesource.com/setup_15.x | bash - \
    && apt-get install -y nodejs \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn

## Install php extensions
RUN docker-php-ext-install bz2 pdo pdo_pgsql bcmath mbstring tokenizer xml pdo pdo_pgsql

## Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD chown -R www-data:www-data .; composer install --optimize-autoloader --no-dev ;  php-fpm

EXPOSE 9000
