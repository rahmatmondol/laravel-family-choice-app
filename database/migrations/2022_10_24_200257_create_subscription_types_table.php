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
    Schema::create('subscription_types', function (Blueprint $table) {
      $table->id();
      $table->integer('number_of_days')->default(1); // default active
      $table->double('price'); // default active
      $table->enum('type',['part_time','full_time'])->nullable(); // default active
      $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
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
    Schema::dropIfExists('subscription_types');
  }
};
