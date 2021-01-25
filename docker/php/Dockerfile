FROM php:8.0.1-fpm-buster

LABEL maintainer="Léo Hubert"

# Prepare PHP dependencies
RUN apt-get update && apt-get install -y git libbz2-dev libxml2-dev libpq-dev libonig-dev libzip-dev

# Install php extensions
RUN docker-php-ext-install bz2 pdo pdo_pgsql bcmath mbstring tokenizer xml pdo pdo_pgsql zip

# Install redis
RUN pecl install redis
RUN docker-php-ext-enable redis

# Install Supervisord
RUN apt-get install -y supervisor

# Install NodeJs
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash -
RUN apt-get install -y nodejs

# Install Yarn
RUN npm install --global yarn

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./supervisord.conf /etc/supervisor
COPY ./supervisor.d/* /etc/supervisor/conf.d

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
