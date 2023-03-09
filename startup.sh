#!/bin/sh
if [ ! -f ".env" ]; then
  cp .env.example .env
fi

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
 
sail up -d
sail php artisan key:generate
