# Hallapandur

## A Propos

This app is used to organize event for the Hallapandur association
## Installation
1. Clone or Download the repo
2. Install composer and execute `composer install` in the project folder
3. Install nodejs and execute `npm install` in the project folder
4. Edit `.env` and line 27, enter your database informations
5. Execute `php bin/console doctrine:database:create`
6. Execute `php bin/console doctrine:migrations:migrate`
7. Execute `php bin/console doctrine:fixtures:load`
8. (Optional) Start the internal server with `php bin/console server:start`