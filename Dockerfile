FROM php:8.1.5-fpm-alpine
LABEL maintainer="Sergey Snopko"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

WORKDIR /var/www/html/client
RUN composer install

#for Dev
RUN apk update \
    && apk add --no-cache \
        unzip \
        git \
        iputils \
        icu-dev \
        bzip2-dev \
        curl \
        bash

WORKDIR /var/www/html/