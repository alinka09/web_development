LOCALHOST_PROJECT_DIR := $(shell pwd "-"W)

# IMPORT CONFIG WITH ENVS. You can change the default config with `make cnf="config_special.env" up-dev`
cnf ?= $(LOCALHOST_PROJECT_DIR)/deploy/config.env
include $(cnf)

export $(shell sed 's/=.*//' $(cnf))

.DEFAULT_GOAL := help
help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help

echo-project-dir:## Show current working directory.
	@echo $(LOCALHOST_PROJECT_DIR)
	@echo $(PROJECT_NAME)

.PHONY: echo-project-dir

print:## print
	@printenv

.PHONY: print

## Docker compose shortcuts
up-dev print-compose-file: COMPOSE_FILE=./docker-compose.yml
up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

stop-dev: ## Stop current containers for dev
	docker-compose $(COMPOSE_FILE) stop

delete-dev: ## Delete current containers for dev
	docker-compose $(COMPOSE_FILE) rm -s -f

restart-dev: ## Restart current containers for dev
	docker-compose $(COMPOSE_FILE) restart

build-dev: ## Build or rebuild services for dev
	docker-compose $(COMPOSE_FILE) build

ps-dev: ## List containers
	docker ps

print-compose-file:## print compose file
	@echo $(COMPOSE_FILE)

.PHONY: up-dev stop-dev delete-dev restart-dev build-dev ps-dev print-compose-file

php-exec: CMD?=-r 'phpinfo();'
php-exec: ## Run any php command in our container
	docker exec ${PROJECT_NAME}-php php $(CMD)

.PHONY: php-exec

ifeq (installer, $(firstword $(MAKECMDGOALS)))
  CURRENT := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  $(eval $(CURRENT):;@:)
endif

installer:
	winpty docker run --name installer -v /$(LOCALHOST_PROJECT_DIR)/app:/app --interactive --tty composer $(CURRENT)
	winpty docker cp installer:app $(LOCALHOST_PROJECT_DIR)
	winpty docker rm installer

.PHONY: installer