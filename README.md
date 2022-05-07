# Work in Progress

##

# translator-api
This project consists of applying translations in text, being able to convert the same to .json and .php files using a system between key and value to be used in translations of other applications.

# Build and configure Docker 🐋

To build docker container you need open terminal on folder of your application and execute this command:

```
docker-compose up -d --build
```

After the construction of the container is finished, it is necessary to install composer and for that we need to enter the container. Run:

```
docker-compose exec app bash
```

After that we need install composer. Make sure you are inside the container and run:

```
composer install
```

Build and confiration done. 👌

If you need enter in container with root just run:

```
docker-compose exec -uroot app bash
```

# Testing application

To make sure application is on go to url:

```
localhost:9050/api/
```
