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

# Force HTTPS in production
export FORCE_HTTPS=true

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

# Clear all caches first
echo "Clearing all caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache configuration for production
echo "Caching configuration..."
php artisan config:cache

# Cache views
echo "Caching views..."
php artisan view:cache

# Test Laravel application
echo "Testing Laravel application..."
php artisan about || echo "Laravel about command failed, continuing..."

# Test if the application can boot
echo "Testing application boot..."
php artisan route:list --json > /dev/null 2>&1 || echo "Route list failed, but continuing..."

# Test database connection with better error handling
echo "Testing database connection more thoroughly..."
php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection successful';" || echo "Database connection test failed"

# Ensure storage is writable
echo "Setting up storage permissions..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

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
