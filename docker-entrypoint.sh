#!/bin/bash
set -e

# Configurar Laravel para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Mostrar errores de Laravel en logs
php artisan about --no-ansi || true
cat storage/logs/laravel.log 2>/dev/null || true

# Arrancar Apache
exec "$@"