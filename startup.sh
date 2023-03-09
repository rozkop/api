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

alias sail="./vendor/bin/sail"
sail up -d
