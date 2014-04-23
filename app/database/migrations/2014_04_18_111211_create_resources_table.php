<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->string('name');
			$table->string('key');
			$table->enum('type', array('data', 'template', 'contract'));
			$table->enum('method', array('GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS'));
			$table->string('uri');
			$table->integer('contract_id')->nullable();
			$table->longText('config');

			$table->unique('key');
			$table->index('type');
			$table->index('contract_id');
			$table->unique(array('method', 'uri'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('resources');
	}

}
