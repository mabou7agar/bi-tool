<h1 align="center">BI Tool Start</h1>

## Summery
1. This Project for scraping Hotels rate per night and store there history for rate comparing
2. Every day, there is an ingestion service that runs at 1AM EST. for whole hotel rate from today to next year ( Using Cron Job and Queue )
3. There is a Dashboard has Line Chart and Paginated Table to Show the Changes in rate for every hotel for specified date

#How ot works
1. Scrape Hotels data every day at 1 AM EST using Laravel Scheduler
2. Dispatch Job to create a Queue for number of hotels per Queue pre-defined ( Currently Defined By 2 For Testing Purpose )
3. After Fetch The Data I Have Created 2 Tables to handle this in most cases I can merge this 2 tables if not needed :
   1. hotel_stay_rates
   2. hotel_stay_rates_histories
4. The Reason of creating 2 tables to make DB faster while at normal case we will communicate with hotel_stay_rates to get the latest rate for the hotel instead of search at from application start date and protect from table and column lock for any reason
5. When we fetch data it updates the rates or create if not exist at hotel_stay_rates table then clone all updates using one query to hotel_stay_rates_histories ( In Queue )
6. Then we can search for all related history for single date of stay using foreign_key (old_uuid) could be renamed to parent_id and get the history for this Hotel
7. I decided to keep hotel name instead of passing the hotel id to reduce joining between tables while we are handle a big dataset

## Prerequisites
1. [Docker](https://docs.docker.com/install/)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. The SSH keys set for your GitHub account
4. OrbStack recommend for Mac users
5. if you are using Docker Desktop for Linux, you should execute the following command. If you are not using Docker Desktop for Linux, you may skip this step:
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

3- run this command to use sail command:
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

4- this will build all needed containers:
```bash
sail build --no-cache
```

5- this will create and start the containers:
```bash
sail up -d
```

6- run this command to setup the seeders and all needed migrations to your system
```bash
make setup
```
Login to admin dashboard using
```bash
http://localhost/admin
```
I have made sample for api you can download it from postman folder at repo
```bash
https://api.postman.com/collections/2661015-3e508dd2-f7d6-439c-828b-5b059bdd7e4d?access_key=PMAT-01HDD9X5F33PK8FCA3X72AYTZM
```

# What's Happening With Docker File
1. Setting Server Timezone to EST
2. Install Cron Job
3. Initialize Scheduler ( That schedule for laravel use cronjob )
4. Installing PHP 8.2 CLI With PHP Extensions
5. Install Composer
6. Install Node
7. Install MySql Client
8. Copy php.ini ( Has php configurations ) and supervisord.conf ( Described Below ) to image

# What is the use of Supervisord
The main purpose of using Supervisord that make sure that process never die and all programs assigned always alive like:
1. [program:php] run the php service at port 80
2. [program:cron] run the cron job
3. [program:laravel-worker] run laravel worker for Queue system

#Dashboard
While my main stack is laravel is used `Filament php` Dashboard to support with simple FE side 
you can access it using
```bash
http://localhost/admin
```
you can find more about it
```bash
https://filamentphp.com/docs
```

#Telescope
I Have installed telescope for tracing and debugging purpose you can reach it using
```bash
http://localhost/telescope
```