<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitiesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    City::create([
      'ar' => ['title' => 'القاهرة'],
      'en' => ['title' => 'Cairo'],
      'status' => 1,
    ]);

    City::create([
      'ar' => ['title' => 'الجيزة'],
      'en' => ['title' => 'Giza'],
      'status' => 1,
    ]);

    City::create([
      'ar' => ['title' => 'اسيوط'],
      'en' => ['title' => 'assuit'],
      'status' => 1,
    ]);
  }
}
