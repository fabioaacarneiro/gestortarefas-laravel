#!/usr/bin/env bash


composer install

php artisan migrate
