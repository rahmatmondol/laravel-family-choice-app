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
    $customers = Customer::pluck('id');
    foreach (School::all() as $key => $school) {
      for ($i = 0; $i < 10; $i++) {
        Review::updateOrCreate(
          ['school_id' => $school->id, 'customer_id' => $customers->random()],
          [
            'follow_up' => 2,
            'quality_of_education' => 2,
            'cleanliness' => 4,
            'comment' => "good school"
          ]
        );
      }
    }
  }
}
