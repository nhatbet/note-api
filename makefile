install:
	- docker-compose up -d
	- docker-compose run --rm php composer install
	- docker-compose run --rm php php artisan migrate
	- docker-compose run --rm php php artisan db:seed
start:
	- docker-compose up -d
stop:
	- docker-compose stop
down:
	- docker-compose down
kill:
	docker compose kill
build:
	docker compose up -d --build
migrate:
	- docker-compose run --rm php php artisan migrate
composer-autoload:
	- docker-compose run --rm php composer dump-autoload
composer-install:
	- docker-compose run --rm php composer install
php:
	- docker-compose run --rm php sh
refresh-remote:
	- docker-compose run --rm php php artisan migrate:refresh
	- docker-compose run --rm php php artisan db:seed
clear-config:
	- docker-compose run --rm php php artisan config:cache
