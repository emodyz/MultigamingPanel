FROM nginx:alpine

LABEL maintainer="Saber Nouira"

WORKDIR /var/www/app

# ARG PUBLISH_TEMPLATE

# Ensure the container is up-to-date
RUN apk update && apk upgrade && apk add vim && crond

# Install LetsEncrypt's certbot
RUN apk add --no-cache --update certbot certbot-nginx

# TODO: Maybe manualy run envsubst or trick it by changing NGINX_ENVSUBST_TEMPLATE_SUFFIX after ssl gen ?????
COPY docker/app/default.conf.template /etc/nginx/templates/default.conf.template
