FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --no-cache linux-headers \
    && apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS\
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del .build-dependencies

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
