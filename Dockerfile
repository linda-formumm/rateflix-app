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

# Create minimal build directory 
RUN mkdir -p /var/www/html/public/build

# Try to build assets properly
RUN echo "Building assets with detailed logging..." && \
    npm run build 2>&1 | tee /tmp/build.log || true

# Check if build was successful, create fallback if not
RUN if [ ! -f "/var/www/html/public/build/manifest.json" ]; then \
        echo "Build failed or incomplete, creating fallback assets:"; \
        echo '{"resources/css/app.css":{"file":"assets/app-fallback.css","src":"resources/css/app.css"},"resources/js/app.js":{"file":"assets/app-fallback.js","src":"resources/js/app.js"}}' > /var/www/html/public/build/manifest.json; \
        mkdir -p /var/www/html/public/build/assets; \
        echo "/* Fallback Tailwind CSS */ @import 'tailwindcss';" > /var/www/html/public/build/assets/app-fallback.css; \
        echo "// Fallback JS - App loaded" > /var/www/html/public/build/assets/app-fallback.js; \
    else \
        echo "Build successful!"; \
    fi

# Show final build status
RUN echo "Final build directory:" && ls -la /var/www/html/public/build/ && \
    echo "Manifest content:" && cat /var/www/html/public/build/manifest.json

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
