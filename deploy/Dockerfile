# Стадия сборки зависимостей
FROM composer:latest AS build
WORKDIR /app

# Копируем composer.json и composer.lock
COPY project/composer.json project/composer.lock ./

# Устанавливаем зависимости без выполнения скриптов
RUN composer install --no-progress --no-suggest --no-scripts

# Генерация автозагрузки
RUN composer dump-autoload --no-scripts

# Проверяем наличие папки vendor
RUN ls -la /app/vendor

# Финальная стадия
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

# Рабочая директория
WORKDIR /var/www/html

# Копируем зависимости из первой стадии
COPY --from=build /app/vendor ./vendor

# Копируем остальные файлы проекта
COPY project/. .

# Настройка прав
RUN chmod -R 775 storage bootstrap/cache vendor && \
    chown -R www-data:www-data storage bootstrap/cache vendor

CMD ["php-fpm"]