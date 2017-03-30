<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sensors')->truncate();

      $users = User::pluck('id');

      foreach ($users as $id) {
        DB::table('sensors')->insert([
          'title' => 'Sensor'.$id,
          'mac' => str_random(10),
          'api_key' => bcrypt('kenzo'),
          'user_id' => $id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ]);
      }
    }
  }
