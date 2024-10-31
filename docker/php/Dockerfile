FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt xdebug qua pecl và các gói cần thiết
RUN apk add --no-cache linux-headers \
    && apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del .build-dependencies

# Cài đặt gói cần thiết cho gd và php gd extension
RUN apk update && apk add --no-cache \
    freetype \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev
RUN docker-php-ext-configure gd \
    --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql gd exif

# Cài đặt grpc extension
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install grpc \
    && docker-php-ext-enable grpc \
    && apk del $PHPIZE_DEPS
