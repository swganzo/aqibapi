<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReadingsTable extends Migration {

	public function up()
	{
		Schema::create('readings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('sensor_id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->integer('api_id')->unsigned();
			$table->string('pm1')->nullable();
			$table->string('pm25')->nullable();
			$table->string('pm10')->nullable();
			$table->string('so2')->nullable();
			$table->string('o3')->nullable();
			$table->string('no2')->nullable();
			$table->string('co')->nullable();
      $table->string('humidity')->nullable();
			$table->string('temperature')->nullable();
			$table->string('nh3')->nullable();
			$table->text('other')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('readings');
	}
}
