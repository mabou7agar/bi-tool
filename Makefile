#!/usr/bin/env make

default: backend-bash

DOCKER_COMPOSE_V1_EXIT_CODE=$(shell docker-compose >/dev/null 2>&1; echo $$?)
backend-bash:
	$(call compose,exec,laravel.test bash)

setup:
	cp -n ./.env.example ./.env || :
	$(call compose,exec,laravel.test composer install  --no-interaction --no-progress)
	@make db-setup
	$(call compose,exec,laravel.test php artisan telescope:publish)
	$(call compose,exec,laravel.test npm install)

db-setup:
# DB Setup
# Backend Migrations
	$(call compose,exec,laravel.test php artisan migrate)
# Seeds
	$(call compose,exec,laravel.test php artisan db:seed)

clear-configs-caches:
	$(call compose,exec,laravel.test php artisan config:clear)
	$(call compose,exec,laravel.test php artisan cache:clear)
	$(call compose,exec,laravel.test php artisan route:clear)

define compose
	if [ "$(DOCKER_COMPOSE_V1_EXIT_CODE)" = "0" ]; then\
		docker-compose $1 $2;\
	else\
		docker compose $1 $2;\
	fi
endef

define sail
	if [ "$(DOCKER_COMPOSE_V1_EXIT_CODE)" = "0" ]; then\
		sail $1 $2;\
	else\
		sail $1 $2;\
	fi
endef
