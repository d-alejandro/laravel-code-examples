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
