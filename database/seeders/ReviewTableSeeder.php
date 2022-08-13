<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Review;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach (School::all() as $key => $school) {
        Review::updateOrCreate(
          ['school_id' => $school->id, 'customer_id' => 1],
          [
            'follow_up' => 3,
            'quality_of_education' => 3,
            'cleanliness' =>3,
            'avg' => 3,
            'comment' => "good school"
          ]
        );
    }

    $customers = Customer::pluck('id');
    foreach (School::all() as $key => $school) {
      for ($i = 0; $i < 10; $i++) {
        Review::updateOrCreate(
          ['school_id' => $school->id, 'customer_id' => $customers->random()],
          [
            'follow_up' => 3,
            'quality_of_education' => 3,
            'cleanliness' =>3,
            'avg' => 3,
            'comment' => "good school"
          ]
        );
      }
    }
  }
}
