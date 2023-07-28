FROM php:8.1-fpm-alpine

RUN apk update && apk upgrade

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www
