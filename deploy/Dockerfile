# Сборочный этап
FROM composer:latest as build

WORKDIR /client
COPY client/composer.json ./

RUN composer install --prefer-dist --no-interaction #--no-dev
COPY . ..
RUN composer dump-autoload --optimize #--no-dev --classmap-authoritative
RUN composer clear-cache

# Финальный этап
FROM php:8.1.5-fpm-alpine as final

RUN apk update && \
    apk upgrade && \
    apk add --no-cache --update \
    curl

WORKDIR /var/www/html

COPY --from=build /client /var/www/html/client
