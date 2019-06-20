#-----------------------------------------------------------
# Docker controls
#-----------------------------------------------------------

# Up docker containers
up:
	docker-compose up -d

# Shut down docker containers
down:
	docker-compose down

# Show status of the each container
s:
	docker-compose ps

# Restart all docker containers
restart: down up

# Restart all docker containers
restart-node:
	docker-compose restart node

# Build and up docker containers
build:
	docker-compose up -d --build

# Build and up docker containers
rebuild: down build

# Shut down and remove all volumes
remove-volumes:
	docker-compose down --volumes

#-----------------------------------------------------------
# Laravel
#-----------------------------------------------------------

# Add permissions for cache and store folders
permissions:
	sudo chmod -R 777 api/bootstrap/cache
	sudo chmod -R 777 api/storage

# Run tinker
tinker:
	docker-compose exec php-cli php artisan tinker

# Run phpunit tests
test:
	docker-compose exec php-cli vendor/bin/phpunit

# Run phpunit tests with coverage
coverage:
	docker-compose exec php-cli vendor/bin/phpunit --coverage-html tests/report

# PHP composer autoload comand
autoload:
	docker-compose exec php-cli composer dump-autoload

# Run database migrations
db-migrate:
	docker-compose exec php-cli php artisan migrate

# Run migrations rollback
db-rollback:
	docker-compose exec php-cli php artisan rollback

# Run seeders
db-seed:
	docker-compose exec php-cli php artisan db:seed

# Fresh all migrations
db-fresh:
	docker-compose exec php-cli php artisan migrate:fresh
