#!/bin/bash

echo "Starting Laravel app"

# Step 1: Composer install, no dev for lightness
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Step 2: Build your frontend assets (if you have npm and build scripts)
if [ -f package.json ]; then
    echo "Installing npm packages and building assets"
    npm install
    npm run build
fi

# Step 3: Generate Laravel app key if missing
if [ ! -f .env ]; then
    echo "no .env found! Copying from .env.example"
    cp .env.example .env
    php artisan key:generate
fi

# Step 4: Run migrations
php artisan migrate --force

# Step 5: Set proper permissions for storage and bootstrap~
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Step 6: Start PHP-FPM (or your preferred PHP server)
echo "Starting PHP-FPM server~"
php-fpm -F
