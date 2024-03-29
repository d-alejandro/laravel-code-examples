.DEFAULT_GOAL := up

b:
	docker-compose build

bnc:
	docker-compose build --no-cache

up:
	docker-compose up -d

down:
	docker-compose down

ps:
	docker-compose ps

run:
	docker container exec -it $(var) /bin/sh

db:
	docker-compose exec php-fpm php artisan migrate --seed

refresh:
	docker-compose exec php-fpm php artisan migrate:refresh --seed
