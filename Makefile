#ifndef APP_ENV
#	include .env
#endif

.PHONY: clear-stores
clear-stores:
	rm var/tests/eventstore/*.txt

# Tests

.PHONY: unit features test
unit:
	@test -f bin/phpunit || echo "cannot run unit tests (needs phpunit/phpunit)"
	php bin/phpunit --testdox tests

features:
	@test -f bin/behat || echo "cannot run tests (needs behat/behat)"
	php bin/behat

test: unit features

# Coding Style

.PHONY: cs cs-fix cs-ci
cs:
	./bin/php-cs-fixer fix --dry-run --stop-on-violation --diff

cs-fix:
	./bin/php-cs-fixer fix

cs-ci:
	./bin/php-cs-fixer fix --dry-run --using-cache=no --verbose
