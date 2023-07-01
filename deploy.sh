#!/bin/sh

# Change to the project directory
cd ..

# Turn on maintenance mode
$DEPLOY_PHP_VERSION artisan down

# Pull the latest changes from the git repository
git reset --hard
git clean -df
git pull

# Install/update composer dependecies
$DEPLOY_COMPOSER_VERSION install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Restart FPM
( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $DEPLOY_FPM_VERSION reload ) 9>/tmp/fpmlock

# #npm 
$DEPLOY_NPM_VERSION install
$DEPLOY_NPM_VERSION run build

$DEPLOY_PHP_VERSION artisan migrate --force
$DEPLOY_PHP_VERSION artisan cache:clear
$DEPLOY_PHP_VERSION artisan clear
$DEPLOY_PHP_VERSION artisan optimize:clear

$DEPLOY_PHP_VERSION artisan view:cache
$DEPLOY_PHP_VERSION artisan event:cache
$DEPLOY_PHP_VERSION artisan optimize

$DEPLOY_PHP_VERSION artisan up