<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolTypesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    SchoolType::create([
      'ar' => ['title' => 'عالمية'],
      'en' => ['title' => 'internationality'],
      'status' => 1,
    ]);

    SchoolType::create([
      'ar' => ['title' => 'اهلية'],
      'en' => ['title' => 'qualification'],
      'status' => 1,
    ]);

    SchoolType::create([
      'ar' => ['title' => 'تعليم خاص'],
      'en' => ['title' => 'Private education'],
      'status' => 1,
    ]);
  }
}
