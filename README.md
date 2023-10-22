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

2- run laravel sail command to run full env in docker:
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

3- run laravel sail command to run full env in docker:
```bash
sail up
```

4- to run queue 
```bash
 sail artisan queue:work  
```

php artisan jwt:secret
