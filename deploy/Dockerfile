FROM php:8.1.5-fpm-alpine
LABEL maintainer="Sergey Snopko"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk update \
    && apk add --no-cache \
        unzip \
        git \
        iputils \
        icu-dev \
        bzip2-dev \
        curl \
        bash

COPY . .

RUN cd client && composer install