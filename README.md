# Laravel Code Examples

## Topics

- Back-end
- Clean Architecture
- Code coverage
- CRUD
- Dependency Injection
- Design Patterns
- Docker Compose
- DTO
- Enums
- Feature tests
- Interfaces
- Laravel 9
- Linux
- Makefile
- Mocking Objects
- MySQL 8
- Nginx
- PHP 8.2
- PHPUnit
- PostgreSQL 16
- Presenters
- Repository Pattern (with criteria queries)
- RESTful API
- SOLID
- SQL
- Unit tests
- Use Cases
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

- `docker-compose build --no-cache`
- `docker-compose up -d`
- `docker-compose exec php-fpm composer install`
- `docker-compose exec php-fpm php artisan key:generate`
- `docker-compose exec php-fpm php artisan migrate`
- `docker-compose exec php-fpm php artisan db:seed`

## Testing

To run the unit tests:
```
docker-compose exec php-fpm php artisan test --testsuite=Unit
```

To run the feature tests:
```
docker-compose exec php-fpm php artisan test --testsuite=Feature
```

To run the test coverage:
```
docker-compose exec php-fpm php artisan test --coverage
```
```
docker-compose exec php-fpm ./vendor/bin/phpunit --coverage-html ./storage/reports/coverage
```

## API Endpoints

### All Orders with pagination
- Request URL: `http://localhost:8081/api/orders?start=0&end=2&sort_column=id&sort_type=asc`
- Method: `GET`
- Path: `/orders`
- Request Parameters: `start, end, sort_column, sort_type`
- Status Code: `200`
- Response:
```json
{
    "data": [
        {
            "id": 10000001,
            "agency_name": "МКК ТверьВектор",
            "status": "prepayment",
            "is_confirmed": true,
            "is_checked": true,
            "rental_date": "21-12-2023",
            "user_name": "Марат Романович Яковлев",
            "transport_count": 3,
            "guest_count": 3,
            "admin_note": "Ну, душа, вот это так!"
        },
        {
            "id": 10000002,
            "agency_name": "ЗАО КазТехРечЛизинг",
            "status": "waiting",
            "is_confirmed": true,
            "is_checked": true,
            "rental_date": "27-12-2023",
            "user_name": "Сергеева Эльвира Андреевна",
            "transport_count": 3,
            "guest_count": 3,
            "admin_note": null
        }
    ]
}
```

### Create Order
- Request URL: `http://localhost:8081/api/orders`
- Method: `POST`
- Path: `/orders`
- Request Parameters: `agency_name, rental_date, guest_count, transport_count, user_name, email, phone`
- Status Code: `201`
- Response:
```json
{
    "data": {
        "id": 10000011,
        "agency_name": "Test Agency Name",
        "status": "waiting",
        "is_confirmed": false,
        "is_checked": false,
        "rental_date": "22-12-2023",
        "user_name": "Test User Name",
        "transport_count": 1,
        "guest_count": 1,
        "admin_note": null,
        "note": null,
        "email": "test@test.ru",
        "phone": "71437854547",
        "confirmed_at": null,
        "created_at": "21-12-2023 12:22:33",
        "updated_at": "21-12-2023 12:22:33"
    }
}
```
