#!/bin/bash
set -e

# Mostrar variables para debug
echo "DB_HOST: $DB_HOST"
echo "DB_DATABASE: $DB_DATABASE"

# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recachear
php artisan config:cache
php artisan migrate --force

# Arrancar Apache
exec "$@"