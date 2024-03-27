.DEFAULT_GOAL = help
.PHONY        : help

# Executables
COMPOSER      = composer
DOCKER        = docker
DOCKER_COMP   = docker compose
PHP           = php
SYMFONY       = symfony
YARN          = yarn

# Alias
CONSOLE       = $(EXEC_PHP) bin/console

# Vendor executables
PHPMD         = ./vendor/bin/phpmd
PHPUNIT       = ./vendor/bin/phpunit
PHPSTAN       = ./vendor/bin/phpstan
PHP_CS_FIXER  = ./vendor/bin/php-cs-fixer
PSALM         = ./vendor/bin/psalm
RECTOR        = ./vendor/bin/rector
TWIG_CS_FIXER = ./vendor/bin/twig-cs-fixer

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

## —— 🎵 🐳 The Symfony Docker makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Project setup 🚀 ——————————————————————————————————————————————————————————
setup: ## Setup the whole project
	@$(COMPOSER) install --no-interaction
	@$(COMPOSER) setup-env

setup-dev: ## Setup the dev environment for the project
	@$(COMPOSER) install --no-interaction
	@$(COMPOSER) setup-env
	@$(COMPOSER) setup-test-env
	@$(COMPOSER) load-fixtures
	@$(YARN) install

warmup-dev: ## Warmup the dev environment (e.g. after purge)
	@$(COMPOSER) setup-env
	@$(COMPOSER) load-fixtures
	@$(CONSOLE) asset-map:compile
	@$(CONSOLE) cache:warmup

## —— Project pipelines 🚇 ——————————————————————————————————————————————————————
checks: lint cs static-analysis ## Run check-styles and static-analysis

ci: checks test ## Run CI pipeline

reset: purge warmup-dev ## Reset pipeline for the whole project (caution!)

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
vendor: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --prefer-dist --no-dev --no-progress --no-interaction

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
compile: ## Execute some tasks before deployment
	rm -rf public/assets/*
	@$(CONSOLE) asset-map:compile
	@$(CONSOLE) cache:clear
	@$(CONSOLE) cache:warmup

consume: ## Consume messages from symfony messenger
	@$(CONSOLE) messenger:consume async -vvv

trans: ## Extract translations from symfony
	@$(CONSOLE) translation:extract --dump-messages --force --sort=asc en

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: rector fix-php fix-twig eslint phpmd ## Run all coding standards checks

static-analysis: phpstan psalm ## Run the static analysis

lint: lint-composer lint-php lint-twig ## Run the linting tools

eslint: ## Run ESLint
	@$(YARN) run eslint assets

eslint-fix: ## Run ESLint with fixes
	@$(YARN) run eslint assets --fix

fix-php: ## Fix files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes --config=php-cs-fixer.php

fix-twig: ## Fix files with php-cs-fixer
	@$(TWIG_CS_FIXER) --fix

lint-composer: ## Lint files with composer
	@$(COMPOSER) lint

lint-php: ## Lint files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes --dry-run --config=php-cs-fixer.php

lint-twig: ## Lint files with php-cs-fixer
	@$(TWIG_CS_FIXER)

phpmd: ## Run PHP Mess detector
	@$(PHPMD) src/ html phpmd.xml --report-file var/report/phpmd.html --ignore-violations-on-exit

phpstan: ## Run PHPStan
	@$(PHP_CONT) $(PHPSTAN) analyse --memory-limit 1G

psalm: ## Run Psalm
	@$(PSALM)

rector: ## Run Rector
	@$(RECTOR)

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: ## Run tests
	@$(PHPUNIT) --stop-on-failure -d memory_limit=-1

testdox: ## Run tests with testdox
	@$(PHPUNIT) --testdox -d memory_limit=-1

coverage: ## Run tests with Coverage reports
	@XDEBUG_MODE=coverage $(PHPUNIT) -d memory_limit=-1

## —— Cleanup 🚮 ————————————————————————————————————————————————————————————————
purge: ## Purge temporary files
	@rm -rf public/assets/*
	@rm -rf var/cache/* var/logs/*

clear: ## Cleanup everything (except docker)
	@rm -rf vendor/*
	@rm -rf node_modules/*
	@rm -rf public/assets/*
	@rm -rf var/cache/* var/logs/*
