FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    git \
    unzip \
    zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb
    
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html