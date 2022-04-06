<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Type::create([
      'ar' => ['title' => 'مدارس'],
      'en' => ['title' => 'schools'],
      'status' => 1,
    ]);
    Type::create([
      'ar' => ['title' => 'حضانات'],
      'en' => ['title' => 'nurseries'],
      'status' => 1,
    ]);
  }
}
