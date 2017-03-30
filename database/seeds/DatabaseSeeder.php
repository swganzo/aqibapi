<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
    $this->call(UsersTableSeeder::class);
    $this->call(SensorsTableSeeder::class);
    $this->call(LocationsTableSeeder::class);
		$this->call(ReadingsTableSeeder::class);
  }
}