# Use official PHP image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install composer
RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# Expose Render’s expected port
EXPOSE 10000

# Run built-in PHP server
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t ."]


