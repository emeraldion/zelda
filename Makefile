.PHONY: docs test install update

update:
	php ~/dev/tools/php-composer/composer.phar update
install:
	php ~/dev/tools/php-composer/composer.phar install
create_test_db:
	mysql -u root -p < schemas/zelda_test.sql
test: install
	vendor/bin/phpunit --test-suffix=.test.php test/unit
docs:
	doxygen Doxyfile
