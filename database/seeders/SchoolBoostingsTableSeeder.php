<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SchoolBoostingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('school_boostings')->insert([
            [
                'school_id' => 1,
                'city_id' => 1,
                'monthly_budget' => 500.00,
                'cost_per_click' => 1.50,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 1,
                'city_id' => 1,
                'monthly_budget' => 1000.00,
                'cost_per_click' => 2.00,
                'start_date' => '2024-02-01',
                'end_date' => '2024-11-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'school_id' => 1,
                'city_id' => 1,
                'monthly_budget' => 750.00,
                'cost_per_click' => 1.75,
                'start_date' => '2024-03-01',
                'end_date' => '2024-10-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
