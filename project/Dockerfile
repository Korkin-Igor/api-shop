FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

COPY . .

RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pdo_pgsql

RUN chmod -R 777 storage bootstrap/cache

CMD ["php-fpm"]
