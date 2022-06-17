<?php

namespace Database\Seeders;

use App\Models\School;
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

    $school = School::first();
    Slider::create([
      'ar'            => ['title' => 'فاميلي شويس', 'description' => 'افضل ابلكيشن للبحث عن المدارس'],
      'en'            => ['title' => 'family choice', 'description' => 'The best application to search for schools'],
      'status'        => 1,
      'image'         => 'default.png',
      'order_column'  => rand(1, 10),
      'school_id'     => $school->id
    ]);

    Slider::create([
      'ar'            => ['title' => 'فاميلي شويس', 'description' => 'افضل ابلكيشن للبحث عن المدارس'],
      'en'            => ['title' => 'family choice', 'description' => 'The best application to search for schools'],
      'status'        => 1,
      'image'         => 'default.png',
      'order_column'  => rand(1, 10),
      'school_id'     => $school->id
    ]);

    Slider::create([
      'ar'            => ['title' => 'فاميلي شويس', 'description' => 'افضل ابلكيشن للبحث عن المدارس'],
      'en'            => ['title' => 'family choice', 'description' => 'The best application to search for schools'],
      'status'        => 1,
      'image'         => 'default.png',
      'order_column'  => rand(1, 10),
      'school_id'     => $school->id
    ]);
  }
}
