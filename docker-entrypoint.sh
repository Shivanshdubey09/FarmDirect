#!/bin/sh

# Exit immediately if a command exits with a non-zero status
set -e

# Dynamically set Apache port from Render's environment PORT variable
if [ -n "$PORT" ]; then
    echo "Setting Apache to listen on port: $PORT"
    sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
    sed -i "s/*:80/*:${PORT}/g" /etc/apache2/sites-available/*.conf
fi

# Run caching and optimization commands for production
echo "Running Laravel production optimizations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground (standard for official PHP-Apache base image)
echo "Starting Apache Web Server..."
exec apache2-foreground
