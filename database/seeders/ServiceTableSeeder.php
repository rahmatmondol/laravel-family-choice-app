<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Service::create([
      'ar' => ['title' => 'وجبات اطفال'],
      'en' => ['title' => 'kids meals'],
      'status' => 1,
    ]);

    Service::create([
      'ar' => ['title' => 'رعاية صحية'],
      'en' => ['title' => 'Health Care'],
      'status' => 1,
    ]);

    Service::create([
      'ar' => ['title' => 'وسائل نقل'],
      'en' => ['title' => 'Means of transport'],
      'status' => 1,
    ]);
  }
}
