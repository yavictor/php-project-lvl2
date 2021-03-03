install:
	composer install

validate:
	composer validate

lint:
	composer run-script phpcs -- --standard=PSR12 src bin tests

test:
	composer exec --verbose phpunit tests