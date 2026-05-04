FROM php:8.2-cli

WORKDIR /app

# 1. Instalamos dependencias de PHP Y TAMBIÉN Node.js/npm para Vite
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Copiamos los archivos del proyecto
COPY . .

# 3. Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Instalamos dependencias, compilamos Vite y damos permisos
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && chmod -R 777 storage bootstrap/cache

# 5. Pasamos la caché al CMD para que lea las variables de Render al arrancar
CMD sh -c "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force || true && php artisan db:seed --force || true && php artisan serve --host=0.0.0.0 --port=$PORT"