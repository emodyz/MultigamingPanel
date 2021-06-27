FROM php:8.0-fpm-alpine3.13

LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# Ensure the container is up-to-date
RUN apk update && apk upgrade

# Install PHP extention
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync
RUN install-php-extensions sockets
RUN install-php-extensions opcache
RUN install-php-extensions bz2
RUN install-php-extensions zip
RUN install-php-extensions bcmath
RUN install-php-extensions pgsql
RUN install-php-extensions pdo_pgsql
RUN install-php-extensions redis
# TODO: Put all this in its own pre-built image because compiling grpc takes ~17min !!!!!!
RUN install-php-extensions grpc

# Install EVENT extention
# RUN apk add --no-cache libevent-dev
# RUN pecl install event-3.0.4 \
#     && docker-php-ext-enable event

# Install composer
RUN install-php-extensions @composer

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
