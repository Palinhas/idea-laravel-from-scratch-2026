#!/bin/bash

# Laravel Forge Deploy Script
# Add this to your Deploy Script in Laravel Forge

set -e

echo "Deploying application..."

# Clear Laravel caches
php artisan optimize:clear

# Install/update dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Clear and cache views
php artisan view:clear
php artisan view:cache

echo "Deployment completed successfully!"

