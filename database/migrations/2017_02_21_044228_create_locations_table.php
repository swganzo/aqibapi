<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration {

	public function up()
	{
		Schema::create('locations', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('sensor_id')->unsigned();
			$table->string('lat')->nullable();
			$table->string('lon')->nullable();
			$table->string('ip')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('locations');
	}
}
