#!/bin/sh

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/storage/logs/laravel.log
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/storage/logs/laravel.log

set -e

cd /var/www/html

composer install

php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
