FROM nginx:alpine

LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# Ensure the container is up-to-date
RUN apk update && apk upgrade && crond

# Install LetsEncrypt's certbot
RUN apk add --no-cache --update certbot certbot-nginx

# CERTBOT LOL
# RUN mkdir -p /var/www/letsencrypt/.well-known/acme-challenge/ && echo hi > /var/www/letsencrypt/.well-known/acme-challenge/hi && chgrp -R www-data /var/www/letsencrypt
