FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    git \
    unzip \
    zip \
    libmysqlclient-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN apt-get install -y apache2 libapache2-mod-fcgid
RUN a2enmod rewrite proxy_fcgi setenvif
RUN a2enconf php8.2-fpm

COPY ./docker/apache/apache-laravel.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]