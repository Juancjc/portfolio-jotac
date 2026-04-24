#!/usr/bin/env bash
set -Eeuo pipefail

echo "Iniciando container..."

# PCNTL
if ! php -m | grep -q pcntl; then
  echo "Instalando extensão PCNTL..."

  if command -v docker-php-ext-install >/dev/null 2>&1; then
      docker-php-ext-install pcntl
  elif command -v pecl >/dev/null 2>&1; then
      printf "\n" | pecl install pcntl || true
  else
      echo "Não foi possível instalar pcntl automaticamente"
  fi
fi

php -m | grep pcntl || echo "pcntl ainda não disponível"

# Pastas
mkdir -p \
  storage/app \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

chmod -R 775 storage bootstrap/cache || true

# Laravel
php artisan storage:link || true
php artisan migrate --force --seed || true

if [ "${START_MODE:-}" = "reverb" ]; then
  echo "Iniciando servidor Reverb..."
  exec php artisan reverb:start --host=0.0.0.0 --port=${PORT}

elif [ "${START_MODE:-}" = "app" ]; then
  echo "Iniciando aplicação Laravel + fila..."
  php artisan queue:work --sleep=1 --tries=3 --timeout=90 2>&1 &
  exec php artisan serve --host=0.0.0.0 --port=${PORT}

else
  echo "START_MODE inválido: use app ou reverb"
  exit 1
fi
