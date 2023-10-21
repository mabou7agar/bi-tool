<h1 align="center">BI Tool Start</h1>

Start all services from a single repository, for local use only.

## Prerequisites
1. [Docker](https://docs.docker.com/install/)
2. [Docker Compose](https://docs.docker.com/compose/install/)
5. The SSH keys set for your GitHub account ([click here][github-ssh-tutorial] if you don't know how to do it)

## First time setup
1- Go to the cloned directory:
```bash
cd bi-tool
```
2- run laravel sail command to run full env in docker:
```bash
./vendor/bin/sail up
```
