# Use the official PHP image with Apache
FROM php:8.2-apache

# Enable necessary extensions and install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mysqli mbstring gd

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy project files to the container
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
