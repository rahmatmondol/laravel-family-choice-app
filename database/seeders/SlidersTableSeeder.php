<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SlidersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Slider::create([
      'ar' => ['title' => 'فاميلي شويس', 'description' => 'افضل ابلكيشن للبحث عن المدارس'],
      'en' => ['title' => 'family choice', 'description' => 'The best application to search for schools'],
      'status' => 1,
      'image' => 'default.png',
    ]);

    Slider::create([
      'ar' => ['title' => 'فاميلي شويس', 'description' => 'افضل ابلكيشن للبحث عن المدارس'],
      'en' => ['title' => 'family choice', 'description' => 'The best application to search for schools'],
      'status' => 1,
      'image' => 'default.png',
    ]);

    Slider::create([
      'ar' => ['title' => 'فاميلي شويس', 'description' => 'افضل ابلكيشن للبحث عن المدارس'],
      'en' => ['title' => 'family choice', 'description' => 'The best application to search for schools'],
      'status' => 1,
      'image' => 'default.png',
    ]);
  }
}
