FROM php:7.4-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    build-essential \
    zip \
    vim \
    unzip \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    sqlite3

RUN docker-php-ext-install zip intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000

CMD ["php-fpm"]
