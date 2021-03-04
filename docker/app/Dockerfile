FROM nginx:alpine

LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# Ensure the container is up-to-date
RUN apk update && apk upgrade && crond

# Deploy nginx conf
COPY ./docker/app/app.conf /etc/nginx/conf.d/default.conf
COPY ./docker/app/test.conf /etc/nginx/conf.d/test.conf


# Install LetsEncrypt's certbot
RUN apk add --no-cache --update certbot certbot-nginx

# Install node
RUN apk add --no-cache --update nodejs yarn


