FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip ftp

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Move to the laravel directory for composer
WORKDIR /var/www/html/kode

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN mkdir -p /var/www/html/kode/storage/framework/cache/data \
             /var/www/html/kode/storage/framework/sessions \
             /var/www/html/kode/storage/framework/views \
             /var/www/html/kode/storage/logs
RUN chown -R www-data:www-data /var/www/html/kode/storage /var/www/html/kode/bootstrap/cache
RUN chmod -R 775 /var/www/html/kode/storage /var/www/html/kode/bootstrap/cache

# Go back to root
WORKDIR /var/www/html

# Set Apache Document Root to Laravel public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/kode/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides
RUN printf "<Directory ${APACHE_DOCUMENT_ROOT}>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n" >> /etc/apache2/apache2.conf

# Expose port (Render will use $PORT)
EXPOSE 80

# Start Apache with dynamic port binding and host binding
CMD echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i "s/Listen 80/Listen 0.0.0.0:${PORT:-80}/g" /etc/apache2/ports.conf && \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/*.conf && \
    cd /var/www/html/kode && php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    cd /var/www/html && \
    apache2-foreground
