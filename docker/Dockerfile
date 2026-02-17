FROM php:7.4-cli-alpine

# Build Dependencies für PECL
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    bash \
    autoconf \
    gcc \
    g++ \
    make \
    pkgconf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PECL Channel Update
RUN pecl channel-update pecl.php.net

# Xdebug kompatible Version für PHP 7.4
RUN pecl install xdebug-3.1.6 \
    && docker-php-ext-enable xdebug

# Default aus
ENV XDEBUG_MODE=off

WORKDIR /app
