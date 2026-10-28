#!/bin/sh
set -eu

cd "$(dirname "$0")/.."

if [ ! -f .env ]; then
    cp .env.example .env
fi

mkdir -p database
touch database/database.sqlite

docker compose build

if ! grep -q '^APP_KEY=base64:' .env; then
    docker compose run --rm app php artisan key:generate --force
fi

docker compose run --rm app php artisan migrate --force
