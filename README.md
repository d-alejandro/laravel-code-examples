## Docker commands
- `docker-compose build --no-cache`
- `docker-compose up -d`
- `docker-compose down`
- `docker-compose ps`
- `docker container exec -it name_php-fpm_1 /bin/sh`

- `docker ps`
- `docker cp <containerId>:/file/path/within/container /host/path/target`

## Run unit tests
```
php artisan test --testsuite=Unit
```

##PHP Unit Testing Coverage
```
./vendor/bin/phpunit --coverage-html ./storage/reports/coverage
```
