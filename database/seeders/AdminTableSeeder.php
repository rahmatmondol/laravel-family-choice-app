<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    #super_admin
    $super_admin = Admin::create([
      'first_name' => 'super',
      'last_name' => 'admin',
      'email' => 'super_admin@app.com',
      'phone' => '123456',
      'password' => bcrypt('123456'),
    ]);

    #super_admin
    $admin = Admin::create([
      'first_name' => 'super',
      'last_name' => 'admin',
      'email' => 'admin@app.com',
      'phone' => '1234567',
      'password' => bcrypt('123456'),
    ]);

    $super_admin->attachRole('super_admin');
    $admin->attachRole('super_admin');

    #super_admin family-choice
    $user = Admin::create([
      'first_name' => 'super',
      'last_name' => 'admin',
      'email' => 'super_admin@family-choice.com',
      'phone' => '12345678',
      'password' => bcrypt('123456'),
    ]);

    $user->attachRole('super_admin');
  } //end of run

}//end of seeder
