#!/bin/bash

# Generate application key if not exists
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
exec apache2-foreground
