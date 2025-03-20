
# 1. Installation
Clone this repository, then use the following commands:

```
composer install
```

After successful installation of the composer, configure the database
go to the .env file and configure the database with your credentials.
```
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
```

The next step will be to create the database and load the standard configuration for this purpose use the following commands
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load --no-interaction
```

After executing these commands, all you need to do is start the symfony server with the command:
```
symfony serve
```

If you don't have Symfony CLI, database server or composer installed, you can use docker
Build docker images with the command:
```
docker compose build
```

once the images are built, all you have to do is run them
```
docker compose up -d
```

For full configuration, you need to switch to the symfony container shell with the command:
```
docker exec -it symfony bash
```
or
```
docker exec -it symfony sh
```

Then follow the previously mentioned steps
Notice: you don't need to change the data in the .env, because by default it is configured under the data from the docker conener


# 2. Usage
If the installation was successful go to the following endpoint to see the API documentation
```
http://localhost:8000/api/v1/doc
```

You can test all endpoints using postman or the available nelmio documentation.