# Сборочный этап
FROM composer:latest as build

WORKDIR /client
COPY client/composer.json client/composer.lock ./

RUN composer install --prefer-dist --no-interaction --no-dev
COPY . ..
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative
RUN composer clear-cache

# Финальный этап
FROM php:8.1.5-fpm-alpine as final
LABEL maintainer="Sergey Snopko <sergey.snopko@gmail.com>"

RUN apk update && \
    apk upgrade && \
    apk add --no-cache --update \
    curl \
    icu \
    bzip2 \
    bzip2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev && \
    docker-php-ext-install bcmath pdo_mysql mysqli gd zip

WORKDIR /var/www/html
COPY --from=build /client /var/www/html/client

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
