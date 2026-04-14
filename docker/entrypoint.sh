#!/bin/sh
set -e

echo "==> Descubriendo paquetes..."
php artisan package:discover --ansi

echo "==> Actualizando assets de Filament..."
php artisan filament:upgrade

echo "==> Generando APP_KEY si no existe..."
php artisan key:generate --no-ansi 2>/dev/null || true

echo "==> Ejecutando migraciones..."
php artisan migrate --force

echo "==> Inicializando configuración del sitio..."
php artisan db:seed --class=SiteConfigSeeder --force

echo "==> Creando enlace de storage..."
php artisan storage:link || true

echo "==> Cacheando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Iniciando servidor en 0.0.0.0:8000..."
exec php artisan serve --host=0.0.0.0 --port=8000
