FROM php:8.1-fpm
LABEL maintainer="Sergey Snopko"

ARG user=bulder
ARG uid=1001

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

#for Dev
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip

WORKDIR /var/www/html/
USER $user