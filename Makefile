.PHONY: docs test

test:
	/usr/bin/find test -name test_* -exec php {} \;
docs:
	doxygen