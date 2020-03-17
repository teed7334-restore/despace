#!/bin/sh
cd /var/www/html;
php ~/composer.phar create-project --prefer-dist laravel/laravel web;
cd /var/www/html/web;
chmod -R 777 storage bootstrap/cache;
php ~/composer.phar require tcg/voyager;
php ~/composer.phar require barryvdh/laravel-debugbar --dev
echo 'success';