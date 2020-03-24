#!/bin/bash

docker-compose up -d --build && docker-compose exec -u user backend bash