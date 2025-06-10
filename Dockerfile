# Use the official PHP image with required extensions
FROM php:8.2-cli

# Set working directory (corrigido para /var/www)
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    zip \
    libxml2-dev \
    && docker-php-ext-install zip pdo pdo_mysql dom bcmath

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan key:generate \
    && php artisan config:cache || true

EXPOSE 9000

# Run the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
