<?php

class ContractTypeTableSeeder extends Seeder {

	public function run()
	{
		ContractType::create(array(
			'id' => 1,
			'title' => 'Form',
			'name' => 'form',
		));

		ContractType::create(array(
			'id' => 2,
			'title' => 'List',
			'name' => 'list',
		));

		ContractType::create(array(
			'id' => 3,
			'title' => 'Template',
			'name' => 'template',
		));

	}

}