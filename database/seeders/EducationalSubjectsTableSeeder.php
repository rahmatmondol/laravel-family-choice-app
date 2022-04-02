<?php

namespace Database\Seeders;

use App\Models\EducationalSubject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalSubjectsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    EducationalSubject::create([
      'ar' => ['title' => 'منهج مصري'],
      'en' => ['title' => 'Egyptian curriculum'],
      'status' => 1,
    ]);

    EducationalSubject::create([
      'ar' => ['title' => 'منهج امريكي'],
      'en' => ['title' => 'american curriculum'],
      'status' => 1,
    ]);

    EducationalSubject::create([
      'ar' => ['title' => 'منهج سعودي'],
      'en' => ['title' => 'saudi curriculum'],
      'status' => 1,
    ]);
  }
}
