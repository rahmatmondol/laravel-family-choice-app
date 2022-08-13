<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    $this->call([
      LaratrustSeeder::class,
      AdminTableSeeder::class,
      CitiesTableSeeder::class,
      TypesTableSeeder::class,
      SchoolTypesTableSeeder::class,
      EducationalSubjectsTableSeeder::class,
      EducationTypesTableSeeder::class,
      GradesTableSeeder::class,
      ServiceTableSeeder::class,
      SchoolTableSeeder::class,
      SlidersTableSeeder::class,
      CustomerTableSeeder::class,
      ReviewTableSeeder::class,
    ]);
  }
}
