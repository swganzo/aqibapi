<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('locations')->truncate();

      DB::table('locations')->insert([
        'user_id' => 1,
        'sensor_id' => 1,
        'lat' => '47.913868',
        'lon' => '106.908141',
        'ip' => '127.0.0.1',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ]);
    }
  }
