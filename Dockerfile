FROM php:7.4-cli

COPY . /drom
WORKDIR /drom
CMD [ "php", ".example/index.php" ]