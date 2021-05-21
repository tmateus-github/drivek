up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

build-clean:
	docker-compose build --no-cache --force-rm --compress

migrate:
	docker exec -it importer_app php artisan migrate

migrate-seed:
	docker exec -it importer_app php artisan migrate:fresh --seed

run:
	docker exec -it importer_app php artisan $(command)

composer-install:
	docker exec -it importer_app composer install

composer-update:
	docker exec -it importer_app composer update

composer-require:
	docker exec -it importer_app composer require $(lib)

clean-cache:
	docker exec -it importer_app php artisan cache:clear
	docker exec -it importer_app php artisan config:clear
	docker exec -it importer_app composer dump-autoload -o

build-setup:
	make build-clean
	make up
	make composer-install
	make migrate
