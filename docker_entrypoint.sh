#!/bin/bash
set -e

if [ -n "$UID" ] && [ -n "$GID" ]; then
    echo "Setting www-data UID=$UID and GID=$GID..."
    usermod -u "$UID" www-data
    groupmod -g "$GID" www-data
fi

# echo "Add directory to safe directories"
# git config --global --add safe.directory /var/www/html

echo "Fixing storage & cache permissions..."
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rw storage bootstrap/cache
find storage bootstrap/cache -type d -exec chmod g+s {} \;


echo "Installing Composer dependencies..."
composer update --no-dev --optimize-autoloader


if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo "Generating Laravel APP_KEY..."
    php artisan key:generate --force
fi


echo "Running migrations..."
# php artisan migrate

exec php artisan serve  --host=0.0.0.0 --port=8005
