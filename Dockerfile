FROM php:8.4-fpm-alpine

# Install Nginx and other dependencies
RUN apk add --no-cache \
    nginx \
    libzip-dev \
    libxml2-dev \
    curl-dev \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip curl xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Create required directories for Nginx
RUN mkdir -p /run/nginx

# Expose port 80
EXPOSE 80

# Start script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]
