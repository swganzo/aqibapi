<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->truncate();

      DB::table('users')->insert([
        'name' => 'Kenzo',
        'email' => 'swganzo@gmail.com',
        'password' => app('hash')->make('kenzo'),
        'remember_token' => str_random(10),
        'level' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ]);
    }
  }
