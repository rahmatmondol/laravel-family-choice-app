<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Customer::create([
      'full_name' => "mahmoud ahmed",
      'email'    => "m@g.com",
      'phone' => "0100",
      'password' => bcrypt('123456'),
      'gender' => "male",
      'image' => "default.png",
      'verified' => 1,
      'status' => 1,
      'city_id' => City::first()?->id,
    ]);
  }
}
