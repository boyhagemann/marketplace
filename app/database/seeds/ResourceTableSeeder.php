<?php

class ResourceTableSeeder extends Seeder {

	public function run()
	{
		Resource::create(array(
			'id' => 1,
			'name' => 'News index',
			'key' => '9IAH54IX',
			'method' => 'GET',
			'type' => 'data',
			'uri' => 'http://localhost/resourceprovider/public/news',
			'contract_id' => 3,
			'config' => json_encode(array()),
		));

		Resource::create(array(
			'id' => 2,
			'name' => 'View voor News index',
			'key' => '9IAH54IY',
			'method' => 'POST',
			'type' => 'template',
			'uri' => 'http://localhost/resourceprovider/public/views/news-index',
			'contract_id' => 3,
			'config' => json_encode(array()),
		));

		Resource::create(array(
			'id' => 3,
			'name' => 'Contract voor News',
			'key' => '9IAH54IZ',
			'method' => 'GET',
			'type' => 'contract',
			'uri' => 'http://localhost/resourceprovider/public/contracts/news',
			'config' => json_encode(array()),
		));

		Resource::create(array(
			'id' => 4,
			'name' => 'Layout view',
			'key' => '12345layout',
			'method' => 'POST',
			'type' => 'template',
			'uri' => 'http://localhost/resourceprovider/public/views/layouts.default',
			'contract_id' => 5,
			'config' => json_encode(array()),
		));

		Resource::create(array(
			'id' => 5,
			'name' => 'Layout contract',
			'key' => '12345layoutcontract',
			'method' => 'GET',
			'type' => 'contract',
			'uri' => 'http://localhost/resourceprovider/public/contracts/layout',
			'config' => json_encode(array()),
		));
	}

}