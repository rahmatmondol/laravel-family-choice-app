<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('school_reservations', function (Blueprint $table) {
      $table->id();
      $table->string('parent_name');
      $table->string('address');
      $table->string('reason_of_refuse');
      $table->enum('status', ['pending', 'rejected', 'approved'])->default('pending'); // default active
      $table->enum('payment_status', ['failed', 'succeed'])->nullable();
      $table->string('identification_number'); // text
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('school_reservations');
  }
};
