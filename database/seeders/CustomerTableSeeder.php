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
    if (empty(Customer::where('email', 'm@g.com')->first())) {
      Customer::create([
        'full_name' => "mahmoud ahmed ",
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

    for ($i = 0; $i < 20; $i++) {
      $randValue = $i . rand(1, 100);
      Customer::create([
        'full_name' => "mahmoud ahmed " . $randValue ,
        'email'    => $randValue . "m@g.com",
        'phone' => $randValue ."0100",
        'password' => bcrypt('123456'),
        'gender' => "male",
        'image' => "default.png",
        'verified' => 1,
        'status' => 1,
        'city_id' => City::first()?->id,
      ]);
    }
  }
}
