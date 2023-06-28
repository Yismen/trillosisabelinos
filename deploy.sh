#!/bin/sh

# Change to the project directory
cd /home/forge/trillosisabelinos.com

# Turn on maintenance mode
php artisan down || true

# Pull the latest changes from the git repository
git reset --hard
git clean -df
git pull

# Install/update composer dependecies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Restart FPM
( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service php8.2-fpm reload ) 9>/tmp/fpmlock

#npm 
npm install
npm run build

php artisan migrate --force
php artisan cache:clear
php artisan clear
php artisan optimize:clear

php artisan view:cache
php artisan event:cache

php artisan up