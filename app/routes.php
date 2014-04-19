<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{

});

Route::bind('resource', function($key) {
	return Resource::where('key', $key)->firstOrFail();
});

Route::resource('/resource', 'ResourceController');
Route::any('/invoke', 'ResourceController@multiple');
Route::any('/invoke/{resource}', 'ResourceController@invoke');
Route::any('/resolve/{resource}', 'ResourceController@resolve');
