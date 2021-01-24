FROM php:8.0.1-fpm-alpine

LABEL maintainer="Léo Hubert"

## Prepare PHP dependencies
RUN apk --update --no-cache add git bzip2-dev oniguruma-dev libxml2-dev postgresql-dev

## Install php extensions
RUN docker-php-ext-install bz2 bcmath mbstring tokenizer xml pdo pdo_pgsql

## Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install composer
COPY --from=node:15-alpine /usr/bin/node /usr/bin/node

WORKDIR /var/www

##RUN chown -R www-data:www-data /var/www

RUN chmod 777 -R /var/www

CMD composer install --optimize-autoloader --no-dev ;  php-fpm

EXPOSE 9000
