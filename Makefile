setuptest:
	php bin/console doctrine:database:drop --force --env=test --if-exists
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:create --env=test
	php bin/console doctrine:fixtures:load --env=test --no-interaction

setupdevtest:
	php bin/console doctrine:database:drop --force --env=dev --if-exists
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:create --env=dev
	php bin/console doctrine:fixtures:load --env=dev --no-interaction

test:
	testcafe chrome tests/testcafe --skip-js-errors --debug-on-fail