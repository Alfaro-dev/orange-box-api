#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

php artisan optimize
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan storage:link
php artisan event:cache