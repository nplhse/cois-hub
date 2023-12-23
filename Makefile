# Executables (local)
DOCKER_COMP = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP           = $(PHP_CONT) php
COMPOSER      = $(PHP_CONT) composer
SYMFONY       = symfony
YARN          = yarn

CONSOLE       = $(SYMFONY) console
PHPSTAN       = vendor/bin/phpstan
PHPUNIT       = vendor/bin/phpunit
PHP_CS_FIXER  = vendor/bin/php-cs-fixer
PSALM         = vendor/bin/psalm
RECTOR        = vendor/bin/rector
TWIG_CS_FIXER = vendor/bin/twig-cs-fixer

# Misc
.DEFAULT_GOAL = help
.PHONY        : help build up start down logs sh composer vendor sf cc

## —— 🎵 🐳 The Symfony Docker makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Project setup 🚀 ——————————————————————————————————————————————————————————
setup: install setup-db ## Setup the whole project

setup-dev: install setup-test-db setup-fixtures ## Setup the project in dev environment

install: ## Install composer dependencies
	@$(COMPOSER) install --no-interaction

setup-db: ## Setup the database backend
	@$(CONSOLE) doctrine:database:create --if-not-exists --no-interaction
	@$(CONSOLE) doctrine:migrations:migrate --no-interaction

setup-test-db: ## Setup the test database
	@$(CONSOLE) doctrine:database:drop --force --env=test
	@$(CONSOLE) doctrine:database:create --no-interaction --if-not-exists --env=test
	@$(CONSOLE) doctrine:schema:create --env=test

setup-fixtures: ## Install the fixtures
	@$(CONSOLE) doctrine:fixtures:load --no-interaction

reset-db: ## Reset the whole database (caution!)
	@$(CONSOLE) doctrine:database:drop --force
	@$(CONSOLE) doctrine:database:create --no-interaction
	@$(CONSOLE) doctrine:migrations:migrate --no-interaction

## —— Project pipelines 🚇 ——————————————————————————————————————————————————————
checks: cs static-analysis lint ## Run check-styles and static-analysis

ci: validate checks test ## Run CI pipeline

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

audit:
	@$(COMPOSER) audit

validate:
	@$(COMPOSER) validate

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf

consume: ## Consume messages from symfony messenger
	@$(CONSOLE) messenger:consume async -vvv

trans: ## Extract translations from symfony
	@$(CONSOLE) translation:extract --dump-messages --force --sort=asc en

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: rector fix-php fix-twig eslint phpmd ## Run all coding standards checks

static-analysis: phpstan psalm ## Run the static analysis

lint: lint-php lint-container lint-yaml lint-doctrine lint-xliff lint-twig

eslint: ## Run ESLint
	@$(YARN) run eslint assets

fix-php: ## Fix files with php-cs-fixer
	@PHP_CS_FIXER_IGNORE_ENV=1 $(PHP_CS_FIXER) fix --allow-risky=yes --config=php-cs-fixer.php

fix-twig: ## Fix files with php-cs-fixer
	@$(TWIG_CS_FIXER) --fix

lint-container:
	@$(CONSOLE) lint:container --no-debug

lint-doctrine:
	@$(CONSOLE) doctrine:schema:validate --skip-sync -vvv --no-interaction

lint-php: ## Lint files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes --dry-run --config=php-cs-fixer.php

lint-twig: ## Lint files with php-cs-fixer
	@$(TWIG_CS_FIXER)

lint-yaml:
	@$(CONSOLE) lint:yaml config

lint-xliff:
	@$(CONSOLE) lint:xliff translations

phpmd:
	vendor/bin/phpmd src/ html phpmd.xml --report-file var/report/phpmd.html --ignore-violations-on-exit

phpstan: ## Run PHPStan
	@$(PHP_CONT) $(PHPSTAN) analyse --memory-limit 1G

psalm: ## Run Psalm
	@$(PSALM)

rector: ## Run Rector
	@$(RECTOR)

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: ## Run tests
	@$(PHPUNIT) --stop-on-failure
