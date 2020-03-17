FROM php:7.2-fpm-alpine

RUN apk update

RUN apk add libpng-dev freetype-dev libjpeg-turbo-dev jpeg-dev libzip-dev

RUN docker-php-ext-install zip pdo_mysql

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-png-dir=/usr/include --with-jpeg-dir=/usr/include

RUN docker-php-ext-install gd

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

RUN php composer-setup.php

RUN php -r "unlink('composer-setup.php');"

RUN mv composer.phar ~/

WORKDIR /var/www/html