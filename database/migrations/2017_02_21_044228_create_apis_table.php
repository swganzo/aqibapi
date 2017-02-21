<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApisTable extends Migration {

	public function up()
	{
		Schema::create('apis', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->string('key');
		});
	}

	public function down()
	{
		Schema::drop('apis');
	}
}