# Exads Challenge

##### This project was originally started on https://github.com/rodolfodanielsa/exads-old.git.

## Setup

### Clone project
`git clone https://github.com/rodolfodanielsa/exads-challenge.git`

### Setup Docker Containers
`cd exads-challenge`

Copy `.env.[OS]` to `.env` according to your Operating System

`docker-compose up -d`

Run Composer Install

`docker exec php composer install`

Execute Migrations

`docker exec php php bin/console doctrine:migrations:migrate`

## Tests

Run `docker exec php php bin/phpunit`

## Exercises

### Prime number

`docker exec php php bin/console app:prime-number`

### Ascii Array

`docker exec php php bin/console app:ascii-array`

### TV Series
- Import Data

`docker exec php php bin/console app:tvseries:import`

- Execute command

`docker exec php php bin/console app:tvseries:next`

- With Specific Date

`docker exec php php bin/console app:tvseries:next --date="Y-m-d H:i"`

- With Specific Title

`docker exec php php bin/console app:tvseries:next --title="Some Title"`

- With Specific Date and Title

`docker exec php php bin/console app:tvseries:next  --date="Y-m-d H:i" --title="Some Title"`

### A/B Testing

- Execute command without promotion ID (1 is the default)

`docker exec php php bin/console app:ab-testing`

- With input promotion ID

`docker exec php php bin/console app:ab-testing --promoId=2`

## Environment

### url
http://localhost:8080/

### ports

- php: 9000
- nginx: 8080
- mysql: 3306

### database

- host: 127.0.0.1
- username: user
- password: pass
- database: tvdb
- port: 3306
