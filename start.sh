#!/bin/sh

if [ ! -f ".env" ]; then
  cp .env.example .env
fi

docker-compose build 
docker-compose up -d


docker-compose run --rm -u "$(id -u):$(id -g)" app composer install

docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan key:generate
docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan storage:link

docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan migrate:fresh --seed

docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan love:reaction-type-add --name=Favourite --mass=0
docker-compose run --rm -u "$(id -u):$(id -g)" app php artisan love:reaction-type-add --default
