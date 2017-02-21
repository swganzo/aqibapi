<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSensorsTable extends Migration {

	public function up()
	{
		Schema::create('sensors', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title')->nullable();
			$table->string('mac')->nullable();
			$table->integer('api_id')->unsigned();
			$table->integer('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('sensors');
	}
}
