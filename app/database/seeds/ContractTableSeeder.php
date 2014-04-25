<?php

class ContractTableSeeder extends Seeder {

	public function run()
	{
		Contract::create(array(
			'id' => 1,
			'resource_id' => 3,
			'contract_type_id' => 2,
			'config' => array(),
		));

		Contract::create(array(
			'id' => 2,
			'resource_id' => 5,
			'contract_type_id' => 3,
			'config' => array(),
		));

		Contract::create(array(
			'id' => 3,
			'resource_id' => 6,
			'contract_type_id' => 1,
			'config' => array(),
		));

		Contract::create(array(
			'id' => 4,
			'resource_id' => 9,
			'contract_type_id' => 4,
			'config' => array(),
		));
	}

}