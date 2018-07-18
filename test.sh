#!/bin/sh

docker-compose -f tests/docker-compose.yml pull
docker-compose -f tests/docker-compose.yml build
docker-compose -f tests/docker-compose.yml run app vendor/bin/phpunit --verbose --strict-coverage
docker-compose -f tests/docker-compose.yml down
