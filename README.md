# Frigorlato

Sistema web de trazabilidad e inventario desarrollado con Laravel.

## Funcionalidades

- Gestion de lotes con fecha de vencimiento automatica.
- Salidas por FIFO con `numero_salida`.
- Historial de movimientos.
- Exportacion de inventario y movimientos en PDF y Excel.
- Gestion de contratos asociados a lotes.

## Acceso

Usuarios disponibles:

- `admin1@frigorlato.com` / `password123`
- `admin2@frigorlato.com` / `password123`
- `admin3@frigorlato.com` / `password123`

## Puesta en marcha

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

## Notas

- La ruta `/` redirige al login.
- Los contratos se almacenan en `storage/app/private`.
