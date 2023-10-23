<h1 align="center">BI Tool Start</h1>

Start all services from a single repository, for local use only.

## Prerequisites
1. [Docker](https://docs.docker.com/install/)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. The SSH keys set for your GitHub account ([click here][github-ssh-tutorial] if you don't know how to do it)
4. if you are using Docker Desktop for Linux, you should execute the following command. If you are not using Docker Desktop for Linux, you may skip this step:
```bash
 docker context use default
```
## First time setup
1- Go to the cloned directory:
```bash
cd bi-tool
```
2- run this command to install the composer dependencies
```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```

2- run this command to use sail command:
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

3- this will build all needed containers:
```bash
sail build --no-cache
```

4- this will create and start the containers:
```bash
sail up -d
```

5- run this command to setup the seeders and all needed migrations to your system
```bash
make setup
```
