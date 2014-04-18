<?php

class ResourceTableSeeder extends Seeder {

	public function run()
	{
		Resource::create(array(
			'name' => 'News index',
			'key' => '9IAH54IX',
			'method' => 'GET',
			'uri' => 'http://localhost/resourceprovider/public/news',
			'config' => json_encode(array()),
		));

		Resource::create(array(
			'name' => 'View voor News index',
			'key' => '9IAH54IY',
			'method' => 'GET',
			'uri' => 'http://localhost/resourceprovider/public/views/news-index',
			'config' => json_encode(array()),
		));
	}

}