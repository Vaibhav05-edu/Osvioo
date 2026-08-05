#!/bin/bash
set -euo pipefail

# Configure Apache port and ServerName
echo "ServerName localhost" >> /etc/apache2/apache2.conf
sed -i "s/Listen 80/Listen 0.0.0.0:${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/*.conf

# Create necessary writable directories if missing
mkdir -p \
    /var/www/html/kode/storage/framework/cache/data \
    /var/www/html/kode/storage/framework/sessions \
    /var/www/html/kode/storage/framework/views \
    /var/www/html/kode/storage/logs \
    /var/www/html/kode/bootstrap/cache \
    /var/www/html/kode/public/assets/images/custom \
    /var/www/html/assets/images/custom

# Fix ownership and permissions BEFORE running Artisan commands
chown -R www-data:www-data \
    /var/www/html/kode/storage \
    /var/www/html/kode/bootstrap/cache \
    /var/www/html/assets \
    /var/www/html/kode/public/assets

find /var/www/html/kode/storage /var/www/html/kode/bootstrap/cache -type d -exec chmod 775 {} +
find /var/www/html/kode/storage /var/www/html/kode/bootstrap/cache -type f -exec chmod 664 {} +

# Run Artisan commands as www-data user
cd /var/www/html/kode
su -s /bin/sh www-data -c "php artisan optimize:clear"
su -s /bin/sh www-data -c "php artisan migrate --force"
su -s /bin/sh www-data -c "php artisan config:cache"
su -s /bin/sh www-data -c "php artisan route:cache"
su -s /bin/sh www-data -c "php artisan view:cache"
cd /var/www/html

# Execute container main command (apache2-foreground)
exec "$@"
