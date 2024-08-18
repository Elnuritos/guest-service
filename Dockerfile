# Dockerfile
FROM php:8.1-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql gd zip

# Установка Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Установка Laravel
COPY . /var/www
WORKDIR /var/www

RUN composer install

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
