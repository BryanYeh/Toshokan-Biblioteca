#!/bin/bash

path=$(printf '%s\n' "${PWD##*/}")
command="docker-compose exec app php "$@""
echo "Running php on docker app: "
$command
