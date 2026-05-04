FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install \
    && php artisan migrate --force \
    && php artisan config:cache

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT