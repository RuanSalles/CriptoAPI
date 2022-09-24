init: ## Start a new develop environment
	$(MAKE) install
	$(MAKE) keys
	$(MAKE) fresh
	$(MAKE) seed

keys: ## Generate secret keys
	docker-compose exec cripto-api-nginx bash -c "su -c 'php artisan key:generate' application"

install: ## Composer install dependencies
	docker-compose exec cripto-api-nginx bash -c "su -c \"composer install\" application"

##@ Database tools

migration: ## Create migration file
	docker-compose exec cripto-api-nginx bash -c "su -c \"php artisan make:migration $(name)\" application"

migrate: ## Perform migrations
	docker-compose exec cripto-api-nginx php artisan migrate

storeall: ## Perform migrations
	docker-compose exec cripto-api-nginx php artisan coins:storeAll

horizon: ## Start laravel horizon
	docker-compose exec -u application cripto-api-nginx php artisan horizon

fresh: ## Perform fresh migrations
	docker-compose exec cripto-api-nginx php artisan migrate:fresh

seed: ## Import database
	docker-compose exec cripto-api-nginx php artisan db:seed

rollback: ## Rollback migration
	docker-compose exec cripto-api-nginx php artisan migrate:rollback

reapply: ## Reapply the last migrations
	docker-compose exec cripto-api-nginx php artisan migrate:rollback
	docker-compose exec cripto-api-nginx php artisan migrate

backup: ## Export database
	docker-compose exec cripto-api-mysql bash -c "mysqldump -u root -p database > /var/www/app/database/dumps/backup.sql"
	docker-compose exec cripto-api-mysql bash -c "chown 1000:1000 /var/www/app/database/dumps/backup.sql"

restore: ## Import database
	docker-compose exec cripto-api-mysql bash -c "mysql -u root -p database < /var/www/app/database/dumps/backup.sql"

route: ## Rollback migration
	docker-compose exec cripto-api-nginx php artisan route:list

##@ Composer

install: ## Composer install dependencies
	docker-compose exec cripto-api-nginx bash -c "su -c \"composer install\" application"

autoload: ## Run the composer dump
	docker-compose exec cripto-api-nginx bash -c "su -c \"composer dump-autoload\" application"
##@ Bash controls

bash: ## Start nginx bash
	docker-compose exec cripto-api-nginx bash

nginx: ## Start nginx bash
	docker-compose exec -u application cripto-api-nginx bash

mysql: ## Start mysql bash
	docker-compose exec cripto-api-mysql bash