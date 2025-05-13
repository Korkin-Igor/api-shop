FROM php:8.2-fpm-alpine

# Установка необходимых пакетов
RUN apk add --no-cache \
    postgresql-dev \
    build-base \
    git \
    curl

# Установка PHP-расширений
RUN docker-php-ext-install pdo_pgsql && \
    docker-php-ext-enable pdo_pgsql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Копируем composer.json и lock из project/
COPY project/composer.json project/composer.lock ./

# Установка зависимостей
RUN composer install --no-scripts --no-autoloader --no-progress --no-suggest

# Копируем остальные файлы Laravel
COPY project/. .

# Генерация автозагрузки
RUN composer dump-autoload

# Настройка прав
RUN chmod -R 777 storage bootstrap/cache

CMD ["php-fpm"]
