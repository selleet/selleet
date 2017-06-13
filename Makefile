TARGETS:=$(MAKEFILE_LIST)

#ifndef APP_ENV
#	include .env
#endif

# Event store

.PHONY: clear-stores
clear-stores: ## Purge event stores
	rm var/tests/eventstore/*.txt

# Tests

.PHONY: unit features test
unit: ## Run unit tests
	@test -f bin/phpunit || echo "cannot run unit tests (needs phpunit/phpunit)"
	php bin/phpunit --testdox tests

features: clear-stores ## Run behaviour tests
	@test -f bin/behat || echo "cannot run tests (needs behat/behat)"
	php bin/behat

test: unit features

# Coding Style

.PHONY: cs cs-fix cs-ci
cs: ## Check code style
	./bin/php-cs-fixer fix --dry-run --stop-on-violation --diff

cs-fix: ## Fix code style
	./bin/php-cs-fixer fix

cs-ci: ## Run Continuous Integration code style check
	./bin/php-cs-fixer fix --dry-run --using-cache=no --verbose

# Help

.PHONY: help
help: ## This help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(TARGETS) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
