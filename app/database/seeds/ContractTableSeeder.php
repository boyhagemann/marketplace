<?php

class ContractTableSeeder extends Seeder {

	public function run()
	{
		Contract::create(array(
			'id' => 1,
			'resource_id' => 3,
			'type' => 'list',
			'config' => array(),
		));

		Contract::create(array(
			'id' => 2,
			'resource_id' => 5,
			'type' => 'template',
			'config' => array(),
		));
	}

}