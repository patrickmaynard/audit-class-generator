FROM php:7.4-cli-alpine

# System-Abhängigkeiten für Composer und PHP-Extensions
RUN apk add --no-cache \
    git \
    unzip \
    zip \
    libzip-dev \
    bash

# PHP-Extensions installieren
RUN docker-php-ext-install zip

# Composer installieren
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Arbeitsverzeichnis
WORKDIR /app
