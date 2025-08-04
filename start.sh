#!/bin/bash

# Set the port from Railway environment variable
export PORT=${PORT:-80}

# Update Apache configuration with the correct port
sed -i "s/\${PORT:-80}/$PORT/g" /etc/apache2/sites-available/000-default.conf
sed -i "s/\${PORT:-80}/$PORT/g" /etc/apache2/ports.conf

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
