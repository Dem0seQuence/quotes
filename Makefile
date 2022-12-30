dev:
	cp .env.example .env
	php artisan key:generate
	composer install
	./vendor/bin/sail up -d
seed:
	./vendor/bin/sail artisan migrate:refresh --seed
