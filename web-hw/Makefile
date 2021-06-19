LOCALHOST_PROJECT_DIR := $(shell pwd "-"W)

# IMPORT CONFIG WITH ENVS. You can change the default config with `make cnf="config_special.env" up-dev`
cnf ?= $(LOCALHOST_PROJECT_DIR)/deploy/config.env
include $(cnf)

export $(shell sed 's/=.*//' $(cnf))

.DEFAULT_GOAL := help
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help

## Docker compose shortcuts
up-dev stop-dev kill-dev build-dev: COMPOSE_FILE=./docker-compose.yml
up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

.PHONY: up-dev

stop-dev: ## Stop current containers for dev
	docker-compose -f $(COMPOSE_FILE) stop

.PHONY: stop-dev

kill-dev: ## Kill current containers for dev
	docker-compose -f $(COMPOSE_FILE) rm -s -f

.PHONY: kill-dev

build-dev: ## Build current containers for dev
	docker-compose -f $(COMPOSE_FILE) build

.PHONY: build-dev

save-dev:## Save dev files
	docker export ${PROJECT_NAME}-php | gzip > php.gz &
	docker export ${PROJECT_NAME}-nginx | gzip > nginx.gz

.PHONY: save-dev

ifeq (run-dev, $(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "run"
  RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(RUN_ARGS):;@:)
endif

run-dev:
	winpty docker run \
	--rm \
	--name test \
	-v /$(LOCALHOST_PROJECT_DIR):/app \
	--interactive \
	--tty composer require $(RUN_ARGS)
