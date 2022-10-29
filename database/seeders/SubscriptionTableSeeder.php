<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Subscription::create([
      'en' => ['title' => 'One Term', 'short_description' =>  'Three Months'],
      'ar' => ['title' => 'ترم واحد', 'short_description' =>  'ثلاثة شهور'],
      'status' => 1,
    ]);

    Subscription::create([
      'en' => ['title' => 'Tow Terms', 'short_description' =>  '6 Months'],
      'ar' => ['title' => 'ترمين', 'short_description' =>  '6 شهور'],
      'status' => 1,
    ]);

    Subscription::create([
      'en' => ['title' => 'Complete Year', 'short_description' =>  '12 Months'],
      'ar' => ['title' => 'سنة كاملة', 'short_description' =>  '12 شهر'],
      'status' => 1,
    ]);

  }
}
