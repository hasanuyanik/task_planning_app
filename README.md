# Task Planning App

Application that saves json data from API Endpoints to database. Transactions are done with endpoints in .env file. 

## Technical 

- [Laravel 10]([https://laravel.com/docs/9.x](https://laravel.com/docs/10.x))

## Features

-  Saves json data from API Endpoints to database. 
-  list, create, update, delete, get endpoints.
-  Planning tasks and show localhost in web page.
-  Planning tasks and show in command
-  Saving Json data from API Endpoints to database by running command

Task model actions is done with service-repository pattern.

## Installation

Task Planning App requires [Docker](https://www.docker.com/) to run.

Install the dependencies and devDependencies and start the server.

```sh
cd task-planning-app
sail up -d OR docker-compose up -d
```

Database migration...

```sh
sail artisan migrate
```

## ENV EndPoint Vars Examples

```
MOCK_API_1=https://run.mocky.io/v3/7b0ff222-7a9c-4c54-9396-0df58e289143
MOCK_API_2=https://run.mocky.io/v3/27b47d79-f382-4dee-b4fe-a0976ceda9cd

```
## Saving Json data from API Endpoints to database by running command

```sh
./vendor/bin/sail artisan task:create MOCK_API_1
```

## Planning tasks and show in command

```sh
./vendor/bin/sail artisan task:calculate-plan
```
