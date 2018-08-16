#!/usr/bin/env bash

composer install --optimize-autoloader
composer dump-autoload --optimize
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --force
php artisan passport:install --force
php artisan config:cache
php artisan route:cache
./vendor/bin/phpunit
