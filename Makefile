#ifndef APP_ENV
#	include .env
#endif

# Tests

unit:
	@test -f bin/phpunit || echo "cannot run unit tests (needs phpunit/phpunit)"
	php bin/phpunit --testdox tests
.PHONY: unit

features:
	@test -f bin/behat || echo "cannot run tests (needs behat/behat)"
	php bin/behat
.PHONY: test

test: unit features
.PHONY: test

# Coding Style

cs:
	./bin/php-cs-fixer fix --dry-run --stop-on-violation --diff

cs-fix:
	./bin/php-cs-fixer fix

cs-ci:
	./bin/php-cs-fixer fix --dry-run --using-cache=no --verbose
