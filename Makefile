dev:
	cp .env.example .env
	composer install
	php artisan key:generate
	./vendor/bin/sail up -d
seed:
	./vendor/bin/sail artisan migrate:refresh --seed
test:
	./vendor/bin/sail test
