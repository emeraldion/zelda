.PHONY: docs test install update

update:
	php ~/dev/tools/php-composer/composer.phar update
install:
	php ~/dev/tools/php-composer/composer.phar install
test: install
	vendor/bin/phpunit --test-suffix=.test.php test/unit
docs:
	doxygen Doxyfile
