
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>  
  
<p align="center">  
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>  
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>  
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>  
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>  
</p>  
  
## About Laravel Logs Importer  
Logs importer, is way to insert logs file data to the database.
this is implements new custom console command in laravel application and REST API to access `api/v1/logs/count`
endpoint.
For implements REST API usage once of design patterns to handle filter parameters.
This design pattern is "Chain of responsibility" to implements filter by params and open extension or close modification main `Filter` class.

*Please see this directory or submodule: `app/Http/Controllers/Logs/Filters`*
  
## *Assigned tasks to me:*
  
 - Create a console command that parses the log file and inserts the data into the  
database.  
 - Design a REST API endpoint `/logs/count` which returns a count of rows that match the  
filter criteria. This endpoint accepts filters via GET HTTP verb and allows zero or more filter  
parameters.  
  
#### *The filter include:*  
  
 - serviceName  
 - statusCode  
 - startDate  
 - endDate  
  
## *The result of `/logs/count` is*:  
`{"count" : 50}`  
  
# Infrustructure

### Model, Controller, Job, Factory, and Seeder:  
 - Model/Log
 - Controllers/Logs/LogController
 - Jobs/ImportLog
 - database/factories/LogFactory
 - database/seeders/LogsTableSeeder 

### implemented with Queue and Job  
  
At the time of executing the above command, firstly, the content of the file is analyzed using a number of helper functions, and then for the insert operation, I have used a Job to import the microservice report.  
The job name is `ImportLog` 

# Usage

#### Work with `LogsImporterCommand`:
`php artisan migrate`
`php artisan db:seed`

*Before usage of console command, please enter in terminal:*
`php artisan queue:work --tries=3`

*Then open new terminal window, replaced `__FILE_PATH__` with logs.txt file path, and enter below command:*
`php artisan logs:import __FILE_PATH__`

#### Work with REST API:
with `GET` HTTP verb send request to `http://127.0.0.1:8000/api/v1/logs/count`:

*Available filter parameters:*
- 
- serviceName
- statusCode  
- startDate  
- endDate
 
 *cURL example:*
 
    curl --location 'http://127.0.0.1:8000/api/v1/logs/count?serviceName=order-service'


# Feature tests

#### Command

*Please, enter `LOGS_FILE_PATH` into .env. needs setup for running test!*

`php artisan test --filter LogsImporterCommandTest`

#### REST API

`php artisan test --filter LogsCountEndpointTest`


## Other tests I would include with more time:

- I would write unit tests to check helper functions likes: `app/Utils/LogParserHelper.php` and `app/helpers.php`
- I would write unit tests to check secure header params in REST API for `logs/count` endpoint! 
- if i had more time, implements jwt to use for authentication user and add user access token endpoint to check roles and access level and write related tests for this.
- etc...

##### Thank you so much
