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
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('body');

      // $table->integer('reservationable_id'); // school reserations or course reservations
      // $table->string('reservationable_type');

      $table->foreignId('reservation_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();

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
    Schema::dropIfExists('notifications');
  }
};
