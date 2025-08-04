# Use PHP 8.4 with Apache
FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    sqlite3 \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer*.json ./

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm ci

# Show Node and npm versions for debugging
RUN echo "Node version: $(node --version)" && echo "NPM version: $(npm --version)"

# Create and clean build directory 
RUN rm -rf /var/www/html/public/build && mkdir -p /var/www/html/public/build

# Build assets with comprehensive error handling
RUN echo "Building assets with detailed logging..." && \
    NODE_ENV=production npm run build 2>&1 | tee /tmp/build.log || \
    (echo "=== BUILD FAILED ===" && cat /tmp/build.log && exit 1)

# Verify build was successful and show detailed information
RUN echo "=== BUILD VERIFICATION ===" && \
    ls -la /var/www/html/public/build/ && \
    echo "=== MANIFEST CONTENT ===" && \
    cat /var/www/html/public/build/manifest.json && \
    echo "=== ASSET FILES ===" && \
    find /var/www/html/public/build -type f -name "*.css" -o -name "*.js" | head -10

# Create SQLite database with proper permissions
RUN touch /var/www/html/database/database.sqlite

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html/storage
RUN chmod -R 755 /var/www/html/bootstrap/cache
RUN chmod -R 755 /var/www/html/public/build
RUN chmod 664 /var/www/html/database/database.sqlite

# Configure Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Create simple Apache configuration that listens on all ports
RUN echo 'Listen ${PORT:-8080}' > /etc/apache2/ports.conf
RUN echo '<VirtualHost *:${PORT:-8080}>\n\
    DocumentRoot ${APACHE_DOCUMENT_ROOT}\n\
    <Directory ${APACHE_DOCUMENT_ROOT}>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose the port
EXPOSE ${PORT:-8080}

# Start script
CMD ["/var/www/html/start.sh"]
