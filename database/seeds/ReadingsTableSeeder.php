<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReadingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('readings')->truncate();

      DB::table('readings')->insert([
        'sensor_id' => 1,
        'location_id' => 1,
        'user_id' => 1,
        'pm1' => '10',
        'pm25' => '10',
        'pm10' => '10',
        'so2' => '10',
        'o3' => '10',
        'no2' => '10',
        'co' => '10',
        'nh3' => '10',
        'mq135' => '10',
        'gas' => '10',
        'humidity' => '10',
        'temperature' => '10',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ]);
    }
  }
