FROM php:8.0-fpm-alpine

LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# Ensure the container is up-to-date
RUN apk update && apk upgrade

# Prepare BUILD dependencies
#RUN apk add --no-cache --update --virtual buildDeps autoconf gcc musl-dev make

# Prepare PHP dependencies
#RUN apk add --no-cache bzip2-dev postgresql-dev oniguruma-dev libzip-dev protobuf

# Install PHP extentions
#RUN docker-php-ext-install pgsql pdo_pgsql bcmath zip bz2 opcache sockets

# Install REDIS extention
#RUN pecl install redis-5.3.3 \
#    && docker-php-ext-enable redis

# Install PHP extention
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions grpc redis pgsql pdo_pgsql bcmath zip bz2 opcache sockets

# Install EVENT extention
# RUN apk add --no-cache libevent-dev
# RUN pecl install event-3.0.4 \
#     && docker-php-ext-enable event

# Install composer
#RUN apk add --no-cache composer
RUN install-php-extensions @composer

# Cleanup build dependencies
#RUN apk del buildDeps

# Deploy php.ini
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/99-ezgames.ini

# Install node
RUN apk add --no-cache --update nodejs yarn npm

# Install SupervisorD
RUN apk add --no-cache --update supervisor

# Install Crond
RUN apk add --no-cache --update busybox

# Deploy SupervisorD configuration
RUN mkdir /etc/supervisor && mkdir /etc/supervisor/conf.d && mkdir /var/log/supervisor
COPY docker/php/supervisord.conf /etc/supervisor
COPY docker/php/supervisor.d/* /etc/supervisor/conf.d/

CMD yarn install \
&& composer install --no-dev \
&& chgrp -R www-data ./ \
&& chmod -R 775 ./storage \
&& php artisan key:generate --no-interaction \
&& php artisan migrate --force \
&& php artisan storage:link \
&& crond -b -L /dev/stdout \
&& /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
