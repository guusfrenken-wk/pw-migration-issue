PROJECT := pw-migration-issue

up: ## Docker up
	docker-compose -p ${PROJECT} up -d

start: ## Start docker containers
	docker-compose -p ${PROJECT} start

stop: ## Stop docker containers
	docker-compose -p ${PROJECT} stop

down: ## Stop docker containers and remove images
	docker-compose -p ${PROJECT} down

destroy: ## Stop docker containers and remove images and volumes
	docker-compose -p ${PROJECT} down -v

rebuild: ## Rebuild docker containers
	docker compose -p ${PROJECT} build --no-cache
	docker compose -p ${PROJECT} up --force-recreate --no-deps -d

logs: ## Tail logs of running docker containers
	docker-compose -p ${PROJECT} logs -f

bash: ## Ssh into PHP container
	docker-compose -p ${PROJECT} exec php bash

cache-clear: ## Clear cache
	docker-compose -p ${PROJECT} exec php php bin/console cache:clear

setup-database: ## Setup DB and fixture data
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:database:create
	docker-compose -p ${PROJECT} exec php php bin/console doc:schema:create
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:fixtures:load -n
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:migrations:sync-metadata-storage -n
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:migrations:version --add --all -n

fixtures: ## Run fixtures
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:fixtures:load -n

migrate-database: ## Run migrations
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:migrations:migrate -n

drop-database: ## Drop database
	docker-compose -p ${PROJECT} exec php php bin/console doctrine:database:drop --force --if-exists
