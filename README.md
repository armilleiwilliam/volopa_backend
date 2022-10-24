

## About the project
You find details instructions about the project and installation on the front end code.
Rates in the seeder are absolutely fake, surely they don't reflect the reality.
## Versions
Laravel 9, PHP 8 (if you are running the project on a php 7 version just remove the double return type 
on ExchangeRate Model at the function findRate)

## Laravel back end installation:
(You find these same instructions on the front end readme file app as well)
##### git clone git@github.com:armilleiwilliam/volopa_backend.git
##### env. file: set database connections
##### composer install
##### php artisan migrate:refresh --seed
(this command creates tables and populate them with rates data and login details needed for the project,
the rates are totally invented)
#### php artisan serve
#### if you click on the link provided it might suggest to click on "Generate App Key" button and refresh the page


