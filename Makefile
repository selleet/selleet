#ifndef APP_ENV
#	include .env
#endif

test:
	@test -f bin/behat || echo "cannot run tests (needs behat/behat)"
	php bin/behat
.PHONY: test
