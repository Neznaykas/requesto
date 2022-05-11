FROM php:7.4-cli
LABEL maintainer="Sergey Snopko"

ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update && apt install curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

#RUN apt-get install git

WORKDIR /var/www

#COPY composer.json composer.json
#RUN composer install --prefer-dist

COPY . .

RUN composer dump-autoload

CMD [ "php", "example/index.php" ]