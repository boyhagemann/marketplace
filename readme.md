## Install

First install [ResourceProvider] (boyhagemann/resourceprovider) as a separate application. 
The location must point to http://localhost/resourceprovider/public (because of database seeds).

* in cmd call `php artisan migrate` (or `php artisan migrate:refresh`) for existing database)
* then `php artisan db:seed`

