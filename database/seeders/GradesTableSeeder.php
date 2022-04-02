<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Grade::create([
      'ar' => ['title' => 'الاول الابتدائي'],
      'en' => ['title' => 'first primary'],
      'status' => 1,
    ]);

    Grade::create([
      'ar' => ['title' => 'الثاني الابتدائي'],
      'en' => ['title' => 'second primary'],
      'status' => 1,
    ]);

    Grade::create([
      'ar' => ['title' => 'الثالث الابتدائي'],
      'en' => ['title' => 'third primary'],
      'status' => 1,
    ]);
  }
}
