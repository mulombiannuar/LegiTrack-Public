FROM php:8.5.12-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl \
    default-mysql-client \
    libicu-dev libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    ca-certificates \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_mysql sockets gd intl zip bcmath pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# php.ini-production caps uploads at 2M; match the app's largest upload rule
RUN echo "upload_max_filesize=10M" > /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size=12M" >> /usr/local/etc/php/conf.d/uploads.ini

# Copy custom CA into the system trust store when one is present
COPY composer.json devCA.pe[m] /tmp/certs/

# Update CA certificates (this merges dev CA with system CAs)
RUN if [ -f /tmp/certs/devCA.pem ]; then cp /tmp/certs/devCA.pem /usr/local/share/ca-certificates/devCA.crt; fi \
    && update-ca-certificates \
    && rm -rf /tmp/certs

# Configure PHP to use the full system CA bundle (FIX)
RUN echo "curl.cainfo=/etc/ssl/certs/ca-certificates.crt" >> /usr/local/etc/php/conf.d/local-ca.ini \
 && echo "openssl.cafile=/etc/ssl/certs/ca-certificates.crt" >> /usr/local/etc/php/conf.d/local-ca.ini \
 && echo "openssl.capath=/etc/ssl/certs" >> /usr/local/etc/php/conf.d/local-ca.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/LegiTrack-Public

# Set proper permissions
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/LegiTrack-Public \
    && chmod -R 775 storage bootstrap/cache

# Expose FastCGI port
EXPOSE 9000
