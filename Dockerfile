FROM php:7.4.16-fpm
LABEL maintainer="Sergey Snopko"

ARG user=bulder
ARG uid=1001

ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1

#RUN apt-get update && apt install curl && \
#  curl -sS https://getcomposer.org/installer | php \
#  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www/html/

USER $user

#COPY composer.json composer.json
#RUN composer install --prefer-dist

COPY . .

RUN composer dump-autoload

#VOLUME /var/www/html/vendor:vendor
#CMD [ "php", "example/index.php" ]

EXPOSE 3000