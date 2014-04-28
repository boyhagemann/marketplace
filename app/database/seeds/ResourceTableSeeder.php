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
			'contract_id' => 1,
			'uri' => 'http://localhost/resourceprovider/public/news',
		));

		Resource::create(array(
			'id' => 2,
			'name' => 'View voor News index',
			'key' => '9IAH54IY',
			'method' => 'POST',
			'type' => 'template',
			'contract_id' => 1,
			'uri' => 'http://localhost/resourceprovider/public/views/news-index',
		));

		Resource::create(array(
			'id' => 3,
			'name' => 'Contract voor News',
			'key' => '9IAH54IZ',
			'method' => 'GET',
			'type' => 'contract',
			'uri' => 'http://localhost/resourceprovider/public/contracts/news',
		));

		Resource::create(array(
			'id' => 4,
			'name' => 'Layout view',
			'key' => '12345layout',
			'method' => 'POST',
			'type' => 'template',
			'contract_id' => 2,
			'uri' => 'http://localhost/resourceprovider/public/views/layouts.default',
		));

		Resource::create(array(
			'id' => 5,
			'name' => 'Layout contract',
			'key' => '12345layoutcontract',
			'method' => 'GET',
			'type' => 'contract',
			'uri' => 'http://localhost/resourceprovider/public/views/layouts.default',
		));





		Resource::create(array(
			'id' => 6,
			'name' => 'Contract voor news create',
			'key' => '12345newscreatecontract',
			'method' => 'OPTIONS',
			'type' => 'contract',
			'contract_id' => 3,
			'uri' => 'http://localhost/resourceprovider/public/news/create',
		));

		Resource::create(array(
			'id' => 7,
			'name' => 'News store',
			'key' => '12345newsstore',
			'method' => 'POST',
			'type' => 'data',
			'contract_id' => 3,
			'uri' => 'http://localhost/resourceprovider/public/news',
		));

		Resource::create(array(
			'id' => 8,
			'name' => 'Form',
			'key' => '12345form',
			'method' => 'POST',
			'type' => 'template',
			'contract_id' => 4,
			'contract_type_id' => 1,
			'uri' => 'http://localhost/resourceprovider/public/views/form',
		));

		Resource::create(array(
			'id' => 9,
			'name' => 'Form contract',
			'key' => '12345formcontract',
			'method' => 'GET',
			'type' => 'contract',
			'uri' => 'http://localhost/resourceprovider/public/contracts/form',
		));

		Resource::create(array(
			'id' => 10,
			'name' => 'Texteditor',
			'key' => '12345text',
			'method' => 'POST',
			'type' => 'template',
			'uri' => 'http://localhost/resourceprovider/public/texteditor',
		));
	}

}