# leaveMS
## Features:
* Authenticate users(login/signup/logout)
* Role: super-admin, hr and employees
* CRUD  User 
* CRUD  Leave Type 
* GET and display paginated lists of Employees and Employee Leave requests
* Approve or declined leave requests
* 
-----------
# Getting started
## Installation
Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x#installation)
- Clone the repository
```
    git clone  <git hub template url> <project_name>
```
- Switch to the repo folder
```
    cd <project_name>
```
- Install all the dependencies using composer
```
   composer install
```
Copy the example env file and make the required configuration changes in the .env file
```
   cp .env.example .env
```
Generate a new application key
```
   php artisan key:generate
```
Run the database migrations (**Set the database connection in .env before migrating**)
```
   php artisan migrate
```
Start the local development server
```
  php artisan serve
```
You can now access the server at http://localhost:8000
**TL;DR command list**

    git clone https://github.com/RanaAlhuniess/leaveMS.git
    cd leaveMS
    composer install
    cp .env.example .env
    php artisan key:generate
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users and leave Types. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the Factory files and set the property values as per your requirement

    database/factories/UserFactory.php
    database/factories/LeaveTypeFactory.php

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
## Dependencies
Laravel Passport for authentication
## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

