#!/bin/sh
set -eu

cd "$(dirname "$0")/.."

docker compose up -d --build

echo "Aplicacao disponivel em http://localhost:8000"
