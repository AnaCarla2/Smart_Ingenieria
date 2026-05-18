#!/bin/bash
set -e

# Configurar Laravel para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Arrancar Apache
exec "$@"