FROM php:7.4-cli

WORKDIR /drom
COPY . /app

CMD [ "php", "example/index.php" ]