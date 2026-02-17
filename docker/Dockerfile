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

# Da dies eine Bibliothek ist, kopieren wir standardmäßig nichts, 
# sondern nutzen Volumes für die Entwicklung.
# Wenn man das Image standalone nutzen möchte:
# COPY . /app
# RUN composer install

#CMD ["php", "-a"]
