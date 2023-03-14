#!/bin/sh

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

docker-compose build 
docker-compose up -d

docker-compose run --rm -u "$(id -u):$(id -g)" app composer install
docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan key:generate
docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan storage:link