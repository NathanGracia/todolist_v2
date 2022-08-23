# ToDo-Co-OC-P8
## Author
Gracia Nathan

## Codacy
I used [codacy](https://app.codacy.com/gh/NathanGracia/todolist_v2/dashboard?branch=main) to check my code quality
## Introduction
This project is the 8th project of the [Developer PHP / Symfony](https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony) formation of [Openclassrooms](https://openclassrooms.com/).

The goal of this project is to upgrade an existing PHP / Symfony 3.1 application. 

The website is a TO DO List App to manage team's tasks. We have to fix anomalies, upgrade to a new Symfony version, add new fixtures, test the code, document and reduce technical debt.

We also need to make UML's diagram's, quality and performance audit and suggest improvements.

## Build with 

-   Symfony 
-   Twig
-   PhpUnit

## Requirements 

-   PHP 8.1
-   Composer
-   Web server
-   MYSQL

## Installation

-   Clone / Download the project
-   Configure your web server to point on the project directory
-   Composer install
-   Copy the .env.template file and rename it to .env 
-   Edit the .env file to connect it with your database server
-   Run the command to create the database :  `php bin/console doctrine:database:create`

## Test - PhpUnit

-   Edit your .env file with test data
-   Create the test database :  `php bin/console doctrine:database:create`
-   Load Fixtures : `php bin/console doctrine:fixtures:load --env=test`
-   Run test : `vendor/bin/phpunit --coverage-html public/code-coverage`