.PHONY: docs test install update

update:
	php ~/dev/tools/php-composer/composer.phar update
install:
	php ~/dev/tools/php-composer/composer.phar install
test: install
	vendor/bin/phpunit test/unit/test_antispam.php
docs:
	doxygen Doxyfile
