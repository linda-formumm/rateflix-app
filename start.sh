#!/bin/bash

# Enable debugging
set -e

# Debugging: Print environment variables
echo "PORT: ${PORT:-8080}"
echo "APP_ENV: ${APP_ENV}"
echo "APP_KEY: ${APP_KEY:0:20}..." # Show only first 20 chars for security
echo "OMDB_API_KEY: ${OMDB_API_KEY:0:8}..." # Show only first 8 chars

# Set default port if not provided by Railway
export PORT=${PORT:-8080}

# Update Apache configuration with Railway port
sed -i "s/\${PORT:-8080}/$PORT/g" /etc/apache2/ports.conf
sed -i "s/\${PORT:-8080}/$PORT/g" /etc/apache2/sites-available/000-default.conf

# Generate application key if not exists
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
else
    echo "Using provided APP_KEY"
fi

# Test database connection
echo "Testing database connection..."
php artisan migrate:status || echo "Migration status check failed, continuing..."

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Clear and cache configuration
echo "Caching configuration..."
php artisan config:clear
php artisan config:cache

# Don't cache routes in production if they might cause issues
echo "Clearing route cache..."
php artisan route:clear

# Cache views
echo "Caching views..."
php artisan view:cache

# Test Laravel application
echo "Testing Laravel application..."
php artisan about || echo "Laravel about command failed, continuing..."

# Set ServerName to suppress Apache warnings
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Test if Apache config is valid
echo "Testing Apache configuration..."
apache2ctl configtest

# Print final Apache configuration for debugging
echo "Apache is listening on port: $PORT"
cat /etc/apache2/ports.conf

# Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground
