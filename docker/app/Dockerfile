FROM nginx:1.20-alpine

LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# ARG PUBLISH_TEMPLATE

# Ensure the container is up-to-date
RUN apk update && apk upgrade && apk add vim && crond

# Install LetsEncrypt's certbot
RUN apk add --no-cache --update certbot certbot-nginx

# Install Crond
RUN apk add --no-cache --update busybox

COPY docker/app/default.conf.template /etc/nginx/templates/default.conf.template

CMD crond -b -L /dev/stdout \
    && nginx -g 'daemon off;'
