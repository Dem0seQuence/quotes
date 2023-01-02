# Quotes

## Requirement
Github repository: [twiscard/techtest](https://github.com/twiscard/techtest)

## How to boot the project
- Make sure Docker is up and running
- run `make dev`
- run `make seed` (optional)

#### Solution for common issues
- Adjust local dns: `awesomequotesapi.test` hostname to your localhost ip (`/etc/hosts` for unix based systems or `c:\Windows\System32\Drivers\etc\hosts` for windows)
- Adjust .env file if `http`, `mysql`, `redis` or `rabbitmq` service ports are already in use
    - http port: APP_PORT
    - mysql port: FORWARD_DB_PORT
    - redis port: FORWARD_REDIS_PORT
    - rabbitmq management plugin port: FORWARD_RABBITMQ_MANAGEMENT_PORT

## Available endpoints
- http://awesomequotesapi.test:8082/shout/<author>?limit=<limit>
### Examples
- [http://awesomequotesapi.test:8082/shout/steve-jobs?limit=2](http://awesomequotesapi.test:8082/shout/steve-jobs?limit=2)

## Available commands
- Get author shouted quotes using `./vendor/bin/sail artisan quotes:shout author --limit=limit`
### Examples
- `./vendor/bin/sail artisan quotes:shout steve-jobs --limit=2`

## Tests
 Running tests:
- `make test`
