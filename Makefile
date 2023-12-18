# Executables (local)
DOCKER_COMP = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP          = $(PHP_CONT) php
COMPOSER     = $(PHP_CONT) composer
SYMFONY      = symfony
PHPSTAN      = vendor/bin/phpstan
PHPUNIT      = vendor/bin/phpunit
PHP_CS_FIXER = vendor/bin/php-cs-fixer
PSALM        = vendor/bin/psalm
RECTOR       = vendor/bin/rector
YARN         = yarn

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc

## —— 🎵 🐳 The Symfony Docker makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Project setup 🚀 ——————————————————————————————————————————————————————————
setup: install setup-database ## Setup the whole project

setup-dev: install setup-test-db setup-fixtures ## Setup the project in dev environment

install: ## Install composer dependencies
	@$(COMPOSER) install --no-interaction

setup-database: ## Setup the database backend
	@$(SYMFONY) console doctrine:database:create --if-not-exists --no-interaction
	@$(SYMFONY) console doctrine:migrations:migrate --no-interaction

setup-test-db: ## Setup the test database
	@$(SYMFONY) console doctrine:database:create --no-interaction --if-not-exists --env=test
	@$(SYMFONY) console doctrine:schema:create --env=test

setup-fixtures: ## Install the fixtures
	@$(SYMFONY) console doctrine:fixtures:load --no-interaction

reset-database: ## Reset the whole database (caution!)
	@$(SYMFONY) console doctrine:database:drop --force
	@$(SYMFONY) console doctrine:database:create --no-interaction
	@$(SYMFONY) console doctrine:migrations:migrate --no-interaction

## —— Project pipelines 🚇 ——————————————————————————————————————————————————————
checks: cs static-analysis ## Run check-styles and static-analysis

ci: checks test ## Run CI pipeline

reset: install reset-database setup-fixtures ## Reset pipeline for the whole project (caution!)

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
start: build up ## Build and start the containers

build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: rector fix-php stan psalm eslint ## Run all coding standards checks

static-analysis: stan psalm ## Run the static analysis

lint-php: ## Lint files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes --dry-run --config=php-cs-fixer.php

fix-php: ## Fix files with php-cs-fixer
	@PHP_CS_FIXER_IGNORE_ENV=1 $(PHP_CS_FIXER) fix --allow-risky=yes --config=php-cs-fixer.php

eslint: ## Run ESLint
	@$(YARN) run eslint assets

psalm: ## Run Psalm
	@$(PSALM)

stan: ## Run PHPStan
	@$(SYMFONY) php $(PHPSTAN) analyse --memory-limit 1G

rector: ## Run Rector
	@$(RECTOR)

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: ## Run tests
	@$(PHPUNIT) --stop-on-failure
