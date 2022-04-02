<?php

namespace Database\Seeders;

use App\Models\EducationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationTypesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    EducationType::create([
      'ar' => ['title' => 'شراكة'],
      'en' => ['title' => 'partnership'],
      'status' => 1,
    ]);

    EducationType::create([
      'ar' => ['title' => 'خاص'],
      'en' => ['title' => 'private'],
      'status' => 1,
    ]);

    EducationType::create([
      'ar' => ['title' => 'حضانة'],
      'en' => ['title' => 'nursery'],
      'status' => 1,
    ]);
  }
}
