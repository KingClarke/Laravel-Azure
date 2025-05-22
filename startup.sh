#!/bin/bash
# Start PHP-FPM
php-fpm &

# Start nginx with your custom config
nginx -c /home/site/wwwroot/nginx.conf
