#!/usr/bin/env bash
composer install --no-dev --working-dir=/var/www/html

php artisan migrate --force
