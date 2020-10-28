#!/bin/sh

export CONNECT_CORE_DIR="/app"
tests/app/docker/wait-for-it.sh $POSTGRES_HOST:$POSTGRES_PORT \
&& php tests/yii pgsql-migrate/up --interactive=0 \
&& exec "$@"
