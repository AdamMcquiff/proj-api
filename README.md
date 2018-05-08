# _Proj_ API

_Proj_ is a highly customisable and queryable project management tool aimed at small and medium-sized enterprise consultancies. The application was developed in completion of a BSc Computer Science at the University of Sunderland.

This repo hosts the project RESTful API, built upon Laravel with Dingo API. 

The API handles _Proj_'s authentication, CRUD operations and any other database interactions.

Authentication is handled with JSON Web Tokens (JWT) as opposed to any session-based alternatives, leveraging an auth guard on the appropriate routes for security. 

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/AdamMcquiff/proj-api.git

Switch to the repo folder

    cd proj-api

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes (e.g. database credentials) in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations

    php artisan migrate

Run the database seeder (for User Roles)

    php artisan db:seed
    
Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
