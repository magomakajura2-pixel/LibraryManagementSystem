#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Create required directories
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chown -R www-data:www-data storage bootstrap/cache

# Clear ALL old caches (old config may have wrong APP_URL)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run migrations and seed database
php artisan migrate --force
php artisan db:seed --force

# Configure Apache to listen on Render's assigned PORT
PORT=${PORT:-10000}
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground
