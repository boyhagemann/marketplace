## Install

First install [ResourceProvider] (boyhagemann/resourceprovider) as a separate application. 
The location must point to http://localhost/resourceprovider/public (because of database seeds).

* install like a standard laravel/laravel project
* add a `.env.php` or `.env.local.php` file containing the following keys:
  - DB_HOST
  - DB_NAME
  - DB_USER
  - DB_PASS
* in cmd call `php artisan migrate` (or `php artisan migrate:refresh`) for existing database)
* then `php artisan db:seed`

