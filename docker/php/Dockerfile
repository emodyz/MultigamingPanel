FROM php:8.0.1-fpm-buster

LABEL maintainer="Léo Hubert"

# Prepare PHP dependencies
RUN apt-get update && apt-get install -y git libbz2-dev libxml2-dev libpq-dev libonig-dev

# Install php extensions
RUN docker-php-ext-install bz2 pdo pdo_pgsql bcmath mbstring tokenizer xml pdo pdo_pgsql

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

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD chown -R www-data:www-data .; php-fpm

EXPOSE 9000
