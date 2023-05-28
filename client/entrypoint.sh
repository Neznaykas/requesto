#!/bin/sh
#docker cp app:/var/www/html/client/vendor/. client/vendor
echo "Synchronizing vendor files..." rsync -a --stats /var/www/cache/vendor/* /var/www/html/client/vendor/ echo "Synchronized vendor files"
exec "php-fpm"