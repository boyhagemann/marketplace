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
Route::any('/invoke/{resource}', 'ResourceController@invoke');
Route::post('/resolve/{resource}', 'ResourceController@resolve');

Route::get('test', function() {

	return API::post('resolve/9IAH54IY', array(
		'title' => 'Hallo',
		'news' => array(
			'source' => '9IAH54IX',
			'params' => array(),
		),
	));

});

Route::get('test2', function() {

	return API::post('resolve/12345layout', array(
		'title' => 'Hallo layout title',
		'content' => array(
			array(

				'source' => '9IAH54IY',
				'params' => array(
					'title' => 'Hallo',
					'news' => array(
						'source' => '9IAH54IX',
						'params' => array(),
					),
				),
			),
			array(
				'source' => '9IAH54IY',
				'params' => array(
					'title' => 'Hallo',
					'news' => array(
						'source' => '9IAH54IX',
						'params' => array(),
					),
				),
			),
			array(
				'source' => '12345form',
				'params' => array(
					'target' => '12345newsstore',
					'title' => 'Create',
				),
			)
		),
		'sidebar' => array(
			'source' => '9IAH54IY',
			'params' => array(
				'title' => 'Hallo',
				'news' => array(
					'source' => '9IAH54IX',
					'params' => array(),
				),
			),
		),
	));

});

Route::get('test3', function() {

	return API::post('resolve/12345form', array(
		'target' => '12345newsstore',
		'title' => 'Create',
	));

});

Route::get('test4', function() {

	return API::post('resolve/12345layout', array(
		'title' => 'Hallo layout title',
		'content' => array(
			'source' => '12345form',
			'params' => array(
				'target' => '12345newsstore',
				'title' => 'Create',
			),
		),
		'sidebar' => array(),
	));

});