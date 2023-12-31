<h1 align="center">BI Tool Start</h1>

## Summery
1. This Project for scraping Hotels rate per night and store there history for rate comparing
2. Every day, there is an ingestion service that runs at 1AM EST. for whole hotel rate from today to next year ( Using Cron Job and Queue )
3. There is a Dashboard has Line Chart and Paginated Table to Show the Changes in rate for every hotel for specified date
4. I have assumed That Hotel Scraping has no relation to the number of customers exists

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
2- Clone Env Config
```bash
cp .env.example .env
```

3- if you have Composer installed with PHP 8.2 you can just run 
```bash
composer install
```

Or you run this command to install the composer dependencies using small docker image
```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```

4- run this command to use sail command:
```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

5- this will build all needed containers:
```bash
sail build --no-cache
```

6- this will create and start the containers:
```bash
sail up -d
```

7- run this command to setup the seeders and all needed migrations to your system
```bash
make setup
```
##Dashboard
While my main stack is laravel is used `Filament php` Dashboard to support with simple FE side
you can access it using
```bash
http://localhost/admin
```
Default Users
- Emails : c1@bi.com , c2@bi.com , c3@bi.com , c4@bi.com
- Password : password

##Api
I have made sample for api you can download it from postman folder at repo
```bash
https://api.postman.com/collections/2661015-3e508dd2-f7d6-439c-828b-5b059bdd7e4d?access_key=PMAT-01HDD9X5F33PK8FCA3X72AYTZM
```

##Structure
All application files will be under app folder we have the following
1. **Console**
    1. Contains Custom Commands to be called like php artisan ScrapeHotelsCommand
    2. Contains Kernel that where we can configure schedules and import the commands

2. **Data** - it contains Data Classes
    * Data classes are used to return well-structured data for a payload.
    * Data classes are very useful to transfer data between the system components in a maintainable way

3. **DTOs**
    * DTO (Data Transfer Object) is a simple utility and a small component that can be used to transfer data
      between the outside world to the inside world of either the Domain or the Module.

4. **Exception** - Here where we create our custom exceptions

5. **Handlers** - Used to make an action without need any feedback delete action for example or run a statement

6. **Http**
    1. Controllers ( Contains the controllers that use to handle outside requests and the presentation of data and communicating with routes,services to make the request )
    2. Middleware ( Convenient mechanism for inspecting and filtering HTTP requests entering the application like how we use it at Auth )
    3. Requests ( Where we create the expected requests and define their rules )
    4. Kernel ( The place where we define the middlewares )

7. **Jobs** - Here we create the jobs needed to be dispatched in the Queues.

8. **Models** - Contains all of your Eloquent model classes

9. **Presenters**
    * Instead of outputting all the model fields and their loaded relationship,
    * We can basically format that to an agreed structure that will output only the needed data and also rename fields
    * To be more convenient than the original names in models or datasets
    * We use AbstractPresenter to make Presenter support both Collection or single item

10. **Providers** - Service providers are the central place to configure the application

11. **Repositories** - provides an abstraction layer between the application logic and the data persistence layer
    * We can say this is a middle man the handle the communication between Services and the Models

12. **Services** - Services are the basic classes to run logic.

13. **Database**
    1. Migration - Migrations are like version control for your database, allowing your team to modify and share the application's database schema
    2. Factories - define database records in a predictable and easily replicable way
    3. Seeders - the ability to seed your database with data using seed classes

14. **Routes** - The route is a way of creating a request URL for your application

## What's Happening With Docker File
1. Setting Server Timezone to EST
2. Install Cron Job
3. Initialize Scheduler ( That schedule for laravel use cronjob )
4. Installing PHP 8.2 CLI With PHP Extensions
5. Install Composer
6. Install Node
7. Install MySql Client
8. Copy php.ini ( Has php configurations ) and supervisord.conf ( Described Below ) to image

## What is the use of Supervisord
The main purpose of using Supervisord that make sure that process never die and all programs assigned always alive like:
1. [program:php] run the php service at port 80
2. [program:cron] run the cron job
3. [program:laravel-worker] run laravel worker for Queue system

you can find more about it
```bash
https://filamentphp.com/docs
```

## Telescope
I Have installed telescope for tracing and debugging purpose you can reach it using
```bash
http://localhost/telescope
```

You Can See My Expalnation using loom link below
https://www.loom.com/share/ae46f01413cb46e5870aa3c8e655f19a

## The End xD
This is a sample to produce the technical abilities please don't hasitate to ask me if there is any info needed