#ifndef APP_ENV
#	include .env
#endif

test:
	@test -f bin/phpunit || echo "cannot run tests (needs phpunit/phpunit)"
	php bin/phpunit
.PHONY: test
