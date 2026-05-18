#!/bin/bash
set -e

# Limpiar TODO
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Solo cachear config, NO rutas ni vistas
php artisan config:cache
php artisan migrate --force

# Arrancar Apache
exec "$@"