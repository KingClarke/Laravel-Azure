
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

php artisan key:generate

php artisan migrate --force

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Starting PHP-FPM server~"
php-fpm -F
