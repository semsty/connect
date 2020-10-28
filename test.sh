#!/bin/sh

docker-compose -f docker-compose.yml pull
docker-compose -f docker-compose.yml build
docker-compose -f docker-compose.yml run app vendor/bin/phpunit --verbose --strict-coverage
docker-compose -f docker-compose.yml down
