<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserInfosTable extends Migration {

	public function up()
	{
		Schema::create('user_infos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->timestamps();
			$table->string('country')->nullable();
			$table->string('city')->nullable();
			$table->string('district')->nullable();
			$table->string('address_1')->nullable();
			$table->string('address_2')->nullable();
			$table->string('zipcode')->nullable();
			$table->string('phone')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('user_infos');
	}
}