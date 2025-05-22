#!/bin/bash
cd /home/site/wwwroot

# Install and build frontend
npm install
npm run build

# Serve Laravel
php artisan serve --host 0.0.0.0 --port 8080
