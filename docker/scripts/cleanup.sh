#!/usr/bin/env bash

sleep 10

su www-data

cd /var/www/html

php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

php artisan migrate --force > /proc/1/fd/1

