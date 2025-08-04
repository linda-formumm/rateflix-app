#!/bin/bash

# Debugging: Print environment variables
echo "PORT: ${PORT:-8080}"
echo "APP_ENV: ${APP_ENV}"

# Set default port if not provided by Railway
export PORT=${PORT:-8080}

# Update Apache configuration with Railway port
sed -i "s/\${PORT:-8080}/$PORT/g" /etc/apache2/ports.conf
sed -i "s/\${PORT:-8080}/$PORT/g" /etc/apache2/sites-available/000-default.conf

# Generate application key if not exists
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Test if Apache config is valid
echo "Testing Apache configuration..."
apache2ctl configtest

# Print final Apache configuration for debugging
echo "Apache is listening on port: $PORT"
cat /etc/apache2/ports.conf

# Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground
