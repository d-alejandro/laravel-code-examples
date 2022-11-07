# Laravel Code Examples

## Topics

- Back-end
- Code coverage
- CRUD
- Design Patterns
- Docker
- DTO
- Feature tests
- Laravel 9
- Linux
- Makefile
- Mocking Objects
- MySQL 8
- Nginx
- PHP 8.1
- PHPUnit
- RESTful API
- SOLID
- SQL
- Unit tests
- Xdebug

## Installation

1. Clone this repository:
```
git clone git@github.com:d-alejandro/laravel-code-examples.git
```
2. Go to 'laravel-code-examples' directory:
```
cd laravel-code-examples
```
3. Create a new .env file:
```
cp .env.example .env
```
4. Run following commands:

- `docker-compose build`
- `docker-compose up -d`
- `docker-compose exec php-fpm composer install`
- `docker-compose exec php-fpm php artisan migrate`

### Run unit tests
```
docker-compose exec php-fpm php artisan test --testsuite=Unit
```

### PHP Unit Testing Coverage
```
docker-compose exec php-fpm ./vendor/bin/phpunit --coverage-html ./storage/reports/coverage
```
