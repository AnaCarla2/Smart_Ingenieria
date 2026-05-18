#!/bin/bash
set -e

# Limpiar todos los cachés primero
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Volver a cachear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Mostrar info de diagnóstico
php artisan route:list --no-ansi 2>&1 | head -20 || true
cat storage/logs/laravel.log 2>&1 | tail -50 || true

# Arrancar Apache
exec "$@"